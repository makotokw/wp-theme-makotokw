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
	?>
	<script async src="<?php echo esc_url( 'https://www.googletagmanager.com/gtag/js?id=' . WP_THEME_GOOGLE_ANALYTICS_ACCOUNT ); ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo esc_js( WP_THEME_GOOGLE_ANALYTICS_ACCOUNT ); ?>', {
			<?php if ( $content_group1 ) : ?>
			'content_group1' : '<?php echo esc_js( $content_group1 ); ?>',
			<?php endif ?>
			'linker': {
				'domains': ['<?php echo esc_js( WP_THEME_GOOGLE_ANALYTICS_DOMAIN ); ?>']
			}
		});
	</script>
	<?php
}
