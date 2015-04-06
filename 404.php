<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package makotokw
 */

get_header(); ?>

	<div class="site-content-area ">
		<main class="site-content site-content-error404" role="main">
			<div class="container">

				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'makotokw' ); ?></h1>
				</header>

			</div>

			<div class="page-wrapper">
				<div class="page-content">
					<div class="container">
						<?php get_search_form(); ?>
					</div>
				</div>

			</div>

		</main>
	</div>

<?php get_footer(); ?>