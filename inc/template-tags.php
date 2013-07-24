<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package makotokw
 */

if ( ! function_exists( 'makotokw_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function makotokw_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'makotokw' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<div class="nav-links">
			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'makotokw' ) . '</span> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'makotokw' ) . '</span>' ); ?>
		</div>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>


		<div class="nav-links">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'makotokw' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'makotokw' ) ); ?></div>
			<?php endif; ?>

		</div>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // makotokw_content_nav

if ( ! function_exists( 'makotokw_google_analytics' ) ) :

function makotokw_google_analytics() {

	if (WP_THEME_DEBUG === true || WP_THEME_GOOGLE_ANALYTICS_ACCOUNT === false) {
		return;
	}
?>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo WP_THEME_GOOGLE_ANALYTICS_ACCOUNT?>']);
_gaq.push(['_trackPageview']);
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<?php
}

endif; // makotokw_google_analytics

/**
 * @see http://gilbert.pellegrom.me/how-to-breadcrumbs-in-wordpress/
 */
function makotokw_breadcrumbs()
{
	global $wp_query;

	if (!is_home()) {

		// Start the UL

		echo '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb">';

		// Add the Home link
		echo '<a href="' . esc_url(home_url('/')) . '"><i class="icon-home icon-large"></i></a><i class="icon-chevron-right"></i>';

		if (is_category()) {
			echo '<a href="/categories/" itemprop="url"><span itemprop="title">Categories</span></a><i class="icon-chevron-right"></i>';
			$term = $wp_query->get_queried_object();
			if ($term->parent > 0) {
				echo makotokw_breadcrumbs_category_parents($term->parent, '<i class="icon-chevron-right"></i>');
			}
			echo '<span itemprop="title">'.single_cat_title('', false).'</span>';
		} else if (is_tag()) {
			echo '<a href="/tags/" itemprop="url"><span itemprop="title">Tags</a><i class="icon-chevron-right"></i>';
			echo single_tag_title('', false);
		} elseif (is_archive()) {
			echo "  Archives";
		} elseif (is_search()) {
			echo "  Search Results";
		} elseif (is_404()) {
			echo "  404 Not Found";
		} elseif (is_single()) {
			$category = get_the_category();
			if (is_array($category) && count($category) > 0) {
				echo '<a href="/categories/" itemprop="url"><span itemprop="title">Categories</span></a><i class="icon-chevron-right"></i>';
				$category_id = get_cat_ID($category[0]->cat_name);
				echo makotokw_breadcrumbs_category_parents($category_id, '<i class="icon-chevron-right"></i>');
			}
			echo the_title('', '', false);
		} elseif (is_page()) {
			$post = $wp_query->get_queried_object();
			if ($post->post_parent == 0) {
				echo the_title('', '', false);
			} else {
				$ancestors = array_reverse(get_post_ancestors($post->ID));
				array_push($ancestors, $post->ID);
				foreach ($ancestors as $ancestor) {
					if ($ancestor != end($ancestors)) {
						echo '<a href="' . get_permalink($ancestor) . '" itemprop="url"><span itemprop="title">' . strip_tags(apply_filters('single_post_title', get_the_title($ancestor))) . '</span></a><i class="icon-chevron-right"></i>';
					} else {
						echo strip_tags(apply_filters('single_post_title', get_the_title($ancestor)));
					}
				}
			}
		}

		// End the UL
		echo "</div>";
	}
}

function makotokw_breadcrumbs_category_parents( $id, $separator = '/', $visited = array() ) {
	$chain = '';
	$parent = get_category( $id );
	if ( is_wp_error( $parent ) ) {
		return $chain;
	}
	if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
		$visited[] = $parent->parent;
		$chain .= makotokw_breadcrumbs_category_parents( $parent->parent, $separator, $visited );
	}

	$chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $parent->name ) ) . '" itemprop="url"><span itemprop="title">'.$parent->name.'</span></a>' . $separator;

	return $chain;
}

if ( ! function_exists( 'makotokw_zenback_widget' ) ) :

function makotokw_zenback_widget() {
	?>
	<?php if (!is_preview() && comments_open() && (is_single() || is_page())):?>
		<aside class="zenback-widget-area">
			<?php if (WP_THEME_DEBUG === false): ?>
				<?php echo WP_THEME_ZENBACK_WIDGET_SCRYPT ?>
			<?php else: ?>
				<?php include 'zenback.debug.html' ?>
			<?php endif; ?>
		</aside>
	<?php endif; ?>
<?php
}

endif; // ends check for makotokw_zenback_widget

if ( ! function_exists( 'makotokw_facebook_sdk' ) ) :
	function makotokw_facebook_sdk() {
		if (WP_THEME_OGP === true):
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/<?php echo WP_OGP_LOCALE; ?>/all.js#xfbml=1&appId=<?php echo WP_OGP_FB_APPID; ?>";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script><?php
		endif;
	}
