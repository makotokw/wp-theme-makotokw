<?php
/**
 * @subpackage makotokw
 * Template Name: Portfolios
 */
include __DIR__ . '/header.php'; ?>
<article class="hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">
		<?php wp_nav_menu(
			array(
				'theme_location'  => 'portfolio',
				'container_class' => 'portfolio-list',
				'link_before'     => '',
				'link_after'      => '',
			)
		); ?>
	</div>
</article>
</div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
