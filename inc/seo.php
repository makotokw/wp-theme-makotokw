<?php
/**
 * SEO functions
 *
 * @package makotokw
 */

function makotokw_is_seo_noindex() {
	global $wp_query;
	if ( $wp_query ) {
		if ( $wp_query->is_archive() ) {
			if ( $wp_query->is_category() ) {
				$category_id = $wp_query->get_queried_object_id();
				if ( in_array( $category_id, wp_parse_id_list( WP_THEME_EXCLUDE_CATEGORY ), true ) ) {
					return true;
				}
				$paged = $wp_query->get( 'paged', 1 );
				// old pages should be noindexes
				return $paged > 3;
			} elseif ( makotokw_is_mylist() ) {
				return false;
			}
			return true;
		}
		if ( $wp_query->is_search() || $wp_query->is_404() || is_page_template( 'templates/template-help.php' ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Apply noindex,follow to low-value pages via the core robots meta tag.
 * Index pages keep WordPress's default robots directives.
 *
 * @param array $robots Robots directives.
 * @return array
 */
function makotokw_seo_robots( $robots ) {
	if ( makotokw_is_seo_noindex() ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
	}
	return $robots;
}
add_filter( 'wp_robots', 'makotokw_seo_robots' );

/**
 * Build the meta description for listing pages.
 * Keep existing behavior: singular views do not output a standard meta description here.
 *
 * @return string
 */
function makotokw_get_meta_description() {
	$description = '';
	if ( is_home() ) {
		$description = get_bloginfo( 'description' );
	} elseif ( is_archive() ) {
		$description = get_the_archive_description();
	}
	return $description;
}

/**
 * Output the meta description tag; WordPress has no core equivalent.
 */
function makotokw_seo_meta_description() {
	$description = makotokw_get_meta_description();
	if ( $description ) {
		printf( "<meta name=\"description\" content=\"%s\" />\n", esc_attr( $description ) );
	}
}
add_action( 'wp_head', 'makotokw_seo_meta_description', 1 );
