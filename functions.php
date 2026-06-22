<?php
/**
 * makotokw functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package makotokw
 */

require get_template_directory() . '/config.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function makotokw_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on makotokw, use a find and replace
	 * to change 'makotokw' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'makotokw', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'footer-menu' => __( 'Footer Menu', 'makotokw' ),
			'portfolio'   => __( 'Portfolio Menu', 'makotokw' ),
		)
	);

	/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support(
		'html5',
		array(
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	remove_filter( 'wp_head', 'rel_canonical' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );

	/**
	 * Removed Emoji feature WordPress 4.2
	 */
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Tospy may use shortlink
	//remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

	/*
	 * Disable Jetpack OGP
	 */
	if ( true === WP_THEME_OGP ) {
		add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
	}
}
add_action( 'after_setup_theme', 'makotokw_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function makotokw_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'makotokw_content_width', 750 );
}
add_action( 'after_setup_theme', 'makotokw_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function makotokw_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'makotokw' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'makotokw' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'makotokw_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function makotokw_scripts() {
	$fonts_urls = makotokw_fonts_urls();
	for ( $fi = 0, $flen = count( $fonts_urls ); $fi < $flen; $fi++ ) {
		wp_enqueue_style( 'makotokw-fonts' . $fi, esc_url_raw( $fonts_urls[ $fi ] ) );
	}

	if ( true === WP_THEME_DEBUG && function_exists( 'wp_enqueue_script_module' ) && makotokw_is_vite_running() ) {
		$vite_server_url = rtrim( makotokw_vite_dev_server_url(), '/' );
		// Vite dev server supports ES modules only.
		wp_enqueue_script_module( 'makotokw-vite-client', $vite_server_url . '/@vite/client' );
		wp_enqueue_script_module( 'makotokw-script', $vite_server_url . '/src/scripts/index.js' );
	} else {
		$assets_version = wp_get_theme()->get( 'Version' );
		if ( true === WP_THEME_DEBUG ) {
			$assets_version .= '.' . gmdate( 'YmdHis' );
		}
		wp_enqueue_style( 'makotokw-style', get_template_directory_uri() . '/dist/style.css', array(), $assets_version );
		wp_register_script( 'makotokw-script', get_template_directory_uri() . '/dist/style.js', array(), $assets_version, true );
	}

	wp_enqueue_script( 'makotokw-script' );
}
add_action( 'wp_enqueue_scripts', 'makotokw_scripts' );

/**
 * @return array
 */
function makotokw_fonts_urls() {
	$urls  = array();
	$fonts = array(
		// https://fonts.google.com/specimen/Nunito+Sans
		'Nunito+Sans:300,300i,400,400i,700,800',
	);
	if ( ! empty( $fonts ) ) {
		$fonts_url = add_query_arg(
			array(
				'family'  => implode( '|', $fonts ),
				'display' => 'swap',
			),
			'https://fonts.googleapis.com/css'
		);
		$urls[]    = $fonts_url;
	}
	return $urls;
}

function makotokw_vite_dev_server_url( $host = 'localhost' ) {
	return "http://$host:5173";
}

function makotokw_is_vite_running() {
	$vite_server_url = rtrim( makotokw_vite_dev_server_url( 'host.docker.internal' ), '/' );

	$response = wp_remote_head(
		$vite_server_url . '/@vite/client',
		array(
			'timeout'     => 0.5,
			'redirection' => 0,
			'sslverify'   => false,
		)
	);

	if ( is_wp_error( $response ) ) {
		return false;
	}

	$code = wp_remote_retrieve_response_code( $response );
	return is_int( $code ) && $code < 400;
}

/**
 * deregister styles
 */
function makotokw_deregister_styles() {
	wp_deregister_style( 'dashicons' );
}

if ( ! is_admin_bar_showing() ) {
	add_action( 'wp_print_styles', 'makotokw_deregister_styles', 100 );
}

/**
 * add elementId to style to concat it by PageSpeed
 */
if ( ! is_admin() ) {
	/**
	 * @param $link
	 * @return null|string|string[]
	 */
	function makotokw_remove_style_id( $link ) {
		return preg_replace( "/id='(?:gfm|thickbox|amazonjs|makotokw).*-css'/", '', $link );
	}
	add_filter( 'style_loader_tag', 'makotokw_remove_style_id' );
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function makotokw_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'makotokw_pingback_header' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function makotokw_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
		return $url;
	}

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent !== $id ) {
		$url .= '#main';
	}

	return $url;
}
add_filter( 'attachment_link', 'makotokw_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function makotokw_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		/* translators: %s: page number */
		$title .= " $sep " . sprintf( __( 'Page %s', 'makotokw' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'makotokw_wp_title', 10, 2 );

function makotokw_get_meta_description() {
	$description = '';
	if ( is_home() ) {
		$description = get_bloginfo( 'description' );
	} elseif ( is_archive() ) {
		$description = get_the_archive_description();
	}
	return $description;
}

add_action( 'makotokw_get_meta_description', 'makotokw_get_meta_description' );

function makotokw_template_redirect() {
	if ( is_page() && ! is_preview() ) {
		$values = get_post_custom_values( 'makotokw_part_of_home' );
		if ( $values ) {
			if ( 1 === intval( $values[0] ) ) {
				wp_redirect( home_url( '/' ) );
				exit;
			}
		}
	}
}
add_action( 'template_redirect', 'makotokw_template_redirect' );

require get_template_directory() . '/inc/admin.php';
require get_template_directory() . '/inc/font-awesome.php';
require get_template_directory() . '/inc/ga.php';
require get_template_directory() . '/inc/ogp.php';
require get_template_directory() . '/inc/seo.php';
require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/featured-image.php';
require get_template_directory() . '/inc/taxonomy.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/share.php';
require get_template_directory() . '/inc/related.php';
require get_template_directory() . '/inc/comments.php';
require get_template_directory() . '/inc/debug.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
