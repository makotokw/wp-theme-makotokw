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
function makotokw_content_nav() {

	$next_post = get_next_post();
	$prev_post = get_previous_post();

	if ( ! $next_post && ! $prev_post ) {
		return;
	}

	$pagination_classes = '';

	if ( ! $next_post ) {
		$pagination_classes = ' only-one only-prev';
	} elseif ( ! $prev_post ) {
		$pagination_classes = ' only-one only-next';
	}
	?>
	<nav class="pagination-single section-inner<?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Post', 'makotokw' ); ?>" role="navigation">
		<hr aria-hidden="true" />
		<div class="pagination-single-inner">
			<?php if ( $prev_post ) : ?>
				<a class="previous-post" href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
					<span class="arrow" aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
					<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $prev_post->ID ) ); ?></span></span>
				</a>
			<?php endif; ?>
			<?php if ( $next_post ) : ?>
				<a class="next-post" href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
					<span class="arrow" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
					<span class="title"><span class="title-inner"><?php echo wp_kses_post( get_the_title( $next_post->ID ) ); ?></span></span>
				</a>
			<?php endif; ?>
		</div>
	</nav>
	<?php
}

function makotokw_pagination( $pages = '', $range = 3 ) {
	global $paged;
	$showitems = ( $range * 3 ) + 1;

	if ( empty( $paged ) ) {
		$paged = 1;
	}
	if ( '' === $pages ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}
	if ( 1 !== $pages ) {
		?>
		<div class="pagination section-inner"><ul>
		<?php if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) : ?>
			<li><a href="<?php echo get_pagenum_link( 1 ); ?>">&laquo; <?php __( 'First', 'makotokw' ); ?></a></li>
		<?php endif ?>
		<?php if ( $paged > 1 ) : ?>
			<li><a href="<?php echo get_pagenum_link( $paged - 1 ); ?>">&lsaquo; <?php __( 'Previous', 'makotokw' ); ?></a></li>
		<?php endif ?>
		<?php for ( $i = 1; $i <= $pages; $i++ ) : ?>
			<?php if ( 1 !== $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) : ?>
				<?php if ( $paged === $i ) : ?>
					<li class="current"><span class="page"><?php echo $i; ?></span></li>
				<?php else : ?>
					<li><a href="<?php echo get_pagenum_link( $i ); ?>"><?php echo $i; ?></a></li>
				<?php endif ?>
			<?php endif ?>
		<?php endfor ?>
		<?php if ( $paged < $pages ) : ?>
			<li><a href="<?php echo get_pagenum_link( $paged + 1 ); ?>"><?php __( 'Next', 'makotokw' ); ?> &rsaquo;</a></li>
		<?php endif ?>
		<?php if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) : ?>
			<li><a href="<?php echo get_pagenum_link( $pages ); ?>"><?php __( 'Last', 'makotokw' ); ?> &raquo;</a></li>
		<?php endif ?>
		</ul></div>
		<?php
	}
}

/**
 * @return bool|string
 * @see https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference?hl=ja#contentGroup
 */
function makotokw_get_category_content_group() {
	/** @var WP_Query $wp_query */
	global $wp_query;
	$cat = null;
	if ( is_single() ) {

		$cats = get_the_category();
		if ( ! empty( $cats ) ) {
			$cat = $cats[0];
		}
	} elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
	}
	if ( $cat ) {
		if ( $cat->category_parent ) {
			return rtrim( get_category_parents( $cat->term_id, false, '/', true ), '/' );
		}
		return $cat->slug;
	}
	return false;
}

function makotokw_google_analytics() {
	if ( true === WP_THEME_DEBUG || false === WP_THEME_GOOGLE_ANALYTICS_ACCOUNT ) {
		return;
	}
	if ( is_user_logged_in() ) {
		return;
	}
	$content_group1 = makotokw_get_category_content_group();
	?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo WP_THEME_GOOGLE_ANALYTICS_ACCOUNT; ?>"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo WP_THEME_GOOGLE_ANALYTICS_ACCOUNT; ?>', {
			<?php if ( $content_group1 ) : ?>
			'content_group1' : '<?php echo $content_group1; ?>',
			<?php endif ?>
			'linker': {
				'domains': ['<?php echo WP_THEME_GOOGLE_ANALYTICS_DOMAIN; ?>']
			}
		});
	</script>
	<?php
}

