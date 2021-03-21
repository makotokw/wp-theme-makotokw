<?php
/**
 * @var string $t_title
 * @var string $t_contents
 */
get_header();
the_post();
?>
	<article class="post-detailed">
		<header class="entry-header">
			<h1 class="entry-title"><?php echo $t_title; ?></h1>
		</header>
		<div class="entry-content section-inner">
			<?php echo $t_contents; ?>
		</div>
	</article>
<?php
get_footer();
