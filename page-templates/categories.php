<?php
/**
 * @subpackage makotokw
 * Template Name: Categories
 * /categories/
 */
include __DIR__ . '/header.php'; ?>
<article class="hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">
		<ul class="list-categories">
			<?php makotokw_list_categories( true ); ?>
		</ul>
	</div>
</article>
<?php include __DIR__ . '/footer.php'; ?>
