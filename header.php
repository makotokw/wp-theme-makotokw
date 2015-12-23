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
<meta name="viewport" content="width=device-width" />
	<?php if ( is_archive() || is_search() ) : ?>
<meta name="robots" content="noindex,follow" />
	<?php endif ?>
<title><?php wp_title( ' - ', true, 'right' ); ?></title>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-ipad-retina.png">
<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<?php if ( is_singular() ) : ?>
<link rel="canonical" href="<?php the_permalink(); ?>" />
	<?php endif ?>
<link rel="alternate" type="<?php echo feed_content_type() ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) )?>" href="<?php echo get_feed_link() ?>" />
<?php if ( true === WP_THEME_OGP ) : ?><?php get_template_part( 'meta-ogp' ); ?><?php endif ?>
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
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="site-info">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img id="siteLogo" src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>"  width="190" height="40" class="site-logo" /></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
			<div class="sub-nav">
				<div class="socials">
					<a href="<?php echo get_feed_link() ?>" class="btn btn-default btn-circle btn-rss" title="RSS">
						<i class="icon fa fa-rss"></i>
					</a>
				</div>
				<?php get_search_form(); ?>
			</div>
		</div>
	</header>
	<?php if ( ! is_home() ) : ?>
	<nav class="site-navi">
		<div class="container">
			<?php makotokw_breadcrumbs(); ?>
		</div>
	</nav>
	<?php endif ?>
	<div id="main" class="site-main">

