<?php
/**
 * @package makotokw
 */
$post_type = get_post_type();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php the_title(); ?>
		</h1>
		<section class="entry-meta">
			<?php if ( 'post' == $post_type ) : ?>
				<?php makotokw_the_post_date(); ?>
				<span class="tag-links"><?php makotokw_the_category_slug( '', ', ' ); ?><?php makotokw_the_tags_slug( ', ', ', ' ); ?><?php makotokw_the_terms_slug( 'portfolios', ', ', ', ' ); ?></span>
			<?php endif; ?>
		</section>
	</header>
	<div class="entry-content">
		<?php makotokw_breadcrumbs(); ?>
		<?php the_content(); ?>
		<?php if ( JETPACK_DEV_DEBUG === true ) : ?>
			<div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
			</div>
		<?php endif ?>
		<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'makotokw' ),
					'after'  => '</div>',
				)
			);
		?>
	</div>
	<footer class="entry-footer">
		<div class="entry-meta">
			<?php makotokw_author(); ?>
		</div>
		<?php makotokw_share_this(); ?>
		<?php if ( 'post' == $post_type ) : ?>
			<?php makotokw_list_nav(); ?>
			<?php makotokw_section_category_and_tag( __( 'Tag', 'makotokw' ) ); ?>
			<?php makotokw_related_portfolio( __( 'Related Software', 'makotokw' ) ); ?>
			<?php makotokw_related_posts( __( 'Related Posts', 'makotokw' ) ); ?>
			<?php makotokw_content_nav( 'nav-below' ); ?>
		<?php else : ?>
			<div class="section section-mini section-2col section-last-updated">
				<h2 class="section-title"><?php _e( 'Last Updated', 'makotokw' ); ?></h2>
				<div class="section-content"><?php makotokw_updated_on(); ?></div>
			</div>
			<?php makotokw_related_posts(); ?>
		<?php endif ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
