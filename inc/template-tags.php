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

		<?php if ( get_next_post_link() ) : ?>
		<div class="section section-mini">
			<h2 class="section-title">Newer post</h2>
			<div class="section-content"><?php next_post_link( '%link', '%title' ); ?></div>
		</div>
		<?php endif; ?>
		<?php if ( get_previous_post_link() ) : ?>
		<div class="section section-mini">
			<h2 class="section-title">Older post</h2>
			<div class="section-content"><?php previous_post_link( '%link', '%title' ); ?></div>
		</div>
		<?php endif; ?>

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


function makotokw_list_nav()
{
	global $post;

	if ($mylist = get_mylist($post)) {

		$first_post = get_first_post_on_mylist($post);
		$prev_post = get_adjacent_post_on_mylist($post, true);
		$next_post = get_adjacent_post_on_mylist($post, false);

		if ($first_post->ID == $post->ID || $first_post->ID == $prev_post->ID) {
			unset($first_post);
		}

		$mylist_link = get_term_link($mylist, 'mylist');

		?>
		<div class="section section-mini">
			<h2 class="section-title">List</h2>

			<div class="section-content">
				<?php if ($first_post): ?>
					最初→&nbsp;<a href="<?php echo get_permalink($first_post) ?>"
								rel="prev"><?php echo get_the_title($first_post) ?></a>&nbsp;
				<?php endif ?>
				<?php if ($prev_post): ?>
					前→&nbsp;<a href="<?php echo get_permalink($prev_post) ?>"
								rel="prev"><?php echo get_the_title($prev_post) ?></a>&nbsp;
				<?php endif ?>
				<?php if ($next_post): ?>
					次→&nbsp;<a href="<?php echo get_permalink($next_post) ?>"
								rel="prev"><?php echo get_the_title($next_post) ?></a>&nbsp;
				<?php endif ?>
				<?php if (!is_wp_error($mylist_link)): ?>
					マイリスト→&nbsp;<a href="<?= $mylist_link ?>"><?= $mylist->name ?></a>&nbsp;
				<?php endif ?>
			</div>
		</div>
	<?php
	}
}

