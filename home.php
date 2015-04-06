<?php
/**
 * @package makotokw
 */

global $wp_rewrite;
$wp_rewrite->pagination_base = 'archive/page';

function makotekw_home_after_body() {
	?>
	<?php
}

add_action( 'makotekw_after_body', 'makotekw_home_after_body' );
get_header(); ?>
<main role="main">
	<section class="section-page section-page-entry section-page-first">
		<div class="container">
			<ul class="list-entries list-entries-recent">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', get_post_format() ); ?>
				<?php endwhile; ?>
			</ul>
			<?php makotokw_pagination(); ?>
		</div>
	</section>

	<section class="section-page section-page-category">
		<div class="container">
			<ul class="list-category">
				<?php
				wp_list_categories(
					array(
						'title_li'   => '',
						'show_count' => false,
					)
				); ?>
			</ul>
		</div>
	</section>

	<?php $pagePosts = new WP_Query(); $pagePosts->query( 'pagename=about' ); ?>
	<section class="section-page section-page-about">
		<div class="container">
			<h2 class="section-title">About</h2>
			<?php if ( $pagePosts->have_posts() ) : $pagePosts->the_post(); ?>
				<?php the_content(); ?>
			<?php endif ?>
		</div>
	</section>

	<section class="section-page section-page-archive">
		<div class="container">
			<?php makotokw_inline_archives() ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>
