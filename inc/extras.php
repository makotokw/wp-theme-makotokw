<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package makotokw
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function makotokw_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'makotokw_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function makotokw_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	return $classes;
}

add_filter( 'body_class', 'makotokw_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function makotokw_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
		return $url;
	}

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id ) {
		$url .= '#main';
	}

	return $url;
}

add_filter( 'attachment_link', 'makotokw_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function makotokw_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'makotokw' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'makotokw_wp_title', 10, 2 );

/**
 * @param WP_Query $query
 */
function makotokw_pre_get_posts( $query ) {
	if ( is_home() ) {
		$query->set( 'posts_per_page', '10' );
	}
}

add_action( 'pre_get_posts', 'makotokw_pre_get_posts' );

function makotokw_template_redirect() {
	if ( is_page() && ! is_preview() ) {
		if ( $values = get_post_custom_values( 'makotokw_part_of_home' ) ) {
			if ( 1 == $values[0] ) {
				wp_redirect( home_url( '/' ) );
				exit;
			}
		}
	}
}

add_action( 'template_redirect', 'makotokw_template_redirect' );
