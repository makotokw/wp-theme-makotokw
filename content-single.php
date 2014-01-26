<?php
/**
 * @package makotokw
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-single'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<span class="entry-date"><?php makotokw_posted_on(); ?></span>
		<span class="cat-links"><i class="fa fa-folder"></i> <?php makotokw_the_category_slug(', '); ?></span>
		<span class="tag-links"><?php makotokw_the_tag_links(); ?></span>
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

		<?php printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() ); ?>

		<?php if (!is_preview()): ?>
			<?php makotokw_share_this(); ?>
		<?php endif; ?>
		<?php makotokw_list_nav(); ?>
		<?php makotokw_section_category_and_tag('Tag'); ?>
		<?php makotokw_related_portfolio(); ?>
		<?php makotokw_related_posts(); ?>
		<?php makotokw_content_nav( 'nav-below' ); ?>

	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
