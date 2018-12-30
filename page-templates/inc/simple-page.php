<?php
get_header();
the_post();
?>
	<article class="post-single">
		<header class="entry-header">
			<h1 class="entry-title"><?php echo $t_title; ?></h1>
		</header>
		<div class="entry-content">
			<?php echo $t_contents; ?>
		</div>
	</article>
<?php
get_footer();
