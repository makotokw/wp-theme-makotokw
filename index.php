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

<?php if ( ! is_home() ) : ?>
<header class="site-content-header">
	<h2 class="archives-title"><?php makotokw_archives_title(); ?></h2>
	<?php if ( is_archive() || is_search() ) : ?>
		<?php makotokw_breadcrumbs(); ?>
	<?php endif ?>
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
