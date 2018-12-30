<?php
/**
 * @subpackage makotokw
 * Template Name: Portfolios
 * /portfolio/
 */
$t_title = get_the_title();
ob_start();
?>
<?php
wp_nav_menu(
	array(
		'theme_location' => 'portfolio',
		'container_class' => 'portfolio-list',
		'link_before' => '',
		'link_after' => '',
		'fallback_cb' => false,
	)
);
?>
<?php
$t_contents = ob_get_contents();
ob_end_clean();
include __DIR__ . '/inc/simple-page.php';
