<?php
$page_posts = new WP_Query();
$page_posts->query( 'pagename=author&post_status=private' );
?>
<?php if ( $page_posts->have_posts() ) : ?>
	<?php $page_posts->the_post(); ?>
	<section class="site-author">
		<img class="site-author-img" src="<?php echo WP_THEME_AUTHOR_GRAVATOR_IMAGE; ?>?size=300" />
		<div class="site-author-profile">
			<?php the_content(); ?>
		</div>
	</section>
<?php endif ?>
<?php
unset( $page_posts );
