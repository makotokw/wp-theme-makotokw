<?php
/**
 * @package makotokw
 */
$post_type              = get_post_type();
$featured_image_url     = null;
$featured_image_service = null;
if ( class_exists( 'Makotokw\PostUtility' ) ) {
	$featured_image_url = Makotokw\PostUtility::find_featured_image_url( null, $featured_image_service );
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary' ); ?>>
	<header class="entry-header">
		<?php if ( $featured_image_url ) : ?>
			<div class="entry-feature-image entry-feature-image-<?php echo $featured_image_service; ?>">
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<img src="<?php echo $featured_image_url; ?>" alt="<?php echo the_title_attribute(); ?>"/>
				</a>
			</div>
		<?php endif ?>
		<div>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'makotokw' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<section class="entry-meta">
				<?php if ( 'post' === $post_type ) : ?>
					<?php makotokw_the_post_date(); ?>
					<span class="tag-links"><?php makotokw_the_category_slug( '', ', ' ); ?><?php makotokw_the_tags_slug( ', ', ', ' ); ?><?php makotokw_the_terms_slug( 'portfolios', ', ', ', ' ); ?></span>
				<?php endif; ?>
			</section>
		</div>
	</header>

	<div class="entry-content">
		<p><?php echo makotokw_post_summary( $post->post_content, 180 ); ?></p>
	</div>
	<footer class="entry-footer">
		<a class="btn btn-text btn-more-link" href="<?php the_permalink(); ?>"><?php _e( 'Continue reading', 'makotokw' ); ?></a>
		<div class="entry-meta">
			<?php makotokw_author(); ?>
		</div>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
