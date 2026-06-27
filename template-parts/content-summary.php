<?php
/**
 * @package makotokw
 */
list ( $makotokw_featured_image_url, $makotokw_featured_image_service ) = makotokw_get_the_featured_image_url();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary' ); ?>>
	<header class="entry-header">
		<?php if ( $makotokw_featured_image_url ) : ?>
			<div class="entry-feature-image entry-feature-image-<?php echo esc_attr( $makotokw_featured_image_service ); ?>">
				<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1" title="<?php echo the_title_attribute(); ?>">
					<div class="post-image" style="background-image: url( <?php echo esc_url( $makotokw_featured_image_url ); ?> );"></div>
				</a>
			</div>
		<?php endif ?>
		<div>
			<?php makotokw_the_post_primary_meta(); ?>
			<h1 class="entry-title">
				<?php
				/* translators: %s: post title */
				$makotokw_permalink_title = sprintf( __( 'Permalink to %s', 'makotokw' ), the_title_attribute( 'echo=0' ) );
				?>
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( $makotokw_permalink_title ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
		</div>
	</header>

	<div class="entry-content">
		<p><?php echo esc_html( makotokw_post_summary( $post->post_content, 180 ) ); ?></p>
	</div>
	<footer class="entry-footer">
		<a class="btn-more-link" href="<?php the_permalink(); ?>">
			<?php esc_html_e( 'Continue reading', 'makotokw' ); ?>
			<i class="fas fa-circle-right" aria-hidden="true"></i>
		</a>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
