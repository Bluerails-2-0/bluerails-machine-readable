# Facts sheet — bluerails-machine-readable (BLUE-2029)

Every fact published by this plugin (`includes/facts.php`), with its source. No
fact below is invented — anything not traceable to the evidence dir or an
external check performed this session is a gap, listed at the bottom instead.

| Fact | Value | Source |
| --- | --- | --- |
| Org name | Weingut Domhof | `impressum.html`, `home.html` (`evidence/weingut-domhof.de-2026-09-25/`) |
| Street | Bleichstraße 12-14 | `impressum.html` footer block |
| Postal code / city | 67583 Guntersblum | `impressum.html`; **externally verified** against `de.wikipedia.org/wiki/Guntersblum` infobox (2026-09-27) — matches |
| Region | Rheinland-Pfalz | Nominatim geocode result (below), consistent with `impressum.html`'s "Ministerium für Wirtschaft... Mainz" |
| Phone | +49 6249 805767 | `impressum.html` footer |
| Fax | +49 6249 80039 | `impressum.html` footer |
| Email | baumann@weingut-domhof.de | `impressum.html` footer |
| Geo (lat/lon) | 49.7954974 / 8.3468879 | **Externally geocoded** via `nominatim.openstreetmap.org` for "Bleichstr. 12-14, 67583 Guntersblum, Germany" (2026-09-27) — the geocoder's own `display_name` independently resolved to "Schlafgut Domhof... Guntersblum", corroborating the address |
| sameAs: Instagram | `https://www.instagram.com/weingut_domhof/` | Listed in site header/footer social menu (`home.html`); **title-verified** via WebFetch — profile title reads "Weingut Domhof (@weingut_domhof)" |
| Logo URL | `.../weingut-domhof-logo.png` | Yoast's existing Organization node, `home.html`/`impressum.html` JSON-LD |
| Star rating | `ratingValue: "3"`, description "3 Sterne Superior (DEHOGA)" | `posts.json` (`evidence/weingut-domhof.de-2026-09-25/`) lists a real, published blog post "3 Sterne Superior für SCHLAFGUT Domhof" (id 1419, `/blog/3-sterne-superior-fuer-schlafgut-domhof/`) |
| Business-line page URLs (Weingut, Feiergut, Tagegut, Schmecktgut, Schlafgut, Ferienwohnung, Escape Room, Inklusivangebote, Kontakt, Historie, News, Impressum, Datenschutz) | see `includes/facts.php` `pages` array | `pages.json` (`evidence/weingut-domhof.de-2026-09-25/`) |
| Awards CPT (6 URLs) | Feinschmecker, Gault Millau, Best of Wine Tourism Award, Eichelmann, Barrierefreiheit, Vinum | `auszeichnungen-sitemap.xml` (`evidence/weingut-domhof.de-2026-09-25/`) |
| Events CPT (9 URLs) | grape-escape, degustationsmenue, krimidinner, herbsterleben, hopfen-kuesst-traube, korken-und-koepfchen, wein-quiz-night, kellergeheimnisse, gans-schoen-festlich | `events-sitemap.xml` (`evidence/weingut-domhof.de-2026-09-25/`) — the `/blog/events/` archive URL itself deliberately excluded, per ticket scope |

## Gaps / TODO-VERIFY (not invented, left incomplete instead)

1. **sameAs: Facebook (`facebook.com/domhof`) and Pinterest (`de.pinterest.com/baumann8272`)** — both linked from the site's own social menu, but WebFetch could not render either page (Facebook's mobile view returned "Inhalt nicht gefunden"; Pinterest returned no usable content). Per `wp-schema-remediation` SKILL.md's own warning, a bare 200/link existing is not proof of ownership — left OUT of `sameAs` rather than citing an unverified match. Needs a JS-rendering fetch or manual check before adding.
2. **Event dates/ticketing** — the evidence snapshot (`events-sitemap.xml`) only has each event page's `lastmod` (last-edited timestamp), not its actual event date. `includes/facts.php`'s `events` array has `start_date => null` for all 9 events; `includes/schema.php` only emits `startDate`/`eventStatus`/`eventAttendanceMode` when populated, so these Event nodes are valid but incomplete JSON-LD (Google's Event rich-results guidance expects `startDate`). Event `name` values are a mechanical slug→title transcription, not a captured page `<title>`. **Needs a follow-up pass that fetches each of the 9 live event pages and fills in real dates before this is a complete Event graph.**
3. **Rich Results Test** — not run against Google's live tool this session (no browser/JS-app access from this environment). `schema-graph-preview.json` is ready to paste into `search.google.com/test/rich-results` — deferred to whoever runs the pre-upload validation gate (ticket step 3/4).
4. **Öffnungszeiten (opening hours)** — not in the evidence dir (no page content captured for `/kontakt/#open`). `llms.txt` links to the page's anchor rather than stating specific hours, so nothing is invented, but the file doesn't answer "what are your hours" directly.
