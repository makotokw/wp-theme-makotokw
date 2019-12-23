<?php
get_header();
the_post();
?>
	<article class="post-detailed">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content section-inner">
			<?php the_content(); ?>
		</div>
	</article>
<?php
get_footer();
