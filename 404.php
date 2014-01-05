<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package makotokw
 */

get_header(); ?>

	<div id="primary" class="site-content-area">
		<div id="content" class="site-content" role="main">

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Not Found', 'makotokw' ); ?></h1>
			</header>

			<div class="page-wrapper">
				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'makotokw' ); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->

			</div><!-- .page-wrapper -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>