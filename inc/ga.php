<?php
/**
 * Google Analytics functions
 *
 * @package makotokw
 */

/**
 * @return bool|string
 * @see https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference?hl=ja#contentGroup
 */
function makotokw_get_category_content_group() {
	/** @var WP_Query $wp_query */
	global $wp_query;
	$cat = null;
	if ( is_single() ) {

		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			$cat = $cats[0];
		}
	} elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
	}
	if ( $cat ) {
		if ( $cat->category_parent ) {
			return rtrim( get_category_parents( $cat->term_id, false, '/', true ), '/' );
		}
		return $cat->slug;
	}
	return false;
}

function makotokw_google_analytics() {
	if ( true === WP_THEME_DEBUG || false === WP_THEME_GOOGLE_ANALYTICS_ACCOUNT ) {
		return;
	}
	if ( is_user_logged_in() ) {
		return;
	}
	$content_group1 = makotokw_get_category_content_group();
	$config         = array(
		'linker' => array(
			'domains' => array( WP_THEME_GOOGLE_ANALYTICS_DOMAIN ),
		),
	);
	if ( $content_group1 ) {
		$config['content_group1'] = $content_group1;
	}

	wp_enqueue_script(
		'makotokw-google-analytics',
		'https://www.googletagmanager.com/gtag/js?id=' . rawurlencode( WP_THEME_GOOGLE_ANALYTICS_ACCOUNT ),
		array(),
		wp_get_theme()->get( 'Version' ),
		false
	);
	wp_add_inline_script(
		'makotokw-google-analytics',
		sprintf(
			"window.dataLayer = window.dataLayer || [];\nfunction gtag(){dataLayer.push(arguments);}\ngtag('js', new Date());\ngtag('config', %s, %s);",
			wp_json_encode( WP_THEME_GOOGLE_ANALYTICS_ACCOUNT ),
			wp_json_encode( $config )
		)
	);
}
add_action( 'wp_enqueue_scripts', 'makotokw_google_analytics' );
