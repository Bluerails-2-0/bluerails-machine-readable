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

## Detail added 2026-09-28 (founder feedback: llms.txt "not long/detailed enough")

Fetched live from each business-line page directly (`curl https://weingut-domhof.de/<page>/`,
saved locally, not from the 2026-09-25 evidence dir). Every quote below was spot-checked by
`grep` against the raw fetched HTML before being trusted, not taken on a subagent's word.

| Fact | Value | Source (exact quote, abbreviated) |
| --- | --- | --- |
| Schlafgut room count | 22 doubles (1 accessible) + 2 apartments | schlafgut.html: "12 stilvoll-moderne Doppelzimmer inkl. eines barrierefreien Zimmers... Weitere 10 Doppelzimmer... zwei... Ferienwohnungen" |
| Named rooms | Riesling-Lounge, Himmelthal, Flaschenlager, Zehntscheune, Wolke 7, Seitensprung | schlafgut.html |
| Room rates | Double from 132€, single occ. from 98€ (incl. breakfast) | schlafgut.html: "Übernachtung im Doppelzimmer ab 132€... als Einzelbelegung... ab 98€" |
| Check-in/out | ab 15:00 Uhr / nach dem Frühstück | schlafgut.html |
| Pets, parking, EV charging, vegan breakfast | all yes | kontakt.html FAQ ("Ja, Sie dürfen gern Ihren Hund mitbringen"; "kostenfreie Parkplätze"; "zwei Ladestationen für e-Autos"; "Gern servieren wir vegane Alternativen") |
| Ferienwohnung sizes | 90 qm + 80 qm, up to 6 guests | ferienwohnung.html |
| Schmecktgut chef/style | Kevin Muth, "gehobene modern-kreative Küche" | schmecktgut.html |
| Schmecktgut address | Hauptstr. 33, 67583 Guntersblum (distinct from the winery/hotel's Bleichstraße address) | schmecktgut.html, kontakt.html |
| Schmecktgut hours | Di–Do 17:30–22:00, Fr/Sa 17:30–22:30 | schmecktgut.html + kontakt.html (both agree) |
| Schmecktgut prices | starters 10–20€, mains 27–42€, desserts 4–15€ | schmecktgut.html menu |
| Feiergut capacity | up to 100 guests, 150 sqm | feiergut.html: "bis zu 100 Personen"; "150 qm große Veranstaltungsbereich" |
| Feiergut registrar | civil ceremonies held on-site, official Guntersblum registry branch | feiergut.html |
| Tagegut capacity | up to 46 guests, U-shape seating | tagegut.html: "bis zu 46 Personen bei Bestuhlung im U" |
| Escape Room detail | 60 min, 2–8 players, difficulty 4/5, 80–160€, English available, min age ~10 | grapeescape.html + kontakt.html FAQ |
| Office/Vinothek hours | Mo–Fr 8–12, Mi & Fr also 15–18 | kontakt.html: "Montag – Freitag 8-12Uhr. Mittwoch & Freitag: 15 – 18 Uhr" |

**Known discrepancy, not silently resolved**: `feiergut.html` states Vinothek hours as
"Do und Fr von 17 bis 19 Uhr und Sa von 10 bis 12 Uhr" — different days AND times than
`kontakt.html`'s "Mo–Fr 8-12, Mi & Fr 15-18". Both verified as real, current text on their
respective live pages (2026-09-28); they contradict each other. `facts.php` cites
`kontakt.html` as authoritative (it's the site's own dedicated "Öffnungszeiten" page) —
`feiergut.html`'s line is treated as stale copy, not overwritten. **Founder should confirm
which is actually correct and get feiergut.html's copy fixed on the site itself** — this
plugin can only publish one, it can't reconcile the site's own conflicting content.

Deliberately NOT added: Inklusivangebote's 14 named packages with specific 2026 dates and
per-person prices (real, all verified against the raw HTML) — these are perishable
seasonal offers that will be wrong within weeks and this plugin has no update mechanism.
`llms.txt` links to the page instead ("see page for current dates and prices"), same
pattern as the Events section's date handling.

## Gaps / TODO-VERIFY (not invented, left incomplete instead)

1. **sameAs: Facebook (`facebook.com/domhof`) and Pinterest (`de.pinterest.com/baumann8272`)** — both linked from the site's own social menu, but WebFetch could not render either page (Facebook's mobile view returned "Inhalt nicht gefunden"; Pinterest returned no usable content). Per `wp-schema-remediation` SKILL.md's own warning, a bare 200/link existing is not proof of ownership — left OUT of `sameAs` rather than citing an unverified match. Needs a JS-rendering fetch or manual check before adding.
2. **Event dates/ticketing** — the evidence snapshot (`events-sitemap.xml`) only has each event page's `lastmod` (last-edited timestamp), not its actual event date. `includes/facts.php`'s `events` array has `start_date => null` for all 9 events; `includes/schema.php` only emits `startDate`/`eventStatus`/`eventAttendanceMode` when populated, so these Event nodes are valid but incomplete JSON-LD (Google's Event rich-results guidance expects `startDate`). Event `name` values are a mechanical slug→title transcription, not a captured page `<title>`. **Needs a follow-up pass that fetches each of the 9 live event pages and fills in real dates before this is a complete Event graph.**
3. **Rich Results Test** — not run against Google's live tool this session (no browser/JS-app access from this environment). `schema-graph-preview.json` is ready to paste into `search.google.com/test/rich-results` — deferred to whoever runs the pre-upload validation gate (ticket step 3/4).
4. ~~**Öffnungszeiten (opening hours)**~~ — RESOLVED 2026-09-28, see the detail table above.
