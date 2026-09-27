<?php
/**
 * Removes the author-sitemap entry from sitemap_index.xml (exposes WP
 * usernames). The author provider registers directly rather than through a
 * filterable list, so removing its entry after the fact is the only seam.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'wpseo_sitemap_index_links', 'bluerails_dhz_remove_author_sitemap_link' );

function bluerails_dhz_remove_author_sitemap_link( $links ) {
	if ( ! is_array( $links ) ) {
		return $links;
	}

	foreach ( $links as $i => $link ) {
		// Match the stem, not just the unpaginated literal — paginated entries
		// are 'author-sitemap2.xml', etc.
		if ( isset( $link['loc'] ) && false !== strpos( $link['loc'], 'author-sitemap' ) ) {
			unset( $links[ $i ] );
		}
	}

	return array_values( $links );
}
