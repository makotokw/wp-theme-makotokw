<?php
/**
 * @subpackage makotokw
 * Template Name: Help
 */
include __DIR__ . '/header.php'; ?>
<?php the_post(); ?>
<article class="hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="help-content">
		<?php the_content(); ?>
	</div>
</article>
<?php
include __DIR__ . '/footer.php';
