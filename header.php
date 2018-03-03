<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package makotokw
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<?php if ( is_archive() || is_search() ) : ?>
<meta name="robots" content="noindex,follow" />
<?php endif ?>
<title><?php wp_title( ' - ', true, 'right' ); ?></title>
<?php if ( is_front_page() && ! is_archive() ) : ?>
<meta name="description" content="<?php echo esc_attr( makotokw_get_meta_description() ); ?>" />
<?php endif ?>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-ipad-retina.png">
<?php if ( is_home() ) : ?>
<link rel="alternate" hreflang="<?php echo get_bloginfo( 'language' ); ?>" href="<?php echo home_url(); ?>">
<?php elseif ( is_singular() ) : ?>
<link rel="alternate" hreflang="<?php echo get_bloginfo( 'language' ); ?>" href="<?php the_permalink(); ?>">
<link rel="canonical" href="<?php the_permalink(); ?>" />
<?php endif ?>
<link rel="alternate" type="<?php echo feed_content_type(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" href="<?php echo get_feed_link(); ?>" />
<?php if ( true === WP_THEME_OGP ) : ?>
<?php get_template_part( 'meta-ogp' ); ?>
<?php endif ?>
<?php // @codingStandardsIgnoreStart ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/components/js/html5shiv/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php // @codingStandardsIgnoreEnd ?>
<?php wp_head(); ?>
<?php makotokw_google_analytics(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'makotekw_after_body' ); ?>
<div class="site">
	<header id="siteHeader" class="site-header" role="banner">
		<nav class="site-header-nav">
			<div class="site-header-menu1">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-header-logo">
					<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>
				</a>
			</div>
			<div class="site-header-menu2">
				<form method="get" id="siteHeaderSearchForm" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<input type="text" id="siteHeaderSearchText" class="search-form-text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Search the site', 'makotokw' ); ?>"/>
					<a id="siteHeaderSearchTrigger" class="search-form-trigger"></a>
				</form>
			</div>
		</nav>
		<progress id="siteProgress" class="progress site-progress" value="0">
			<div class="progress-container">
				<span class="progress-bar"></span>
			</div>
		</progress>
	</header>
	<div class="site-main">
		<div class="site-content-area ">
			<main class="site-content" role="main">

