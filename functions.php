<?php
/**
 * makotokw functions and definitions
 *
 * @package makotokw
 */

define( 'THEME_STYLE_CSS_REV', '2018032110' );
define( 'THEME_STYLE_SCRIPT_REV', '2018032110' );
define( 'THEME_DATE_FORMAT', 'Y/m/d' );

if ( ! isset( $content_width ) ) {
	$content_width = 750;
}

/*
 * Load Jetpack compatibility file.
 */
/** @noinspection PhpIncludeInspection */
require( get_template_directory() . '/inc/jetpack.php' );

/*
 * Custom Taxonomy
 */
/** @noinspection PhpIncludeInspection */
require( get_template_directory() . '/inc/taxonomy.php' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function makotokw_setup() {
	/** @noinspection PhpIncludeInspection */
	require( get_template_directory() . '/config.php' );

	/**
	 * Custom template tags for this theme.
	 */
	/** @noinspection PhpIncludeInspection */
	require( get_template_directory() . '/inc/template-tags.php' );
	/** @noinspection PhpIncludeInspection */
	require( get_template_directory() . '/inc/related.php' );
	/** @noinspection PhpIncludeInspection */
	require( get_template_directory() . '/inc/comments.php' );
	/** @noinspection PhpIncludeInspection */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on makotokw, use a find and replace
	 * to change 'makotokw' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'makotokw', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(
		array(
			'site-info' => __( 'Site Menu', 'makotokw' ),
			'footer' => __( 'Footer Menu', 'makotokw' ),
			'portfolio' => __( 'Portfolio Menu', 'makotokw' ),
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

	if ( is_admin() ) {
		add_action( 'admin_print_footer_scripts', 'makotokw_quicktags' );
	}
}

add_action( 'after_setup_theme', 'makotokw_setup' );

function makotokw_move_admin_bar() {
	if ( ! is_admin_bar_showing() ) {
		return;
	}
	?>
<style type="text/css" media="screen">
	html { margin-top: 0 !important; margin-bottom: 32px !important; }
	* html body { margin-top: 0 !important; margin-bottom: 32px !important; }
	@media screen and ( max-width: 782px ) {
		html { margin-top: 0 !important; margin-bottom: 46px !important; }
		* html body { margin-top: 0 !important; margin-bottom: 46px !important; }
	}
	#wpadminbar { top: auto !important; bottom: 0; }
	@media screen and (max-width: 600px) {
		#wpadminbar { position: fixed; }
	}
</style>
	<?php
}

add_action( 'wp_head', 'makotokw_move_admin_bar', 99 );

function makotokw_get_meta_description() {
	$description = '';
	if ( is_home() ) {
		$description = get_bloginfo( 'description' );
	} elseif ( is_single() ) {
		if ( have_posts() ) {
			the_post();
			$description = get_the_excerpt();
			rewind_posts();
		}
	} elseif ( is_archive() ) {
		$description = get_the_archive_description();
	}
	return $description;
}

add_action( 'makotokw_get_meta_description', 'makotokw_get_meta_description' );

/**
 * Enqueue scripts and styles
 */
function makotokw_scripts() {
	// move jQuery to footer
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery-core' );
		wp_deregister_script( 'jquery-migrate' );
		wp_register_script( 'jquery-core', '/wp-includes/js/jquery/jquery.js', array(), '1.10.2', true );
		wp_register_script( 'jquery-migrate', '/wp-includes/js/jquery/jquery-migrate.js', array(), '1.2.1', true );
		wp_enqueue_script( 'jquery-core' );
		wp_enqueue_script( 'jquery-migrate' );
	}

	wp_enqueue_style( 'makotokw-fonts', esc_url_raw( makotokw_fonts_url() ), array(), null );
	wp_enqueue_style( 'makotokw-style', get_stylesheet_uri(), array(), THEME_STYLE_CSS_REV );

	wp_register_script( 'makotokw-script', get_template_directory_uri() . '/style.js', array( 'jquery' ), THEME_STYLE_SCRIPT_REV, true );
	wp_localize_script( 'makotokw-script', 'makotokw', array( 'counter_api' => WP_THEME_COUNT_API ) );
	wp_enqueue_script( 'makotokw-script' );

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'makotokw-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202', true );
	}
}

add_action( 'wp_enqueue_scripts', 'makotokw_scripts' );

/**
 * deregister styles
 */
function makotokw_deregister_styles() {
	wp_deregister_style( 'dashicons' );
}

if ( ! is_admin_bar_showing() ) {
	add_action( 'wp_print_styles', 'makotokw_deregister_styles', 100 );
}

