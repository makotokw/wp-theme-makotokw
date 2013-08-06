<?php
/**
 * makotokw functions and definitions
 *
 * @package makotokw
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width))
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require(get_template_directory() . '/inc/jetpack.php');

if (!function_exists('makotokw_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 */
	function makotokw_setup()
	{
		require(get_template_directory() . '/config.php');

		/**
		 * Custom template tags for this theme.
		 */
		require(get_template_directory() . '/inc/template-tags.php');

		/**
		 * Custom functions that act independently of the theme templates
		 */
		require(get_template_directory() . '/inc/extras.php');

		/**
		 * Make theme available for translation
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on makotokw, use a find and replace
		 * to change 'makotokw' to the name of your theme in all the template files
		 */
		load_theme_textdomain('makotokw', get_template_directory() . '/languages');

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support('automatic-feed-links');

		/**
		 * Enable support for Post Thumbnails
		 */
		add_theme_support('post-thumbnails');

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus(array(
			'site-info' => __('Site Info Menu', 'makotokw'),
			'portfolio' => __('Portfolio Menu', 'makotokw'),
		));

		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

		/*
		 * Disable Jetpack OGP
		 */
		if (WP_THEME_OGP === true) {
			add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
		}

		if (is_admin()) {
			add_action('admin_print_footer_scripts',  'makotokw_quicktags');
		}
	}
endif; // makotokw_setup
add_action('after_setup_theme', 'makotokw_setup');

/**
 * Register widgetized area and update sidebar with default widgets
 */
function makotokw_widgets_init()
{
	register_sidebar(array(
		'name' => __('Sidebar', 'makotokw'),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	));
}

add_action('widgets_init', 'makotokw_widgets_init');

/**
 * Enqueue scripts and styles
 */
function makotokw_scripts()
{
	global $wp_styles;

	wp_enqueue_style('makotokw-style', get_stylesheet_uri(), array(), '20130727');
	wp_enqueue_style('makotokw-fonts', esc_url_raw( makotokw_fonts_url() ), array(), null );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'makotokw-ie', get_template_directory_uri() . '/ie.css', array( 'makotokw-style' ), '20130428' );
	$wp_styles->add_data( 'makotokw-ie', 'conditional', 'lt IE 9' );

	wp_enqueue_script('makotokw-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);
	wp_enqueue_script('makotokw-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);

//	wp_enqueue_script('google-code-run-prettify', 'https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js', array(), false, true);
	wp_enqueue_script('google-code-prettify', get_template_directory_uri() . '/js/prettify.js', array(), '20130305', true);
	wp_enqueue_script('makotokw-script', get_template_directory_uri() . '/js/script.js', array('google-code-prettify'), '20130503', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (is_singular() && wp_attachment_is_image()) {
		wp_enqueue_script('makotokw-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20120202');
	}
}

add_action('wp_enqueue_scripts', 'makotokw_scripts');

function makotokw_fonts_url() {

	$font_families = array(
		'Lato:300,400,700,300italic,400italic,700italic',
		'Slackey',
	);
	$query_args = array(
		'family' => implode( '|', $font_families ),
		'subset' => 'latin,latin-ext',
	);

	$protocol = is_ssl() ? 'https' : 'http';
	$fonts_url = add_query_arg( $query_args, $protocol.'://fonts.googleapis.com/css' );

	return $fonts_url;
}

function makotokw_feed_link() {

	global $feedburner_settings;

	if (isset($feedburner_settings)) {
		return trim($feedburner_settings['feedburner_url']);
	}
	return get_feed_link();
}

function makotokw_quicktags()
	// http://wordpress.stackexchange.com/questions/37849/add-custom-shortcode-button-to-editor
	/* Add custom Quicktag buttons to the editor Wordpress ver. 3.3 and above only
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
{ ?>
	<script type="text/javascript">

		(function($){
			_datetime = (function() {
				var now = new Date(), zeroise;
				zeroise = function(number) {
					var str = number.toString();
					if ( str.length < 2 )
						str = "0" + str;
					return str;
				}
				return now.getUTCFullYear() + '-' +
					zeroise( now.getUTCMonth() + 1 ) + '-' +
					zeroise( now.getUTCDate() ) + 'T' +
					zeroise( now.getUTCHours() ) + ':' +
					zeroise( now.getUTCMinutes() ) + ':' +
					zeroise( now.getUTCSeconds() ) +
					'+00:00';
			})();

			$.each(['h2','h3','h4','h5','p'], function(i, e){
				QTags.addButton(e, e, '<'+e+'>', '</'+e+'>');
			});
			QTags.addButton('ins_block', 'ins_block', '<ins class="note-ins" datetime="' + _datetime + '">', '</ins>');
			QTags.addButton('AA', 'aa', '<span class="aa">', '</span>');
			QTags.addButton('big', 'big', '<span class="big">', '</span>');

			$.each(['', 'github','qiita','evernote'], function(i, t){
				var cls = (t == '') ? 'enclosure' : 'enclosure-' + t;
				QTags.addButton(cls, cls, '<div class="'+cls+'">', '</div>');
			});
			$.each(['comment','ins','link'], function(i, t){
				var cls = 'note-' + t;
				QTags.addButton(cls, cls, '<div class="'+cls+'">', '</div>');
			});

			QTags.addButton('prettyprint', 'prettyprint', '<pre class="prettyprint">', '</pre>');
			QTags.addButton('sh_code', '[code]', '[code autolinks="false" collapse="false" firstline="1" gutter="true" highlight="" htmlscript="false" light="false" padlinenumbers="false" toolbar="true" title="example-filename.php"]', '[/code]');

		})(jQuery);
	</script>
<?php }


