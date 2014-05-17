<?php
/**
 * @package makotokw
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-summary'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'makotokw' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php if ( 'post' == get_post_type() ) : ?>
			<span class="entry-date"><?php makotokw_posted_on(); ?></span>
			<span class="cat-links"><i class="fa fa-folder"></i> <?php makotokw_the_category_slug(', '); ?></span>
			<span class="tag-links"><?php makotokw_the_tag_links(); ?></span>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_home() || is_year() || is_month() || is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<p><?php echo makotokw_post_summary($post->post_content); ?></p>
		<a class="btn more-link" href="<?php the_permalink() ?>">続きを読む</a>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'makotokw' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'makotokw' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() ); ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
