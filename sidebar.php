<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makotokw
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<aside id="sideBar" class="site-sidebar" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'makotokw' ); ?>">
	<div class="site-sidebar-inner section-inner">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</aside>
