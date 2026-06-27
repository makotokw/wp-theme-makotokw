<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="main">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makotokw
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta name="format-detection" content="telephone=no" />
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo esc_url( get_theme_file_uri() . '/assets/images/touch-icon-iphone.png' ); ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url( get_theme_file_uri() . '/assets/images/touch-icon-ipad.png' ); ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url( get_theme_file_uri() . '/assets/images/touch-icon-iphone-retina.png' ); ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url( get_theme_file_uri() . '/assets/images/touch-icon-ipad-retina.png' ); ?>">
<link rel="alternate" type="<?php echo esc_attr( feed_content_type() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" href="<?php echo esc_url( get_feed_link() ); ?>" />
<?php wp_head(); ?>
<?php if ( defined( 'JETPACK_DEV_DEBUG' ) && JETPACK_DEV_DEBUG === true ) : ?>
<link rel='stylesheet' id='jetpack_css-css' href='/wp-content/plugins/jetpack/css/jetpack.css' type='text/css' media='all'/>
<?php endif ?>
<?php makotokw_google_analytics(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="siteHeader" class="site-header">
	<div class="site-header-inner section-inner">
		<div class="site-header-titles">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-header-logo">
				<span class="site-header-logo-image" role="img" aria-label="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" style="<?php echo esc_attr( "--logo-mask-image: url('" . get_theme_file_uri( '/assets/images/logo.svg' ) . "')" ); ?>"></span>
			</a>
			<div class="site-header-description"><?php bloginfo( 'description' ); ?></div>
		</div>
		<nav class="site-header-nav">
			<button class="toggle menu-button" aria-expanded="false">
				<span class="menu-button-inner show">
					<span class="menu-icon"><i class="fas fa-bars"></i></span>
				</span>
				<span class="menu-button-inner hide">
					<span class="menu-icon"><i class="fas fa-xmark"></i></span>
				</span>
			</button>
		</nav>
	</div>
	<progress id="siteProgress" class="progress site-progress" value="0">
		<div class="progress-container">
			<span class="progress-bar"></span>
		</div>
	</progress>
</header>
<?php makotokw_menu_overlay(); ?>
<div class="site-main">
	<main id="siteContent" class="site-content">
