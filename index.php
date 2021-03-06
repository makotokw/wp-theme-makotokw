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

// This template is required for
//  - Archives Page
//  - Site Front Page
//  - Error 404 Page
//  - Search Result Page

get_header(); ?>

<?php if ( is_archive() || is_search() ) : ?>
<header class="site-content-header">
	<div class="section-inner">
		<h2 class="archives-title"><?php makotokw_archives_title(); ?></h2>
		<?php makotokw_breadcrumbs(); ?>
	</div>
</header>
<?php endif ?>
<?php if ( have_posts() ) : ?>
	<div class="post-summaries">
		<?php while ( have_posts() ) : ?>
			<?php
				the_post();
				get_template_part( 'template-parts/content', 'summary' );
			?>
		<?php endwhile; ?>
	</div>
	<?php makotokw_pagination(); ?>
<?php else : ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
