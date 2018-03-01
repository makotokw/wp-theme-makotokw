<?php
/**
 * @subpackage makotokw
 * Template Name: Tags
 * /tags/
 */
include __DIR__ . '/header.php'; ?>
<article class="hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">
		<?php makotokw_tag_cloud( array( 'number' => '' ) ); ?>
	</div>
</article>
<?php include __DIR__ . '/footer.php'; ?>
