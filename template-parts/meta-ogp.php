<?php
/**
 * Open Graph protocol for WordPress
 * @version 0.9
 * @author makoto_kw
 * @link https://gist.github.com/3399585
 */
// key into custom fields for description. Default is for All in One SEO Pack
//define( 'WP_OGP_POST_DESCRIPTION_KEY', '_aioseop_description' );
define( 'WP_OGP_POST_DESCRIPTION_KEY', 'description' );

// size of Feature Image
// https://codex.wordpress.org/Post_Thumbnails
define( 'WP_OGP_POST_IMAGE_SIZE', 'medium' );

// default Image Url
define( 'WP_OGP_DEFAULT_IMG', get_theme_file_uri() . '/assets/images/ogp_default.png' );

// locale
define( 'WP_OGP_LOCALE', WP_THEME_OGP_LOCALE );

// Facebook AppId and username
// https://developers.facebook.com/docs/sharing/opengraph
//define( 'WP_OGP_FB_APPID', 'your-appid' );
//define( 'WP_OGP_FB_ADMINS', 'your-admins' );
define( 'WP_OGP_FB_APPID', WP_THEME_OGP_FB_APPID );
define( 'WP_OGP_FB_ADMINS', WP_THEME_OGP_FB_ADMINS );

// Twitter Usernames
//define( 'WP_OGP_TWITTER_SITE_USERNAME', '@site_username' );
//define( 'WP_OGP_TWITTER_CREATOR_USERNAME', '@creator_username' );
//define( 'WP_OGP_TWITTER_DOMAIN', 'YourDomain.com' );
define( 'WP_OGP_TWITTER_SITE_USERNAME', '@makoto_kw' );
define( 'WP_OGP_TWITTER_CREATOR_USERNAME', '@makoto_kw' );
define( 'WP_OGP_TWITTER_DOMAIN', 'blog.makotokw.com' );

function ogp_post_description() {
	global $post;
	$description = null;
	if ( defined( 'WP_OGP_POST_DESCRIPTION_KEY' ) ) {
		$description = get_post_meta( $post->ID, WP_OGP_POST_DESCRIPTION_KEY, true );
	}
	if ( empty( $description ) ) {
		$description = get_the_excerpt();
	}
	return $description;
}

function ogp_post_image() {
	$image    = null;
	$image_id = get_post_thumbnail_id();
	if ( $image_id ) {
		$image = wp_get_attachment_image_src( $image_id, WP_OGP_POST_IMAGE_SIZE );
	}
	if ( empty( $image ) ) {
		// find first img element
		global $post;
		if ( preg_match( '/<img[^>]*src\s*=\s*("|\' )([^"\']+)("|\' )[^>]*>/i', $post->post_content, $matches ) ) {
			return $matches[2];
		}
	}
	return $image;
}

function ogp_post_section() {
	$categories = get_the_category();
	if ( count( $categories ) > 0 ) {
		if ( __( 'Uncategorized', 'default' ) !== $categories[0]->name ) {
			return $categories[0]->name;
		}
	}
	return false;
}

function ogp_post_tag() {
	$tags     = get_the_tags();
	$tagnames = array();
	if ( $tags ) {
		foreach ( $tags as $tag ) {
			$tagnames[] = $tag->name;
		}
		return implode( ',', $tagnames );
	}
	return false;
}

?>
	<?php if ( is_single() || is_page() ) : ?>
		<?php if ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php
			$og_image       = ogp_post_image();
			$og_description = ogp_post_description();
			$og_section     = ogp_post_section();
			$og_tag         = ogp_post_tag()
			?>
<meta property="og:title" content="<?php the_title_attribute(); ?>"/>
<meta property="og:type" content="article"/>
			<?php if ( $og_image ) : ?>
<meta property="og:image" content="<?php echo $og_image; ?>"/>
			<?php else : ?>
<meta property="og:image" content="<?php echo WP_OGP_DEFAULT_IMG; ?>"/>
			<?php endif ?>
<meta property="og:url" content="<?php echo esc_url( get_permalink() ); ?>"/>
			<?php if ( $og_description ) : ?>
<meta property="og:description" content="<?php echo esc_attr( $og_description ); ?>"/>
			<?php else : ?>
<meta property="og:description" content="<?php bloginfo( 'description' ); ?>"/>
			<?php endif ?>
<meta property="article:published_time" content="<?php echo get_post_time( DATE_ISO8601, false, null, true ); ?>"/>
<meta property="article:modified_time" content="<?php echo get_post_modified_time( DATE_ISO8601, false, null, true ); ?>"/>
			<?php if ( $og_section ) : ?>
<meta property="article:section" content="<?php echo esc_attr( $og_section ); ?>"/>
			<?php endif ?>
			<?php if ( $og_tag ) : ?>
<meta property="article:tag" content="<?php echo esc_attr( $og_tag ); ?>"/>
			<?php endif ?>
<meta property="twitter:card" content="summary"/>
<meta property="twitter:title" content="<?php echo mb_strimwidth( the_title_attribute(), 0, 70, '...' ); ?>"/>
			<?php if ( $og_description ) : ?>
<meta property="twitter:description" content="<?php echo mb_strimwidth( esc_attr( $og_description ), 0, 200 ); ?>"/>
			<?php endif; ?>
			<?php if ( $og_image ) : ?>
<meta property="twitter:image:src" content="<?php echo $og_image; ?>"/>
			<?php else : ?>
<meta property="twitter:image:src" content="<?php echo WP_OGP_DEFAULT_IMG; ?>"/>
			<?php endif; ?>
			<?php if ( defined( 'WP_OGP_TWITTER_SITE_USERNAME' ) ) : ?>
<meta property="twitter:site" content="<?php echo WP_OGP_TWITTER_SITE_USERNAME; ?>"/>
			<?php endif ?>
			<?php if ( defined( 'WP_OGP_TWITTER_CREATOR_USERNAME' ) ) : ?>
<meta property="twitter:creator" content="<?php echo WP_OGP_TWITTER_CREATOR_USERNAME; ?>"/>
			<?php endif ?>
			<?php if ( defined( 'WP_OGP_TWITTER_DOMAIN' ) ) : ?>
<meta property="twitter:domain" content="<?php echo WP_OGP_TWITTER_DOMAIN; ?>"/>
			<?php endif ?>
		<?php endif; ?>
		<?php rewind_posts(); ?>
	<?php else : ?>
<meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>"/>
		<?php if ( is_front_page() || is_404() ) : ?>
<meta property="og:type" content="blog"/>
<meta property="og:url" content="<?php echo esc_url( home_url() ); ?>"/>
		<?php else : ?>
<meta property="og:type" content="article"/>
<meta property="og:url" content="<?php echo get_pagenum_link(); ?>"/>
		<?php endif ?>
<meta property="og:image" content="<?php echo WP_OGP_DEFAULT_IMG; ?>"/>
<meta property="og:description" content="<?php bloginfo( 'description' ); ?>"/>
	<?php endif ?>
<meta property="og:locale" content="<?php echo WP_OGP_LOCALE; ?>"/>
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>"/>
	<?php if ( defined( 'WP_OGP_FB_APPID' ) ) : ?>
<meta property="fb:app_id" content="<?php echo WP_OGP_FB_APPID; ?>"/>
	<?php endif ?>
	<?php if ( defined( 'WP_OGP_FB_ADMINS' ) ) : ?>
<meta property="fb:admins" content="<?php echo WP_OGP_FB_ADMINS; ?>"/>
	<?php endif ?>
