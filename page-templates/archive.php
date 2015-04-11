<?php
/**
 * @subpackage makotokw
 * Template Name: Archive
 */
$paged = intval( get_query_var( 'paged' ) );
$offset = 0;
if ( 0 != $paged ) {
	$offset = ($paged - 1) * get_query_var( 'posts_per_page' );
}
$query = new WP_Query( 'post_type=post&offset=' . $offset );
// hack! for is_home()
$query->is_archive   = true;
$GLOBALS['wp_query'] = $query;
?>
<?php include __DIR__ . '/header.php'; ?>
	<?php if ( $query->have_posts() ) : ?>
		<div class="post-summaries">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php get_template_part( 'content' ); ?>
			<?php endwhile; ?>
		</div>
		<?php makotokw_pagination(); ?>
	<?php else : ?>
		<?php get_template_part( 'no-results' ); ?>
	<?php endif; ?>
<?php include __DIR__ . '/footer.php'; ?>
