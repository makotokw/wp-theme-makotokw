<?php
/**
 * @subpackage makotokw
 * Template Name: Portfolios
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'portfolio',
					'container_class' => 'portfolio-list',
					'link_before' => '',
					'link_after' => '',
				))
			; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
