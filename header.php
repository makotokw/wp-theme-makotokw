<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package makotokw
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="viewport" content="width=device-width"/>
	<?php if ( is_category() || is_tag() || is_archive() ) : ?>
<meta name="robots" content="noindex,follow" />
	<?php endif ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-152.png">
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-120.png">
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-76.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-57.png">
<link rel="profile" href="http://gmpg.org/xfn/11"/>
<link rel="alternate" type="<?php echo feed_content_type() ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) )?>" href="<?php echo get_feed_link() ?>" />
<?php if ( true === WP_THEME_OGP ) : ?><?php include('header-ogp.php'); ?><?php endif ?>
<?php // @codingStandardsIgnoreStart ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/components/js/html5shiv/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php // @codingStandardsIgnoreEnd ?>
<?php wp_head(); ?>
<?php makotokw_google_analytics(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( false === WP_THEME_DEBUG && true === WP_THEME_FB_RECOMMEND_BAR ) : ?><?php makotokw_facebook_sdk(); ?><?php endif; ?>
<?php do_action( 'makotekw_after_body' ); ?>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="site-info">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
			<div class="sub-nav">
				<div class="socials">
					<a href="<?php echo get_feed_link() ?>" title="RSS">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-rss fa-stack-1x fa-inverse"></i>
						</span>
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

