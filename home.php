<?php
/**
 * @package makotokw
 */

function makotekw_home_after_body() {
	?>
<?php
}
add_action('makotekw_after_body', 'makotekw_home_after_body');
get_header(); ?>
<div id="primary" class="content-area">
	<main id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php makotokw_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>
	</main>
</div>

<?php get_footer(); ?>
