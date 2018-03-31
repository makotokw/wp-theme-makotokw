<?php
/**
 * The Template for displaying all single posts.
 *
 * @package makotokw
 */

get_header(); ?>

<div class="container">
<?php while ( have_posts() ) : ?>
	<?php
		the_post();
		get_template_part( 'content' );
	?>
	<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
		<?php comments_template(); ?>
	<?php endif ?>
<?php endwhile; // end of the loop. ?>
</div>

<?php
$page_posts = new WP_Query();
$page_posts->query( 'pagename=author&post_status=private' );
?>
<?php if ( $page_posts->have_posts() ) : ?>
	<?php $page_posts->the_post(); ?>
	<section class="site-author">
		<div class="container">
			<div class="site-author">
				<img class="site-author-img" src="<?php echo WP_THEME_AUTHOR_GRAVATOR_IMAGE; ?>?size=300" />
				<div class="site-author-profile">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</section>
<?php endif ?>
<?php
unset( $page_posts );
?>

<?php get_footer(); ?>
