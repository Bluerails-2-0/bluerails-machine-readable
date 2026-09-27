<?php
/**
 * Enriches Yoast's Organization node and appends Hotel/Restaurant/EventVenue/
 * Event pieces to the wpseo_schema_graph filter's $graph array (a plain array
 * of already-generated pieces — pushing new elements is a standard pattern,
 * confirmed against schema-generator.php:167 in Yoast 20.2.1).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'wpseo_schema_graph', 'bluerails_dhz_enrich_schema_graph', 10, 1 );

function bluerails_dhz_enrich_schema_graph( $graph ) {
	if ( ! is_array( $graph ) ) {
		return $graph;
	}

	$f = bluerails_dhz_facts();

	foreach ( $graph as $i => $piece ) {
		if ( isset( $piece['@id'] ) && $piece['@id'] === $f['url'] . '#organization' ) {
			$graph[ $i ] = bluerails_dhz_enrich_organization_node( $piece, $f );
		}
	}

	$graph[] = bluerails_dhz_hotel_node( $f );
	$graph[] = bluerails_dhz_restaurant_node( $f );
	$graph[] = bluerails_dhz_event_venue_node( $f );

	foreach ( $f['events'] as $event ) {
		$graph[] = bluerails_dhz_event_node( $event, $f );
	}

	return $graph;
}

function bluerails_dhz_enrich_organization_node( $piece, $f ) {
	$piece['@type']       = array( 'Organization', 'Winery' );
	$piece['address']     = bluerails_dhz_postal_address( $f );
	$piece['geo']         = bluerails_dhz_geo( $f );
	$piece['telephone']   = $f['phone'];
	$piece['email']       = $f['email'];
	$piece['sameAs']      = $f['same_as'];

	return $piece;
}

function bluerails_dhz_postal_address( $f ) {
	return array(
		'@type'           => 'PostalAddress',
		'streetAddress'   => $f['street'],
		'addressLocality' => $f['locality'],
		'postalCode'      => $f['postcode'],
		'addressRegion'   => $f['region'],
		'addressCountry'  => $f['country'],
	);
}

function bluerails_dhz_geo( $f ) {
	return array(
		'@type'     => 'GeoCoordinates',
		'latitude'  => $f['geo_lat'],
		'longitude' => $f['geo_lon'],
	);
}

function bluerails_dhz_hotel_node( $f ) {
	return array(
		'@type'       => 'Hotel',
		'@id'         => $f['url'] . '#schlafgut',
		'name'        => 'Schlafgut Domhof',
		'url'         => $f['pages']['schlafgut'],
		'address'     => bluerails_dhz_postal_address( $f ),
		'geo'         => bluerails_dhz_geo( $f ),
		'telephone'   => $f['phone'],
		'starRating'  => array(
			'@type'       => 'Rating',
			'ratingValue' => $f['star_rating_value'],
		),
		'description' => $f['star_rating_description'],
		'isPartOf'    => array( '@id' => $f['url'] . '#organization' ),
	);
}

function bluerails_dhz_restaurant_node( $f ) {
	return array(
		'@type'     => 'Restaurant',
		'@id'       => $f['url'] . '#schmecktgut',
		'name'      => 'Schmecktgut Domhof',
		'url'       => $f['pages']['schmecktgut'],
		'address'   => bluerails_dhz_postal_address( $f ),
		'geo'       => bluerails_dhz_geo( $f ),
		'telephone' => $f['phone'],
		'isPartOf'  => array( '@id' => $f['url'] . '#organization' ),
	);
}

function bluerails_dhz_event_venue_node( $f ) {
	return array(
		'@type'     => 'EventVenue',
		'@id'       => $f['url'] . '#feiergut-tagegut',
		'name'      => 'Feiergut & Tagegut Domhof',
		'url'       => $f['pages']['feiergut'],
		'address'   => bluerails_dhz_postal_address( $f ),
		'geo'       => bluerails_dhz_geo( $f ),
		'telephone' => $f['phone'],
		'isPartOf'  => array( '@id' => $f['url'] . '#organization' ),
	);
}

function bluerails_dhz_event_node( $event, $f ) {
	$node = array(
		'@type'    => 'Event',
		'@id'      => $event['url'] . '#event',
		'name'     => $event['name'],
		'url'      => $event['url'],
		'location' => array( '@id' => $f['url'] . '#feiergut-tagegut' ),
	);

	// Only emit fields that are populated (BLUE-2029: no evidence for event
	// dates, so nothing invented — see facts.php's events array).
	if ( ! empty( $event['start_date'] ) ) {
		$node['startDate']            = $event['start_date'];
		$node['eventStatus']          = 'https://schema.org/EventScheduled';
		$node['eventAttendanceMode']  = 'https://schema.org/OfflineEventAttendanceMode';
	}

	return $node;
}
