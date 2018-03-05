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
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
		return;
	}

	$nav_class = ( is_single() ) ? 'navigation-post' : 'navigation-paging';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo esc_attr( $nav_class ); ?>">
		<?php if ( is_single() ) : // navigation links for single posts ?>
			<?php if ( get_next_post_link() ) : ?>
				<div class="section section-mini section-2col">
					<h2 class="section-title">Newer post</h2>
					<div class="section-content"><?php next_post_link( '%link', '%title' ); ?></div>
				</div>
			<?php endif; ?>
			<?php if ( get_previous_post_link() ) : ?>
				<div class="section section-mini section-2col">
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


function makotokw_list_nav() {
	global $post;

	if ( $mylist = get_mylist( $post ) ) {

		$first_post = get_first_post_on_mylist( $post );
		$prev_post  = get_adjacent_post_on_mylist( $post, true );
		$next_post  = get_adjacent_post_on_mylist( $post, false );

		if ( $first_post->ID == $post->ID || $first_post->ID == $prev_post->ID ) {
			unset( $first_post );
		}

		$mylist_link = get_term_link( $mylist, 'mylist' );

		?>
		<div class="section section-mini section-mylist">
			<h2 class="section-title">List</h2>

			<div class="section-content">
				<?php if ( ! is_wp_error( $mylist_link ) ) : ?>
					<a href="<?php echo $mylist_link; ?>"><?php echo $mylist->name; ?></a>
				<?php endif ?>
				<ul>
					<?php if ( $first_post ) : ?>
						<li><i class="fa fa-angle-double-left"></i>&nbsp;<a
								href="<?php echo get_permalink( $first_post ); ?>"
								rel="prev"><?php echo get_the_title( $first_post ); ?></a></li>
					<?php endif ?>
					<?php if ( $prev_post ) : ?>
						<li><i class="fa fa-angle-left"></i>&nbsp;<a href="<?php echo get_permalink( $prev_post ); ?>" rel="prev"><?php echo get_the_title( $prev_post ); ?></a></li>
					<?php endif ?>
					<?php if ( $next_post ) : ?>
						<li><i class="fa fa-angle-right"></i>&nbsp;<a href="<?php echo get_permalink( $next_post ); ?>" rel="prev"><?php echo get_the_title( $next_post ); ?></a></li>
					<?php endif ?>
				</ul>
			</div>
		</div>
	<?php
	}
}

function makotokw_pagination( $pages = '', $range = 3 ) {
	global $paged;
	$showitems = ( $range * 3 ) + 1;

	if ( empty( $paged ) ) {
		$paged = 1;
	}
	if ( '' == $pages ) {
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
			<li><a rel="nofollow" href="<?php echo get_pagenum_link( 1 ); ?>">&laquo; <?php __( 'First', 'makotokw' ); ?></a></li>
		<?php endif ?>
		<?php if ( $paged > 1 ) : ?>
			<li><a rel="nofollow" href="<?php echo get_pagenum_link( $paged - 1 ); ?>" class="inactive">&lsaquo; <?php __( 'Previous', 'makotokw' ); ?></a></li>
		<?php endif ?>
		<?php for ( $i = 1; $i <= $pages; $i++ ) : ?>
			<?php if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) : ?>
				<?php if ( $paged == $i ) : ?>
					<li class="current"><span class="page"><?php echo $i; ?></span></li>
				<?php else : ?>
					<li><a rel="nofollow" href="<?php echo get_pagenum_link( $i ); ?>" class="inactive"><?php echo $i; ?></a></li>
				<?php endif ?>
			<?php endif ?>
		<?php endfor ?>
		<?php if ( $paged < $pages ) : ?>
			<li><a rel="nofollow" href="<?php echo get_pagenum_link( $paged + 1 ); ?>" class="inactive"><?php __( 'Next', 'makotokw' ); ?> &rsaquo;</a></li>
		<?php endif ?>
		<?php if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) : ?>
			<a rel="nofollow" class="inactive" href="<?php echo get_pagenum_link( $pages ); ?>"><?php __( 'Last', 'makotokw' ); ?> &raquo;</a>
		<?php endif ?>
		</ul></div>
		<?php
	}
}

