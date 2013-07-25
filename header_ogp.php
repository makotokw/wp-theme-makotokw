<?php
/**
 * Open Graph protocol for WordPress
 * @version 0.9
 * @author makoto_kw
 * @link https://gist.github.com/3399585
 */
// key into custom fields for description. Default is for All in One SEO Pack
//define('WP_OGP_POST_DESCRIPTION_KEY', '_aioseop_description');
define('WP_OGP_POST_DESCRIPTION_KEY', 'description');

// size of Feature Image
// http://codex.wordpress.org/Post_Thumbnails
define('WP_OGP_POST_IMAGE_SIZE', 'medium');

// default Image Url
define('WP_OGP_DEFAULT_IMG', get_template_directory_uri() .'/images/ogp_default.png');

// locale
define('WP_OGP_LOCALE', WP_THEME_OGP_LOCALE);

// Facebook AppId and username
// http://developers.facebook.com/docs/opengraphprotocol/
//define('WP_OGP_FB_APPID', 'your-appid');
//define('WP_OGP_FB_ADMINS', 'your-admins');
define('WP_OGP_FB_APPID', WP_THEME_OGP_FB_APPID);
define('WP_OGP_FB_ADMINS', WP_THEME_OGP_FB_ADMINS);

// Twitter Usernames
//define('WP_OGP_TWITTER_SITE_USERNAME', '@site_username');
//define('WP_OGP_TWITTER_CREATOR_USERNAME', '@creator_username');
//define('WP_OGP_TWITTER_DOMAIN', 'YourDomain.com');
define('WP_OGP_TWITTER_SITE_USERNAME', '@makoto_kw');
define('WP_OGP_TWITTER_CREATOR_USERNAME', '@makoto_kw');
define('WP_OGP_TWITTER_DOMAIN', 'blog.makotokw.com');

function ogp_post_description() {
	global $post;
	$description = null;
	if (defined('WP_OGP_POST_DESCRIPTION_KEY')) {
		$description = get_post_meta($post->ID, WP_OGP_POST_DESCRIPTION_KEY, true);
	}
	if (empty($description)) {
		$description = get_the_excerpt();
	}
	return $description;
}
function ogp_post_image() {
	$image = null;
	if ($image_id = get_post_thumbnail_id()) {
		$image = wp_get_attachment_image_src($image_id, WP_OGP_POST_IMAGE_SIZE);
	}
	if (empty($image)) {
		// find first img element
		global $post;
		if (preg_match('/<img[^>]*src\s*=\s*("|\')([^"\']+)("|\')[^>]*>/i', $post->post_content, $matches)) {
			return $matches[2];
		}
	}
	return $image;
}
function ogp_post_section() {
	$categories = get_the_category();
	if (count($categories)>0) {
		if ($categories[0]->name !=  __('Uncategorized')) {
			return $categories[0]->name;
		}
	}
	return false;
}
function ogp_post_tag() {
	$tags = get_the_tags();
	$tagnames = array();
	if ($tags) {
		foreach ($tags as $tag) {
			$tagnames[] = $tag->name;
		}
		return implode(',', $tagnames);
	}
	return false;
}
?>
<?php if( is_single() || is_page()): ?>
<?php while(have_posts()): the_post(); ?>
<meta name="og:title" content="<?php the_title();?>" />
<meta name="og:type" content="article" />
<?php if ($og_image = ogp_post_image()):?>
<meta name="og:image" content="<?php echo $og_image ?>" />
<?php else:?>
<meta name="og:image" content="<?php echo WP_OGP_DEFAULT_IMG ?>" />
<?php endif ?>
<meta name="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
<?php if ($og_description = ogp_post_description()):?>
<meta name="og:description" content="<?php echo esc_attr($og_description) ?>" />
<?php else:?>
<meta name="og:description" content="<?php bloginfo('description'); ?>" />
<?php endif ?>
<!-- <meta name="article:author" content="<?php echo get_the_author(); ?>" /> -->
<meta name="article:published_time" content="<?php echo get_post_time('c') ?>" />
<meta name="article:modified_time" content="<?php echo get_the_modified_time('c') ?>" />
<?php if ($og_section = ogp_post_section()):?>
<meta name="article:section" content="<?php echo esc_attr($og_section) ?>" />
<?php endif ?>
<?php if ($og_tag = ogp_post_tag()):?>
<meta name="article:tag" content="<?php echo esc_attr($og_tag) ?>" />
<?php endif ?>
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?php echo mb_strimwidth(get_the_title(), 0, 70, '...'); ?>" />
<?php if ($og_description):?>
<meta name="twitter:description" content="<?php echo mb_strimwidth(esc_attr($og_description), 0, 200); ?>" />
<?php endif; ?>
<?php if ($og_image):?>
<meta name="twitter:image:src" content="<?php echo $og_image ?>" />
<?php else: ?>
<meta name="twitter:image:src" content="<?php echo WP_OGP_DEFAULT_IMG ?>" />
<?php endif; ?>
<?php if (defined('WP_OGP_TWITTER_SITE_USERNAME')): ?>
<meta name="twitter:site" content="<?php echo WP_OGP_TWITTER_SITE_USERNAME; ?>" />
<?php endif ?>
<?php if (defined('WP_OGP_TWITTER_CREATOR_USERNAME')): ?>
<meta name="twitter:creator" content="<?php echo WP_OGP_TWITTER_CREATOR_USERNAME; ?>" />
<?php endif ?>
<?php if (defined('WP_OGP_TWITTER_DOMAIN')): ?>
<meta name="twitter:domain" content="<?php echo WP_OGP_TWITTER_DOMAIN; ?>" />
<?php endif ?>
<?php endwhile; ?>
<?php else: ?>
<meta name="og:title" content="<?php wp_title('|', true, 'right'); ?>" />
<?php if (is_front_page() || is_404()): ?>
<meta name="og:type" content="blog" />
<meta name="og:url" content="<?php echo get_bloginfo('url')?>" />
<?php else: ?>
<meta name="og:type" content="article" />
<meta name="og:url" content="<?php echo get_pagenum_link()?>" />
<?php endif ?>
<meta name="og:image" content="<?php echo WP_OGP_DEFAULT_IMG?>" />
<meta name="og:description" content="<?php bloginfo('description'); ?>" />
<?php endif ?>
<meta name="og:locale" content="<?php echo WP_OGP_LOCALE?>" />
<meta name="og:site_name" content="<?php bloginfo('name'); ?>" />
<?php if (defined('WP_OGP_FB_APPID')): ?>
<meta name="fb:app_id" content="<?php echo WP_OGP_FB_APPID; ?>" />
<?php endif ?>
<?php if (defined('WP_OGP_FB_ADMINS')): ?>
<meta name="fb:admins" content="<?php echo WP_OGP_FB_ADMINS; ?>" />
<?php endif ?>