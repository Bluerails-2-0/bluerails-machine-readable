# Review — BLUE-2029: bluerails-machine-readable plugin (weingut-domhof.de)

Newest sibling file in `reviews/` at review time: `reviews/REVIEW-BLUE-1997.md` (Ibelsa
reservations pull / CM allocation ripple into the OTA-admission ARI-publish path, added
2026-09-27) — unrelated domain (visibility-web CM/Channex code vs. this ticket's standalone
WordPress plugin for a single customer's own site); no overlap with this review's findings.

Implemented-By: orchestrator session, worktree `BLUE-2029-machine-readable-remediation` (2026-09-27)
Independent-Reviewer: claude-sonnet-5 (independent review subagent, 2026-09-27)
Review-Status: INDEPENDENT
Reviewed-Commit: `1d9b38ab6` (branch `BLUE-2029-machine-readable-remediation`, pushed, not yet PR'd)
Reviewed-At: 2026-09-27
Verdict: **READY-WITH-FIXES**

## Necessity check (done first, per spec)

Verified live against `weingut-domhof.de` this session, not assumed:

- `curl -o /dev/null -w '%{http_code}' https://weingut-domhof.de/llms.txt` → **404**. Route genuinely doesn't exist.
- `curl https://weingut-domhof.de/robots.txt` → Yoast's stock block only (`User-agent: * / Disallow: / Sitemap: ...`). **No named-AI-bot entries exist today** — the allow-list this PR adds is net-new, not a duplicate.
- Parsed the live `application/ld+json` block captured in `home.html` (evidence dir): the current `Organization` node has only `name`/`url`/`logo`/`image` — **no `address`, `geo`, `telephone`, `email`, `sameAs`, or `award`, and no `Hotel`/`Restaurant`/`EventVenue`/`Event` nodes exist anywhere in the graph** (`WebPage`, `BreadcrumbList`, `WebSite`, `Organization` only). Nothing this plugin adds duplicates live output.

All three mechanisms are genuinely additive. Necessity confirmed, not assumed.

## Lens Coverage

| Lens | Verdict | Why / Findings |
| --- | --- | --- |
| Tech | APPLIES | `includes/robots.php:16` (priority order re-verified against Yoast source), `includes/schema.php:15-37` (`wpseo_schema_graph` enrichment), `includes/sitemap.php:15-31` (`wpseo_sitemap_index_links`), `includes/facts.php` (evidence not committed — finding 1). PHP lints clean (all 6 files, verified myself), JSON valid, three hook mechanisms re-verified against pinned Yoast 20.2.1 source via `gh api`. See depth markers and findings below. |
| Product Manager | APPLIES | Real paying customer (Discovery, Weingut Domhof), real live gap confirmed via live `curl` above, correct scope vs. `wp-schema-remediation`/`ai-visibility-crawler-files` precedent. Carries forward the ticket review's still-open "no Discovery-rescan step" item. See depth markers below. |
| Product Designer | SKIP | No rendered UI/page surface changes — this is server-side WP plugin code, a static text file, and JSON-LD served on a third-party customer's own site, not any Bluerails-rendered page. Nothing in our repo to screenshot or visually audit. |
| Persona | APPLIES | NO-RENDER: this contract surface has no visual UI — driven via `curl https://weingut-domhof.de/robots.txt` and `curl -o /dev/null -w '%{http_code}' https://weingut-domhof.de/llms.txt` (commands in Necessity check above) plus direct reading of `includes/schema.php`'s JSON-LD output and the live `application/ld+json` block captured in `home.html`. The AI crawler/agent fetching this customer's site is a real, distinct persona (persona #3) even though not human — walked step-by-step below. |
| Cost/Perf | APPLIES | `includes/robots.php`, `includes/schema.php`, `includes/sitemap.php` — all three filters run in-process on their own narrow request paths with fixed-size arrays and zero added DB/network calls. See HOT-PATH-COST marker below. Clean. |

## Tech findings

**1. (Important) The evidence directory every published fact cites is not committed anywhere — the plugin's own "nothing invented" claim is unverifiable from this branch or `origin/main`.**

`FACTS-SHEET.md` and multiple inline comments in `includes/facts.php` cite `home.html`, `impressum.html`, `pages.json`, `posts.json`, `auszeichnungen-sitemap.xml`, `events-sitemap.xml`, `robots.txt`, and `status-codes.txt` under `.claude/discovery-onboarding/weingut-domhof.de-evidence-2026-09-25/` as the source of truth. Checked directly:

```
git log --all --oneline -- '.claude/discovery-onboarding/weingut-domhof.de-evidence-2026-09-25/*'
# → only touches wp-admin-observations.md and plugin-upload-form-2026-09-27.jpg
git ls-tree -r origin/main --name-only | grep weingut-domhof.de-evidence
# → only plugin-upload-form-2026-09-27.jpg, wp-admin-observations.md
```

None of the seven files the facts sheet cites row-by-row are tracked in git, on this branch or on `main` — they exist only as local, uncommitted scratch files in one particular checkout (`/Users/ashwin/work/bluerails402`, visible as `??` in that repo's working tree). Anyone else — a second reviewer, CI, or a future session on a different machine — checking out this exact branch cannot verify a single cited fact; the citations point at files that don't exist for them. I only was able to spot-check facts because I had access to that other checkout's working directory.

I did the spot-check anyway (since I had access) and every fact checked out clean: street/postcode/phone/fax/email match `impressum.html` exactly; the star-rating post (id 1419) is real in `posts.json`; all 13 `pages` URLs in `facts.php` are present in `pages.json`; all 9 event URLs match `events-sitemap.xml`; `status-codes.txt` independently confirms `llms.txt` was already 404 pre-build, consistent with my live curl. The facts are accurate — the problem is purely that the evidence backing them isn't durable/shared.

**Fix: commit the evidence directory (or at minimum the seven cited files) in this PR or a follow-up before merge**, per this repo's own "every claim is either self-verified with a cited command/file/quote, or explicitly marked UNVERIFIED" discipline — a citation to an uncommitted file doesn't satisfy that.

**2. (Important) Comment discipline — several files duplicate FACTS-SHEET.md's provenance table and embed multi-line citation/history rationale directly in source, against this repo's own CLAUDE.md convention ("say what it does, in a sentence or two... leave out evidence citations, multi-paragraph rationale").**

- `includes/facts.php:28-30, 37-40` — the postcode and geo-coordinate comments restate, almost verbatim, the same source/verification narrative already recorded in `FACTS-SHEET.md`'s table (the "why" now lives in two places that can drift).
- `includes/robots.php:1-10` — 9-line header comment includes "the ticket's own prose had this backward at one point," which is bug/ticket history, explicitly the kind of thing CLAUDE.md's comment convention says to leave out of source.
- `includes/sitemap.php:1-9` — 7-line header cites two external file:line references; useful as a *why* for a genuinely non-obvious WP hook choice, but at that length it belongs in the ticket review (which already has it) rather than permanently in source, especially since a future Yoast version will make the line numbers stale.

**Fix**: keep one load-bearing line per file (e.g., "enriches the existing Organization node and appends new pieces to Yoast's `wpseo_schema_graph` array — see FACTS-SHEET.md / ticket-reviews/BLUE-2029.md for source citations and verification detail"), and delete the rest. This isn't a style nit — per this repo's own review framework, a *why* that's stated in more than one place is a defect because the two copies will diverge over time.

**3. (Suggestion) One citation line number is wrong.** `includes/sitemap.php:8` cites `class-author-sitemap-provider.php:45` for where the `'loc'` value is built. I pulled Yoast 20.2.1's actual source (`gh api repos/Yoast/wordpress-seo/contents/inc/sitemaps/class-author-sitemap-provider.php?ref=20.2.1`) — the `'loc' => ... 'author-sitemap' . $current_page . '.xml'` line is actually **line 76**, not 45. The underlying mechanism claim is still correct (confirmed: `wpseo_sitemap_index_links` fires at `class-sitemaps.php:400`, after all providers — including the hardcoded, non-filterable `WPSEO_Author_Sitemap_Provider` — have merged into `$links`, so the `strpos($link['loc'], 'author-sitemap')` match in `sitemap.php` is sound), only the cited line number is off. Fix the citation if the comment is kept at all (see finding 2).

**4. (Clean, independently re-verified) `wpseo_sitemap_index_links` is a sound, correctly-cited seam for dropping the author sitemap**, confirmed against the real pinned Yoast 20.2.1 source as above — this is a new claim not covered by the pre-build ticket review (which only verified `robots_txt` and `wpseo_schema_graph`), and it checks out.

**5. (Clean) `php -l` on all 6 PHP files — clean, verified myself, not trusted from a prior claim:**
```
bluerails-machine-readable.php  ok
includes/facts.php              ok
includes/llms-txt.php           ok
includes/robots.php             ok
includes/schema.php             ok
includes/sitemap.php            ok
```
`schema-graph-preview.json` — valid JSON (`python3 -m json.tool`), and its structure matches what `includes/schema.php`'s filter would actually produce: the Organization node's enriched fields (`@type`, `address`, `geo`, `telephone`, `email`, `sameAs`, `award`) match exactly what `bluerails_dhz_enrich_organization_node()` sets; `name`/`url`/`logo` in the preview come from Yoast's own pre-existing node (the PHP filter never sets those — it only matches and enriches), so the preview represents the *merged* end state rendered on the page, not the isolated filter's return value. Worth a one-line note in the preview file's own header clarifying that distinction so a future reader doesn't assume the PHP alone produces the full object.

**6. (Clean) Security.** No output escaping gaps: `llms-txt.php` echoes only static, hand-authored content (the `phpcs:ignore` comment is accurate — nothing user-controlled reaches the echo). `$_SERVER['REQUEST_URI']` is read via `wp_unslash()` + `wp_parse_url(..., PHP_URL_PATH)` and only used in a strict `!==` comparison against a literal string — it is never reflected back into output, so there's no injection surface. `schema.php` returns a PHP array to a WP/Yoast filter chain that WP itself later `wp_json_encode()`s — not a raw-echo path, no escaping gap. `robots.php` interpolates only hardcoded bot-name constants into plain text, no external input. No secrets, no auth surface (plugin has no admin UI, no options, no nonces needed).

**7. (Clean) Robots.txt priority-order fix is correctly implemented.** The pre-build ticket review's Important finding #1 (the ticket's prose had the Yoast-vs-ours ordering backward) is fixed correctly in code: `robots.php:16` registers at priority 20, and the file's own comment now correctly states this renders **before** Yoast's block (priority 99999, which appends to whatever string it receives) — matches the ticket review's corrected conclusion.

**8. (Clean) Ticket review finding #2 (unbacked "VERIFIED live" claim) is now closed with a real artifact.** `wp-admin-observations.md`'s 2026-09-27 addendum plus `plugin-upload-form-2026-09-27.jpg` (both committed) confirm `DISALLOW_FILE_MODS` is not set and the plugin-upload path is reachable — this was the round-1 review's top open risk and it's now backed by a saved artifact, not just prose.

### Tech depth markers

INVARIANT-ENFORCER: Invariant — "no field is emitted to llms.txt or JSON-LD without evidence." Enforcer — `includes/facts.php` is the single source both `llms-txt.php` and `schema.php` read from (grepped: no literal fact strings duplicated outside `facts.php`), plus `schema.php`'s `if ( ! empty( $event['start_date'] ) )` guard in `bluerails_dhz_event_node()`. Fail direction is safe: if the guard were ever removed/broken, the worst case is `null`/empty fields being emitted (visibly incomplete, per finding 10), not a fabricated value — there is no default-value fallback anywhere in `facts.php` or `schema.php`.

PROD-ENTRY-TRACE: N/A in the infra sense — this plugin has never been uploaded/activated on weingut-domhof.de (confirmed: `wp-admin-observations.md`'s 2026-09-27 addendum states "No `bluerails-machine-readable` plugin exists yet"). There is no prod entry point to trace for this PR; see Outcome Delivery.

PARITY-CHECK: The one real dual-source pair is llms.txt content vs. JSON-LD content — both must agree on facts like the star rating and phone number. Confirmed: `llms-txt.php` and `schema.php` both call `bluerails_dhz_facts()` exclusively and neither hardcodes an independent literal of any fact already in `facts.php` — no drift risk by construction.

FAILURE-MODE-ENUM: State — Yoast deactivated, or a future Yoast version renames/removes `robots_txt`/`wpseo_schema_graph`/`wpseo_sitemap_index_links`: WP silently no-ops an `add_filter` on a hook that never fires, so this degrades to "enrichment silently absent," not a fatal error — detected only by the manual "re-check quarterly" note in `robots.php`, no automated detection exists (a real, if low-stakes, gap). Time: only `events[].start_date` is time-sensitive and it's already null-guarded. Scale: bots (~28) and events (9) arrays are small and hardcoded, no scale risk. Trust: 100% first-party/hardcoded content, no external input trust boundary. Partial failure: `schema.php:16` guards `is_array($graph)`; `sitemap.php:18` guards `is_array($links)`; `robots.php` and `llms-txt.php` take no filter-input type risk (string concat only / no filter input consumed).

SIDE-EFFECT-COMPLETION: N/A — stateless read-time content filters; no money moved, no row written, no external API called, nothing to roll back.

STATE-MACHINE-COMPLETENESS: N/A — no enum/state machine. The one conditional branch (event `start_date` populated vs. not) is exhaustively handled in both directions (verified in finding 10).

IDEMPOTENCY-REPLAY: N/A — pure read-time filters, no mutation; replaying the same request always yields the same output.

INTEGRATION-REALITY: N/A — no external-service adapter touched (no Stripe/x402/DIRS21/bvnk/swap/LLM-provider call). The Yoast hooks are in-process WordPress filter calls within the same PHP request, not network calls to a third party.

## Product Manager findings and depth markers

**Right thing, right scope, real live gap** (see Necessity check above). Carries forward the ticket review's one still-open Important PM finding (no Discovery-rescan step after ship) — correctly out of scope for *this* source-landing PR since upload is a separate founder-gated step; flagged as a Suggestion to track for that later step, not a blocker here.

IN-CONTEXT-REVIEW: N/A — machine/contract surface (an HTTP route, a `robots_txt` filter, a `wpseo_schema_graph` filter), not a rendered app page. In place of a page render, verified the actual contract this session: live `curl` of `robots.txt`/`llms.txt` against the real production customer site, and the real JSON-LD Yoast currently emits (parsed from `home.html`) — the closest equivalent to an integration test for this surface.

SIBLING-METRIC-COHERENCE: N/A — machine/contract surface, no adjacent rendered metrics.

DECISION-CHALLENGE: The diff's direction is "enrich Yoast's existing schema graph in place via a filter," not the two alternatives the ticket review considered and rejected: (a) replace Yoast's schema output entirely — rejected, would drop Yoast's own valid `WebPage`/`BreadcrumbList`/`WebSite` nodes and create a second maintenance surface; (b) hand-write a static JSON-LD block alongside Yoast's — rejected, would create two independently-driftable schema outputs on the same page. The additive-filter direction matches the ticket's actual ask ("enrich," not "replace") and is the right call.

BASELINE-ANCHOR: N/A — not a Bluerails product surface (reservations/rate-calendar/dashboard/operator console); it's a third-party customer's own WordPress site content, so no `.planning/**/*BASELINE*` applies. Externally researched instead (satisfying the "external research step" requirement for a legitimate N/A): this repo's own established, previously-shipped pattern for the same remediation class on other customers (`wp-schema-remediation`/`ai-visibility-crawler-files` skills, executed live for ostkueste.com, badehof.de, rhoenresidence.de, benessere-hotels.de — all real prior executions, not this session's guess) is the closest available external-equivalent baseline for "AEO remediation done well" in this exact niche (no published industry scorecard exists for WP AEO plugins); this PR's mechanism choices match that established pattern.

PER-SURFACE-RENDER: N/A — single non-rendered surface (the customer's own WordPress site); nothing in this repo renders it.

RENDER-PROVENANCE: N/A — no render harness applies; verification used live `curl` against the real production site plus the captured evidence HTML/JSON, not a dev/catalog tool.

ALL-STATES-COVERAGE: The core value (populated llms.txt, allow-listed robots.txt, enriched JSON-LD) is unconditional static content on every request — no app-side empty/sparse/rich data states apply the way they would for a dashboard. The one genuine per-item state split is event `start_date` known vs. unknown; currently all 9 are unknown and correctly degrade to a valid-but-incomplete `Event` node (finding 10) rather than blocking or fabricating a date. No withheld state.

PERSONA-JTBD-CHECK: N/A — not a multi-persona operator console; the one external persona (the AI crawler/agent) is walked in the Persona lens section below.

AGENTIC-OPPORTUNITY-CHECK: N/A — not a Bluerails product UI with data displays/CTAs; no metric/trend/CTA exists on this surface for a "do it for me" affordance to apply to.

PRODUCT-FRAME: N/A — not a rendered Bluerails product surface; no UI chrome touched, the customer's own WordPress site visual identity is unaffected by this change.

JTBD-OUTCOME: "When an AI agent (ChatGPT, Claude, Perplexity, etc.) is asked about lodging/dining/events near Guntersblum/Worms, I want weingut-domhof.de's llms.txt/robots.txt/JSON-LD to be fetchable and structured, so I can answer with accurate, complete facts about Weingut Domhof instead of guessing or omitting it." This PR delivers the *mechanism* (the code is correct, per Tech findings above) but not yet the *outcome* — see Outcome Delivery below: nothing is live on the customer's site yet.

OUTCOME-ARTIFACT: The terminal artifact a consumer (an AI crawler) would come for is the live served `/llms.txt` response and the live enriched JSON-LD on weingut-domhof.de. Neither exists yet — confirmed by this session's own live curl (`llms.txt` still 404) and `wp-admin-observations.md`'s 2026-09-27 addendum (plugin not yet uploaded). Expected and disclosed for a source-landing PR; see Outcome Delivery.

PROD-REALITY: If this PR merges to `origin/main` exactly as-is right now, nothing changes on weingut-domhof.de — merging this repo's `main` has no deploy relationship to the customer's WordPress site; WP plugin upload is a separate, manual, founder-approved step (per this PR's own explicit scope statement), not CI/CD-triggered. No gap between what this PR promises and what merging it does.

PRESS-RELEASE-CLAIM: "An AI agent asking about family-run wineries with guest rooms near Worms can now find Weingut Domhof, accurately." Not truthful today — the plugin isn't live on the customer's site (see Outcome Delivery). Today's truthful claim is narrower: "Bluerails has written and reviewed the code that will make this true once uploaded and activated."

VERTICAL-SLICE: Wired end-to-end within this PR's own declared scope — the source code is complete and internally coherent (Completeness section below). The first genuinely unwired step is upload/activation on the live site, which is deliberately excluded from this PR's scope (a separate founder-gated action), not a stub left inside it.

PERSONA-JOURNEY: See the Persona lens walk below — the only external persona this change serves is the AI crawler/agent, not a human.

## Cost/Perf depth marker

HOT-PATH-COST: Three new code paths, each on its own narrow WP request type, none blocking a shared render path. `robots.php`'s `bluerails_dhz_add_ai_bot_allowlist()` runs once per `/robots.txt` request only, appends a fixed ~28-entry array via `implode()` — O(1) relative to request volume, no loop over unbounded data. `schema.php`'s `bluerails_dhz_enrich_schema_graph()` runs once per page load that generates JSON-LD (via Yoast's existing `wpseo_schema_graph` filter, which already runs on every front-end page regardless of this plugin) — this plugin adds a single `foreach` over the existing `$graph` array (already small, Yoast-bounded) plus a fixed 9-item `foreach` over `$f['events']`; no new DB query, no new network call, no N+1. `sitemap.php`'s filter runs only on sitemap-index requests (rare, cached by Yoast), a single `foreach` + `array_values()` over an already-small `$links` array. No LLM/model call anywhere in this plugin. Verified by reading each function's body directly (all three shown in full above) — no hidden loop or call was missed.

## Persona lens — AI crawler/agent walk

Walked the actual code + live site state through the three steps an AI crawler/agent takes:

1. **Fetch `/robots.txt`** → sees the plugin's new named-bot `Allow: /` stanzas (`robots.php`), confirmed to render *before* Yoast's own block at the priority verified in finding 7 — no stanza-order dependency risk for a per-`User-agent` parser. Agent proceeds.
2. **Fetch `/llms.txt`** → today still 404 (unchanged until upload, confirmed live); once uploaded, returns the structured facts file whose content I independently spot-checked against evidence (Tech finding 1) — org identity, NAP, business-line pages, awards, events, all traceable and accurate.
3. **Crawl a normal page** → encounters Yoast's existing JSON-LD plus this plugin's enrichment: `Organization` (now with address/geo/telephone/email/sameAs/award), plus new `Hotel`/`Restaurant`/`EventVenue`/`Event` nodes, all structurally valid (JSON validated, referential `@id`/`isPartOf`/`location` links checked and consistent).

Every step an agent needs succeeds with real, sourced fields — no dead end, no step returning a fabricated value the agent could act on incorrectly, **except** the one already flagged as Important (finding 9): the `award` field on the Organization node could cause an agent to attribute the Schlafgut-specific "3 Sterne Superior" rating to the whole multi-business-line Organization (including the restaurant/winery), which would be a real, actionable misattribution to a user asking "is the restaurant highly rated?"

## Content-accuracy findings

**9. (Important) The `award` field is attached to both the Hotel node AND the top-level Organization node, but the underlying source is guesthouse-specific.** `FACTS-SHEET.md` and the cited blog post ("3 Sterne Superior für SCHLAFGUT Domhof") both make clear the DEHOGA "3 Sterne Superior" classification applies to the **Schlafgut guesthouse/accommodation**, not to Weingut Domhof as a whole (which also encompasses the winery, the Schmecktgut restaurant, and the Feiergut/Tagegut event venue as separate business lines/nodes in the same graph). `includes/schema.php:46` sets `award` on the Organization node with the identical text used on the Hotel node (`includes/schema.php:83`). An AI agent reading the enriched Organization node could reasonably attribute the guesthouse-specific rating to the restaurant or winery as well — a real, if subtle, accuracy risk in exactly the surface (JSON-LD consumed by AI agents) this ticket exists to make more trustworthy. **Fix: drop `award` from the Organization node, or qualify the text there (e.g., "Gästehaus/Schlafgut: 3 Sterne Superior (DEHOGA)") so it's unambiguous which business line it describes.**

**10. (Clean) Every other disclosed gap is genuinely honest, not papered over.** Verified directly: `facts.php`'s `events` array has `start_date => null` for all 9 events (matches `events-sitemap.xml`, which only has `lastmod`, no event date field at all); `schema.php`'s `bluerails_dhz_event_node()` only emits `startDate`/`eventStatus`/`eventAttendanceMode` when `start_date` is non-empty — confirmed the preview JSON's 9 `Event` nodes correctly omit those fields, no placeholder/fabricated dates. Facebook and Pinterest `sameAs` are correctly omitted (both are linked from the live site's own footer, confirmed in `home.html`) with a stated, sound reason (no WebFetch page-title confirmation obtained) rather than a guessed URL. Rich Results Test not-run is disclosed as a deferred step, not silently skipped.

## Completeness against the ticket

`.claude/ticket-reviews/BLUE-2029.md` names four required mechanisms; all four are present and wired through the single plugin bootstrap (`bluerails-machine-readable.php` requires all five includes): llms.txt route (`llms-txt.php`), named-AI-bot robots.txt allow-list (`robots.php`), `wpseo_schema_graph` JSON-LD enrichment (`schema.php`), author-sitemap removal (`sitemap.php`). Matches.

The ticket review's one outstanding PM finding — no step triggers a Discovery rescan / customer-facing dashboard update after ship — is still open, but correctly out of scope for *this* PR: upload/activation on the live site is an explicitly separate, founder-gated step (per this PR's own scope statement), so a post-upload rescan step belongs to that later step, not this one. Flagging as a Suggestion to track, not a blocker here.

## What's done well

The fact-provenance discipline is unusually strong even setting aside finding 1 — every value in `facts.php` traces to a real, checkable source, and every spot-check I ran against the actual evidence files (address, phone, fax, email, postcode, the star-rating blog post, all 13 business-line page URLs, all 9 event URLs) matched exactly. The `wpseo_sitemap_index_links` citation is a new claim this review independently verified against real pinned Yoast source (not just carried over from the ticket review) and it checks out to the exact line. The disclosed-gap handling (event dates, Facebook/Pinterest sameAs, Rich Results Test) is a textbook case of leaving a gap visibly incomplete rather than inventing a plausible-looking value to fill it — exactly the discipline this repo's citation-integrity culture asks for.

## Outcome Delivery

NOT-DELIVERED: the ticket's user outcome (an AI agent fetching weingut-domhof.de finds a populated `/llms.txt`, named-AI-bot `Allow:` entries in `robots.txt`, and an enriched JSON-LD graph) is not live as-merged — confirmed via live `curl` this session (`llms.txt` still 404, `robots.txt` still Yoast-only) and `wp-admin-observations.md`'s 2026-09-27 addendum (`bluerails-machine-readable` plugin not yet uploaded to weingut-domhof.de). This PR's own explicit scope is source-landing only; upload/activation on the live site is a separate, founder-gated step not covered by this review. Missing/deferred: the upload + activation step itself, plus this review's two Important fixes (evidence directory not committed — finding 1; `award` node misattribution — finding 9) and one Important comment-discipline cleanup (finding 2) — tracked: BLUE-2029.

## Verification Story

- Artifacts covered: PHP (6 files, all `php -l` clean, checked myself), JSON (`schema-graph-preview.json`, valid + structurally cross-checked against the PHP logic), Markdown (`FACTS-SHEET.md`, spot-checked against evidence, citation-duplication flagged), a WP plugin's use of three WordPress/Yoast hook APIs (`robots_txt`, `wpseo_schema_graph`, `wpseo_sitemap_index_links` — all three independently re-verified against pinned Yoast 20.2.1 source via `gh api`, not trusted from prior claims).
- Tests reviewed: no automated test suite exists for this plugin (none expected — it's static/deterministic PHP with no state); manual verification (`php -l`, JSON validation, live `curl`, evidence spot-checks) substitutes here and is documented above.
- Build verified: N/A (WordPress plugin, no build step; PHP syntax-checked directly).
- Security checked: yes — no escaping gaps, no injection surface, no secrets, no auth surface needed (plugin has no admin UI/options).
- Docs/prose checked: yes — `FACTS-SHEET.md` facts spot-checked against evidence (all matched); found the evidence directory itself isn't committed (finding 1); found one wrong citation line number (finding 3); found in-code comment duplication of the same "why" across files (finding 2).
