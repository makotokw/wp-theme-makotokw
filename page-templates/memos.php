<?php
/**
 * @subpackage makotokw
 * Template Name: Memos
 */
get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">
		<article class="hentry">
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			<div class="entry-content">
				<ul class="memo-list">
					<?php wp_list_pages(array('title_li' =>false, 'show_date'=>true, 'child_of' => WP_THEME_MEMO_POST_ID)); ?>
				</ul>
			</div>
		</article>
	</div>
</section>

<?php get_footer(); ?>
