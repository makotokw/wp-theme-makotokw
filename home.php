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

<div class="site-content-header">
	<h2 class="archives-title"><?php makotokw_archives_title(); ?></h2>
</div>
<div class="archive">
	<div class="post-summaries">
		<?php while ( have_posts() ) : ?>
			<?php
				the_post();
				get_template_part( 'template-parts/content', get_post_format() );
			?>
		<?php endwhile; ?>
	</div>
	<?php makotokw_pagination(); ?>
</div>

<?php get_footer(); ?>
