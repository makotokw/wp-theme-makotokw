<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package makotokw
 */
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
			echo '<a href="/categories/" itemprop="url"><span itemprop="title">' . __( 'Categories', 'makotokw' ) . '</span></a><i class="icon-chevron-right"></i>';
			$term = $wp_query->get_queried_object();
			if ($term->parent > 0) {
				echo makotokw_breadcrumbs_category_parents($term->parent, '<i class="icon-chevron-right"></i>');
			}
			echo '<span itemprop="title">'.single_cat_title('', false).'</span>';
		} else if (is_tag()) {
			echo '<a href="/tags/" itemprop="url"><span itemprop="title">' . __( 'Tags', 'makotokw' ) . '</a><i class="icon-chevron-right"></i>';
			echo single_tag_title('', false);
		} elseif (is_archive()) {
			if ( is_tax( 'blogs' ) ) {
				echo '<span itemprop="title">' . __( 'Blog', 'makotokw' ) . '</span>';
				echo '<i class="icon-chevron-right"></i><span itemprop="title">'.single_cat_title('', false).'</span>';
			} elseif ( is_tax( 'portfolios' ) ) {
				echo '<span itemprop="title">' . __( 'Portfolio', 'makotokw' ) . '</span>';
				echo '<i class="icon-chevron-right"></i><span itemprop="title">'.single_cat_title('', false).'</span>';
			} else {
				echo "  "  . __( 'Archives', 'makotokw' );
			}
		} elseif (is_search()) {
			echo "  " . __( 'Search Results', 'makotokw' );
		} elseif (is_404()) {
			echo "  " . __( '404 Not Found', 'makotokw' );
		} elseif (is_single()) {
			$category = get_the_category();
			if (is_array($category) && count($category) > 0) {
				echo '<a href="/categories/" itemprop="url"><span itemprop="title">' . __( 'Categories', 'makotokw' ) . '</span></a><i class="icon-chevron-right"></i>';
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

function makotokw_facebook_recommendations_bar() {
	?>
<div class="fb-recommendations-bar" data-href="<?php echo esc_url(( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])?>"></div>
<?php
}

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
} // ends check for makotokw_comment()

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

function makotokw_post_summary($content, $length = 50, $trimmarker = '...') {
	if (class_exists('PukiWiki_for_WordPress')) {
		$pukiwiki = PukiWiki_for_WordPress::getInstance();
		$content = $pukiwiki->the_content($content);
	}
	if (class_exists('WP_GFM')) {
		$gfm = WP_GFM::getInstance();
		$content = $gfm->the_content($content);
	}
	return mb_strimwidth(strip_tags(strip_shortcodes($content)), 0, 128) . '...';
}

function makotokw_related_post($arg = array()) {
	global $post;
?>
	<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	<div class="entry-content">
		<span class="entry-date"><?php makotokw_posted_on(); ?></span>
		<p class="entry-summary">
			<?php echo makotokw_post_summary($post->post_content); ?>
		</p>
	</div>
<?php
}

function makotokw_related_posts($arg = array()) {
	global $post;

	$rq = false;

	$arg = array_merge(array(
		'post_type' => 'post',
		'max_count' => 5,
	), $arg);

	$cur_post = $post;
	$max_count = $arg['max_count'];

	// find by portfolio
	unset($portfolio);
	$terms = get_the_terms($cur_post->ID, 'portfolios');
	if (!is_wp_error($terms) && !empty($terms)) {
		$portfolio = array_shift($terms);

		$query_arg = array(
			'post_type' => $arg['post_type'],
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolios',
					'terms' => $portfolio->term_id,
					'operator' => 'IN'
				)
			),
			'showposts' => $max_count + 1,
		);
		$rq = new WP_Query($query_arg);
	}

	// find by featured tags
	if (defined('WP_THEME_FEATURED_TAG')) {
		$featuredTagSlugs = explode(',', WP_THEME_FEATURED_TAG);
		if (!$rq || !$rq->have_posts()) {
			$tags = get_the_tags($cur_post->ID);
			if (is_array($tags) && count($tags)) {
				$tags = array_filter($tags, function ($t) use ($featuredTagSlugs) {
					return in_array($t->slug, $featuredTagSlugs);
				});
				if (count($tags) > 0) {
					$tag = array_pop($tags);
					$rq = new WP_Query(
						array(
							'tag_id' => $tag->term_id,
							'showposts' => $max_count + 1,
						)
					);
				}

			}
		}
	}

	// find by category
	if (!$rq || !$rq->have_posts()) {
		$categories = get_the_category($cur_post->ID);
		if (count($categories) > 0) {
			$cat = $categories[0];
			if ($cat->cat_ID != 1) { // ignore uncategorized category
				$rq = new WP_Query(
					array(
						'cat' => $cat->cat_ID,
						'showposts' => $max_count + 1,
					)
				);
			}
		}
	}

	if ($rq && $rq->have_posts()): $count = 0;?>
		<aside class="related-posts">
			<h2><?php _e('Related Posts', 'makotokw');?></h2>
			<?php while ( $rq->have_posts() ): $rq->the_post(); ?>
					<?php if ($post->ID != $cur_post->ID && $count < $max_count): ?>
						<section class="related-post">
							<?php makotokw_related_post(); ?>
						</section>
					<?php endif ?>
			<?php endwhile ?>
		</aside>
	<?php endif;
	wp_reset_query();
}

function makotokw_portfolio_note() {
	global $post;
	unset($portfolio);
	$terms = get_the_terms($post->ID, 'portfolios');
	if (!is_wp_error($terms) && !empty($terms)) {
		$portfolio = array_shift($terms);
	}

	if (isset($portfolio)):
		$query_arg = array(
			'post_type' => 'page',
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolios',
					'terms' => $portfolio->term_id,
					'operator' => 'IN'
				)
			)
		);

		$rq = new WP_Query($query_arg);
		if ($rq->have_posts()): $rq->the_post(); ?>
			<section class="note-portfolio">
				<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
			</section>
			<?php
		endif;
		wp_reset_query();
	endif;
}

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