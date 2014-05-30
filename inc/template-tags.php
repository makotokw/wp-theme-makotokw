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
		$previous = (is_attachment()) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && (is_home() || is_archive() || is_search()) )
		return;

	$nav_class = (is_single()) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?= esc_attr( $nav_id ); ?>" class="<?= esc_attr( $nav_class ); ?>">
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

		<?php elseif ( $wp_query->max_num_pages > 1 && (is_home() || is_archive() || is_search()) ) : // navigation links for home, archive, and search pages ?>
			<div class="nav-links">
				<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'makotokw' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'makotokw' ) ); ?></div>
				<?php endif; ?>

			</div>
		<?php endif; ?>

	</nav><!-- #<?= esc_html( $nav_id ); ?> -->
	<?php
}


function makotokw_list_nav() {
	global $post;

	if ( $mylist = get_mylist( $post ) ) {

		$first_post = get_first_post_on_mylist( $post );
		$prev_post  = get_adjacent_post_on_mylist( $post, true );
		$next_post  = get_adjacent_post_on_mylist( $post, false );

		if ( $first_post->ID == $post->ID || $first_post->ID == $prev_post->ID ) {
			unset($first_post);
		}

		$mylist_link = get_term_link( $mylist, 'mylist' );

		?>
		<div class="section section-mini section-mylist">
			<h2 class="section-title">List</h2>

			<div class="section-content">
				<?php if ( ! is_wp_error( $mylist_link ) ): ?>
					<i class="fa fa-list-alt"></i> <a href="<?= $mylist_link ?>"><?= $mylist->name ?></a>
				<?php endif ?>
				<ul>
					<?php if ( $first_post ): ?>
						<li><i class="fa fa-angle-double-left"></i>&nbsp;<a
								href="<?= get_permalink( $first_post ) ?>"
								rel="prev"><?= get_the_title( $first_post ) ?></a></li>
					<?php endif ?>
					<?php if ( $prev_post ): ?>
						<li><i class="fa fa-angle-left"></i>&nbsp;<a href="<?= get_permalink( $prev_post ) ?>" rel="prev"><?= get_the_title( $prev_post ) ?></a></li>
					<?php endif ?>
					<?php if ( $next_post ): ?>
						<li><i class="fa fa-angle-right"></i>&nbsp;<a href="<?= get_permalink( $next_post ) ?>" rel="prev"><?= get_the_title( $next_post ) ?></a></li>
					<?php endif ?>
				</ul>
			</div>
		</div>
	<?php
	}
}

function makotokw_pagination( $pages = '', $range = 3 ) {
	global $paged;
	$showitems = ($range * 3) + 1;

	if ( empty($paged) ) {
		$paged = 1;
	}
	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}
	if ( 1 != $pages ) {
		?>
		<div class="pagination"><ul>
		<?php if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) : ?>
			<li><a rel="nofollow" href="<?= get_pagenum_link( 1 ) ?>">&laquo; <?php __( 'First', 'makotokw' ) ?></a></li>
		<?php endif ?>
		<?php if ( $paged > 1 ) : ?>
			<li><a rel="nofollow" href="<?= get_pagenum_link( $paged - 1 ) ?>" class="inactive">&lsaquo; <?php __( 'Previous', 'makotokw' ) ?></a></li>
		<?php endif ?>
		<?php for ( $i = 1; $i <= $pages; $i++ ) : ?>
			<?php if ( 1 != $pages && ( ! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems) ) : ?>
				<?php if ( $paged == $i ) : ?>
					<li class="current"><span class="page"><?= $i ?></span></li>
				<? else : ?>
					<li><a rel="nofollow" href="<?= get_pagenum_link( $i ) ?>" class="inactive"><?= $i ?></a></li>
				<? endif ?>
			<?php endif ?>
		<?php endfor ?>
		<?php if ( $paged < $pages ) : ?>
			<li><a rel="nofollow" href="<?= get_pagenum_link( $paged + 1 ) ?>" class="inactive"><?php __( 'Next', 'makotokw' ) ?> &rsaquo;</a></li>
		<?php endif ?>
		<?php if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) : ?>
			<a rel="nofollow" class="inactive" href="<?= get_pagenum_link( $pages ) ?>"><?php __( 'Last', 'makotokw' ) ?> &raquo;</a>
		<?php endif ?>
		</ul></div>
		<?php
	}
}

