<?php
/**
 * @package makotokw
 * Template Name: Portfolios
 * Template Post Type: page
 * @link /portfolio/
 */

__( 'Portfolios', 'makotokw' );
$makotokw_title = get_the_title();
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
$makotokw_contents = ob_get_contents();
ob_end_clean();
get_template_part(
	'templates/inc/simple-page',
	null,
	array(
		'title'    => $makotokw_title,
		'contents' => $makotokw_contents,
	)
);
