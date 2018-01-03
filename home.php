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
<header class="site-content-header">
	<div class="home-header">
		<h1 class="blog-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="<?php bloginfo( 'name' ); ?>"  width="190" height="40" class="site-logo" />
			</a>
		</h1>
		<h2 class="blog-description"><?php bloginfo( 'description' ); ?></h2>
	</div>
</header>
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