/**
 * @see http://gilbert.pellegrom.me/how-to-breadcrumbs-in-wordpress/
 */
function makotokw_breadcrumbs() {
	/** @var WP_Query $wp_query */
	global $wp_query;

	if ( ! is_home() && ! is_404() ) {
		$divider = '&nbsp;<i class="fas fa-angle-right"></i>&nbsp;';
		?>
		<div itemscope itemtype="http://schema.org/Breadcrumb" class="breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home"></i></a><?php echo $divider; ?>
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
			<span class="breadcrumb-last" itemprop="title"><?php _e( 'Search Results', 'makotokw' ); ?>: <em><?php echo get_search_query(); ?></em></span>
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
			<?php if ( empty( $post->post_parent ) ) : ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo the_title( '', '', false ); ?></span>
			<?php else : ?>
				<?php
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
				?>
				<?php foreach ( $ancestors as $ancestor ) : ?>
					<?php if ( end( $ancestors ) !== $ancestor ) : ?>
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

/**
 * @param $id
 * @param string $separator
 * @param array $visited
 * @return string
 */
function makotokw_breadcrumbs_category_parents( $id, $separator = '/', $visited = array() ) {
	$chain  = '';
	$parent = get_category( $id );
	if ( is_wp_error( $parent ) ) {
		return $chain;
	}
	if ( $parent->parent && ( $parent->parent !== $parent->term_id ) && ! in_array( $parent->parent, $visited, true ) ) {
		$visited[] = $parent->parent;
		$chain    .= makotokw_breadcrumbs_category_parents( $parent->parent, $separator, $visited );
	}

	$chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'makotokw' ), $parent->name ) ) . '" itemprop="url"><span itemprop="title">' . $parent->name . '</span></a>' . $separator;

	return $chain;
}

/**
 * @param string $slug
 * @return string
 */
function makotokw_awesome_icon_by_slug( $slug ) {
	$icon       = '';
	$icon_class = makotokw_find_awesome_icon_class( $slug );
	if ( ! empty( $icon_class ) ) {
		$icon = '<i class="' . $icon_class . '"></i> ';
	}
	return $icon;
}

/**
 * @param string $slug
 * @param string $default
 * @return string
 */
function makotokw_find_awesome_icon_class( $slug, $default = 'folder' ) {
	$map = array(
		'interior'            => 'fas fa-couch',
		'comedy'              => 'fas fa-laugh-beam',
		'gourmet'             => 'fas fa-utensils',
		'computer'            => 'fas fa-laptop',
		'computer/software'   => 'fas fa-laptop-code',
		'computer/hardware'   => 'fas fa-keyboard',
		'computer/server'     => 'fas fa-server',
		'computer/programing' => 'fas fa-code',
		'sports'              => 'fas fa-futbol',
		'lifehack'            => 'fas fa-hat-wizard',
		'work'                => 'fas fa-building',
		'politics'            => 'fas fa-landmark',
		'stationery'          => 'fas fa-pen-fancy',
		'life'                => 'fas fa-sun',
		'cinema'              => 'fas fa-film',
		'art'                 => 'fas fa-image',
		'readingbook'         => 'fas fa-book',
		'electronics'         => 'fas fa-robot',
		'music'               => 'fas fa-music',
		'gadget'              => 'fas fa-mobile-alt',
		'game'                => 'fas fa-gamepad',
	);

	if ( array_key_exists( $slug, $map ) ) {
		return $map[ $slug ];
	}

	return $default;
}

/**
 * @param bool $all
 */
