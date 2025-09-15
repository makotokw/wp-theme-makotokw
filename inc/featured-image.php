<?php
/**
 * Featured Image functions
 *
 * @package makotokw
 */

function makotokw_get_the_featured_image_url() {
	$featured_image_url     = null;
	$featured_image_service = null;
	if ( class_exists( 'Makotokw\PostUtility' ) ) {
		$featured_image_url = Makotokw\PostUtility::find_featured_image_url( null, $featured_image_service );
	}

	if ( $featured_image_url ) {
		return array( $featured_image_url, $featured_image_service );
	}

	$fallback_categories      = array( 'wordpress', 'programing', 'server', 'hardware', 'computer' );
	$fallback_image_timestamp = '20210301';

	$post_title      = get_the_title();
	$post_categories = get_the_category();
	foreach ( $fallback_categories as $fallback_category ) {
		if ( $post_title && preg_match( '/' . $fallback_category . '/i', $post_title ) ) {
			$featured_image_url     = get_template_directory_uri() . "/assets/images/featured/{$fallback_category}.png?{$fallback_image_timestamp}";
			$featured_image_service = 'fallback';
			break;
		}
		$filterd = array_filter(
			$post_categories,
			function ( $term ) use ( $fallback_category ) {
				return $term->slug === $fallback_category;
			}
		);
		if ( ! empty( $filterd ) ) {
			$featured_image_url     = get_template_directory_uri() . "/assets/images/featured/{$fallback_category}.png?{$fallback_image_timestamp}";
			$featured_image_service = 'fallback';
			break;
		}
	}

	if ( ! $featured_image_url ) {
		$featured_image_url     = get_template_directory_uri() . '/assets/images/default-fallback-image.png';
		$featured_image_service = 'fallback';
	}

	return array( $featured_image_url, $featured_image_service );
}
