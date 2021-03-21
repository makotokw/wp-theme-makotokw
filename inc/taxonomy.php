<?php

/**
 * feature taxonomy by post
 * @param $post
 * @return array
 */
function makotokw_get_featured_taxonomy( $post ) {
	$taxonomies = array();

	// 1. find first portfolio
	$terms = get_the_terms( $post->ID, 'portfolios' );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$taxonomies[] = array_shift( $terms );
	}

	// 2. find featured tag
	if ( defined( 'WP_THEME_FEATURED_TAG' ) ) {
		$featured_tag_slugs = explode( ',', WP_THEME_FEATURED_TAG );
		$tags               = get_the_tags( $post->ID );
		if ( is_array( $tags ) && count( $tags ) ) {
			$tags = array_filter(
				$tags,
				function ( $t ) use ( $featured_tag_slugs ) {
					return in_array( $t->slug, $featured_tag_slugs, true );
				}
			);
			if ( ! empty( $tags ) ) {
				$taxonomies[] = array_shift( $tags );
			}
		}
	}

	// 3. find first category
	$categories = get_the_category( $post->ID );
	if ( ! empty( $categories ) ) {
		$taxonomies[] = array_shift( $categories );
	}

	return $taxonomies;
}

function is_mylist() {
	return is_tax( 'mylist' );
}

function get_mylist( $post ) {
	$mylists = get_the_terms( $post->ID, 'mylist' );
	if ( ! empty( $mylists ) ) {
		return array_shift( $mylists );
	}
	return null;
}

//function mylist_pre_get_posts($query)
//{
//	if (is_mylist()) {
//		$query->set('order', 'ASC');
//	}
//}
//
//add_action('pre_get_posts', 'mylist_pre_get_posts');

function get_first_post_on_mylist( $post ) {
	$mylist = get_mylist( $post );
	if ( $mylist ) {
		$mylist_slug = $mylist->slug;
		if ( ! empty( $mylist_slug ) ) {
			$q = new WP_Query(
				array(
					'mylist'         => $mylist_slug,
					'order'          => 'ASC',
					'posts_per_page' => 1,
				)
			);
			if ( $q->have_posts() ) {
				return $q->next_post();
			}
		}
	}
	return false;
}

function get_adjacent_post_on_mylist( $post, $previous = true ) {
	$mylist = get_mylist( $post );
	if ( $mylist ) {
		$mylist_slug = $mylist->slug;
		if ( ! empty( $mylist_slug ) ) {
			$date_query_compare = $previous ? 'before' : 'after';
			$order              = $previous ? 'DESC' : 'ASC';
			$q                  = new WP_Query(
				array(
					'mylist'         => $mylist_slug,
					'date_query'     => array( $date_query_compare => $post->post_date ),
					'order'          => $order,
					'posts_per_page' => 1,
				)
			);
			if ( $q->have_posts() ) {
				return $q->next_post();
			}
		}
	}
	return false;
}
