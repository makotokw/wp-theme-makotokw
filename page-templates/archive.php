<?php
/**
 * @subpackage makotokw
 * Template Name: Archive
 */
$paged  = intval( get_query_var( 'paged' ) );
$offset = 0;
if ( 0 !== $paged ) {
	$offset = ( $paged - 1 ) * get_query_var( 'posts_per_page' );
}
$query = new WP_Query( 'post_type=post&offset=' . $offset );
// hack! for is_home()
$query->is_archive   = true;
$GLOBALS['wp_query'] = $query;
include __DIR__ . '/../index.php';