function makotokw_google_analytics() {
	if ( WP_THEME_DEBUG === true || WP_THEME_GOOGLE_ANALYTICS_ACCOUNT === false ) {
		return;
	}
	?>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
		ga('create', '<?= WP_THEME_GOOGLE_ANALYTICS_ACCOUNT; ?>', '<?= WP_THEME_GOOGLE_ANALYTICS_DOMAIN; ?>');
		ga('send', 'pageview');
	</script>
	<?php
}

function makotokw_itunes_affiliate_script() {
	if ( WP_THEME_ITUNES_AFFILIATE_ID === false ) {
		return;
	}
	?>
	<script type='text/javascript'>var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', '<?= WP_THEME_ITUNES_AFFILIATE_ID ?>']);(function(){var autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src= ('https:' == document.location.protocol) ? 'https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js' : 'http://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();</script>
	<?php
}

/**
 * @see http://gilbert.pellegrom.me/how-to-breadcrumbs-in-wordpress/
 */
function makotokw_breadcrumbs() {
	global $wp_query;

	if ( ! is_home() ) {
		$divider = '&nbsp;<i class="fa fa-chevron-right"></i>&nbsp;';
		?>
		<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb">
		<a href="<?= esc_url( home_url( '/' ) ) ?>"><i class="fa fa-home"></i></a><?= $divider ?>
		<?php if ( is_category() ) : $term = $wp_query->get_queried_object(); ?>
			<a href="/categories/" itemprop="url"><span itemprop="title"><?php _e( 'Categories', 'makotokw' ) ?></span></a><?= $divider ?>
			<?php if ( $term->parent > 0 ) : ?>
				 <?= makotokw_breadcrumbs_category_parents( $term->parent, $divider ); ?>
			<?php endif; ?>
			<span itemprop="title"><?= single_cat_title( '', false ) ?></span>
		<?php elseif ( is_tag() ) :?>
			<a href="/tags/" itemprop="url"><span itemprop="title"><?php _e( 'Tags', 'makotokw' ) ?></a><?= $divider ?>
			<span class="breadcrumb-last"><?= single_tag_title( '', false ) ?></span>
		<?php elseif ( is_mylist() ): ?>
			<span class="breadcrumb-last"><?php _e( 'Mylist', 'makotokw' ) ?></span>
		<?php elseif ( is_archive() ) : ?>
			<?php if ( is_tax( 'blogs' ) ) : ?>
				<span itemprop="title"><?php _e( 'Blog', 'makotokw' ) ?></span><?= $divider ?>
				<span itemprop="title"><?= single_cat_title( '', false ) ?></span>
			<?php elseif ( is_tax( 'portfolios' ) ) : ?>
				<span itemprop="title"><?php _e( 'Portfolio', 'makotokw' ) ?></span><?= $divider ?>
				<span itemprop="title"><?= single_cat_title( '', false ) ?></span>
			<?php else : ?>
				<span class="breadcrumb-last"><?php _e( 'Archives', 'makotokw' ) ?></span>
			<?php endif ?>
		<?php elseif ( is_search() ) : ?>
			<span class="breadcrumb-last"><?php _e( 'Search Results', 'makotokw' ) ?></span>
		<?php elseif ( is_404() ) : ?>
			<span class="breadcrumb-last"><?php _e( '404 Not Found', 'makotokw' ) ?></span>
		<?php elseif ( is_single() ) : $category = get_the_category(); ?>
			<?php if ( is_array( $category ) && count( $category ) > 0 ) : $category_id = get_cat_ID( $category[0]->cat_name ); ?>
				<a href="/categories/" itemprop="url"><span itemprop="title"><?php _e( 'Categories', 'makotokw' ) ?></span></a><?= $divider ?>
				<?= makotokw_breadcrumbs_category_parents( $category_id, $divider ); ?>
			<?php endif ?>
			<span class="breadcrumb-last"><?= the_title( '', '', false ) ?></span>
		<?php elseif ( is_page() ) : $post = $wp_query->get_queried_object(); ?>
			<?php if ( $post->post_parent == 0 ) : ?>
				<span class="breadcrumb-last"><?= the_title( '', '', false ) ?></span>
			<?php else : ?>
				<?php
				$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				array_push( $ancestors, $post->ID );
				?>
				<?php foreach ( $ancestors as $ancestor ) : ?>
					<?php if ( $ancestor != end( $ancestors ) ) : ?>
						<a href="<?= get_permalink( $ancestor ) ?>" itemprop="url">
							<span itemprop="title"><?= strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) ?></span>
						</a>
						<?= $divider ?>
					<?php else : ?>
						<span class="breadcrumb-last"><?= strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) ?></span>
					<?php endif ?>
				<?php endforeach ?>
			<?php endif ?>
		<?php endif ?>
		</div>
		<?php
	}
}

