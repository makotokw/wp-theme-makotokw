<?php
/**
 * Template for breadcrumbs
 *
 * @package makotokw
 * @see http://gilbert.pellegrom.me/how-to-breadcrumbs-in-wordpress/
 */
/**
 * Build the breadcrumb trail as an ordered list of items.
 *
 * Returns a single source of truth shared by the visual renderer and the
 * JSON-LD output. Each item is [ 'name' => string, 'url' => string|null ];
 * a null url marks a non-linked crumb (e.g. the current page, or a generic
 * label with no landing page).
 *
 * @return array<int, array{name: string, url: string|null}>
 */
function makotokw_get_breadcrumb_items() {
	/** @var WP_Query $wp_query */
	global $wp_query;

	$items = array();
	if ( is_home() || is_404() ) {
		return $items;
	}

	// Home is always the first crumb.
	$items[] = array(
		'name' => get_bloginfo( 'name' ),
		'url'  => home_url( '/' ),
	);

	if ( is_category() ) {
		$term    = $wp_query->get_queried_object();
		$items[] = array(
			'name' => __( 'Categories', 'makotokw' ),
			'url'  => home_url( '/categories/' ),
		);
		if ( $term->parent > 0 ) {
			$items = array_merge( $items, makotokw_get_breadcrumb_category_ancestors( $term->parent ) );
		}
		$items[] = array(
			'name' => single_cat_title( '', false ),
			'url'  => null,
		);
	} elseif ( is_tag() ) {
		$items[] = array(
			'name' => __( 'Tags', 'makotokw' ),
			'url'  => home_url( '/tags/' ),
		);
		$items[] = array(
			'name' => single_tag_title( '', false ),
			'url'  => null,
		);
	} elseif ( makotokw_is_mylist() ) {
		$items[] = array(
			'name' => __( 'Mylist', 'makotokw' ),
			'url'  => null,
		);
		$items[] = array(
			'name' => single_cat_title( '', false ),
			'url'  => null,
		);
	} elseif ( is_tax( 'blogs' ) ) {
		$items[] = array(
			'name' => __( 'Blog', 'makotokw' ),
			'url'  => null,
		);
		$items[] = array(
			'name' => single_cat_title( '', false ),
			'url'  => null,
		);
	} elseif ( is_tax( 'portfolios' ) ) {
		$items[] = array(
			'name' => __( 'Portfolio', 'makotokw' ),
			'url'  => null,
		);
		$items[] = array(
			'name' => single_cat_title( '', false ),
			'url'  => null,
		);
	} elseif ( is_archive() ) {
		// The "Archives" crumb links to the archive index; on generic archives
		// it stays as the last (non-linked) crumb via the renderer's last rule.
		$items[] = array(
			'name' => __( 'Archives', 'makotokw' ),
			'url'  => home_url( '/archives/' ),
		);
		if ( is_day() ) {
			$items[] = array(
				'name' => get_the_date(),
				'url'  => null,
			);
		} elseif ( is_month() ) {
			$items[] = array(
				'name' => get_the_date( __( 'Y/M', 'makotokw' ) ),
				'url'  => null,
			);
		} elseif ( is_year() ) {
			$items[] = array(
				'name' => get_the_date( __( 'Y', 'makotokw' ) ),
				'url'  => null,
			);
		}
	} elseif ( is_search() ) {
		$items[] = array(
			// get_search_query( false ) returns the raw query; the renderer and
			// wp_json_encode escape it, so avoid the default esc_attr (double escaping).
			'name' => sprintf( '%s: %s', __( 'Search Results', 'makotokw' ), get_search_query( false ) ),
			'url'  => null,
		);
	}

	return $items;
}

/**
 * Build the category ancestor chain (root first) as breadcrumb items.
 *
 * @param int   $id      Category term ID.
 * @param array $visited Guard against cyclic parents.
 * @return array<int, array{name: string, url: string}>
 */
function makotokw_get_breadcrumb_category_ancestors( $id, $visited = array() ) {
	$items  = array();
	$parent = get_category( $id );
	if ( is_wp_error( $parent ) || null === $parent ) {
		return $items;
	}
	if ( $parent->parent && ( $parent->parent !== $parent->term_id ) && ! in_array( $parent->parent, $visited, true ) ) {
		$visited[] = $parent->parent;
		$items     = array_merge( $items, makotokw_get_breadcrumb_category_ancestors( $parent->parent, $visited ) );
	}
	$items[] = array(
		'name' => $parent->name,
		// get_category_link() returns '' (not WP_Error) when the link cannot be
		// resolved; an empty url is handled gracefully downstream.
		'url'  => get_category_link( $parent->term_id ),
	);
	return $items;
}

/**
 * Render the breadcrumb trail as presentational HTML.
 *
 * Structured data is emitted separately as JSON-LD; this markup carries no
 * microdata. The last crumb is always rendered as non-linked text.
 */
function makotokw_breadcrumbs() {
	$items = makotokw_get_breadcrumb_items();
	if ( empty( $items ) ) {
		return;
	}

	$divider    = '&nbsp;<i class="fas fa-angle-right"></i>&nbsp;';
	$last_index = count( $items ) - 1;
	?>
	<div class="breadcrumb">
		<?php foreach ( $items as $index => $item ) : ?>
			<?php
			if ( 0 < $index ) {
				echo wp_kses_post( $divider );
			}
			?>
			<?php if ( 0 === $index ) : ?>
				<a href="<?php echo esc_url( $item['url'] ); ?>"><i class="fas fa-house"></i></a>
			<?php elseif ( $index === $last_index ) : ?>
				<span class="breadcrumb-last"><?php echo esc_html( $item['name'] ); ?></span>
			<?php elseif ( ! empty( $item['url'] ) ) : ?>
				<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['name'] ); ?></a>
			<?php else : ?>
				<span><?php echo esc_html( $item['name'] ); ?></span>
			<?php endif ?>
		<?php endforeach ?>
	</div>
	<?php
}

/**
 * Output the breadcrumb trail as schema.org BreadcrumbList JSON-LD.
 *
 * Emitted only where a visual breadcrumb is shown, so the structured data
 * matches the visible trail. Non-last crumbs without a URL are skipped and
 * positions are renumbered; the last crumb omits `item`.
 */
function makotokw_breadcrumbs_jsonld() {
	if ( ! ( is_archive() || is_search() ) ) {
		return;
	}

	$items = makotokw_get_breadcrumb_items();
	if ( count( $items ) < 2 ) {
		return;
	}

	$last_index    = count( $items ) - 1;
	$position      = 1;
	$list_elements = array();
	foreach ( $items as $index => $item ) {
		$is_last = ( $index === $last_index );
		// Non-last crumbs without a URL are not crawlable pages; skip them.
		if ( ! $is_last && empty( $item['url'] ) ) {
			continue;
		}
		$element = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => $item['name'],
		);
		if ( ! $is_last && ! empty( $item['url'] ) ) {
			$element['item'] = $item['url'];
		}
		$list_elements[] = $element;
		++$position;
	}

	$data = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $list_elements,
	);

	// wp_json_encode escapes JSON (including `/`), so the output is safe to
	// place inside a script element without additional escaping.
	echo '<script type="application/ld+json">' . wp_json_encode( $data ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'wp_head', 'makotokw_breadcrumbs_jsonld' );
