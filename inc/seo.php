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
