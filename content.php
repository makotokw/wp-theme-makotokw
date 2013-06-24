<?php
/**
 * @package makotokw
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php if ( 'post' == get_post_type() ) : ?>
		<?php makotokw_posted_on(); ?>
		<?php endif; ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'makotokw' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
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
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ' <i class="icon-folder-close"></i> ', 'makotokw' ) );
				if ( $categories_list && makotokw_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( '<i class="icon-folder-close"></i> %1$s', 'makotokw' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ' <i class="icon-tag"></i>', 'makotokw' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( '<i class="icon-tag"></i> %1$s', 'makotokw' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>

			<?php printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() ); ?>

		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><i class="icon-comment"></i> <?php comments_popup_link( __( 'Leave a comment', 'makotokw' ), __( '1 Comment', 'makotokw' ), __( '% Comments', 'makotokw' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'makotokw' ), '<i class="icon-pencil"></i> ', '' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