function makotokw_google_analytics() {
	if ( true === WP_THEME_DEBUG || false === WP_THEME_GOOGLE_ANALYTICS_ACCOUNT ) {
		return;
	}
	?>
	<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
		ga('create', '<?php echo WP_THEME_GOOGLE_ANALYTICS_ACCOUNT; ?>', '<?php echo WP_THEME_GOOGLE_ANALYTICS_DOMAIN; ?>');
		ga('send', 'pageview');
	</script>
	<?php
}

function makotokw_itunes_affiliate_script() {
	if ( false === WP_THEME_ITUNES_AFFILIATE_ID ) {
		return;
	}
	?>
	<!--[if gt IE 9]><!-->
	<script type='text/javascript'>var _merchantSettings=_merchantSettings || [];_merchantSettings.push(['AT', '<?php echo WP_THEME_ITUNES_AFFILIATE_ID ?>']);(function(){var autolink=document.createElement('script');autolink.type='text/javascript';autolink.async=true; autolink.src='https://autolinkmaker.itunes.apple.com/js/itunes_autolinkmaker.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(autolink, s);})();</script>
	<!--<![endif]-->
	<?php
}

/**
 * @see http://gilbert.pellegrom.me/how-to-breadcrumbs-in-wordpress/
 */
function makotokw_breadcrumbs() {
	global $wp_query;

	if ( ! is_home() && ! is_404() ) {
		$divider = '&nbsp;<i class="fa fa-angle-right"></i>&nbsp;';
		?>
		<div itemscope itemtype="https://schema.org/Breadcrumb" class="breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-home"></i></a><?php echo $divider; ?>
		<?php if ( is_category() ) : ?>
			<?php $term = $wp_query->get_queried_object(); ?>
			<a href="/categories/" itemprop="url"><span itemprop="title"><?php _e( 'Categories', 'makotokw' ); ?></span></a><?php echo $divider; ?>
			<?php if ( $term->parent > 0 ) : ?>
				<?php echo makotokw_breadcrumbs_category_parents( $term->parent, $divider ); ?>
			<?php endif; ?>
			<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
		<?php elseif ( is_tag() ) : ?>
			<a href="/tags/" itemprop="url"><span itemprop="title"><?php _e( 'Tags', 'makotokw' ); ?></span></a><?php echo $divider; ?>
			<span class="breadcrumb-last" itemprop="title"><?php echo single_tag_title( '', false ); ?></span>
		<?php elseif ( is_mylist() ) : ?>
			<span itemprop="title"><?php _e( 'Mylist', 'makotokw' ); ?></span><?php echo $divider; ?>
			<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
		<?php elseif ( is_tax( 'blogs' ) ) : ?>
			<span itemprop="title"><?php _e( 'Blog', 'makotokw' ); ?></span><?php echo $divider; ?>
			<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
		<?php elseif ( is_tax( 'portfolios' ) ) : ?>
			<span itemprop="title"><?php _e( 'Portfolio', 'makotokw' ); ?></span><?php echo $divider; ?>
			<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
		<?php elseif ( is_archive() ) : ?>
			<?php if ( is_day() ) : ?>
				<a href="/archives/" itemprop="url"><span itemprop="title"><?php _e( 'Archives', 'makotokw' ); ?></span></a><?php echo $divider; ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo get_the_date(); ?></span>
			<?php elseif ( is_month() ) : ?>
				<a href="/archives/" itemprop="url"><span itemprop="title"><?php _e( 'Archives', 'makotokw' ); ?></span></a><?php echo $divider; ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo get_the_date( __( 'Y/M', 'makotokw' ) ); ?></span>
			<?php elseif ( is_year() ) : ?>
				<a href="/archives/" itemprop="url"><span itemprop="title"><?php _e( 'Archives', 'makotokw' ); ?></span></a><?php echo $divider; ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo get_the_date( __( 'Y', 'makotokw' ) ); ?></span>
			<?php else : ?>
				<span class="breadcrumb-last" itemprop="title"><?php _e( 'Archives', 'makotokw' ); ?></span>
			<?php endif ?>
		<?php elseif ( is_search() ) : ?>
			<span class="breadcrumb-last" itemprop="title"><?php _e( 'Search Results', 'makotokw' ); ?>: <?php echo get_search_query(); ?></span>
		<?php elseif ( is_single() ) : ?>
			<?php $category = get_the_category(); ?>
			<?php if ( is_array( $category ) && count( $category ) > 0 ) : ?>
				<?php $category_id = get_cat_ID( $category[0]->cat_name ); ?>
				<a href="/categories/" itemprop="url"><span itemprop="title"><?php _e( 'Categories', 'makotokw' ); ?></span></a><?php echo $divider; ?>
				<?php
				$breadcrumbs_category = makotokw_breadcrumbs_category_parents( $category_id, $divider );
				if ( strpos( $breadcrumbs_category, $divider ) !== false ) {
					echo substr( $breadcrumbs_category, 0, -strlen( $divider ) );
				}
				?>
			<?php endif ?>
		<?php elseif ( is_page() ) : ?>
			<?php $post = $wp_query->get_queried_object(); ?>
			<?php if ( 0 == $post->post_parent ) : ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo the_title( '', '', false ); ?></span>
			<?php else : ?>
				<?php
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				?>
				<?php foreach ( $ancestors as $ancestor ) : ?>
					<?php if ( end( $ancestors ) != $ancestor ) : ?>
						<a href="<?php echo get_permalink( $ancestor ); ?>" itemprop="url">
							<span itemprop="title"><?php echo strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ); ?></span>
						</a>
						<?php echo $divider; ?>
					<?php else : ?>
						<a href="<?php echo get_permalink( $ancestor ); ?>" itemprop="url">
							<span itemprop="title"><?php echo strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ); ?></span>
						</a>
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
	if ( $parent->parent && ( $parent->parent != $parent->term_id ) && ! in_array( $parent->parent, $visited ) ) {
		$visited[] = $parent->parent;
		$chain    .= makotokw_breadcrumbs_category_parents( $parent->parent, $separator, $visited );
	}

	$chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'makotokw' ), $parent->name ) ) . '" itemprop="url"><span itemprop="title">' . $parent->name . '</span></a>' . $separator;

	return $chain;
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function makotokw_posted_on() {
	printf(
		__( '<time class="published updated time" datetime="%1$s">%2$s</time>', 'makotokw' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_post_time( THEME_DATE_FORMAT ) )
	);
}

