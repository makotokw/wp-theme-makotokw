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
function makotokw_infinite_scroll_setup()
{
	add_theme_support('infinite-scroll', array(
		'container' => 'content',
		'footer' => 'page',
	));
}

add_action('after_setup_theme', 'makotokw_infinite_scroll_setup');

function makotokw_publicize_save_meta($submit_post, $post_id, $service_name, $connection)
{
	if ($service_name != 'twitter') {
		return;
	}
	$prefix = 'ブログ更新:';
	$title = get_the_title($post_id);
	$publicize_custom_message = get_post_meta($post_id, '_wpas_mess', true);
	if (empty($publicize_custom_message)
		|| ($publicize_custom_message &&
			((strpos($publicize_custom_message, $prefix) === 0 && strpos($publicize_custom_message, $prefix . ' ' . $title) !== 0 )
				|| strpos($publicize_custom_message, $title) === 0))) {
		$publicize_custom_message = sprintf(
			"%s %s %s",
			$prefix,
			$title,
			wp_get_shortlink($post_id, 'post')
		);
		update_post_meta($post_id, '_wpas_mess', $publicize_custom_message);
	}
}

add_action('publicize_save_meta', 'makotokw_publicize_save_meta', 10, 4);

// Disable OGP in jetpack
// http://wordpress.org/support/topic/plugin-jetpack-cant-disable-opengraph
add_filter('jetpack_enable_opengraph', '__return_false', 99);
//add_filter( 'jetpack_enable_open_graph', '__return_false', 99 );