function makotokw_breadcrumbs_category_parents( $id, $separator = '/', $visited = array() ) {
	$chain  = '';
	$parent = get_category( $id );
	if ( is_wp_error( $parent ) ) {
		return $chain;
	}
	if ( $parent->parent && ($parent->parent != $parent->term_id) && ! in_array( $parent->parent, $visited ) ) {
		$visited[] = $parent->parent;
		$chain    .= makotokw_breadcrumbs_category_parents( $parent->parent, $separator, $visited );
	}

	$chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s' ), $parent->name ) ) . '" itemprop="url"><span itemprop="title">' . $parent->name . '</span></a>' . $separator;

	return $chain;
}

function makotokw_zenback_widget() {
	?>
	<?php if ( ! is_preview() && comments_open() && (is_single() || is_page()) ): ?>
		<aside class="zenback-widget-area">
			<?php if ( WP_THEME_DEBUG === false ): ?>
				<?= WP_THEME_ZENBACK_WIDGET_SCRYPT ?>
			<?php else : ?>
				<?php include 'zenback.debug.html' ?>
			<?php endif; ?>
		</aside>
	<?php endif; ?>
	<?php
}

function makotokw_facebook_sdk() {
	if ( WP_THEME_OGP === true ):
		?>
		<div id="fb-root"></div>
		<script>(function (d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/<?= WP_OGP_LOCALE; ?>/all.js#xfbml=1&appId=<?= WP_OGP_FB_APPID; ?>";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<?php
	endif;
}

function makotokw_facebook_recommendations_bar() {
	?>
	<div class="fb-recommendations-bar" data-href="<?= esc_url( ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] )?>"></div>
	<?php
}


/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function makotokw_posted_on() {
	printf(
		__( '<time class="published time time-icon" datetime="%1$s">%2$s</time>', 'makotokw' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_post_time( THEME_DATE_FORMAT ) )
	);

	printf(
		__( '<time class="updated" datetime="%1$s"></time>', 'makotokw' ),
		esc_attr( get_the_modified_date( 'c' ) )
	);
}

function makotokw_the_content_more_link( $link ) {
	if ( preg_match( '/href="([^"]+)"/', $link, $match ) ) {
		return '<a class="btn more-link" href="' . $match[1] . '">続きを読む</a>';
	}
	return $link;
}

add_filter( 'the_content_more_link', 'makotokw_the_content_more_link' );

function makotokw_post_summary( $content, $length = 50, $trimmarker = '...' ) {
	if ( class_exists( 'PukiWiki_for_WordPress' ) ) {
		$pukiwiki = PukiWiki_for_WordPress::getInstance();
		$content  = $pukiwiki->the_content( $content );
	}
	if ( class_exists( 'WP_GFM' ) ) {
		$gfm     = WP_GFM::get_instance();
		$content = $gfm->the_content( $content );
	}
	return mb_strimwidth( strip_tags( strip_shortcodes( $content ) ), 0, 128 ) . '...';
}

function makotokw_share_this() {
	// twitter: https://about.twitter.com/resources/buttons#tweet
	// hatena: http://b.hatena.ne.jp/guide/bbutton
	// pocket: http://getpocket.com/publisher/button
	// google+: https://developers.google.com/+/web/+1button/
	$permalink = get_permalink();
	if ( WP_THEME_DEBUG === true ) {
		$permalink = str_replace( home_url(), WP_THEME_PRODUCTION_URL, $permalink );
	}
	?>
	<div class="section section-mini section-share-this">
		<h2 class="section-title"><?php _e( 'Share This', 'makotokw' ); ?></h2>
		<div class="section-content">
			<div class="share-item share-item-twitter">
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?= $permalink; ?>" data-text="<?php the_title(); ?>" data-via="makoto_kw" data-lang="en">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
			<div class="share-item share-item-hatena-bookmark">
			<a href="http://b.hatena.ne.jp/entry/<?= $permalink; ?>" class="hatena-bookmark-button" data-hatena-bookmark-title="<?php the_title(); ?>｜<?php bloginfo( 'name' ); ?>" data-hatena-bookmark-layout="standard-balloon" data-hatena-bookmark-lang="en" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
			</div>
			<div class="share-item share-item-pocket">
			<a data-pocket-label="pocket"  data-save-url="<?= $permalink; ?>" data-pocket-count="horizontal" class="pocket-btn" data-lang="en"></a>
			<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
			</div>
		<div class="share-item share-item-google-plus"">
			<div class="g-plusone" data-size="medium" data-href="<?php the_permalink(); ?>"></div>
			<script type="text/javascript">
				(function () {
					var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
					po.src = 'https://apis.google.com/js/platform.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				})();
			</script>
		</div>
		<div class="share-item share-item-facebook-like">
			<iframe src="//www.facebook.com/plugins/like.php?href=<?= $permalink; ?>&amp;send=false&amp;layout=button_count&amp;width=110&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=verdana&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:110px; height:21px;" allowTransparency="true"></iframe>
		</div>
	</div>
	</div>
	<?php
}

function makotokw_about_me() {
	?>
	<div class="section section-mini section-about-me">
		<h2 class="section-title"><?php _e( 'About', 'makotokw' ); ?></h2>
		<div class="section-content">
			<div itemprop="author copyrightHolder editor" itemscope itemtype="http://data-vocabulary.org/Person">
			<?= str_replace( '<img ', '<img itemprop="image" ', get_avatar( get_the_author_meta( 'user_email' ), '48', '', get_the_author() ) ) ?><?php makotokw_about_comment() ?>
			</div>
		</div>
	</div>
	<?php
}

function makotokw_related_post( $arg = array() ) {
	global $post;
	?>
	<h1 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	<div class="entry-content">
		<span class="entry-date"><?php makotokw_posted_on(); ?></span>
		<p class="entry-summary">
			<?= makotokw_post_summary( $post->post_content ); ?>
		</p>
	</div>
	<?php
}

function makotokw_related_posts( $arg = array() ) {
	global $post;

	$rq = false;

	$arg = array_merge(
		array(
			'post_type' => 'post',
			'max_count' => 5,
		),
		$arg
	);

	$cur_post  = $post;
	$max_count = $arg['max_count'];

	// find by portfolio
	unset($portfolio);
	$terms = get_the_terms( $cur_post->ID, 'portfolios' );
	if ( ! is_wp_error( $terms ) && ! empty($terms) ) {
		$portfolio = array_shift( $terms );

		$query_arg = array(
			'post_type' => $arg['post_type'],
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolios',
					'terms'    => $portfolio->term_id,
					'operator' => 'IN',
				),
			),
			'showposts' => $max_count + 1,
		);
		$rq = new WP_Query( $query_arg );
	}

	// find by featured tags
	if ( defined( 'WP_THEME_FEATURED_TAG' ) ) {
		$featuredTagSlugs = explode( ',', WP_THEME_FEATURED_TAG );
		if ( ! $rq || ! $rq->have_posts() ) {
			$tags = get_the_tags( $cur_post->ID );
			if ( is_array( $tags ) && count( $tags ) ) {
				$tags = array_filter(
					$tags,
					function ( $t ) use ( $featuredTagSlugs ) {
						return in_array( $t->slug, $featuredTagSlugs );
					}
				);
				if ( count( $tags ) > 0 ) {
					$tag = array_pop( $tags );
					$rq  = new WP_Query(
						array(
							'tag_id'    => $tag->term_id,
							'showposts' => $max_count + 1,
						)
					);
				}
			}
		}
	}

	// find by category
	if ( ! $rq || ! $rq->have_posts() ) {
		$categories = get_the_category( $cur_post->ID );
		if ( count( $categories ) > 0 ) {
			$cat = $categories[0];
			if ( $cat->cat_ID != 1 ) { // ignore uncategorized category
				$rq = new WP_Query(
					array(
						'cat'       => $cat->cat_ID,
						'showposts' => $max_count + 1,
					)
				);
			}
		}
	}

	if ( $rq && $rq->have_posts() ): $count = 0;?>
		<aside class="section section-mini section-related-posts">
			<h2 class="section-title"><?php _e( 'Related Posts', 'makotokw' ); ?></h2>
			<div class="section-content">
				<ul>
					<?php while ( $rq->have_posts() ): $rq->the_post(); ?>
						<?php if ( $post->ID != $cur_post->ID && $count < $max_count ): ?>
							<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
						<?php endif ?>
					<?php endwhile ?>
				</ul>
			</div>
		</aside>
	<?php endif;
	wp_reset_postdata();
}

function makotokw_related_portfolio() {
	global $post;
	unset($portfolio);
	$terms = get_the_terms( $post->ID, 'portfolios' );
	if ( ! is_wp_error( $terms ) && ! empty($terms) ) {
		$portfolio = array_shift( $terms );
	}

	if ( isset($portfolio) ):
		$query_arg = array(
			'post_type' => 'page',
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolios',
					'terms'    => $portfolio->term_id,
					'operator' => 'IN',
				),
			)
		);

		$rq = new WP_Query( $query_arg );
		if ( $rq->have_posts() ): $rq->the_post(); ?>
			<section class="section section-mini section-portfolio">
				<h2 class="section-title">Related Software</h2>
				<div class="section-content"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
			</section>
		<?php
		endif;
		wp_reset_postdata();
	endif;
}