function makotokw_pagination($pages = '', $range = 3) {
	global $paged;
	$showitems = ($range * 3) + 1;

	if (empty($paged)) {
		$paged = 1;
	}
	if ($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if (!$pages) {
			$pages = 1;
		}
	}
	if (1 != $pages) {
		echo '<div class="pagination"><ul>';
		if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
			echo '<li><a rel="nofollow" href="' . get_pagenum_link(1) . '">&laquo; ' . __('First', 'makotokw') . '</a></li>';
		}
		if ($paged > 1) {
			echo '<li><a rel="nofollow" href="' . get_pagenum_link($paged - 1) . '" class="inactive">&lsaquo; ' . __('Previous', 'makotokw') . '</a></li>';
		}
		for ($i = 1; $i <= $pages; $i++) {
			if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
				echo ($paged == $i) ? '<li class="current"><span class="page">' . $i . '</span></li>' : '<li><a rel="nofollow" href="' . get_pagenum_link($i) . '" class="inactive">' . $i . '</a></li>';
			}
		}
		if ($paged < $pages)
			echo '<li><a rel="nofollow" href="' . get_pagenum_link($paged + 1) . '" class="inactive">' . __('Next', 'makotokw') . ' &rsaquo;</a></li>';
		if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
			echo '<a rel="nofollow" class="inactive" href="' . get_pagenum_link($pages) . '">' . __('Last', 'makotokw') . ' &raquo;</a>';
		echo '</ul></div>';
	}
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

		$divider = '&nbsp;<i class="fa fa-chevron-right"></i>&nbsp;';

		echo '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb">';


		// Add the Home link
		echo '<a href="' . esc_url(home_url('/')) . '"><i class="fa fa-home"></i> Home</a>' . $divider;

		if (is_category()) {
			echo '<a href="/categories/" itemprop="url"><span itemprop="title">' . __( 'Categories', 'makotokw' ) . '</span></a>' . $divider;
			$term = $wp_query->get_queried_object();
			if ($term->parent > 0) {
				echo makotokw_breadcrumbs_category_parents($term->parent, $divider);
			}
			echo '<span itemprop="title">'.single_cat_title('', false).'</span>';
		} else if (is_tag()) {
			echo '<a href="/tags/" itemprop="url"><span itemprop="title">' . __( 'Tags', 'makotokw' ) . '</a>'.$divider;
			echo single_tag_title('', false);
		} elseif (is_mylist()) {
			echo "  "  . __( 'Mylist', 'makotokw' );
		} elseif (is_archive()) {
			if ( is_tax( 'blogs' ) ) {
				echo '<span itemprop="title">' . __( 'Blog', 'makotokw' ) . '</span>' . $divider;
				echo '<span itemprop="title">'.single_cat_title('', false).'</span>';
			} elseif ( is_tax( 'portfolios' ) ) {
				echo '<span itemprop="title">' . __( 'Portfolio', 'makotokw' ) . '</span>' . $divider;
				echo '<span itemprop="title">'.single_cat_title('', false).'</span>';
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
				echo '<a href="/categories/" itemprop="url"><span itemprop="title">' . __( 'Categories', 'makotokw' ) . '</span></a>' . $divider;
				$category_id = get_cat_ID($category[0]->cat_name);
				echo makotokw_breadcrumbs_category_parents($category_id, $divider);
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
						echo '<a href="' . get_permalink($ancestor) . '" itemprop="url"><span itemprop="title">' . strip_tags(apply_filters('single_post_title', get_the_title($ancestor))) . '</span></a>' . $divider;
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

function makotokw_share_this() {
	// twitter: https://about.twitter.com/resources/buttons#tweet
	// hatena: http://b.hatena.ne.jp/guide/bbutton
	// pocket: http://getpocket.com/publisher/button
	// google+: https://developers.google.com/+/web/+1button/
	$permalink = get_permalink();
	if (WP_THEME_DEBUG === true) {
		$permalink = str_replace(home_url(), WP_THEME_PRODUCTION_URL, $permalink);
	}
?>
<div class="section section-mini section-share-this">
	<h2 class="section-title"><?php _e('Share This', 'makotokw');?></h2>
	<div class="section-content">
		<div class="share-item share-item-twitter">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $permalink; ?>" data-text="<?php the_title(); ?>" data-via="makoto_kw" data-lang="en">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	  </div>
		<div class="share-item share-item-hatena-bookmark">
			<a href="http://b.hatena.ne.jp/entry/<?php echo $permalink; ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?php the_title(); ?>｜<?php bloginfo('name'); ?>" data-hatena-bookmark-layout="standard-balloon" data-hatena-bookmark-lang="en" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
		</div>
		<div class="share-item share-item-pocket">
			<a data-pocket-label="pocket"  data-save-url="<?php echo $permalink; ?>" data-pocket-count="horizontal" class="pocket-btn" data-lang="en"></a>
			<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
		</div>
		<div class="share-item share-item-google-plus"">
			<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
			<script type="text/javascript">
				(function() {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/platform.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			</script>
		</div>
		<div class="share-item share-item-facebook-like">
			<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo $permalink; ?>&amp;send=false&amp;layout=button_count&amp;width=110&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe>
		</div>
	</div>
</div>
<?php
}

function makotokw_about_me() {
	$email = get_the_author_meta('user_email');
	$avatar = get_avatar( $email, '48', '', true );
?>
<div class="section section-mini section-about-me">
	<h2 class="section-title"><?php _e('About', 'makotokw');?></h2>
	<div class="section-content">
		<?php echo $avatar ?><?php makotokw_about_comment() ?>
	</div>
</div>
<?php
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
		<aside class="section section-mini section-related-posts">
			<h2 class="section-title"><?php _e('Related Posts', 'makotokw');?></h2>
			<div class="section-content">
				<ul>
				<?php while ( $rq->have_posts() ): $rq->the_post(); ?>
					<?php if ($post->ID != $cur_post->ID && $count < $max_count): ?>
						<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
					<?php endif ?>
				<?php endwhile ?>
				</ul>
			</div>
		</aside>
	<?php endif;
	wp_reset_query();
}

function makotokw_related_portfolio() {
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
			<section class="section section-mini section-portfolio">
				<h2 class="section-title">Related Software</h2>
				<div class="section-content"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
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

function makotokw_the_category_slug($separator = '', $post_id = false) {

	global $wp_rewrite;
	$categories = get_the_category( $post_id );

	if ( empty( $categories ) ) {
		return;
	}

	$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

	$thelist = '';
	$i = 0;
	foreach ( $categories as $category ) {
		if ( 0 < $i ) {
			$thelist .= $separator;
		}
		$thelist .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '" ' . $rel . '>' . $category->slug.'</a>';
		++$i;
	}
	echo $thelist;
}

function makotokw_section_category_and_tag($title = 'Tag') {
	?>
	<section class="section section-mini section-category-tag">
		<h2 class="section-title"><?php echo $title?></h2>
		<div class="section-content">
			<?php makotokw_the_category_and_tag(); ?></a>
		</div>
	</section>
<?php
}
function makotokw_the_category_and_tag() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( __( ' <i class="fa fa-folder"></i> ', 'makotokw' ) );
	if ( $categories_list && makotokw_categorized_blog() ) :?>
		<span class="cat-links">
			<?php printf( __( '<i class="fa fa-folder"></i> %1$s', 'makotokw' ), $categories_list ); ?>
		</span>
	<?php endif; // End if categories ?>
	<?php
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ' <i class="fa fa-tag"></i>', 'makotokw' ) );
	if ( $tags_list ) :?>
		<span class="tag-links">
				<?php printf( __( '<i class="fa fa-tag"></i> %1$s', 'makotokw' ), $tags_list ); ?>
			</span>
	<?php endif; // End if $tags_list
	printf( '<span class="author vcard"><span class="fn">%1$s</span></span>', get_the_author() );
}

function makotokw_the_tag_links( $prefix = '<i class="fa fa-tag"></i>') {
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', $prefix );
	if ( $tags_list ) printf( __( $prefix.' %1$s', 'makotokw' ), $tags_list );
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

function makotokw_inline_archives($args = '')
{
	global $wp_locale;
	$base_url = '/';
	$defaults = array('before_year' => '', 'after_year' => '', 'year_format' => 'Y', 'month_format' => 'n', 'echo' => 1);
	$args = wp_parse_args($args, $defaults);
	$archives = explode("\n", wp_get_archives(array_merge($args, (array('echo' => 0)))));
	extract($args, EXTR_SKIP);
	$years = array();
	foreach ($archives as $a) {
		if (preg_match('/\/([0-9]{4})\/([0-9]{2})\//', $a, $matches)) {
			$year = $matches[1];
			$month = $matches[2];
			$label = (empty($month_format)) ? $wp_locale->get_month($month) : date($month_format, mktime(0, 0, 0, $month, 1, $year));
			$a = preg_replace('/(.+<a[^>]+>)([^<]+)(<\/a>.+)/', '${1}' . $label . '$3', $a);
			if (!isset($years[$year])) {
				$years[$year] = array();
			}
			$years[$year][(int)$month] = $a;
		}
	}
	$output = '<ul class="list-archives list-archives-year">';
	foreach ($years as $year => $monthes) {
		$label = date($year_format, mktime(0, 0, 0, 1, 1, $year));
		$url = '/' . $year . '/';
		$output .= '<li class="list-archives-item list-archives-item-year"><a href="' . $url . '">' . $before_year . $label . $after_year . '</a><ul class="list-archives  list-archives-month">';

		for ($month = 1; $month <= 12; $month++) {
			if (is_null($monthes[$month])) {
				$output .= '<li class="list-archives-item list-archives-item-month list-archives-item-month-no-items"><span>' . $month . '</span></li>';
			} else {
				$url = sprintf('%s%04d/%02d/', $base_url, $year, $month);
				$output .= '<li class="list-archives-item list-archives-item-month"><a href="' . $url . '">' . $month . '</a></li>';
			}
		}
		$output .= '</ul></li>';
	}
	$output .= '</ul>';
	if ($echo) {
		echo $output;
	} else {
		return $output;
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
