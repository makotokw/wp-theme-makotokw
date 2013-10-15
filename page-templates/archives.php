<?php
/**
 * @subpackage makotokw
 * Template Name: Archives
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<article class="hentry">
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry-content">
				<ul>
					<?php wp_get_archives('show_post_count=true'); ?>
				</ul>
			</div>
		</article>
	</div>
</section>

<?php get_footer(); ?>
