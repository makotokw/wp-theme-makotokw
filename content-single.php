<?php
/**
 * @package makotokw
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<span class="cat-links"><?php makotokw_the_category_slug(', '); ?></span>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<span class="entry-date"><?php makotokw_posted_on(); ?></span>
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

		<?php makotokw_the_category_and_tag(); ?>
		<?php printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() ); ?>
		<?php edit_post_link( __( 'Edit', 'makotokw' ), '<i class="fa fa-pencil"></i> ', '' ); ?>

		<?php if (!is_preview()): ?>
			<?php makotokw_portfolio_note(); ?>
			<?php makotokw_related_posts(); ?>
		<?php endif; ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
