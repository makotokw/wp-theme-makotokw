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

<section class="section-page archive">
	<h2 class="archives-title"><?php makotokw_archives_title(); ?></h2>
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

<?php get_footer(); ?>
