<?php
/**
 * mylist for wordpress
 */

add_action( 'init', 'mylist_init', 0 );

function mylist_init()
{
	$labels = array(
		'name' => _x('Mylists', 'taxonomy general name'),
		'singular_name' => _x('Mylist', 'taxonomy singular name'),
		'search_items' => __('Search Mylists'),
		'all_items' => __('All Mylists'),
		'edit_item' => __('Edit Mylist'),
		'update_item' => __('Update Mylist'),
		'add_new_item' => __('Add New Mylist'),
		'new_item_name' => __('New Mylist Name'),
		'menu_name' => __('Mylists'),
	);

	$args = array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'mylist'),
	);

	register_taxonomy('mylist', array('post'), $args);

	// to re-generate rewrite rules
	flush_rewrite_rules();
}

function is_mylist()
{
	return is_tax('mylist');
}

function get_mylist($post)
{
	$mylists = get_the_terms($post->ID, 'mylist');
	if (!empty($mylists)) {
		return array_shift($mylists);
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

function get_first_post_on_mylist($post)
{
	if ($mylist = get_mylist($post)) {
		$mylist_slug = $mylist->slug;
		if (!empty($mylist_slug)) {
			$q = new WP_Query(
				array(
					'mylist' => $mylist_slug,
					'order' => 'ASC',
					'posts_per_page' => 1,
				)
			);
			if ($q->have_posts()) {
				return $adjacent_post = $q->next_post();
			}
		}
	}
	return false;
}

function get_adjacent_post_on_mylist($post, $previous = true)
{
	if ($mylist = get_mylist($post)) {
		$mylist_slug = $mylist->slug;
		if (!empty($mylist_slug)) {
			$date_query_compare = $previous ? 'before' : 'after';
			$order = $previous ? 'DESC' : 'ASC';
			$q = new WP_Query(
				array(
					'mylist' => $mylist_slug,
					'date_query' => array(
						$date_query_compare => $post->post_date
					),
					'order' => $order,
					'posts_per_page' => 1,
				)
			);
			if ($q->have_posts()) {
				return $adjacent_post = $q->next_post();
			}
		}
	}
	return false;
}
