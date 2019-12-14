<?php
get_header();
the_post();
?>
	<article class="post-single">
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</article>
<?php
get_footer();
