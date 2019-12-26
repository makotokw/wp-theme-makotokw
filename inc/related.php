<?php
function makotokw_related_posts( $title = 'Related Posts', $arg = array() ) {
	global $post;

	/** @var WP_Query $rfq */
	$rfq = false;
	/** @var WP_Query $rq */
	$rq = false;

	$arg = array_merge(
		array(
			'post_type' => 'post',
			'max_count' => 5,
		),
		$arg
	);

	$featured_taxonomies = makotokw_get_featured_taxonomy( $post );
	foreach ( $featured_taxonomies as $taxonomy ) {
		if ( ! $rq || ! $rq->have_posts() ) {
			$base_query_arg = array(
				'post_type'    => $arg['post_type'],
				'post__not_in' => array( $post->ID ),
				'tax_query'    => array(
					array(
						'taxonomy' => $taxonomy->taxonomy,
						'terms'    => $taxonomy->term_id,
						'operator' => 'IN',
					),
				),
				'showposts'    => $arg['max_count'],
			);
			$custom_key     = 'makotokw_rating';
			$rfq            = new WP_Query(
				array_merge(
					$base_query_arg,
					array(
						'meta_key'     => $custom_key,
						'meta_compare' => 'EXISTS',
						'orderby'      => 'meta_value_num date',
						'order'        => 'DESC',
					)
				)
			);
			if ( $rfq->post_count < $arg['max_count'] ) {
				$rq = new WP_Query(
					array_merge(
						$base_query_arg,
						array(
							'meta_key'     => $custom_key,
							'meta_compare' => 'NOT EXISTS',
							'showposts'    => $arg['max_count'] - $rfq->post_count,
						)
					)
				);
			}
		}
	}

	if ( $rq && $rfq && ( $rfq->have_posts() || $rq->have_posts() ) ) : ?>
		<section class="related-posts section-inner">
			<hr/>
			<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
			<ul class="post-inlines">
				<?php foreach ( array( $rq, $rfq ) as $q ) : ?>
					<?php while ( $q->have_posts() ) : ?>
						<li>
							<?php $q->the_post(); ?>
							<?php get_template_part( 'template-parts/content', 'inline' ); ?>
						</li>
					<?php endwhile; ?>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>
	<?php
	wp_reset_postdata();
}

function makotokw_related_portfolio( $title = 'Related Software' ) {
	global $post;
	unset( $portfolio );
	$terms = get_the_terms( $post->ID, 'portfolios' );
	if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
		$portfolio = array_shift( $terms );
	}

	if ( isset( $portfolio ) ) {
		$query_arg = array(
			'post_type' => 'page',
			'tax_query' => array(
				array(
					'taxonomy' => 'portfolios',
					'terms'    => $portfolio->term_id,
					'operator' => 'IN',
				),
			),
		);

		$rq = new WP_Query( $query_arg );
		if ( $rq->have_posts() ) {
			$rq->the_post();
			?>
			<section class="related-posts section-inner">
				<hr/>
				<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
				<ul>
					<li>
						<a href="<?php the_permalink(); ?>">
							<span class="arrow"><i class="fas fa-angle-right"></i></span>
							<span class="title"><?php the_title(); ?></span>
						</a>
					</li>
				</ul>
			</section>
			<?php
		}
		wp_reset_postdata();
	}
}
