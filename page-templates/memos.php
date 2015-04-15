<?php
/**
 * @subpackage makotokw
 * Template Name: Memos
 */
include __DIR__ . '/header.php'; ?>
<article class="hentry">
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry-content">
		<ul class="memo-list">
			<?php wp_list_pages( array( 'title_li' => false, 'child_of' => WP_THEME_MEMO_POST_ID ) ); ?>
		</ul>
	</div>
</article>

<?php include __DIR__ . '/footer.php'; ?>
