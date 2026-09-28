<?php
/**
 * Serves /llms.txt without a rewrite rule (init-hook path check), avoiding the
 * flush_rewrite_rules() dependency a virtual-file rewrite would need.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'bluerails_dhz_serve_llms_txt' );

function bluerails_dhz_serve_llms_txt() {
	$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';

	if ( '/llms.txt' !== $path ) {
		return;
	}

	// Must run before the echo — WordPress's own prior 404 status otherwise
	// leaks through even with a correct body (confirmed gotcha, morgensonne.de).
	status_header( 200 );
	header( 'Content-Type: text/plain; charset=utf-8' );
	echo bluerails_dhz_llms_txt_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static, hand-authored plain text, not user input.
	exit;
}

function bluerails_dhz_llms_txt_content() {
	$f = bluerails_dhz_facts();

	$lines = array();
	$lines[] = '# Weingut Domhof';
	$lines[] = '';
	$lines[] = '> Weingut, Gästehaus (Schlafgut), Restaurant (Schmecktgut) und Eventlocation (Feiergut/Tagegut) in Guntersblum bei Worms, Rheinhessen. Familienbetrieb mit Übernachtung, Weinverkostung, Tagungen, Hochzeiten und einem Escape Room.';
	$lines[] = '> Winery, guesthouse (Schlafgut), restaurant (Schmecktgut) and event venue (Feiergut/Tagegut) in Guntersblum near Worms, Rheinhessen, Germany. Family-run, with overnight stays, wine tasting, conferences, weddings and an escape room.';
	$lines[] = '';

	$lines[] = '## Facts / Fakten';
	$lines[] = '- ' . $f['org_name'] . ', ' . $f['street'] . ', ' . $f['postcode'] . ' ' . $f['locality'] . ', ' . $f['region'] . ', Deutschland / Germany';
	$lines[] = '- Telefon / Phone: ' . $f['phone'];
	$lines[] = '- Fax: ' . $f['fax'];
	$lines[] = '- E-Mail / Email: ' . $f['email'];
	$lines[] = '- Sprachen / Languages: Deutsch, English';
	$lines[] = '- Vinothek & Bürozeiten / Shop & office hours: ' . $f['opening_hours_office'];
	$lines[] = '';

	$lines[] = '## Weingut (Winery)';
	$lines[] = '- [Weingut](' . $f['pages']['weingut'] . '): Weinverkostung, Lagen- und Ortsweine, Weinliste. / Wine tasting, single-vineyard and village wines, wine list.';
	$lines[] = '- Produktlinien / Product lines: Lagenweine (einmalige Einzellagen / single-vineyard), Ortsweine (Böden Roter Hang, Löss, Kalk, Edelstahlausbau / regional soils, stainless-steel aged), Gutsweine (unkomplizierte Alltagsweine / easy-drinking everyday wines). Auch Sekt und Säfte / Also sparkling wine and juice.';
	$lines[] = '- [Historie](' . $f['pages']['historie'] . '): Geschichte des Weinguts. / History of the winery.';
	$lines[] = '';

	$lines[] = '## Feiergut (Weddings & Celebrations)';
	$lines[] = '- [Feiergut](' . $f['pages']['feiergut'] . '): Hochzeiten, Feste, Eventbereich auf dem Weingut. / Weddings, celebrations, event space on the estate.';
	$lines[] = '- Kapazität / Capacity: bis ' . $f['feiergut_detail']['capacity_guests'] . ' Personen, ' . $f['feiergut_detail']['space_sqm'] . ' qm Veranstaltungsbereich. / up to ' . $f['feiergut_detail']['capacity_guests'] . ' guests, ' . $f['feiergut_detail']['space_sqm'] . ' sqm event space.';
	$lines[] = '- Standesamt / Civil wedding registry: ' . $f['feiergut_detail']['registrar_note'] . '.';
	$lines[] = '';

	$lines[] = '## Tagegut (Conferences)';
	$lines[] = '- [Tagegut](' . $f['pages']['tagegut'] . '): Tagungen, Pauschalen, Rahmenprogramm. / Meetings and conferences, packages, activity program.';
	$lines[] = '- Kapazität / Capacity: bis ' . $f['tagegut_detail']['capacity_guests'] . ' Personen (Bestuhlung im ' . $f['tagegut_detail']['seating'] . '). / up to ' . $f['tagegut_detail']['capacity_guests'] . ' guests (' . $f['tagegut_detail']['seating'] . ' seating).';
	$lines[] = '';

	$lines[] = '## Schmecktgut (Restaurant)';
	$lines[] = '- [Schmecktgut](' . $f['pages']['schmecktgut'] . '): Restaurant mit Tischreservierung, Krimidinner. / Restaurant with table reservations, murder-mystery dinner events.';
	$lines[] = '- Küchenchef / Head chef: ' . $f['schmecktgut_detail']['chef'] . '. Stil / Style: ' . $f['schmecktgut_detail']['cuisine'] . '.';
	$lines[] = '- Adresse / Address: ' . $f['schmecktgut_detail']['address'] . '.';
	$lines[] = '- Öffnungszeiten / Hours: ' . $f['schmecktgut_detail']['hours'] . '.';
	$lines[] = '- Preise / Prices: ' . $f['schmecktgut_detail']['price_range'] . '. Kindermenü, vegane/vegetarische Gerichte und englische Speisekarte verfügbar. / Kids menu, vegan/vegetarian options and English menu available.';
	$lines[] = '';

	$lines[] = '## Schlafgut (Guesthouse)';
	$lines[] = '- [Schlafgut](' . $f['pages']['schlafgut'] . '): Zimmer und Buchung, ' . $f['star_rating_description'] . '. / Rooms and booking, ' . $f['star_rating_description'] . '.';
	$lines[] = '- ' . $f['schlafgut_detail']['room_count_total'] . ' Doppelzimmer (davon ' . $f['schlafgut_detail']['accessible_rooms'] . ' barrierefrei) plus ' . $f['schlafgut_detail']['apartment_count'] . ' Ferienwohnungen. / ' . $f['schlafgut_detail']['room_count_total'] . ' double rooms (' . $f['schlafgut_detail']['accessible_rooms'] . ' wheelchair-accessible) plus ' . $f['schlafgut_detail']['apartment_count'] . ' holiday apartments.';
	$lines[] = '- Namentliche Zimmer / Named rooms: ' . implode( ', ', $f['schlafgut_detail']['named_rooms'] ) . '.';
	$lines[] = '- Preise / Rates: Doppelzimmer ab ' . $f['schlafgut_detail']['rate_double_from'] . ', Einzelbelegung ab ' . $f['schlafgut_detail']['rate_single_from'] . ' (inkl. Frühstück). / Double room from ' . $f['schlafgut_detail']['rate_double_from'] . ', single occupancy from ' . $f['schlafgut_detail']['rate_single_from'] . ' (breakfast included).';
	$lines[] = '- Check-in ' . $f['schlafgut_detail']['check_in'] . ', Check-out ' . $f['schlafgut_detail']['check_out'] . '. Haustiere erlaubt (bitte bei Buchung angeben) / Pets allowed (please register at booking). Kostenfreie Parkplätze und E-Ladestationen / Free parking and EV charging. Veganes Frühstück auf Anfrage / Vegan breakfast on request.';
	$lines[] = '- [Ferienwohnungen](' . $f['pages']['ferienwohnung'] . '): 2 Wohnungen (' . implode( ' und ', array_map( fn( $sqm ) => $sqm . ' qm', $f['ferienwohnung_detail']['apartment_sqm'] ) ) . '), bis zu ' . $f['ferienwohnung_detail']['max_guests'] . ' Personen. / 2 apartments (' . implode( ' and ', array_map( fn( $sqm ) => $sqm . ' sqm', $f['ferienwohnung_detail']['apartment_sqm'] ) ) . '), up to ' . $f['ferienwohnung_detail']['max_guests'] . ' guests.';
	$lines[] = '- [Inklusivangebote](' . $f['pages']['inklusivangebote'] . '): Pauschalangebote, siehe Seite für aktuelle Termine und Preise. / All-inclusive packages, see page for current dates and prices.';
	$lines[] = '';

	$lines[] = '## Escape Room';
	$lines[] = '- [Grape Escape](' . $f['pages']['escape_room'] . '): Escape Room auf dem Weingut, ' . $f['escape_room_detail']['duration_min'] . ' Minuten, für ' . $f['escape_room_detail']['players_min'] . '–' . $f['escape_room_detail']['players_max'] . ' Spieler, Schwierigkeitsgrad ' . $f['escape_room_detail']['difficulty'] . '. / Escape room experience, ' . $f['escape_room_detail']['duration_min'] . ' minutes, for ' . $f['escape_room_detail']['players_min'] . '–' . $f['escape_room_detail']['players_max'] . ' players, difficulty ' . $f['escape_room_detail']['difficulty'] . '.';
	$lines[] = '- Preise / Prices: ' . $f['escape_room_detail']['price_from'] . ' – ' . $f['escape_room_detail']['price_to'] . '. Auf Englisch spielbar, ab ' . $f['escape_room_detail']['min_age'] . ' Jahren empfohlen. / Playable in English, recommended from age ' . $f['escape_room_detail']['min_age'] . '.';
	$lines[] = '';

	$lines[] = '## Events / Veranstaltungen';
	foreach ( $f['events'] as $event ) {
		$lines[] = '- [' . $event['name'] . '](' . $event['url'] . ')' . ( $event['start_date'] ? ': ' . $event['start_date'] : ' (siehe Seite für Termine / see page for dates)' );
	}
	$lines[] = '';

	$lines[] = '## Awards / Auszeichnungen';
	foreach ( $f['awards'] as $award ) {
		$lines[] = '- [' . ucwords( str_replace( '-', ' ', $award['slug'] ) ) . '](' . $award['url'] . ')';
	}
	$lines[] = '';

	$lines[] = '## Contact / Kontakt';
	$lines[] = '- [Anfahrt](' . $f['pages']['kontakt'] . '#anfahrt): Wegbeschreibung. / Directions.';
	$lines[] = '- [Öffnungszeiten](' . $f['pages']['kontakt'] . '#open): Öffnungszeiten (siehe Seite für aktuelle Zeiten). / Opening hours (see page for current hours).';
	$lines[] = '- [Kontakt](' . $f['pages']['kontakt'] . '): Kontaktformular, Anfahrt, Öffnungszeiten. / Contact form, directions, opening hours.';
	$lines[] = '';

	$lines[] = '## Optional';
	$lines[] = '- [News & Events](' . $f['pages']['news'] . '): Aktuelle Veranstaltungen und Neuigkeiten. / Current events and news.';
	$lines[] = '- [Impressum](' . $f['pages']['impressum'] . '): Rechtliche Anbieterkennzeichnung. / Legal notice.';
	$lines[] = '- [Datenschutz](' . $f['pages']['datenschutz'] . '): Datenschutzerklärung. / Privacy policy.';

	return implode( "\n", $lines ) . "\n";
}
