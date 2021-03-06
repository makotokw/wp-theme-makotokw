<?php
/**
 * The Template for displaying all single posts.
 *
 * @package makotokw
 */

get_header(); ?>
<?php while ( have_posts() ) : ?>
	<?php
		the_post();
		get_template_part( 'template-parts/content' );
	?>
	<?php if ( comments_open() || 0 !== intval( get_comments_number() ) ) : ?>
		<?php comments_template(); ?>
	<?php endif ?>
<?php endwhile; // end of the loop. ?>
<?php
get_footer();
