<?php
/**
 * @package makotokw
 */
list ( $featured_image_url, $featured_image_service ) = makotokw_get_the_feature_image_url();
?>
<a class="post-inline" href="<?php the_permalink(); ?>">
	<?php if ( $featured_image_url ) : ?>
		<div class="post-image" style="background-image: url( <?php echo esc_url( $featured_image_url ); ?> );"></div>
	<?php endif ?>
	<div class="inner">
		<span class="title"><?php the_title(); ?></span>
		<span class="meta"><?php the_time( 'Y-m-d' ); ?></span>
	</div>
</a>
