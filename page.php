<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package makotokw
 */

get_header(); ?>

<div class="site-content-area">
	<main class="site-content" role="main">
		<div class="container">
			<?php while (have_posts()) : the_post(); ?>

				<?php get_template_part('content', 'page'); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if (comments_open() || '0' != get_comments_number()):
					if (WP_THEME_ZENBACK === true):
						makotokw_zenback_widget();
					endif;
					comments_template();
				endif; ?>
			<?php endwhile; // end of the loop. ?>
		</div>
	</main>
</div>

<?php get_footer(); ?>
