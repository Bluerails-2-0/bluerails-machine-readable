<?php
/**
 * Named-AI-bot allow-list. Priority 20 (explicit) runs before Yoast's own
 * robots_txt filter (priority 99999), so this block renders first.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'robots_txt', 'bluerails_dhz_add_ai_bot_allowlist', 20 );

function bluerails_dhz_add_ai_bot_allowlist( $output ) {
	return $output . "\n" . bluerails_dhz_ai_bot_allowlist_block();
}

function bluerails_dhz_ai_bot_allowlist_block() {
	// Deliberate policy: allow both search/citation AND pure-training bots, since the
	// site's wildcard already lets every unnamed crawler through — blocking only the
	// *named* training bots wouldn't restrict anything, just look restrictive. To
	// later differentiate, split this list and Disallow the training-bot group.
	$bots = array(
		// OpenAI
		'OAI-SearchBot',
		'ChatGPT-User',
		'OAI-AdsBot',
		'GPTBot',
		// Anthropic
		'Claude-SearchBot',
		'Claude-User',
		'ClaudeBot',
		// Perplexity
		'PerplexityBot',
		'Perplexity-User',
		// Google (AI-specific, beyond the default Googlebot already covered by *)
		'Google-Extended',
		'GoogleOther',
		'Google-CloudVertexBot',
		// Apple
		'Applebot-Extended',
		'Applebot',
		// Moonshot / Kimi
		'Kimi-SearchBot',
		'Kimi-User',
		'KimiBot',
		// Alibaba / Qwen
		'Qwen-User',
		'QwenBot',
		'TongyiBot',
		// Meta
		'Meta-ExternalAgent',
		'Meta-ExternalFetcher',
		// Mistral
		'MistralAI-Training',
		'MistralAI-User',
		// Others with documented AI-search/training relevance
		'CCBot',
		'Bytespider',
		'Amazonbot',
		'DeepSeekBot',
		'Diffbot',
		'DuckAssistBot',
		'PetalBot',
		'YandexAdditionalBot',
	);

	$lines   = array();
	$lines[] = '# BEGIN bluerails-machine-readable AI-bot allow-list';
	$lines[] = '# Explicit, deliberate policy: named AI search/citation and training';
	$lines[] = '# bots are allowed the same as every unnamed crawler under the wildcard';
	$lines[] = '# block below. Re-check quarterly and after any Yoast/WordPress update';
	$lines[] = '# against github.com/ai-robots-txt/ai.robots.txt.';
	foreach ( $bots as $bot ) {
		$lines[] = 'User-agent: ' . $bot;
		$lines[] = 'Allow: /';
		$lines[] = '';
	}
	$lines[] = '# END bluerails-machine-readable AI-bot allow-list';

	return implode( "\n", $lines );
}
