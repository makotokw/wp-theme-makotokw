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
<meta charset="<?php bloginfo('charset'); ?>"/>
<meta name="viewport" content="width=device-width"/>
<?php if(is_category() || is_tag() || is_archive()): ?>
<meta name="robots" content="noindex,follow" />
<?php endif; ?>
<title><?php wp_title('|', true, 'right'); ?></title>
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-144.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-114.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-72.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/images/touch-icon-57.png">
<link rel="profile" href="http://gmpg.org/xfn/11"/>
<link rel="alternate" type="<?php echo feed_content_type()?>" title="<?php echo esc_attr(get_bloginfo('name'))?>" href="<?php echo get_feed_link() ?>" />
<?php if (WP_THEME_OGP === true): ?><?php include('header_ogp.php');?><?php endif ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/components/js/html5shiv/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
<?php makotokw_google_analytics(); ?>
</head>
<body <?php body_class(); ?>>
<?php if (WP_THEME_DEBUG === false && WP_THEME_FB_RECOMMEND_BAR === true): ?><?php makotokw_facebook_sdk(); ?><?php endif; ?>
<?php do_action('makotekw_after_body'); ?>
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
		<?php if (is_home()): ?>
		<?php else: ?>
	<nav class="site-navi">
		<div class="container">
			<?php makotokw_breadcrumbs(); ?>
		</div>
	</nav>
		<?php endif ?>

	<div id="main" class="site-main">

