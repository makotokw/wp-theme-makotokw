<?php
/**
 * @subpackage makotokw
 * Template Name: Tags
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content">
			<?php makotokw_tag_cloud(array('number' => '')); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>