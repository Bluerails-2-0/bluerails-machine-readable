=== Bluerails Machine-Readable Remediation ===
Contributors: bluerails
Tags: seo, ai visibility, llms.txt, json-ld, robots.txt
Requires at least: 5.8
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Serves /llms.txt, a named-AI-bot robots.txt allow-list, and JSON-LD schema enrichment for AI-visibility.

== Description ==

Built by Bluerails for weingut-domhof.de as part of AI-visibility remediation work:

* Serves a bilingual (DE/EN) `/llms.txt`.
* Adds a named-AI-bot `Allow:` allow-list to `robots.txt`, ahead of Yoast SEO's own block.
* Enriches Yoast SEO's JSON-LD graph with `Organization`, `Hotel`, `Restaurant`,
  `EventVenue`, and `Event` nodes.
* Removes the Yoast author sitemap entry.

Requires Yoast SEO (free or Premium) to be active.

== Installation ==

1. WP-admin → Plugins → Add New → Upload Plugin.
2. Upload a zip of this repository.
3. Activate.

== Changelog ==

= 1.0.0 =
* Initial release.
