<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package makotokw
 */

get_header(); ?>

	<div class="site-content-area">
		<main class="site-content" role="main">
			<div class="container">
				<?php if ( have_posts() ) : ?>
					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'makotokw' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
					</header><!-- .page-header -->
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content' ); ?>
					<?php endwhile; ?>
					<?php makotokw_pagination(); ?>
				<?php else : ?>
					<?php get_template_part( 'no-results', 'search' ); ?>
				<?php endif; ?>
			</div>
		</main>
	</div>

<?php get_footer(); ?>