function makotokw_updated_on() {
	printf(
		__( '<time class="updated time" datetime="%1$s">%2$s</time>', 'makotokw' ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_time( THEME_DATE_FORMAT ) )
	);
}

function makotokw_the_content_more_link( $link ) {
	if ( preg_match( '/href="([^"]+)"/', $link, $match ) ) {
		return '<a class="text-more-link" href="' . $match[1] . '">' . __( 'Continue reading', 'makotokw' ) . '</a>';
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

function makotokw_share_permalink() {
	$permalink = get_permalink();
	if ( true === WP_THEME_DEBUG ) {
		$permalink = str_replace( home_url(), WP_THEME_PRODUCTION_URL, $permalink );
	}
	return $permalink;
}

function makotokw_share_buttons() {
	// twitter: https://about.twitter.com/resources/buttons#tweet
	// hatena: http://b.hatena.ne.jp/guide/bbutton
	// pocket: https://getpocket.com/publisher/button
	// google+: https://developers.google.com/+/web/+1button/

	$title     = get_the_title();
	$permalink = makotokw_share_permalink();
	$permalink_schemeless = preg_replace( '/^https?:\/\//', '', $permalink );
	?>
	<div class="share-buttons">
		<ul>
			<li class="share-twitter">
				<a rel="nofollow" data-url="<?php echo $permalink; ?>" class="btn btn-default btn-circle btn-share btn-share-twitter" href="https://twitter.com/intent/tweet?original_referer=<?php echo rawurlencode( $permalink ); ?>&text=<?php echo rawurlencode( $title ); ?>&tw_p=tweetbutton&url=<?php echo urlencode( $permalink ); ?>&via=<?php echo urlencode( WP_THEME_AUTHOR_TWITTER ); ?>" target="_blank">
					<i class="icon icon-default icon-share-twitter"></i>
					<span class="share-title"><?php _e( 'Twitter', 'makotokw' ); ?></span>
				</a>
			</li>
			<li class="share-hatena">
				<a rel="nofollow" class="btn btn-default btn-circle btn-share btn-share-hatena" href="https://b.hatena.ne.jp/entry/<?php echo $permalink_schemeless; ?>" target="_blank">
					<i class="icon icon-default icon-share-hatena"></i>
					<span class="share-title"><?php _e( 'Hatena Bookmark', 'makotokw' ); ?></span>
				</a>
			</li>
			<li class="share-pocket">
				<a rel="nofollow" class="btn btn-default btn-circle btn-share btn-share-pocket" href="https://getpocket.com/save/?url=<?php echo rawurlencode( $permalink ); ?>&title=<?php echo rawurlencode( $title ); ?>" target="_blank">
					<i class="icon icon-default icon-share-pocket"></i>
					<span class="share-title"><?php _e( 'Pocket', 'makotokw' ); ?></span>
				</a>
			</li>
			<li class="share-googleplus">
				<a rel="nofollow" class="btn btn-default btn-circle btn-share btn-share-googleplus" href="https://plus.google.com/share?url=<?php echo rawurlencode( $permalink ); ?>" target="_blank">
					<i class="icon icon-default icon-share-googleplus"></i>
					<span class="share-title"><?php _e( 'Google', 'makotokw' ); ?></span>
				</a>
			</li>
			<li class="share-facebook">
				<a rel="nofollow" class="btn btn-default btn-circle btn-share btn-share-facebook" href="//www.facebook.com/sharer.php?u=<?php echo rawurlencode( $permalink ); ?>&t=<?php echo rawurlencode( $title ); ?>" target="_blank">
					<i class="icon icon-default icon-share-facebook"></i>
					<span class="share-title"><?php _e( 'Facebook', 'makotokw' ); ?></span>
				</a>
			</li>
		</ul>
	</div>
	<?php
}

function makotokw_share_this() {
	?>
	<div id="shareThis" class="section section-mini section-2col section-share-this" data-url="<?php echo makotokw_share_permalink(); ?>">
		<h2 class="section-title"><?php _e( 'Share This', 'makotokw' ); ?></h2>
		<div class="section-content">
			<div class="share-content">
				<?php makotokw_share_buttons(); ?>
			</div>
		</div>
	</div>
	<?php
}

function makotokw_about_me() {
	?>
	<div class="section section-mini section-2col section-about-me">
		<h2 class="section-title"><?php _e( 'About', 'makotokw' ); ?></h2>
		<div class="section-content">
			<div itemprop="author copyrightHolder editor" itemscope itemtype="https://schema.org/Person">
			<?php echo str_replace( '<img ', '<img itemprop="image" ', get_avatar( get_the_author_meta( 'user_email' ), '48', '', get_the_author() ) ); ?>
			</div>
		</div>
	</div>
	<?php
}

function makotokw_related_post( $arg = array() ) {
	global $post;
	?>
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	<div class="entry-content">
		<span class="entry-date"><?php makotokw_posted_on(); ?></span>
		<p class="entry-summary">
			<?php echo makotokw_post_summary( $post->post_content ); ?>
		</p>
	</div>
	<?php
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
				( $count > 0 ) ? '<span class="count">(' . $count . ')</span>' : ''
			);
		}
		echo '</ul>';
	}
}

