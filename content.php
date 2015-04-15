<?php
/**
 * @package makotokw
 */
$post_type = get_post_type();
$is_detail_page = is_single() || is_page();
$only_excerpts = is_home() || is_year() || is_month() || is_search();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $is_detail_page ? 'post-single' : 'post-summary' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<?php if ( $is_detail_page ) : ?>
				<?php the_title(); ?>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'makotokw' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			<?php endif ?>
		</h1>
		<section class="entry-meta">
			<?php if ( 'post' == $post_type ) : ?>
				<span class="entry-date"><?php makotokw_posted_on(); ?></span>
				<span class="tag-links"><?php makotokw_the_category_slug( '', ', ' ); ?><?php makotokw_the_tags_slug( ', ', ', ' ); ?><?php makotokw_the_terms_slug( 'portfolios', ', ', ', ' ) ?></span>
			<?php endif; ?>
		</section>
	</header>

	<?php if ( $only_excerpts ) : ?>
		<div class="entry-summary">
			<p><?php echo makotokw_post_summary( $post->post_content ); ?></p>
			<a class="text-more-link" href="<?php the_permalink() ?>"><?php _e( 'Continue reading', 'makotokw' ); ?></a>
		</div>
	<?php else : ?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'makotokw' ),
					'after'  => '</div>',
				)
			); ?>
		</div>
	<?php endif; ?>

	<footer class="entry-footer">
		<section class="entry-meta">
			<?php makotokw_author(); ?>
		</section>
		<?php if ( ! is_preview() && ! $only_excerpts ) : ?>
			<?php if ( $is_detail_page ) : ?>
				<?php makotokw_share_this(); ?>
				<?php else : ?>
				<?php makotokw_share_buttons(); ?>
			<?php endif ?>
		<?php endif; ?>
		<?php if ( $is_detail_page ) : ?>
			<?php if ( 'post' == $post_type ) : ?>
				<?php makotokw_list_nav(); ?>
				<?php makotokw_section_category_and_tag( 'Tag' ); ?>
				<?php makotokw_related_portfolio(); ?>
				<?php makotokw_related_posts(); ?>
				<?php makotokw_content_nav( 'nav-below' ); ?>
			<?php else : ?>
				<div class="section section-mini section-last-updated">
					<h2 class="section-title"><?php _e( 'Last Updated', 'makotokw' ); ?></h2>
					<div class="section-content"><?php makotokw_updated_on(); ?></div>
				</div>
				<?php makotokw_related_posts(); ?>
			<?php endif ?>
		<?php endif; ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
