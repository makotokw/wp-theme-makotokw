<?php
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
			if ( 1 != $cat->cat_ID ) { // ignore uncategorized category
				$rq = new WP_Query(
					array(
						'cat'       => $cat->cat_ID,
						'showposts' => $max_count + 1,
					)
				);
			}
		}
	}

	if ( $rq && $rq->have_posts() ) : $count = 0;?>
		<aside class="section section-mini section-related-posts">
			<h2 class="section-title"><?php _e( 'Related Posts', 'makotokw' ); ?></h2>
			<div class="section-content">
				<ul>
					<?php while ( $rq->have_posts() ) : $rq->the_post(); ?>
						<?php if ( $post->ID != $cur_post->ID && $count < $max_count ) : ?>
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

	if ( isset($portfolio) ) {
		$query_arg = array(
			'post_type' => 'page',
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolios',
					'terms' => $portfolio->term_id,
					'operator' => 'IN',
				),
			),
		);

		$rq = new WP_Query( $query_arg );
		if ( $rq->have_posts() ) {
			$rq->the_post(); ?>
			<section class="section section-mini section-portfolio">
				<h2 class="section-title">Related Software</h2>

				<div class="section-content"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></div>
			</section>
		<?php
		}
		wp_reset_postdata();
	}
}
