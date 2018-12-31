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
<meta name="format-detection" content="telephone=no" />
<?php if ( makotokw_is_noindex() ) : ?>
<meta name="robots" content="noindex,follow" />
<?php else : ?>
<meta name="robots" content="index" />
<?php endif ?>
<title><?php wp_title( ' - ', true, 'right' ); ?></title>
<?php $meta_description = makotokw_get_meta_description(); ?>
<?php if ( $meta_description ) : ?>
<meta name="description" content="<?php echo esc_attr( $meta_description ); ?>" />
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
<?php wp_head(); ?>
<link rel="stylesheet" href="//use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<?php if ( JETPACK_DEV_DEBUG === true ) : ?>
<link rel='stylesheet' id='jetpack_css-css' href='/wp-content/plugins/jetpack/css/jetpack.css' type='text/css' media='all'/>
<?php endif ?>
<?php makotokw_google_analytics(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'makotekw_after_body' ); ?>
<div class="site">
	<header id="siteHeader" class="site-header" role="banner">
		<div class="site-header-banner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="site-header-logo">
					<span class="site-header-logo-text" style="display: none">
						<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>
					</span>
				<svg class="site-header-logo-svg" viewBox="0 0 190 40" width="120px" height="30">
					<path class="site-header-logo-svg-kw" d="M 0.5932 39.3588 L 12.8942 39.3588 L 12.8942 23.4044 L 21.3382 39.3588 L 36.5233 39.3588 L 24.5003 19.9855 L 35.0291 1.2201 L 20.8517 1.2201 L 12.8942 17.4784 L 12.8942 1.2201 L 0.5932 1.2201 L 0.5932 39.3588 L 0.5932 39.3588 Z"></path>
					<path class="site-header-logo-svg-kw" d="M 77.1247 20.3654 C 76.2444 21.6316 75.1672 22.6953 73.8931 23.5563 C 70.8584 25.6582 67.0592 26.7092 62.4955 26.7092 C 57.9319 26.7092 54.1443 25.6582 51.1327 23.5563 C 49.8586 22.7206 48.7698 21.657 47.8664 20.3654 C 48.793 19.1245 49.8818 18.0735 51.1327 17.2125 C 54.1906 15.0853 57.9782 14.0216 62.4955 14.0216 C 67.036 14.0216 70.8352 15.0853 73.8931 17.2125 C 75.1441 18.0989 76.2213 19.1498 77.1247 20.3654 L 77.1247 20.3654 ZM 62.0786 31.1916 L 62.4955 31.1916 L 66.1094 39.3588 L 77.0552 39.3588 L 87.2713 1.2201 L 74.6576 1.2201 L 71.148 13.072 L 70.8352 13.072 L 66.7349 1.2201 L 57.874 1.2201 L 53.7389 13.072 L 53.4609 13.072 L 49.9165 1.2201 L 37.3375 1.2201 L 47.5189 39.3588 L 58.4647 39.3588 L 62.0786 31.1916 L 62.0786 31.1916 Z"></path>
					<path class="site-header-logo-svg-eve" d="M 62.4955 15.5031 C 61.291 15.5031 60.2601 15.9779 59.4029 16.9276 C 58.5458 17.8773 58.1172 19.0232 58.1172 20.3654 C 58.1172 21.7329 58.5458 22.8915 59.4029 23.8412 C 60.26 24.7909 61.2909 25.2657 62.4955 25.2657 C 63.7233 25.2657 64.7716 24.7909 65.6403 23.8412 C 66.509 22.8915 66.9434 21.7329 66.9434 20.3654 C 66.9434 19.0232 66.509 17.8773 65.6403 16.9276 C 64.7716 15.9779 63.7233 15.5031 62.4955 15.5031 L 62.4955 15.5031 Z"></path>
					<path class="site-header-logo-svg-log" d="M 90.0676 39.3588 L 114.8087 39.3588 L 114.8087 26.9751 L 102.6467 26.9751 L 102.6467 1.2201 L 90.0676 1.2201 L 90.0676 39.3588 L 90.0676 39.3588 Z"></path>
					<path class="site-header-logo-svg-log" d="M 152.3547 20.3654 C 152.3547 17.5797 151.9146 14.9713 151.0343 12.5402 C 150.1308 10.1597 148.8219 8.0197 147.1077 6.1204 C 145.3007 4.2464 143.2853 2.8156 141.0614 1.8279 C 138.768 0.8402 136.324 0.3464 133.7294 0.3464 C 131.0885 0.3464 128.6445 0.8402 126.3975 1.8279 C 124.104 2.8156 122.0886 4.2464 120.3512 6.1204 C 118.6369 7.9184 117.3281 10.0456 116.4246 12.5022 C 115.5443 14.8827 115.1041 17.5037 115.1041 20.3654 C 115.1041 23.2524 115.5443 25.8608 116.4246 28.1907 C 117.3281 30.6471 118.6369 32.7744 120.3512 34.5724 C 122.135 36.4718 124.1504 37.9026 126.3975 38.8649 C 128.6909 39.8526 131.1349 40.3464 133.7294 40.3464 C 136.2777 40.3464 138.6985 39.8526 140.9919 38.8649 C 143.2853 37.8773 145.3007 36.4591 147.0382 34.6104 C 148.7756 32.7111 150.0961 30.5585 150.9995 28.1527 C 151.903 25.7722 152.3547 23.1764 152.3547 20.3654 L 152.3547 20.3654 ZM 133.7294 27.5449 C 131.9457 27.5449 130.521 26.8865 129.4554 25.5696 C 128.3665 24.278 127.8222 22.5433 127.8222 20.3654 C 127.8222 18.2382 128.3665 16.4908 129.4554 15.1232 C 130.521 13.781 131.9457 13.11 133.7294 13.11 C 135.4437 13.11 136.8568 13.7684 137.9688 15.0853 C 139.0344 16.4021 139.5672 18.1622 139.5672 20.3654 C 139.5672 22.5686 139.0344 24.3034 137.9688 25.5696 C 136.88 26.8865 135.4669 27.5449 133.7294 27.5449 L 133.7294 27.5449 Z"></path>
					<path class="site-header-logo-svg-log" d="M 176.6937 25.6836 C 176.5316 26.7219 176.0799 27.4942 175.3385 28.0007 C 174.6204 28.5579 173.6359 28.8364 172.3849 28.8364 C 170.3463 28.8364 168.7826 28.102 167.6938 26.6332 C 166.5819 25.1644 166.0259 23.0751 166.0259 20.3654 C 166.0259 17.7823 166.5819 15.7057 167.6938 14.1356 C 168.7826 12.5908 170.2536 11.8184 172.1069 11.8184 C 173.1725 11.8184 174.1223 12.0843 174.9563 12.6161 C 175.7439 13.0972 176.4505 13.8822 177.076 14.9713 L 188.2303 10.4509 C 186.4929 7.184 184.2226 4.6769 181.4196 2.9295 C 178.6165 1.2074 175.4428 0.3464 171.8984 0.3464 C 169.2807 0.3464 166.8251 0.8402 164.5317 1.8279 C 162.2615 2.7901 160.2692 4.2082 158.5549 6.0824 C 156.8407 7.8804 155.5318 10.0076 154.6283 12.4642 C 153.7249 14.8953 153.2731 17.5291 153.2731 20.3654 C 153.2731 23.1764 153.7249 25.7975 154.6283 28.2287 C 155.4855 30.6598 156.7943 32.7997 158.5549 34.6484 C 160.3155 36.5478 162.3194 37.9659 164.5665 38.9029 C 166.7672 39.8653 169.2112 40.3464 171.8984 40.3464 C 175.5123 40.3464 178.7092 39.4854 181.4891 37.7633 C 184.2921 36.0413 186.5855 33.5468 188.3693 30.2799 C 189.0874 28.8871 189.6434 27.2917 190.0372 25.4936 C 190.4079 23.7462 190.5932 21.7456 190.5932 19.4917 L 190.5932 19.0359 L 190.5932 18.5041 C 190.5701 18.3015 190.5527 18.0546 190.5411 17.7633 C 190.5295 17.4721 190.5237 17.1365 190.5237 16.7567 L 171.2382 16.7567 L 171.2382 25.6836 L 176.6937 25.6836 L 176.6937 25.6836 Z"></path>
				</svg>
			</a>
		</div>
		<nav class="site-header-nav">
			<div class="site-header-nav-item1">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home"></i></a>
			</div>
			<div class="site-header-nav-item2">
				<a href="<?php echo esc_url( home_url( '/category/computer/' ) ); ?>"><?php echo makotokw_awesome_icon_by_slug( 'computer' ); ?>IT</a>
				<a href="<?php echo esc_url( home_url( '/category/gadget/' ) ); ?>"><?php echo makotokw_awesome_icon_by_slug( 'gadget' ); ?>ガジェット</a>
				<a href="<?php echo esc_url( home_url( '/category/readingbook/' ) ); ?>"><?php echo makotokw_awesome_icon_by_slug( 'readingbook' ); ?>読書</a>
				<a href="<?php echo esc_url( home_url( '/category/stationery/' ) ); ?>"><?php echo makotokw_awesome_icon_by_slug( 'stationery' ); ?>文房具</a>
			</div>
			<div class="site-header-nav-item3">
				<form method="get" id="siteHeaderSearchForm" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<input type="text" id="siteHeaderSearchText" class="search-form-text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Search the site', 'makotokw' ); ?>"/>
					<a id="siteHeaderSearchTrigger" class="search-form-trigger">
						<i class="fas fa-search"></i>
						<i class="fas fa-times" style="display: none"></i>
					</a>
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
		<div class="site-content-area">
			<main class="site-content" role="main">