function makotokw_tag_cloud( $args = array() ) {
	$tags = wp_tag_cloud(
		array_merge(
			array(
				'smallest' => 1,
				'largest'  => 10,
				'format'   => 'array',
				'echo'     => false,
			),
			$args
		)
	);

	if ( count( $tags ) ) {

		echo '<ul class="tags-cloud">';
		foreach ( $tags as $tag ) {
			$rank = 0;
			if ( preg_match( '/font-size: ([0-9.]+)pt/', $tag, $matches ) ) {
				$rank = 11 - $matches[1];
				$tag  = str_replace( $matches[0], '', $tag );
			}
			$count = 0;
			if ( preg_match( "/title='[^'0-9]*([0-9]+)[^']*'/", $tag, $matches ) ) {
				$count = intval( $matches[1] );
			}
			printf(
				'<li class="tag rank-%1$d">%2$s%3$s</li>',
				$rank,
				$tag,
				($count > 0) ? '<span class="count">(' . $count . ')</span>' : ''
			);
		}
		echo '</ul>';
	}
}

function makotokw_the_category_slug( $separator = '', $post_id = false ) {

	global $wp_rewrite;
	$categories = get_the_category( $post_id );

	if ( empty($categories) ) {
		return;
	}

	$rel = (is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks()) ? 'rel="category tag"' : 'rel="category"';

	$the_list = '';
	$i       = 0;
	foreach ( $categories as $category ) {
		if ( 0 < $i ) {
			$the_list .= $separator;
		}
		?>
		<a href="<?= esc_url( get_category_link( $category->term_id ) ) ?>" title="<?= esc_attr( sprintf( __( 'View all posts in %s' ), $category->name ) ) ?>" <?= $rel ?>><?= esc_html( $category->slug ) ?></a>
		<?php
		++$i;
	}
}

