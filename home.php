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
	<div class="container">
		<div class="post-summaries">
			<?php while ( have_posts() ) : ?>
				<?php
					the_post();
					get_template_part( 'content', get_post_format() );
				?>
			<?php endwhile; ?>
		</div>
		<?php makotokw_pagination(); ?>
	</div>
</section>

<section class="section-page section-page-category">
	<div class="container">

		<ul class="list-categories">
			<?php makotokw_list_categories(); ?>
		</ul>
	</div>
</section>

<?php get_footer(); ?>
