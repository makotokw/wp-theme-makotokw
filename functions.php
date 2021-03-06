<?php
/**
 * makotokw functions and definitions
 *
 * @package makotokw
 */

define( 'THEME_DATE_FORMAT', 'Y-m-d' );

if ( ! isset( $content_width ) ) {
	$content_width = 750;
}

/*
 * Load Jetpack compatibility file.
 */
/** @noinspection PhpIncludeInspection */
require get_template_directory() . '/inc/jetpack.php';

/*
 * Custom Taxonomy
 */
/** @noinspection PhpIncludeInspection */
require get_template_directory() . '/inc/taxonomy.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function makotokw_setup() {
	/** @noinspection PhpIncludeInspection */
	require get_template_directory() . '/config.php';

	/**
	 * Custom template tags for this theme.
	 */
	/** @noinspection PhpIncludeInspection */
	require get_template_directory() . '/inc/template-tags.php';
	/** @noinspection PhpIncludeInspection */
	require get_template_directory() . '/inc/related.php';
	/** @noinspection PhpIncludeInspection */
	require get_template_directory() . '/inc/comments.php';
	/** @noinspection PhpIncludeInspection */
	require get_template_directory() . '/inc/extras.php';

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
			'footer-menu' => __( 'Footer Menu', 'makotokw' ),
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

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( './dist/style-editor.css' );

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

/**
 * Register widgetized area and update sidebar with default widgets
 */
function makotokw_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'makotokw' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'makotokw' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}

add_action( 'widgets_init', 'makotokw_widgets_init' );

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

	$fonts_urls = makotokw_fonts_urls();
	for ( $fi = 0, $flen = count( $fonts_urls ); $fi < $flen; $fi++ ) {
		wp_enqueue_style( 'makotokw-fonts' . $fi, esc_url_raw( $fonts_urls[ $fi ] ), array(), null );
	}

	$assets_version = wp_get_theme()->get( 'Version' );
	if ( true === WP_THEME_DEBUG ) {
		$assets_version .= '.' . gmdate( 'YmdHis' );
	}
	wp_enqueue_style( 'makotokw-style', get_template_directory_uri() . '/dist/style.css', array(), $assets_version );

	wp_register_script( 'makotokw-script', get_template_directory_uri() . '/dist/style.js', array( 'jquery' ), $assets_version, true );
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
	global $wp_query;
	if ( $wp_query ) {
		if ( $wp_query->is_archive() ) {
			if ( $wp_query->is_category() ) {
				$category_id = $wp_query->get_queried_object_id();
				if ( in_array( $category_id, wp_parse_id_list( WP_THEME_EXCLUDE_CATEGORY ), true ) ) {
					return true;
				}
				$paged = $wp_query->get( 'paged', 1 );
				// old pages should be noindexes
				return $paged > 3;
			} elseif ( is_mylist() ) {
				return false;
			}
			return true;
		}
		if ( $wp_query->is_search() || $wp_query->is_404() || is_page_template( 'templates/template-help.php' ) ) {
			return true;
		}
	}
	return false;
}

/**
 * @param null $post
 * @return bool
 */
function makotokw_is_comment_form_showing( $post = null ) {
	$post = get_post( $post );
	if ( 'page' !== $post->post_type ) {
		return get_post_time( 'U', false, $post ) > strtotime( '-2 months' );
	}
	return true;
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

function makotokw_get_the_updated_date( $format = DATE_ISO8601 ) {
	$values = get_post_custom_values( 'makotokw_updatedat' );
	if ( $values ) {
		$time = strtotime( $values[0] );
		if ( $time ) {
			return date_i18n( $format, $time );
		}
	}
	return false;
}

function makotokw_get_the_feature_image_url() {
	$featured_image_url     = null;
	$featured_image_service = null;
	if ( class_exists( 'Makotokw\PostUtility' ) ) {
		$featured_image_url = Makotokw\PostUtility::find_featured_image_url( null, $featured_image_service );
	}

	if ( $featured_image_url ) {
		return array( $featured_image_url, $featured_image_service );
	}

	$fallback_categories      = array( 'wordpress', 'programing', 'server', 'hardware', 'computer' );
	$fallback_image_timestamp = '20210301';

	$post_title      = get_the_title();
	$post_categories = get_the_category();
	foreach ( $fallback_categories as $fallback_category ) {
		if ( $post_title && preg_match( '/' . $fallback_category . '/i', $post_title ) ) {
			$featured_image_url     = get_template_directory_uri() . "/assets/images/featured/{$fallback_category}.png?{$fallback_image_timestamp}";
			$featured_image_service = 'fallback';
			break;
		}
		$filterd = array_filter(
			$post_categories,
			function ( $term ) use ( $fallback_category ) {
				return $term->slug === $fallback_category;
			}
		);
		if ( ! empty( $filterd ) ) {
			$featured_image_url     = get_template_directory_uri() . "/assets/images/featured/{$fallback_category}.png?{$fallback_image_timestamp}";
			$featured_image_service = 'fallback';
			break;
		}
	}

	if ( ! $featured_image_url ) {
		$featured_image_url     = get_template_directory_uri() . '/assets/images/default-fallback-image.png';
		$featured_image_service = 'fallback';
	}

	return array( $featured_image_url, $featured_image_service );
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

				QTags.addButton('figure', 'figure', '<figure>', '<figcaption>Caption</figcaption></figure>');

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
