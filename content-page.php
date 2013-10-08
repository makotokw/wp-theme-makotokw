<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package makotokw
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
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
		<?php printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() ); ?>
		<?php edit_post_link( __( 'Edit', 'makotokw' ), '<i class="icon-pencil"></i> ', '' ); ?>
		<?php makotokw_related_posts(); ?>
	</footer>

</article><!-- #post-## -->
