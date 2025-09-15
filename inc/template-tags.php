<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package makotokw
 */

function makotokw_menu_overlay() {
?>
	<div id="menuOverlay" class="menu-overlay is-hidden">
		<div class="menu-overlay-inner">
			<?php get_search_form(); ?>
			<ul class="list-categories">
				<?php makotokw_list_categories( array( 'show_count' => false ) ); ?>
			</ul>
		</div>
	</div>
	<?php
}

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
		esc_html( get_post_time( WP_THEME_DATE_FORMAT, false, null, true ) )
	);
}

function makotokw_updated_on() {
	printf(
		__( '<time class="updated time" datetime="%1$s">%2$s</time>', 'makotokw' ),
		esc_attr( get_post_modified_time( DATE_ISO8601, false, null, true ) ),
		esc_html( get_post_modified_time( WP_THEME_DATE_FORMAT, false, null, true ) )
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