endif;

if ( ! function_exists( 'makotokw_facebook_recommendations_bar' ) ) :
function makotokw_facebook_recommendations_bar() {
	?>
<div class="fb-recommendations-bar" data-href="<?php echo esc_url(( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])?>"></div>
<?php
}
endif;

if ( ! function_exists( 'makotokw_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function makotokw_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$is_trackback = ($comment->comment_type == 'pingback' || $comment->comment_type == 'trackback');
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment-body">
			<?php if (!$is_trackback): ?>
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 50 ); ?>
			</div>
			<?php endif; ?>
			<div class="comment-metadata">
				<?php printf( '<cite class="fn">%1$s</cite>', get_comment_author_link()); ?>
				<?php printf( '<a class="comment-time" href="%1$s"><time datetime="%2$s">%3$s</time></a>',
					esc_url( get_comment_link( $comment->comment_ID ) ),
					get_comment_time(),
					/* translators: 1: date, 2: time */
					sprintf( __( '%1$s at %2$s', 'makotokw' ), get_comment_date(), get_comment_time() )
				);
				?>
				<?php edit_comment_link( __( 'Edit', 'makotokw' ), '<span class="edit-link"><i class="icon-pencil"></i> ', '</span>' ); ?>
			</div><!-- .comment-meta -->
			<div class="comment-content">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'makotokw' ); ?></em>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<?php if (!$is_trackback): ?>
			<div class="reply">
			<?php
				comment_reply_link( array_merge( $args,array(
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
				) ) );
			?>
			</div><!-- .reply -->
			<?php endif; ?>
		</article><!-- #comment-## -->
	<?php
}
endif; // ends check for makotokw_comment()

if ( ! function_exists( 'makotokw_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function makotokw_posted_on() {
	printf( __( '<time class="published" datetime="%1$s">%2$s</time>', 'makotokw' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_post_time( 'M jS, Y') )
	);

	printf( __( '<time class="updated" datetime="%1$s"></time>', 'makotokw' ),
		esc_attr( get_the_modified_date( 'c' ) )
	);
}

endif;

if ( ! function_exists( 'makotokw_portfolio_posts' ) ) :

function makotokw_portfolio_posts($arg = array()) {
	global $post;
	unset($portfolio);
	$terms = get_the_terms($post->ID, 'portfolios');
	if (!is_wp_error($terms) && !empty($terms)) {
		$portfolio = array_shift($terms);
	}

	$arg = array_merge(array(
		'header_title' => 'Related Posts',
		'post_type' => 'post',
	), $arg);

	if (isset($portfolio)):
		$query_arg = array(
			'post_type' => $arg['post_type'],
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolios',
					'terms' => $portfolio->term_id,
					'operator' => 'IN'
				)
			)
		);

		$temp_post = $post;
		$rq = new WP_Query($query_arg);
		if ($rq->have_posts()): ?>
			<section class="portfolio-posts-area">
				<h2><?php echo $arg['header_title']?></h2>
				<ul>
					<?php while ($rq->have_posts()) : $rq->the_post(); ?>
						<li>
							<?php makotokw_posted_on(); ?>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile ?>
				</ul>
			</section>
		<?php
		$post = $temp_post;
		endif;
	endif;
}

endif;

if ( ! function_exists( 'makotokw_tag_cloud' ) ) :

function makotokw_tag_cloud($args = array()) {
	$tags = wp_tag_cloud(array_merge(array(
		'smallest' => 1,
		'largest' => 10,
		'format' => 'array',
		'echo' => false
	), $args));

	if (count($tags)) {

		echo '<ul class="tags-cloud">';
		foreach ($tags as $tag) {
			$rank = 0;
			if (preg_match('/font-size: ([0-9.]+)pt/', $tag, $matches)) {
				$rank = 11 - $matches[1];
				$tag = str_replace($matches[0], '', $tag);
			}
			$count = 0;
			if (preg_match("/title='[^'0-9]*([0-9]+)[^']*'/", $tag, $matches)) {
				$count = intval($matches[1]);
			}
			printf('<li class="tag rank-%1$d">%2$s%3$s</li>',
				$rank,
				$tag,
				($count > 0) ? '<span class="count">('.$count.')</span>' : ''
			);
		}
		echo '</ul>';
	}
}

endif;

/**
 * Returns true if a blog has more than 1 category
 */
function makotokw_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so makotokw_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so makotokw_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in makotokw_categorized_blog
 */
function makotokw_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'makotokw_category_transient_flusher' );
add_action( 'save_post', 'makotokw_category_transient_flusher' );