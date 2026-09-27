<?php
/**
 * Single source of truth for every published fact. llms.txt and the JSON-LD
 * filter both read from here so the two surfaces can never drift apart.
 * Full source citations: FACTS-SHEET.md, same directory. A field left
 * null/empty means the evidence didn't cover it — never fabricate a fill.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array<string, mixed>
 */
function bluerails_dhz_facts() {
	return array(
		'org_name'  => 'Weingut Domhof',
		'url'       => 'https://weingut-domhof.de/',
		'logo_url'  => 'https://weingut-domhof.de/wp-content/uploads/2015/10/weingut-domhof-logo.png',

		'street'    => 'Bleichstraße 12-14',
		'locality'  => 'Guntersblum',
		'postcode'  => '67583',
		'region'    => 'Rheinland-Pfalz',
		'country'   => 'DE',
		'phone'     => '+49 6249 805767',
		'fax'       => '+49 6249 80039',
		'email'     => 'baumann@weingut-domhof.de',

		'geo_lat'   => '49.7954974',
		'geo_lon'   => '8.3468879',

		// Facebook/Pinterest omitted — couldn't confirm the profile matches this
		// business, so left out rather than citing an unverified guess.
		'same_as'   => array(
			'https://www.instagram.com/weingut_domhof/',
		),

		// schema.org Rating has no field for the "Superior" qualitative modifier,
		// so it's carried in the description text alongside the numeric value.
		'star_rating_value'       => '3',
		'star_rating_description' => '3 Sterne Superior (DEHOGA)',
		'star_rating_source_url'  => 'https://weingut-domhof.de/blog/3-sterne-superior-fuer-schlafgut-domhof/',

		// Business-line landing pages — source: pages.json (evidence dir).
		'pages'     => array(
			'weingut'          => 'https://weingut-domhof.de/weingut/',
			'feiergut'         => 'https://weingut-domhof.de/feiergut/',
			'tagegut'          => 'https://weingut-domhof.de/tagegut/',
			'schmecktgut'      => 'https://weingut-domhof.de/schmecktgut/',
			'schlafgut'        => 'https://weingut-domhof.de/schlafgut/',
			'ferienwohnung'    => 'https://weingut-domhof.de/ferienwohnung/',
			'escape_room'      => 'https://weingut-domhof.de/grapeescape/',
			'inklusivangebote' => 'https://weingut-domhof.de/inklusivangebote/',
			'kontakt'          => 'https://weingut-domhof.de/kontakt/',
			'historie'         => 'https://weingut-domhof.de/historie/',
			'news'             => 'https://weingut-domhof.de/news/',
			'impressum'        => 'https://weingut-domhof.de/impressum/',
			'datenschutz'      => 'https://weingut-domhof.de/datenschutz/',
		),

		'awards'    => array(
			array( 'slug' => 'feinschmecker', 'url' => 'https://weingut-domhof.de/blog/auszeichnungen/feinschmecker/' ),
			array( 'slug' => 'gault-millau', 'url' => 'https://weingut-domhof.de/blog/auszeichnungen/gault-millau/' ),
			array( 'slug' => 'best-of-wine-tourism-award', 'url' => 'https://weingut-domhof.de/blog/auszeichnungen/best-of-wine-tourism-award/' ),
			array( 'slug' => 'eichelmann', 'url' => 'https://weingut-domhof.de/blog/auszeichnungen/eichelmann/' ),
			array( 'slug' => 'barrierefreiheit', 'url' => 'https://weingut-domhof.de/blog/auszeichnungen/barrierefreiheit/' ),
			array( 'slug' => 'vinum', 'url' => 'https://weingut-domhof.de/blog/auszeichnungen/vinum/' ),
		),

		// The /blog/events/ archive page is deliberately excluded — only real
		// dated events. TODO(BLUE-2029): `start_date` is null for every event below
		// (no per-event date data in evidence); schema.php only emits populated fields.
		'events'    => array(
			array( 'slug' => 'grape-escape', 'name' => 'Grape Escape', 'url' => 'https://weingut-domhof.de/blog/events/grape-escape/', 'start_date' => null ),
			array( 'slug' => 'degustationsmenue', 'name' => 'Degustationsmenü', 'url' => 'https://weingut-domhof.de/blog/events/degustationsmenue/', 'start_date' => null ),
			array( 'slug' => 'krimidinner', 'name' => 'Krimidinner', 'url' => 'https://weingut-domhof.de/blog/events/krimidinner/', 'start_date' => null ),
			array( 'slug' => 'herbsterleben', 'name' => 'Herbsterleben', 'url' => 'https://weingut-domhof.de/blog/events/herbsterleben/', 'start_date' => null ),
			array( 'slug' => 'hopfen-kuesst-traube', 'name' => 'Hopfen küsst Traube', 'url' => 'https://weingut-domhof.de/blog/events/hopfen-kuesst-traube/', 'start_date' => null ),
			array( 'slug' => 'korken-und-koepfchen', 'name' => 'Korken und Köpfchen', 'url' => 'https://weingut-domhof.de/blog/events/korken-und-koepfchen/', 'start_date' => null ),
			array( 'slug' => 'wein-quiz-night', 'name' => 'Wein-Quiz-Night', 'url' => 'https://weingut-domhof.de/blog/events/wein-quiz-night/', 'start_date' => null ),
			array( 'slug' => 'kellergeheimnisse', 'name' => 'Kellergeheimnisse', 'url' => 'https://weingut-domhof.de/blog/events/kellergeheimnisse/', 'start_date' => null ),
			array( 'slug' => 'gans-schoen-festlich', 'name' => 'Gans schön festlich', 'url' => 'https://weingut-domhof.de/blog/events/gans-schoen-festlich/', 'start_date' => null ),
		),
	);
}
