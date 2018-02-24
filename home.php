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
get_header();
?>
<section class="section-page section-page-entry section-page-first">
	<div class="post-summaries">
		<?php while ( have_posts() ) : ?>
			<?php
				the_post();
				get_template_part( 'content', get_post_format() );
			?>
		<?php endwhile; ?>
	</div>
	<?php makotokw_pagination(); ?>
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
				);
			?>
		</ul>
	</div>
</section>

<?php
	$page_posts = new WP_Query();
$page_posts->query( 'pagename=about' );
?>
<section class="section-page section-page-about">
	<div class="container">
		<h2 class="section-title">About</h2>
		<?php if ( $page_posts->have_posts() ) : ?>
			<?php
				$page_posts->the_post();
				the_content();
			?>
		<?php endif ?>
	</div>
</section>

<section class="section-page section-page-archive">
	<div class="container">
		<?php makotokw_inline_archives(); ?>
	</div>
</section>


<?php get_footer(); ?>
