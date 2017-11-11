<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package makotokw
 */

get_header(); ?>

	<div class="site-content-area">
		<main class="site-content" role="main">
			<div class="container">
				<?php if ( is_archive() ) : ?>
					<?php makotokw_breadcrumbs(); ?>
				<?php endif ?>
				<?php if ( have_posts() ) : ?>
					<div class="post-summaries">
						<?php while ( have_posts() ) : ?>
							<?php
								the_post();
								get_template_part( 'content' );
							?>
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
