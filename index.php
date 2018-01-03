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

<header class="site-content-header">
	<h1 class="blog-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>"  width="190" height="40" class="site-logo" />
		</a>
	</h1>
	<h2 class="archives-title">
		<?php if ( is_category() ) : ?>
			<?php echo sprintf( __( 'Category Archives: %s', 'makotokw' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
		<?php elseif ( is_tag() ) : ?>
			<?php echo sprintf( __( 'Tag Archives: %s', 'makotokw' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
		<?php elseif ( is_day() ) : ?>
			<?php echo sprintf( __( 'Daily Archives: %s', 'makotokw' ), '<span>' . get_the_date() . '</span>' ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php echo sprintf( __( 'Monthly Archives: %s', 'makotokw' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php echo sprintf( __( 'Yearly Archives: %s', 'makotokw' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
		<?php elseif ( is_tax( 'blogs' ) ) : ?>
			<?php echo sprintf( __( 'Blog Archives: %s', 'makotokw' ), '<span>' . single_term_title( '', false ) . '</span>' ); ?>
		<?php elseif ( is_tax( 'portfolios' ) ) : ?>
			<?php echo sprintf( __( 'Portfolio Archives: %s', 'makotokw' ), '<span>' . single_term_title( '', false ) . '</span>' ); ?>
		<?php elseif ( is_search() ) : ?>
			<?php echo __( 'Search', 'makotokw' ); ?>
		<?php else : ?>
			<?php echo __( 'Archives', 'makotokw' ); ?>
		<?php endif; ?>
	</h2>
</header>
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

<?php get_footer(); ?>
