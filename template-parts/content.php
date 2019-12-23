<?php
/**
 * @package makotokw
 */
$post_type = get_post_type();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-detailed' ); ?>>
	<header class="entry-header">
		<?php makotokw_the_post_primary_meta(); ?>
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
		<?php makotokw_the_post_secondary_meta(); ?>
	</header>
	<div class="entry-content">
		<div class="section-inner">
			<?php the_content(); ?>
		</div>
		<?php if ( defined( 'JETPACK_DEV_DEBUG' ) && JETPACK_DEV_DEBUG === true ) : ?>
			<div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
			</div>
		<?php endif ?>
	</div>
	<footer class="entry-footer">
		<div class="entry-meta">
			<?php makotokw_author(); ?>
		</div>
		<?php makotokw_share_this(); ?>
		<?php if ( 'post' === $post_type ) : ?>
			<?php makotokw_related_portfolio( __( 'Related Software', 'makotokw' ) ); ?>
			<?php makotokw_related_posts( __( 'Related Posts', 'makotokw' ) ); ?>
			<?php makotokw_content_nav(); ?>
		<?php else : ?>
			<?php makotokw_related_posts( __( 'Related Posts', 'makotokw' ) ); ?>
		<?php endif ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
