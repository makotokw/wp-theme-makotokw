<?php
/**
 * @package makotokw
 * Template Name: Portfolios
 * Template Post Type: page
 * @link /portfolio/
 */
__( 'Portfolios', 'makotokw' );
$t_title = get_the_title();
ob_start();
?>
<?php
wp_nav_menu(
	array(
		'theme_location'  => 'portfolio',
		'container_class' => 'portfolio-list',
		'link_before'     => '',
		'link_after'      => '',
		'fallback_cb'     => false,
	)
);
?>
<?php
$t_contents = ob_get_contents();
ob_end_clean();
require __DIR__ . '/inc/simple-page.php';
