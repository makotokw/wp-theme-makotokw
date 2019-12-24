<?php
/**
 * @package makotokw
 */
$post_type = get_post_type();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-detailed' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
	</header>
	<div class="entry-content">
		<div class="section-inner">
			<?php the_content(); ?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
