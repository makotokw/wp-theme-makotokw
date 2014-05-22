<?php
/**
 * @subpackage makotokw
 * Template Name: Archive
 */
$paged  = get_query_var( 'paged' );
$offset = 0;
if ( $paged != 0 ) {
	$offset = ($paged - 1) * get_query_var( 'posts_per_page' );
}
$query = new WP_Query( 'post_type=post&offset=' . $offset );
// hack: for is_home()
$query->is_archive   = true;
$GLOBALS['wp_query'] = $query;?>

<?php include __DIR__ . '/header.php'; ?>

	<?php if ( $query->have_posts() ) : ?>

		<?php /* Start the Loop */ ?>
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>

			<?php
			/* Include the Post-Format-specific template for the content.
			 * If you want to overload this in a child theme then include a file
			 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
			 */
			get_template_part( 'content', get_post_format() );
			?>

		<?php endwhile; ?>

		<?php makotokw_pagination(); ?>

	<?php else : ?>

		<?php get_template_part( 'no-results', 'index' ); ?>

	<?php endif; ?>

<?php include __DIR__ . '/footer.php'; ?>
