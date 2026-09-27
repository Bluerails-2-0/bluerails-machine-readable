# Bluerails Machine-Readable Remediation

WordPress plugin built for weingut-domhof.de (Weingut Domhof, Guntersblum) as part of
Bluerails' AI-visibility remediation work.

## What it does

- Serves `/llms.txt` (bilingual DE/EN) via an `init`-hook route.
- Appends a named-AI-bot allow-list to `robots.txt` (priority 20, before Yoast's own block).
- Enriches Yoast SEO's JSON-LD graph: `Organization`, `Hotel`, `Restaurant`, `EventVenue`,
  and `Event` nodes, sourced from `FACTS-SHEET.md`.
- Removes the Yoast author sitemap entry (exposes WP usernames).

## Facts

Every published fact traces to a source — see `FACTS-SHEET.md`. Nothing is invented; a
gap in the evidence is left empty, not filled with a plausible guess.

## Install

WP-admin → Plugins → Add New → Upload Plugin → upload a zip of this repo, activate.

## License

GPLv2 or later. See `LICENSE`.
