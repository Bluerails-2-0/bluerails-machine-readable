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
	$lines[] = '';

	$lines[] = '## Weingut (Winery)';
	$lines[] = '- [Weingut](' . $f['pages']['weingut'] . '): Weinverkostung, Lagen- und Ortsweine, Weinliste. / Wine tasting, single-vineyard and village wines, wine list.';
	$lines[] = '- [Historie](' . $f['pages']['historie'] . '): Geschichte des Weinguts. / History of the winery.';
	$lines[] = '';

	$lines[] = '## Feiergut (Weddings & Celebrations)';
	$lines[] = '- [Feiergut](' . $f['pages']['feiergut'] . '): Hochzeiten, Feste, Eventbereich auf dem Weingut. / Weddings, celebrations, event space on the estate.';
	$lines[] = '';

	$lines[] = '## Tagegut (Conferences)';
	$lines[] = '- [Tagegut](' . $f['pages']['tagegut'] . '): Tagungen, Pauschalen, Rahmenprogramm. / Meetings and conferences, packages, activity program.';
	$lines[] = '';

	$lines[] = '## Schmecktgut (Restaurant)';
	$lines[] = '- [Schmecktgut](' . $f['pages']['schmecktgut'] . '): Restaurant mit Tischreservierung, Krimidinner. / Restaurant with table reservations, murder-mystery dinner events.';
	$lines[] = '';

	$lines[] = '## Schlafgut (Guesthouse)';
	$lines[] = '- [Schlafgut](' . $f['pages']['schlafgut'] . '): Zimmer und Buchung, ' . $f['star_rating_description'] . '. / Rooms and booking, ' . $f['star_rating_description'] . '.';
	$lines[] = '- [Ferienwohnungen](' . $f['pages']['ferienwohnung'] . '): Ferienwohnungen auf dem Weingut. / Holiday apartments on the estate.';
	$lines[] = '- [Inklusivangebote](' . $f['pages']['inklusivangebote'] . '): Pauschalangebote. / All-inclusive packages.';
	$lines[] = '';

	$lines[] = '## Escape Room';
	$lines[] = '- [Grape Escape](' . $f['pages']['escape_room'] . '): Escape Room auf dem Weingut. / Escape room experience on the estate.';
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
