<?php
/**
 * mylist for wordpress
 */

add_action( 'init', 'makotokw_taxonomy_init', 0 );

/**
 * taxonomy for kwLog
 */
function makotokw_taxonomy_init() {

	// labels
	//'name' => array( _x( 'Tags', 'taxonomy general name' ), _x( 'Categories', 'taxonomy general name' ) ),
	//'singular_name' => array( _x( 'Tag', 'taxonomy singular name' ), _x( 'Category', 'taxonomy singular name' ) ),
	//'search_items' => array( __( 'Search Tags' ), __( 'Search Categories' ) ),
	//'popular_items' => array( __( 'Popular Tags' ), null ),
	//'all_items' => array( __( 'All Tags' ), __( 'All Categories' ) ),
	//'parent_item' => array( null, __( 'Parent Category' ) ),
	//'parent_item_colon' => array( null, __( 'Parent Category:' ) ),
	//'edit_item' => array( __( 'Edit Tag' ), __( 'Edit Category' ) ),
	//'view_item' => array( __( 'View Tag' ), __( 'View Category' ) ),
	//'update_item' => array( __( 'Update Tag' ), __( 'Update Category' ) ),
	//'add_new_item' => array( __( 'Add New Tag' ), __( 'Add New Category' ) ),
	//'new_item_name' => array( __( 'New Tag Name' ), __( 'New Category Name' ) ),
	//'separate_items_with_commas' => array( __( 'Separate tags with commas' ), null ),
	//'add_or_remove_items' => array( __( 'Add or remove tags' ), null ),
	//'choose_from_most_used' => array( __( 'Choose from the most used tags' ), null ),
	//'not_found' => array( __( 'No tags found.' ), null ),
	register_taxonomy(
		'mylist',
		array( 'post' ),
		array(
			'hierarchical' => false,
			'label' => __( 'Mylists', 'makotokw' ),
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => true,
			'rewrite' => array( 'slug' => 'mylist' ),
			'labels' => array(
				'name' => _x( 'Mylists', 'taxonomy general name', 'makotokw' ),
				'singular_name' => _x( 'Mylist', 'taxonomy singular name', 'makotokw' ),
				'search_items' => __( 'Search Mylists', 'makotokw' ),
				'all_items' => __( 'All Mylists', 'makotokw' ),
				'edit_item' => __( 'Edit Mylist', 'makotokw' ),
				'update_item' => __( 'Update Mylist', 'makotokw' ),
				'add_new_item' => __( 'Add New Mylist', 'makotokw' ),
				'new_item_name' => __( 'New Mylist Name', 'makotokw' ),
			),
		)
	);

	register_taxonomy(
		'portfolios',
		array( 'post', 'page' ),
		array(
			'hierarchical' => true,
			'label' => __( 'Portfolios', 'makotokw' ),
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => false,
			'labels' => array(
				'search_items' => 'portfolio',
				'popular_items' => '',
				'all_items' => '',
				'parent_item' => '',
				'parent_item_colon' => '',
				'edit_item' => '',
				'update_item' => '',
				'add_new_item' => '',
				'new_item_name' => '',
				'separate_items_with_commas' => '',
				'add_or_remove_items' => '',
				'choose_from_most_used' => '',
			),
		)
	);

	register_taxonomy(
		'blogs',
		array( 'post' ),
		array(
			'hierarchical' => true,
			'label' => __( 'Blogs', 'makotokw' ),
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => false,
			'labels' => array(
				'search_items' => 'blog',
				'popular_items' => '',
				'all_items' => '',
				'parent_item' => '',
				'parent_item_colon' => '',
				'edit_item' => '',
				'update_item' => '',
				'add_new_item' => '',
				'new_item_name' => '',
				'separate_items_with_commas' => '',
				'add_or_remove_items' => '',
				'choose_from_most_used' => '',
			),
		)
	);

	// to re-generate rewrite rules
	flush_rewrite_rules();
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
	if ( $mylist = get_mylist( $post ) ) {
		$mylist_slug = $mylist->slug;
		if ( ! empty( $mylist_slug ) ) {
			$q = new WP_Query(
				array(
					'mylist' => $mylist_slug,
					'order' => 'ASC',
					'posts_per_page' => 1,
				)
			);
			if ( $q->have_posts() ) {
				return $adjacent_post = $q->next_post();
			}
		}
	}
	return false;
}

function get_adjacent_post_on_mylist( $post, $previous = true ) {
	if ( $mylist = get_mylist( $post ) ) {
		$mylist_slug = $mylist->slug;
		if ( ! empty( $mylist_slug ) ) {
			$date_query_compare = $previous ? 'before' : 'after';
			$order = $previous ? 'DESC' : 'ASC';
			$q = new WP_Query(
				array(
					'mylist' => $mylist_slug,
					'date_query' => array( $date_query_compare => $post->post_date ),
					'order' => $order,
					'posts_per_page' => 1,
				)
			);
			if ( $q->have_posts() ) {
				return $adjacent_post = $q->next_post();
			}
		}
	}
	return false;
}
