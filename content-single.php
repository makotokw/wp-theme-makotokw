<?php
/**
 * @package makotokw
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php makotokw_posted_on(); ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'makotokw' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ' <i class="icon-folder-close"></i> ', 'makotokw' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ' <i class="icon-tag"></i> ', 'makotokw' ) );

			if ( ! makotokw_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( '<i class="icon-tag"></i> %2$s', 'makotokw' );
				} else {
					$meta_text = '';
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( '<i class="icon-folder-close"></i> %1$s <i class="icon-tag"></i> %2$s', 'makotokw' );
				} else {
					$meta_text = __( '<i class="icon-folder-close"></i> %1$s', 'makotokw' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list
			);

		?>

		<?php printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() ); ?>

		<?php edit_post_link( __( 'Edit', 'makotokw' ), '<i class="icon-pencil"></i> ', '' ); ?>

		<?php makotokw_portfolio_posts(array('post_type'=>'page')); ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