function makotokw_the_category_slug( $before = '', $separator = '', $post_id = false ) {
	$categories = get_the_category( $post_id );

	if ( empty( $categories ) ) {
		return;
	}

	echo esc_html( $before );

	$i = 0;
	foreach ( $categories as $category ) {
		if ( 0 < $i ) {
			echo esc_html( $separator );
		}
		?>
	<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'makotokw' ), $category->name ) ); ?>" rel="category tag">
		<?php echo esc_html( $category->slug ); ?>
	</a>
		<?php
		++$i;
	}
}

function makotokw_the_tags_slug( $before = '', $separator = '', $post_id = false ) {
	$tags = get_the_tags( $post_id );

	if ( empty( $tags ) ) {
		return;
	}

	echo esc_html( $before );

	$i = 0;
	foreach ( $tags as $tag ) {
		if ( 0 < $i ) {
			echo esc_html( $separator );
		}
		?>
		<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'makotokw' ), $tag->name ) ); ?>" rel="tag"><?php echo esc_html( $tag->slug ); ?></a>
		<?php
		++$i;
	}
}

function makotokw_the_terms_slug( $taxonomy, $before = '', $separator = '', $post_id = false ) {
	$terms = get_the_terms( $post_id, $taxonomy );

	if ( empty( $terms ) ) {
		return;
	}

	echo esc_html( $before );

	$i = 0;
	foreach ( $terms as $term ) {
		if ( 0 < $i ) {
			echo esc_html( $separator );
		}
		?>
		<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'makotokw' ), $term->name ) ); ?>" rel="tag"><?php echo esc_html( $term->slug ); ?></a>
		<?php
		++$i;
	}
}

