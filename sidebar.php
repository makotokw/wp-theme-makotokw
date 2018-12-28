<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package makotokw
 */
?>
<aside class="site-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'makotokw' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php endif ?>
</aside>
