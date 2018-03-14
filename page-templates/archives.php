<?php
/**
 * @subpackage makotokw
 * Template Name: Archives
 * /archives/
 */
include __DIR__ . '/header.php'; ?>
<article class="hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">
		<section class="archive-page">
			<?php makotokw_inline_archives(); ?>
		</section>
	</div>
</article>
<?php include __DIR__ . '/footer.php'; ?>
