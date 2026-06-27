<?php
/**
 * Template for breadcrumbs
 *
 * @package makotokw
 * @see http://gilbert.pellegrom.me/how-to-breadcrumbs-in-wordpress/
 */
function makotokw_breadcrumbs() {
	/** @var WP_Query $wp_query */
	global $wp_query;

	if ( ! is_home() && ! is_404() ) {
		$divider = '&nbsp;<i class="fas fa-angle-right"></i>&nbsp;';
		?>
		<div itemscope itemtype="http://schema.org/Breadcrumb" class="breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-house"></i></a><?php echo wp_kses_post( $divider ); ?>
			<?php if ( is_category() ) : ?>
				<?php $term = $wp_query->get_queried_object(); ?>
				<a href="/categories/" itemprop="url"><span itemprop="title"><?php esc_html_e( 'Categories', 'makotokw' ); ?></span></a><?php echo wp_kses_post( $divider ); ?>
				<?php if ( $term->parent > 0 ) : ?>
					<?php
					// Trusted breadcrumb markup with schema.org itemprop; the category name is escaped in the builder. wp_kses_post would strip itemprop.
					echo makotokw_breadcrumbs_category_parents( $term->parent, $divider ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				<?php endif; ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
			<?php elseif ( is_tag() ) : ?>
				<a href="/tags/" itemprop="url"><span itemprop="title"><?php esc_html_e( 'Tags', 'makotokw' ); ?></span></a><?php echo wp_kses_post( $divider ); ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo single_tag_title( '', false ); ?></span>
			<?php elseif ( makotokw_is_mylist() ) : ?>
				<span itemprop="title"><?php esc_html_e( 'Mylist', 'makotokw' ); ?></span><?php echo wp_kses_post( $divider ); ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
			<?php elseif ( is_tax( 'blogs' ) ) : ?>
				<span itemprop="title"><?php esc_html_e( 'Blog', 'makotokw' ); ?></span><?php echo wp_kses_post( $divider ); ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
			<?php elseif ( is_tax( 'portfolios' ) ) : ?>
				<span itemprop="title"><?php esc_html_e( 'Portfolio', 'makotokw' ); ?></span><?php echo wp_kses_post( $divider ); ?>
				<span class="breadcrumb-last" itemprop="title"><?php echo single_cat_title( '', false ); ?></span>
			<?php elseif ( is_archive() ) : ?>
				<?php if ( is_day() ) : ?>
					<a href="/archives/" itemprop="url"><span itemprop="title"><?php esc_html_e( 'Archives', 'makotokw' ); ?></span></a><?php echo wp_kses_post( $divider ); ?>
					<span class="breadcrumb-last" itemprop="title"><?php echo get_the_date(); ?></span>
				<?php elseif ( is_month() ) : ?>
					<a href="/archives/" itemprop="url"><span itemprop="title"><?php esc_html_e( 'Archives', 'makotokw' ); ?></span></a><?php echo wp_kses_post( $divider ); ?>
					<span class="breadcrumb-last" itemprop="title"><?php echo get_the_date( __( 'Y/M', 'makotokw' ) ); ?></span>
				<?php elseif ( is_year() ) : ?>
					<a href="/archives/" itemprop="url"><span itemprop="title"><?php esc_html_e( 'Archives', 'makotokw' ); ?></span></a><?php echo wp_kses_post( $divider ); ?>
					<span class="breadcrumb-last" itemprop="title"><?php echo get_the_date( __( 'Y', 'makotokw' ) ); ?></span>
				<?php else : ?>
					<span class="breadcrumb-last" itemprop="title"><?php esc_html_e( 'Archives', 'makotokw' ); ?></span>
				<?php endif ?>
			<?php elseif ( is_search() ) : ?>
				<span class="breadcrumb-last" itemprop="title"><?php esc_html_e( 'Search Results', 'makotokw' ); ?>: <em><?php echo get_search_query(); ?></em></span>
			<?php elseif ( is_single() ) : ?>
				<?php $category = get_the_category(); ?>
				<?php if ( is_array( $category ) && count( $category ) > 0 ) : ?>
					<?php $category_id = get_cat_ID( $category[0]->cat_name ); ?>
					<a href="/categories/" itemprop="url"><span itemprop="title"><?php esc_html_e( 'Categories', 'makotokw' ); ?></span></a><?php echo wp_kses_post( $divider ); ?>
					<?php
					$breadcrumbs_category = makotokw_breadcrumbs_category_parents( $category_id, $divider );
					if ( strpos( $breadcrumbs_category, $divider ) !== false ) {
						echo substr( $breadcrumbs_category, 0, -strlen( $divider ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted breadcrumb markup with itemprop; name escaped in builder.
					}
					?>
				<?php endif ?>
			<?php elseif ( is_page() ) : ?>
				<?php $post = $wp_query->get_queried_object(); ?>
				<?php if ( empty( $post->post_parent ) ) : ?>
					<span class="breadcrumb-last" itemprop="title"><?php echo esc_html( the_title( '', '', false ) ); ?></span>
				<?php else : ?>
					<?php
					$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
					?>
					<?php foreach ( $ancestors as $ancestor ) : ?>
						<?php if ( end( $ancestors ) !== $ancestor ) : ?>
							<a href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>" itemprop="url">
									<span itemprop="title"><?php echo esc_html( wp_strip_all_tags( get_the_title( $ancestor ) ) ); ?></span>
							</a>
							<?php echo wp_kses_post( $divider ); ?>
						<?php else : ?>
							<a href="<?php echo esc_url( get_permalink( $ancestor ) ); ?>" itemprop="url">
									<span itemprop="title"><?php echo esc_html( wp_strip_all_tags( get_the_title( $ancestor ) ) ); ?></span>
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

	/* translators: %s: taxonomy term name */
	$chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '" title="' . esc_attr( sprintf( __( 'View all posts in %s', 'makotokw' ), $parent->name ) ) . '" itemprop="url"><span itemprop="title">' . esc_html( $parent->name ) . '</span></a>' . $separator;

	return $chain;
}
