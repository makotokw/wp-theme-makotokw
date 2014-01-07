<?php
/**
 * The Template for displaying all single posts.
 *
 * @package makotokw
 */

get_header(); ?>

	<div class="site-content-area">
		<main class="site-content" role="main">

			<div class="container">

				<?php while (have_posts()) : the_post(); ?>

					<?php get_template_part('content', 'single'); ?>

					<?php if (WP_THEME_ZENBACK === true): ?>
						<?php makotokw_zenback_widget(); ?>
					<?php endif ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template
					if (comments_open() || '0' != get_comments_number())
						comments_template();
					?>

				<?php endwhile; // end of the loop. ?>

			</div>

		</main>
	</div>

<?php get_footer(); ?>