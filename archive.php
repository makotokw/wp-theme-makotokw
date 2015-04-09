<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package makotokw
 */

get_header(); ?>

	<div class="site-content-area">
		<main class="site-content" role="main">
			<div class="container">
				<?php if ( have_posts() ) : ?>

					<?php if ( ! is_category() && ! is_tag() ) : ?>
					<header class="page-header">
						<h1 class="page-title">
							<?php if ( is_category() ) : ?>
								<i class="fa fa-folder-o"></i> <?php echo sprintf( __( 'Category Archives: %s', 'makotokw' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
							<?php elseif ( is_tag() ) : ?>
								<i class="fa fa-tag"></i> <?php echo sprintf( __( 'Tag Archives: %s', 'makotokw' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
							<?php elseif ( is_day() ) : ?>
								<i class="fa fa-calendar"></i> <?php echo sprintf( __( 'Daily Archives: %s', 'makotokw' ), '<span>' . get_the_date() . '</span>' ); ?>
							<?php elseif ( is_month() ) : ?>
								<i class="fa fa-calendar"></i> <?php echo sprintf( __( 'Monthly Archives: %s', 'makotokw' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
							<?php elseif ( is_year() ) : ?>
								<i class="fa fa-calendar"></i> <?php echo sprintf( __( 'Yearly Archives: %s', 'makotokw' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
							<?php elseif ( is_tax( 'mylist' ) ) : ?>
								<i class="fa fa-list-alt"></i>  <?php echo sprintf( __( '%s', 'makotokw' ), '<span>' . single_term_title( '', false ) . '</span>' ); ?>
							<?php elseif ( is_tax( 'blogs' ) ) : ?>
								<i class="fa fa-folder"></i> <?php echo sprintf( __( 'Blog Archives: %s', 'makotokw' ), '<span>' . single_term_title( '', false ) . '</span>' ); ?>
							<?php elseif ( is_tax( 'portfolios' ) ) : ?>
								<i class="fa fa-folder"></i> <?php echo sprintf( __( 'Portfolio Archives: %s', 'makotokw' ), '<span>' . single_term_title( '', false ) . '</span>' ); ?>
							<?php else : ?>
								<i class="fa fa-folder"></i> <?php echo _( 'Archives', 'makotokw' ); ?>
							<?php endif; ?>
						</h1>
						<?php if ( is_category() ) :  $category_description = category_description(); ?>
							<?php if ( ! empty($category_description) ) : ?>
								<?php echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' ); ?>
							<?php endif; ?>
						<?php elseif ( is_tag() ) : $tag_description = tag_description(); ?>
							<?php if ( ! empty($tag_description) ) : ?>
								<?php echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' ); ?>
							<?php endif; ?>
						<?php endif; ?>
					</header><!-- .page-header -->
					<?php endif; ?>

					<div class="post-summaries">
						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
							?>

						<?php endwhile; ?>
					</div>

					<?php makotokw_pagination(); ?>

				<?php else : ?>

					<?php get_template_part( 'no-results', 'archive' ); ?>

				<?php endif; ?>
			</div>
		</main>
	</div>

<?php get_footer(); ?>