function makotokw_list_categories( $opt = array(), $all = false ) {
	$opt = array_merge(
		array(
			'title_li'            => '',
			'hide_title_if_empty' => true,
			'show_count'          => true,
			'echo'                => false,
		),
		$opt
	);
	if ( ! $all ) {
		$opt['exclude'] = WP_THEME_EXCLUDE_CATEGORY;
	}
	$list = wp_list_categories( $opt );
	// replace itemCount text to span element
	$list = preg_replace( '/\(([\d]+)\)/', '<span class="cat-item-entry-count">$1</span>', $list );
	$list = preg_replace_callback(
		'/category\/([^"]+)"\s+\>/',
		function ( $matches ) {
			return $matches[0] . makotokw_awesome_icon_by_slug( trim( $matches[1], '/' ) );
		},
		$list
	);
	echo $list;
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function makotokw_posted_on() {
	$time = makotokw_get_the_updated_date();
	if ( ! $time ) {
		$time = get_post_time( DATE_ISO8601, false, null, true );
	}
	printf(
		__( '<time class="published updated time" datetime="%1$s">%2$s</time>', 'makotokw' ),
		esc_attr( $time ),
		esc_html( get_post_time( THEME_DATE_FORMAT, false, null, true ) )
	);
}

function makotokw_updated_on() {
	printf(
		__( '<time class="updated time" datetime="%1$s">%2$s</time>', 'makotokw' ),
		esc_attr( get_post_modified_time( DATE_ISO8601, false, null, true ) ),
		esc_html( get_post_modified_time( THEME_DATE_FORMAT, false, null, true ) )
	);
}

function makotokw_the_post_date() {
	?>
<span class="entry-date date updated"><?php makotokw_posted_on(); ?></span>
	<?php
}

function makotokw_the_post_primary_meta() {
	?>
	<section class="entry-meta-primary">
		<?php if ( 'post' === get_post_type() ) : ?>
			<?php makotokw_the_post_date(); ?>
			/
			<span class="term-links">
				<?php makotokw_the_category_slug( '', '/' ); ?>
			</span>
		<?php endif; ?>
	</section>
	<?php
}

function makotokw_the_post_secondary_meta() {
	?>
	<section class="entry-meta-secondary">
		<?php if ( 'post' === get_post_type() ) : ?>
			<span class="term-links">
				<span class="term-tags-links">
					<?php makotokw_the_tags_slug( '<i class="fas fa-tag"></i>', ', ' ); ?>
				</span>
				<span class="term-portfolio-links">
					<?php makotokw_the_terms_slug( 'portfolios', '<i class="fas fa-browser"></i>', ', ' ); ?>
				</span>
			</span>
		<?php endif; ?>
	</section>
	<?php
}


/**
 * .post_thumbnail for list page
 * @param string $post_content
 */
function makotokw_the_post_thumbnail( $post_content = null ) {
	$src     = null;
	$service = null;
	if ( class_exists( 'Makotokw\PostUtility' ) ) {
		$src = Makotokw\PostUtility::find_featured_image_url( $post_content, $service );
	}
	if ( ! $src ) {
		return;
	}
	?>
	<a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<div class="entry-thumbnail-container entry-thumbnail-<?php echo $service; ?>">
			<img class="entry-thumbnail-image" src="<?php echo $src; ?>" alt="<?php echo the_title_attribute(); ?>"/>
		</div>
	</a>
	<?php
}

function makotokw_post_summary( $content, $length = 128, $trimmarker = '...' ) {
	if ( class_exists( 'PukiWiki_for_WordPress' ) ) {
		$pukiwiki = PukiWiki_for_WordPress::getInstance();
		$content  = $pukiwiki->the_content( $content );
	}
	if ( class_exists( 'WP_GFM' ) ) {
		$gfm = WP_GFM::get_instance();
		if ( is_callable( array( $gfm, 'do_markdown_shortcode' ) ) ) {
			$content = $gfm->do_markdown_shortcode( $content );
		} elseif ( is_callable( array( $gfm, 'the_content' ) ) ) {
			$content = $gfm->the_content( $content );
		}
	}
	return mb_strimwidth( strip_tags( strip_shortcodes( $content ) ), 0, $length ) . $trimmarker;
}

function makotokw_get_share_permalink() {
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
	$title                = get_the_title();
	$permalink            = makotokw_get_share_permalink();
	$permalink_schemeless = preg_replace( '/^https?:\/\//', '', $permalink );
	?>
	<ul class="share-buttons">
		<li class="share-twitter">
			<a rel="nofollow noopener" data-url="<?php echo $permalink; ?>" class="btn-share btn-share-twitter" href="https://twitter.com/intent/tweet?original_referer=<?php echo rawurlencode( $permalink ); ?>&text=<?php echo rawurlencode( $title ); ?>&tw_p=tweetbutton&url=<?php echo urlencode( $permalink ); ?>&via=<?php echo urlencode( WP_THEME_AUTHOR_TWITTER ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Tweete by Twitter', 'makotokw' ); ?>">
				<i class="fab fa-twitter"></i>
				<span class="share-title"><?php _e( 'Twitter', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-facebook">
			<a rel="nofollow noopener" class="btn-share btn-share-facebook" href="//www.facebook.com/sharer.php?u=<?php echo rawurlencode( $permalink ); ?>&t=<?php echo rawurlencode( $title ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Facebook', 'makotokw' ); ?>">
				<i class="fab fa-facebook-f"></i>
				<span class="share-title"><?php _e( 'Facebook', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-hatena">
			<a rel="nofollow noopener" class="btn-share btn-share-hatena" href="https://b.hatena.ne.jp/entry/<?php echo $permalink_schemeless; ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Hatena', 'makotokw' ); ?>">
				<svg class="share-brand-icon" xmlns="http://www.w3.org/2000/svg" viewBox="100 100 300 300">
					<g>
						<path d="M278.2,258.1q-13.6-15.2-37.8-17c14.4-3.9,24.8-9.6,31.4-17.3s9.8-17.8,9.8-30.7A55,55,0,0,0,275,166a48.8,48.8,0,0,0-19.2-18.6c-7.3-4-16-6.9-26.2-8.6s-28.1-2.4-53.7-2.4H113.6V363.6h64.2q38.7,0,55.8-2.6c11.4-1.8,20.9-4.8,28.6-8.9a52.5,52.5,0,0,0,21.9-21.4c5.1-9.2,7.7-19.9,7.7-32.1C291.8,281.7,287.3,268.2,278.2,258.1Zm-107-71.4h13.3q23.1,0,31,5.2c5.3,3.5,7.9,9.5,7.9,18s-2.9,14-8.5,17.4-16.1,5-31.4,5H171.2V186.7Zm52.8,130.3c-6.1,3.7-16.5,5.5-31.1,5.5H171.2V273h22.6c15,0,25.4,1.9,30.9,5.7s8.4,10.4,8.4,20S230.1,313.4,223.9,317.1Z"></path>
						<path d="M357.6,306.1a28.8,28.8,0,1,0,28.8,28.8A28.8,28.8,0,0,0,357.6,306.1Z"></path>
						<rect x="332.6" y="136.4" width="50" height="151.52"></rect>
					</g>
				</svg>
				<span class="share-title"><?php _e( 'Hatena Bookmark', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-line">
			<a rel="nofollow noopener" class="btn-share btn-share-line" href="https://social-plugins.line.me/lineit/share?url=?php echo rawurlencode( $permalink ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Line', 'makotokw' ); ?>">
				<svg class="share-brand-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 315 300">
					<g>
						<path class="fill_1" d="M280.344,206.351 C280.344,206.351 280.354,206.351 280.354,206.351 C247.419,244.375 173.764,290.686 157.006,297.764 C140.251,304.844 142.724,293.258 143.409,289.286 C143.809,286.909 145.648,275.795 145.648,275.795 C146.179,271.773 146.725,265.543 145.139,261.573 C143.374,257.197 136.418,254.902 131.307,253.804 C55.860,243.805 0.004,190.897 0.004,127.748 C0.004,57.307 70.443,-0.006 157.006,-0.006 C243.579,-0.006 314.004,57.307 314.004,127.748 C314.004,155.946 303.108,181.342 280.344,206.351 Z"/>
						<path class="fill_2" d="M253.185,121.872 C257.722,121.872 261.408,125.569 261.408,130.129 C261.408,134.674 257.722,138.381 253.185,138.381
C253.185,138.381 230.249,138.381 230.249,138.381 C230.249,138.381 230.249,153.146 230.249,153.146 C230.249,153.146 253.185,153.146 253.185,153.146 C257.710,153.146 261.408,156.851 261.408,161.398 C261.408,165.960 257.710,169.660 253.185,169.660 C253.185,169.660 222.018,169.660 222.018,169.660 C217.491,169.660 213.795,165.960 213.795,161.398 C213.795,161.398 213.795,130.149 213.795,130.149 C213.795,130.139 213.795,130.139 213.795,130.129 C213.795,130.129 213.795,130.114 213.795,130.109 C213.795,130.109 213.795,98.878 213.795,98.878 C213.795,98.858 213.795,98.850 213.795,98.841 C213.795,94.296 217.486,90.583 222.018,90.583 C222.018,90.583 253.185,90.583 253.185,90.583 C257.722,90.583 261.408,94.296 261.408,98.841 C261.408,103.398 257.722,107.103 253.185,107.103 C253.185,107.103 230.249,107.103 230.249,107.103 C230.249,107.103 230.249,121.872 230.249,121.872 C230.249,121.872 253.185,121.872 253.185,121.872 ZM202.759,161.398 C202.759,164.966 200.503,168.114 197.135,169.236 C196.291,169.521 195.405,169.660 194.526,169.660 C191.956,169.660 189.502,168.431 187.956,166.354 C187.956,166.354 156.012,122.705 156.012,122.705 C156.012,122.705 156.012,161.398 156.012,161.398 C156.012,165.960 152.329,169.660 147.791,169.660 C143.256,169.660 139.565,165.960 139.565,161.398 C139.565,161.398 139.565,98.841 139.565,98.841 C139.565,95.287 141.829,92.142 145.192,91.010 C146.036,90.730 146.915,90.583 147.799,90.583 C150.364,90.583 152.828,91.818 154.366,93.894 C154.366,93.894 186.310,137.559 186.310,137.559 C186.310,137.559 186.310,98.841 186.310,98.841 C186.310,94.296 190.000,90.583 194.536,90.583 C199.073,90.583 202.759,94.296 202.759,98.841 C202.759,98.841 202.759,161.398 202.759,161.398 ZM127.737,161.398 C127.737,165.960 124.051,169.660 119.519,169.660 C114.986,169.660 111.300,165.960 111.300,161.398 C111.300,161.398 111.300,98.841 111.300,98.841 C111.300,94.296 114.986,90.583 119.519,90.583 C124.051,90.583 127.737,94.296 127.737,98.841 C127.737,98.841 127.737,161.398 127.737,161.398 ZM95.507,169.660 C95.507,169.660 64.343,169.660 64.343,169.660 C59.816,169.660 56.127,165.960 56.127,161.398 C56.127,161.398 56.127,98.841 56.127,98.841 C56.127,94.296 59.816,90.583 64.343,90.583 C68.881,90.583 72.564,94.296 72.564,98.841 C72.564,98.841 72.564,153.146 72.564,153.146 C72.564,153.146 95.507,153.146 95.507,153.146 C100.047,153.146 103.728,156.851 103.728,161.398 C103.728,165.960 100.047,169.660 95.507,169.660 Z"/>
					</g>
				</svg>
				<span class="share-title"><?php _e( 'Line', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-pocket">
			<a rel="nofollow noopener" class="btn-share btn-share-pocket" href="https://getpocket.com/save/?url=<?php echo rawurlencode( $permalink ); ?>&title=<?php echo rawurlencode( $title ); ?>" target="_blank" data-tippy-content="<?php esc_attr_e( 'Share by Pocket', 'makotokw' ); ?>">
				<i class="fab fa-get-pocket"></i>
				<span class="share-title"><?php _e( 'Pocket', 'makotokw' ); ?></span>
			</a>
		</li>
		<li class="share-url">
			<button class="btn-share btn-share-url" data-clipboard-text="<?php echo $permalink; ?>" data-toast-success="<?php esc_attr_e( 'URL Copied!', 'makotokw' ); ?>" data-tippy-content="<?php esc_attr_e( 'Copy URL', 'makotokw' ); ?>">
				<i class="fas fa-copy"></i>
				<span class="share-title"><?php _e( 'Copy URL', 'makotokw' ); ?></span>
			</button>
		</li>
	</ul>
	<?php
}

function makotokw_share_this() {
	?>
	<div id="shareThis" class="share-this section-inner" data-url="<?php echo makotokw_get_share_permalink(); ?>">
		<hr aria-hidden="true" />
		<?php makotokw_share_buttons(); ?>
	</div>
	<?php
}

function makotokw_archives_title() {
	?>
	<?php if ( is_category() ) : ?>
		<?php echo sprintf( __( 'Category Archives: %s', 'makotokw' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
	<?php elseif ( is_tag() ) : ?>
		<?php echo sprintf( __( 'Tag Archives: %s', 'makotokw' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
	<?php elseif ( is_day() ) : ?>
		<?php echo sprintf( __( 'Daily Archives: %s', 'makotokw' ), '<span>' . get_the_date() . '</span>' ); ?>
	<?php elseif ( is_month() ) : ?>
		<?php echo sprintf( __( 'Monthly Archives: %s', 'makotokw' ), '<span>' . get_the_date( __( 'Y/M', 'makotokw' ) ) . '</span>' ); ?>
	<?php elseif ( is_year() ) : ?>
		<?php echo sprintf( __( 'Yearly Archives: %s', 'makotokw' ), '<span>' . get_the_date( __( 'Y', 'makotokw' ) ) . '</span>' ); ?>
	<?php elseif ( is_tax( 'blogs' ) ) : ?>
		<?php echo sprintf( __( 'Blog Archives: %s', 'makotokw' ), '<span>' . single_term_title( '', false ) . '</span>' ); ?>
	<?php elseif ( is_tax( 'portfolios' ) ) : ?>
		<?php echo sprintf( __( 'Portfolio Archives: %s', 'makotokw' ), '<span>' . single_term_title( '', false ) . '</span>' ); ?>
	<?php elseif ( is_search() ) : ?>
		<?php echo __( 'Search', 'makotokw' ); ?>
	<?php elseif ( is_home() ) : ?>
		<?php echo __( 'All posts', 'makotokw' ); ?>
	<?php else : ?>
		<?php echo sprintf( __( 'Archives of %s', 'makotokw' ), '<span>' . get_bloginfo( 'name' ) . '</span>' ); ?>
	<?php endif; ?>
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

	echo $before;

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

	echo $before;

	$i = 0;
	foreach ( $tags as $tag ) {
		if ( 0 < $i ) {
			echo $separator;
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

	echo $before;

	$i = 0;
	foreach ( $terms as $term ) {
		if ( 0 < $i ) {
			echo $separator;
		}
		?>
		<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', 'makotokw' ), $term->name ) ); ?>" rel="tag"><?php echo esc_html( $term->slug ); ?></a>
		<?php
		++$i;
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
			$label = ( empty( $month_format ) ) ? $wp_locale->get_month( $month ) : date_i18n( $month_format, mktime( 0, 0, 0, $month, 1, $year ) );
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
		$label = date_i18n( $year_format, mktime( 0, 0, 0, /* for timezone */2, 1, $year ) );
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
