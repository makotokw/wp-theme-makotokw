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
		<h1 class="errorPage-title"><?php _e( 'Nothing Found', 'makotokw' ); ?></h1>
	</header>
	<div class="errorPage-wrapper">
		<div class="errorPage-content">
			<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
				<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'makotokw' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
			<?php elseif ( is_search() ) : ?>
				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'makotokw' ); ?></p>
				<?php get_search_form(); ?>
			<?php else : ?>
				<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'makotokw' ); ?></p>
				<?php get_search_form(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
