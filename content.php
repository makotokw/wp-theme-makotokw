<?php
/**
 * @package makotokw
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
			<span class="cat-links"><?php makotokw_the_category_slug(', '); ?></span>
		<?php endif; ?>

		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'makotokw' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php if ( 'post' == get_post_type() ) : ?>
			<span class="entry-date"><?php makotokw_posted_on(); ?></span>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
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
			<?php makotokw_the_category_and_tag(); ?>
			<?php printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() ); ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><i class="fa fa-comment"></i> <?php comments_popup_link( __( 'Leave a comment', 'makotokw' ), __( '1 Comment', 'makotokw' ), __( '% Comments', 'makotokw' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'makotokw' ), '<i class="fa fa-pencil"></i> ', '' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
