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
		<ul>
			<?php wp_get_archives( 'show_post_count=true' ); ?>
		</ul>
	</div>
</article>
<?php include __DIR__ . '/footer.php'; ?>