function makotokw_is_noindex() {
	/** @var WP_Query $wp_query */
	global $wp_query;
	if ( $wp_query ) {
		if ( $wp_query->is_archive() ) {
			if ( $wp_query->is_category() ) {
				$category_id = $wp_query->get_queried_object_id();
				if ( in_array( $category_id, wp_parse_id_list( WP_THEME_EXCLUDE_CATEGORY ) ) ) {
					return true;
				}
				$paged = $wp_query->get( 'paged', 1 );
				// old pages should be noindexes
				return $paged > 3;
			} else if ( is_mylist() ) {
				return false;
			}
			return true;
		}
		if ( $wp_query->is_search() || $wp_query->is_404() || is_page_template( 'page-templates/help.php' ) ) {
			return true;
		}
	}
	return false;
}

function makotokw_is_old_post( $post = null ) {
	$post = get_post( $post );
	// only within 1 year
	return get_post_time( 'U', false, $post ) < strtotime( '-1 year' );
}

/**
 * @param null $post
 * @return bool
 */
function makotokw_is_comment_form_showing( $post = null ) {
	$post = get_post( $post );
	if ( 'page' != $post->post_type ) {
		return get_post_time( 'U', false, $post ) > strtotime( '-2 months' );
	}
	return true;
}

/**
 * add elementId to style to concat it by PageSpeed
 */
if ( ! is_admin() ) {
	function makotokw_remove_style_id( $link ) {
		return preg_replace( "/id='(?:gfm|thickbox|amazonjs|makotokw).*-css'/", '', $link );
	}
	add_filter( 'style_loader_tag', 'makotokw_remove_style_id' );
}

function makotokw_fonts_url() {
	$fonts_url = '';

	$fonts[] = 'Montserrat:400,700';
	$fonts[] = 'Lato:300,400,700,300italic,400italic,700italic';

	if ( $fonts ) {
		$fonts_url = add_query_arg(
			array(
				'family' => implode( '|', $fonts ),
				'subset' => 'latin,latin-ext',
			),
			'https://fonts.googleapis.com/css'
		);
	}

	return $fonts_url;
}

/**
 * Custom QTags
 */
function makotokw_quicktags() {
	// https://wordpress.stackexchange.com/questions/37849/add-custom-shortcode-button-to-editor
	/* Add custom Quicktag buttons to the editor WordPress ver. 3.3 and above only
	 *
	 * Params for this are:
	 * - Button HTML ID (required)
	 * - Button display, value="" attribute (required)
	 * - Opening Tag (required)
	 * - Closing Tag (required)
	 * - Access key, accesskey="" attribute for the button (optional)
	 * - Title, title="" attribute (optional)
	 * - Priority/position on bar, 1-9 = first, 11-19 = second, 21-29 = third, etc. (optional)
	 */
	?>
	<script type="text/javascript">
		(function ($) {
			if (typeof(QTags) !== 'undefined') {
				var datetime = (function () {
					var now = new Date(), zeroise;
					zeroise = function (number) {
						var str = number.toString();
						if (str.length < 2)
							str = "0" + str;
						return str;
					};
					return now.getUTCFullYear() + '-' +
						zeroise(now.getUTCMonth() + 1) + '-' +
						zeroise(now.getUTCDate()) + 'T' +
						zeroise(now.getUTCHours()) + ':' +
						zeroise(now.getUTCMinutes()) + ':' +
						zeroise(now.getUTCSeconds()) +
						'+00:00';
				})();

				$.each(['h2', 'h3', 'h4', 'h5', 'p'], function (i, e) {
					QTags.addButton(e, e, '<' + e + '>', '</' + e + '>');
				});
				QTags.addButton('ins_block', 'ins_block', '<ins class="note-ins" datetime="' + datetime + '">', '</ins>');
				QTags.addButton('AA', 'aa', '<span class="aa">', '</span>');
				QTags.addButton('big', 'big', '<span class="big">', '</span>');

				$.each(['', 'github', 'qiita', 'evernote'], function (i, t) {
					var cls = (t === '') ? 'enclosure' : 'enclosure-' + t;
					QTags.addButton(cls, cls, '<div class="' + cls + '">', '</div>');
				});
				$.each(['comment', 'ins', 'link'], function (i, t) {
					var cls = 'note-' + t;
					QTags.addButton(cls, cls, '<div class="' + cls + '">', '</div>');
				});

				QTags.addButton('prettyprint', 'prettyprint', '<pre class="prettyprint">', '</pre>');
				QTags.addButton('sh_code', '[code]', '[code autolinks="false" collapse="false" firstline="1" gutter="true" highlight="" htmlscript="false" light="false" padlinenumbers="false" toolbar="true" title="example-filename.php"]', '[/code]');
			}
		})(jQuery);
	</script>
	<?php
}
