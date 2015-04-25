<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package makotokw
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function makotokw_infinite_scroll_setup() {
	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'content',
			'footer' => 'page',
		)
	);
}

add_action( 'after_setup_theme', 'makotokw_infinite_scroll_setup' );

// Disable OGP in jetpack
// http://wordpress.org/support/topic/plugin-jetpack-cant-disable-opengraph
add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
