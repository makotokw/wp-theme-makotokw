<?php
/**
 * The Template for displaying all single posts.
 *
 * @package makotokw
 */

get_header(); ?>

<div class="container">
<?php while ( have_posts() ) : ?>
	<?php
		the_post();
		get_template_part( 'content' );
	?>
	<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
		<?php comments_template(); ?>
	<?php endif ?>
<?php endwhile; // end of the loop. ?>
</div>
<?php get_template_part( 'author' ); ?>
<?php get_footer(); ?>
