<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package makotokw
 */
?>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<aside id="sideBar" class="site-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'makotokw' ); ?>">
		<div class="site-sidebar-inner section-inner">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div>
	</aside>
<?php endif ?>
