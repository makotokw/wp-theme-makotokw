<?php
/**
 * @package makotokw
 */

function makotekw_home_after_body()
{
	?>
<?php
}

add_action('makotekw_after_body', 'makotekw_home_after_body');
get_header(); ?>
<main role="main">
	<section class="section-page section-page-entry section-page-first">
		<div class="container">
			<div class="row">
				<div class="">
					<ul class="list-entries list-entries-recent">
						<?php while (have_posts()) : the_post(); ?>
							<li class="post-summary">
								<div class="entry-header">
									<span class="entry-title"><a href="<?php the_permalink(); ?>"
																 title="<?php echo esc_attr(sprintf(__('Permalink to %s', 'makotokw'), the_title_attribute('echo=0'))); ?>"
																 rel="bookmark"><?php the_title(); ?></a></span>
									<span class="entry-date"><?php makotokw_posted_on(); ?></span>
									<span class="cat-links"><i
											class="fa fa-folder"></i> <?php makotokw_the_category_slug(', '); ?></span>
									<span class="tag-links"><?php makotokw_the_tag_links(); ?></span>
								</div>
							</li>
						<?php endwhile; ?>
					</ul>
					<a class="btn more-link" href="/archive/page/2/">続きを見る</a>

				</div>
<!--				<div>-->
<!--					--><?php
//					$pagePosts = new WP_Query();
//					$pagePosts->query('pagename=about');
//					if ($pagePosts->have_posts()): $pagePosts->the_post();
//						the_content();
//					endif;
//					?>
<!--				</div>-->
			</div>

		</div>
	</section>

	<section class="section-page section-page-category">
		<div class="container">
			<ul class="list-category">
				<?php wp_list_categories(array(
					'title_li' => '',
					'show_count' => false
				)); ?>
			</ul>
		</div>
	</section>

	<section class="section-page section-page-about">
		<div class="container">
			<h2 class="section-title">About</h2>
			<?php
			$pagePosts = new WP_Query();
			$pagePosts->query('pagename=about');
			if ($pagePosts->have_posts()): $pagePosts->the_post();
				the_content();
			endif;
			?>
		</div>
	</section>

	<section class="section-page section-page-archive">
		<div class="container">
			<h2 class="section-title">Archives</h2>
			<?php makotokw_inline_archives() ?>
		</div>
	</section>
</main>

<?php get_footer(); ?>