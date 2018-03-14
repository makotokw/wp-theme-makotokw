<?php
/**
 * @subpackage makotokw
 * Template Name: Portfolios
 * /portfolio/
 */
include __DIR__ . '/header.php'; ?>
<article class="hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'portfolio',
				'container_class' => 'portfolio-list',
				'link_before' => '',
				'link_after' => '',
				'fallback_cb' => false,
			)
		);
		?>
	</div>
</article>

<?php include __DIR__ . '/footer.php'; ?>
