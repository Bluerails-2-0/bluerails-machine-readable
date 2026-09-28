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

		// Detail below sourced live 2026-09-28 from each business-line page itself
		// (not the evidence dir, which predates it) — see FACTS-SHEET.md's detail
		// section for the exact quoted source line per field. Perishable, dated
		// package pricing/dates deliberately excluded — those go stale and this
		// plugin has no update mechanism; the pages array above already links to
		// inklusivangebote for current offers.
		'schlafgut_detail'     => array(
			'room_count_total'   => 22,
			'apartment_count'    => 2,
			'accessible_rooms'   => 1,
			'named_rooms'        => array( 'Riesling-Lounge', 'Himmelthal', 'Flaschenlager', 'Zehntscheune', 'Wolke 7', 'Seitensprung' ),
			'rate_double_from'   => '132€',
			'rate_single_from'   => '98€',
			'check_in'           => 'ab 15:00 Uhr',
			'check_out'          => 'nach dem Frühstück',
			'pets_allowed'       => true,
			'parking_free'       => true,
			'ev_charging'        => true,
			'vegan_breakfast'    => true,
		),
		'ferienwohnung_detail' => array(
			'apartment_sqm'  => array( 90, 80 ),
			'max_guests'     => 6,
		),
		'schmecktgut_detail'   => array(
			'chef'         => 'Kevin Muth',
			'cuisine'      => 'gehobene modern-kreative Küche',
			'address'      => 'Hauptstr. 33, 67583 Guntersblum',
			'hours'        => 'Di–Do 17:30–22:00 Uhr, Fr & Sa 17:30–22:30 Uhr',
			'price_range'  => 'Vorspeisen 10–20€, Hauptgänge 27–42€, Desserts 4–15€',
			'vegan_options' => true,
			'kids_menu'    => true,
			'english_menu' => true,
		),
		'feiergut_detail'      => array(
			'capacity_guests' => 100,
			'space_sqm'       => 150,
			'registrar_note'  => 'offizielle Außenstelle des Standesamts Guntersblum im Pferdestall',
		),
		'tagegut_detail'       => array(
			'capacity_guests' => 46,
			'seating'         => 'U-Form',
		),
		'escape_room_detail'   => array(
			'duration_min'   => 60,
			'players_min'    => 2,
			'players_max'    => 8,
			'difficulty'     => '4/5',
			'price_from'     => '80€ (2 Spieler)',
			'price_to'       => '160€ (8 Spieler)',
			'english_available' => true,
			'min_age'        => 10,
		),
		'opening_hours_office' => 'Mo–Fr 8–12 Uhr, Mi & Fr zusätzlich 15–18 Uhr (oder nach telefonischer Vereinbarung)',
	);
}
