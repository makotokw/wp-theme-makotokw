<?php
/**
 * @package makotokw
 */
$post_type = get_post_type();
$only_excerpts = is_home() || is_year() || is_month() || is_search() || is_archive();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-summary' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'makotokw' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h1>
		<section class="entry-meta">
			<?php if ( 'post' == $post_type ) : ?>
				<?php makotokw_the_post_date(); ?>
				<span class="tag-links"><?php makotokw_the_category_slug( '', ', ' ); ?><?php makotokw_the_tags_slug( ', ', ', ' ); ?><?php makotokw_the_terms_slug( 'portfolios', ', ', ', ' ); ?></span>
			<?php endif; ?>
		</section>
	</header>
	<?php if ( $only_excerpts ) : ?>
		<div class="entry-summary">
			<p><?php echo makotokw_post_summary( $post->post_content, 180 ); ?></p>
			<a class="btn btn-contained btn-more-link" href="<?php the_permalink(); ?>"><?php _e( 'Continue reading', 'makotokw' ); ?></a>
		</div>
	<?php else : ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	<?php endif; ?>
	<footer class="entry-footer">
		<div class="entry-meta">
			<?php makotokw_author(); ?>
		</div>
	</footer>
</article><!-- #post-<?php the_ID(); ?> -->
