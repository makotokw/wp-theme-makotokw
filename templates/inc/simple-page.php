<?php
/**
 * @var string $makotokw_title
 * @var string $makotokw_contents
 */
get_header();
the_post();
?>
	<article class="post-detailed">
		<header class="entry-header">
			<h1 class="entry-title"><?php echo $makotokw_title; ?></h1>
		</header>
		<div class="entry-content section-inner">
			<?php echo $makotokw_contents; ?>
		</div>
	</article>
<?php
get_footer();
