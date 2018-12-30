<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package makotokw
 */
?>

<section class="errorPage">
	<header class="errorPage-header">
		<h1 class="errorPage-title">
			<?php if ( is_search() ) : ?>
				<?php _e( 'Nothing Found', 'makotokw' ); ?>
			<?php elseif ( is_404() ) : ?>
				<?php _e( 'Oops! That page can&rsquo;t be found.', 'makotokw' ); ?>
			<?php endif; ?>
		</h1>
	</header>
	<div class="errorPage-wrapper">
		<div class="errorPage-content">
			<?php if ( is_search() ) : ?>
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'makotokw' ); ?></p>
				<?php get_search_form(); ?>
			<?php elseif ( is_404() ) : ?>
				<nav class="errorPage-nav"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home"></i> <?php _e( 'Return Home', 'makotokw' ); ?></a></nav>
			<?php else : ?>
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'makotokw' ); ?></p>
				<?php get_search_form(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