function makotokw_the_category_and_tag() {
	?>
	<?php $categories_list = get_the_category_list( '&nbsp;' ); ?>
	<?php if ( $categories_list && makotokw_categorized_blog() ) : ?>
		<span class="entry-categories">
			<?php printf( '%1$s', $categories_list ); ?>
		</span>
	<?php endif; ?>
	<?php $tags_list = get_the_tag_list( '', '&nbsp;' ); ?>
	<?php if ( $tags_list ) : ?>
		<span class="entry-tags">
			<?php printf( '&nbsp;&nbsp;%1$s', $tags_list ); ?>
		</span>
	<?php endif; ?>
	<?php $term_list = get_the_term_list( false, 'portfolios', '', '&nbsp;' ); ?>
	<?php if ( $term_list ) : ?>
		<span class="entry-portfolios">
			<?php printf( '&nbsp;&nbsp;%1$s', $term_list ); ?>
		</span>
	<?php endif; ?>
	<?php
}

function makotokw_the_tag_links( $prefix = ', ' ) {
	$tags_list = get_the_tag_list( '', $prefix );
	if ( $tags_list ) {
		printf( $prefix . ' %1$s', $tags_list );
	}
}

function makotokw_section_category_and_tag( $title = 'Tag' ) {
	?>
	<section class="section section-mini section-2col section-category-tag">
		<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
		<div class="section-content">
			<?php makotokw_the_category_and_tag(); ?></a>
		</div>
	</section>
	<?php
}

/**
 * Returns true if a blog has more than 1 category
 */
function makotokw_categorized_blog() {
	$all_the_cool_cats = get_transient( 'all_the_cool_cats' );
	if ( false === $all_the_cool_cats ) {
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
	$archives = explode( "\n", wp_get_archives( array_merge( $args, ( array( 'echo' => 0 ) ) ) ) );
	// @codingStandardsIgnoreStart
	/**
	 * @var string $before_year
	 * @var string $after_year
	 * @var string $year_format
	 * @var string $month_format
	 * @var int $echo
	 */
	extract( $args, EXTR_SKIP );
	// @codingStandardsIgnoreEnd
	$now   = time();
	$years = array();
	foreach ( $archives as $a ) {
		if ( preg_match( '/\/([0-9]{4})\/([0-9]{2})\//', $a, $matches ) ) {
			$year  = $matches[1];
			$month = $matches[2];
			$label = ( empty( $month_format ) ) ? $wp_locale->get_month( $month ) : date( $month_format, mktime( 0, 0, 0, $month, 1, $year ) );
			$a     = preg_replace( '/(.+<a[^>]+>)([^<]+)(<\/a>.+)/', '${1}' . $label . '$3', $a );
			if ( ! isset( $years[ $year ] ) ) {
				$years[ $year ] = array();
			}
			$years[ $year ][ (int) $month ] = $a;
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
			<a href="<?php echo $url; ?>"><?php echo $before_year . $label . $after_year; ?></a>
			<ul class="list-archives  list-archives-month">
		<?php for ( $month = 1; $month <= 12; $month++ ) : ?>
			<?php if ( ! isset( $months[ $month ] ) ) : ?>
				<?php
				$no_month_cls = ' list-archives-item-month-no-items';
				$month_time   = mktime( 0, 0, 0, $month, 1, $year );
				if ( $month_time > $now ) {
					$no_month_cls .= ' list-archives-item-month-no-items-future';
				}
				?>
				<li class="list-archives-item list-archives-item-month <?php echo $no_month_cls; ?>"><span><?php echo $month; ?></span></li>
			<?php else : ?>
				<li class="list-archives-item list-archives-item-month"><a href="<?php echo sprintf( '%s%04d/%02d/', $base_url, $year, $month ); ?>"><?php echo $month; ?></a></li>
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
