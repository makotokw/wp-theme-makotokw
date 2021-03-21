<?php
/**
 * @package makotokw
 * Template Name: Help
 * Template Post Type: page
 */
__( 'Help', 'makotokw' );
get_header(); ?>
<?php while ( have_posts() ) : ?>
	<?php
	the_post();
	get_template_part( 'template-parts/content', 'help' );
	?>
<?php endwhile; // end of the loop. ?>
<?php
get_footer();