function makotokw_section_category_and_tag( $title = 'Tag' ) {
	?>
	<section class="section section-mini section-category-tag">
		<h2 class="section-title"><?= esc_html( $title ) ?></h2>
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

function makotokw_the_tag_links( $prefix = '<i class="fa fa-tag"></i>' ) {
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', $prefix );
	if ( $tags_list ) printf( __( $prefix . ' %1$s', 'makotokw' ), $tags_list );
}

/**
 * Returns true if a blog has more than 1 category
 */
function makotokw_categorized_blog() {
	if ( false === ($all_the_cool_cats = get_transient( 'all_the_cool_cats' )) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories(
			array(
				'hide_empty' => 1,
			)
		);

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

function makotokw_inline_archives( $args = '' ) {
	global $wp_locale;
	$base_url = '/';
	$defaults = array(
		'before_year'  => '',
		'after_year'   => '',
		'year_format'  => 'Y',
		'month_format' => 'n',
	);
	$args     = wp_parse_args( $args, $defaults );
	$archives = explode( "\n", wp_get_archives( array_merge( $args, (array( 'echo' => 0 )) ) ) );
	/**
	 * @var string $before_year
	 * @var string $after_year
	 * @var string $year_format
	 * @var string $month_format
	 * @var int $echo
	 */
	extract( $args, EXTR_SKIP );
	$now   = time();
	$years = array();
	foreach ( $archives as $a ) {
		if ( preg_match( '/\/([0-9]{4})\/([0-9]{2})\//', $a, $matches ) ) {
			$year  = $matches[1];
			$month = $matches[2];
			$label = (empty($month_format)) ? $wp_locale->get_month( $month ) : date( $month_format, mktime( 0, 0, 0, $month, 1, $year ) );
			$a     = preg_replace( '/(.+<a[^>]+>)([^<]+)(<\/a>.+)/', '${1}' . $label . '$3', $a );
			if ( ! isset($years[$year]) ) {
				$years[$year] = array();
			}
			$years[$year][(int)$month] = $a;
		}
	}
	?>
	<ul class="list-archives list-archives-year">
	<?php foreach ( $years as $year => $months ) : ?>
		<?php
		$label = date( $year_format, mktime( 0, 0, 0, 1, 1, $year ) );
		$url   = '/' . $year . '/'
		?>
		<li class="list-archives-item list-archives-item-year">
			<a href="<?= $url ?>"><?= $before_year . $label . $after_year ?></a>
			<ul class="list-archives  list-archives-month">
		<?php for ( $month = 1; $month <= 12; $month++ ) : ?>
			<?php if ( is_null( @$months[$month] ) ) : ?>
				<?php
				$no_month_cls = ' list-archives-item-month-no-items';
				$month_time   = mktime( 0, 0, 0, $month, 1, $year );
				if ( $month_time > $now ) {
					$no_month_cls .= ' list-archives-item-month-no-items-future';
				}
				?>
				<li class="list-archives-item list-archives-item-month <?= $no_month_cls ?>"><span><?= $month ?></span></li>
			<?php else : ?>
				<li class="list-archives-item list-archives-item-month"><a href="<?= sprintf( '%s%04d/%02d/', $base_url, $year, $month ) ?>"><?= $month ?></a></li>
			<?php endif ?>
		<?php endfor ?>
			</ul>
		</li>
	<?php endforeach; ?>
	</ul>
	<?php
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
