<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package makotokw
 */

get_header(); ?>

	<div class="site-content-area">
		<main class="site-content" role="main">
			<div class="container">
				<?php if ( have_posts() ) : ?>
					<?php if ( ! is_category() && ! is_tag() ) : ?>
						<?php makotokw_page_header(); ?>
					<?php endif; ?>
					<div class="post-summaries">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content' ); ?>
						<?php endwhile; ?>
					</div>
					<?php makotokw_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'no-results' ); ?>
				<?php endif; ?>
			</div>
		</main>
	</div>

<?php get_footer(); ?>