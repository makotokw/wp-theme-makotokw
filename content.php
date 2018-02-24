<?php
/**
 * @package makotokw
 */
$post_type = get_post_type();
$is_detail_page = is_single() || is_page();
$only_excerpts = is_home() || is_year() || is_month() || is_search() || is_archive();
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
				<span class="entry-date date updated"><?php makotokw_posted_on(); ?></span>
				<?php if ( makotokw_is_old_post() ) : ?>
					<?php
						$post_time = date_create( get_the_date( 'c' ) );
						$interval = $post_time->diff( date_create() );
					?>
					<?php if ( 1 <= $interval->y ) : ?>
						<span class="entry-date-warning">
							<?php if ( 1 == $interval->y ) : ?>
								<?php _e( '(<span class="entry-date-warning-y">1</span> year ago)', 'makotokw' ); ?>
							<?php else : ?>
								<?php echo sprintf( __( '(<span class="entry-date-warning-y">%d</span> years ago)', 'makotokw' ), $interval->y ); ?>
							<?php endif ?>
						</span>
					<?php endif ?>
				<?php endif ?>
				<span class="tag-links"><?php makotokw_the_category_slug( '', ', ' ); ?><?php makotokw_the_tags_slug( ', ', ', ' ); ?><?php makotokw_the_terms_slug( 'portfolios', ', ', ', ' ); ?></span>
			<?php endif; ?>
		</section>
	</header>
	<?php if ( $only_excerpts ) : ?>
		<div class="entry-summary">
			<p><?php echo makotokw_post_summary( $post->post_content ); ?></p>
			<a class="text-more-link" href="<?php the_permalink(); ?>"><?php _e( 'Continue reading', 'makotokw' ); ?></a>
		</div>
	<?php else : ?>
		<div class="entry-content">
			<?php if ( $is_detail_page ) : ?>
				<?php makotokw_breadcrumbs(); ?>
			<?php endif ?>
			<?php the_content(); ?>
			<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'makotokw' ),
						'after'  => '</div>',
					)
				);
			?>
		</div>
	<?php endif; ?>
	<footer class="entry-footer">
		<div class="entry-meta">
			<?php makotokw_author(); ?>
		</div>
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
				<div class="section section-mini section-2col section-last-updated">
					<h2 class="section-title"><?php _e( 'Last Updated', 'makotokw' ); ?></h2>
					<div class="section-content"><?php makotokw_updated_on(); ?></div>
				</div>
				<?php makotokw_related_posts(); ?>
			<?php endif ?>
		<?php endif; ?>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
