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
<?php if ( makotokw_is_seo_noindex() ) : ?>
<meta name="robots" content="noindex,follow" />
<?php else : ?>
<meta name="robots" content="index" />
<?php endif ?>
<title><?php wp_title( ' - ', true, 'right' ); ?></title>
<?php $makotokw_meta_description = makotokw_get_meta_description(); ?>
<?php if ( $makotokw_meta_description ) : ?>
<meta name="description" content="<?php echo esc_attr( $makotokw_meta_description ); ?>" />
<?php endif ?>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo get_theme_file_uri(); ?>/assets/images/touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_theme_file_uri(); ?>/assets/images/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_theme_file_uri(); ?>/assets/images/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_theme_file_uri(); ?>/assets/images/touch-icon-ipad-retina.png">
<?php if ( is_home() ) : ?>
<link rel="alternate" hreflang="<?php echo get_bloginfo( 'language' ); ?>" href="<?php echo home_url(); ?>">
<?php elseif ( is_singular() ) : ?>
<link rel="alternate" hreflang="<?php echo get_bloginfo( 'language' ); ?>" href="<?php the_permalink(); ?>">
<link rel="canonical" href="<?php the_permalink(); ?>" />
<?php endif ?>
<link rel="alternate" type="<?php echo feed_content_type(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" href="<?php echo get_feed_link(); ?>" />
<?php wp_head(); ?>
<?php if ( defined( 'JETPACK_DEV_DEBUG' ) && JETPACK_DEV_DEBUG === true ) : ?>
<link rel='stylesheet' id='jetpack_css-css' href='/wp-content/plugins/jetpack/css/jetpack.css' type='text/css' media='all'/>
<?php endif ?>
<?php makotokw_google_analytics(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header id="siteHeader" class="site-header" role="banner">
	<div class="site-header-inner section-inner">
		<div class="site-header-titles">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-header-logo">
				<img src="<?php echo get_theme_file_uri(); ?>/assets/images/logo.svg" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site-header-logo-image">
			</a>
			<div class="site-header-description"><?php bloginfo( 'description' ); ?></div>
		</div>
		<nav class="site-header-nav">
			<button class="toggle menu-button" aria-expanded="false">
				<span class="menu-button-inner show">
					<span class="menu-icon"><i class="fas fa-ellipsis"></i></span>
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
	<main id="siteContent" class="site-content" role="main">
