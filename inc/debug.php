<?php
/**
 * Debug functions
 *
 * @package makotokw
 */

/**
 * @param WP_Query $query
 */
function makotokw_pre_get_posts_debug( $query ) {
	if ( is_archive() ) {
		$query->set( 'posts_per_page', '365' );
		$query->set( 'order', 'ASC' );
	}
}

// phpcs:disable Squiz.PHP.CommentedOutCode.Found
/*
if ( WP_THEME_DEBUG ) {
	add_action( 'pre_get_posts', 'makotokw_pre_get_posts_debug' );
}*/
// phpcs:enable Squiz.PHP.CommentedOutCode.Found
