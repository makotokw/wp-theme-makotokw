<?php
/**
 * @package makotokw
 */

?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title">
			<?php if ( is_search() ) : ?>
				<?php esc_html_e( 'Nothing Found', 'makotokw' ); ?>
			<?php elseif ( is_404() ) : ?>
				<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'makotokw' ); ?>
			<?php endif; ?>
		</h1>
	</header>
	<div class="page-content">
		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'makotokw' ); ?></p>
			<?php get_search_form(); ?>
		<?php elseif ( is_404() ) : ?>
			<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-house"></i> <?php esc_html_e( 'Return Home', 'makotokw' ); ?></a></p>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'makotokw' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
