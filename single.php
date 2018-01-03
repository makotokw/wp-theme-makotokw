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
		get_template_part( 'content' );
	?>
	<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
		<div class="container">
			<?php comments_template(); ?>
		</div>
	<?php endif ?>
<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
