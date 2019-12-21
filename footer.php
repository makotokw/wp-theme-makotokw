<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package makotokw
 */
?>
	</main><!-- .site-content -->
	<?php get_sidebar(); ?>
</div><!-- .site-main -->
<footer class="site-footer" role="contentinfo">
	<div class="section-inner">

		<div class="footer-navs">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-home"></i> <?php _e( 'Home', 'makotokw' ); ?></a>
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'footer',
					'container_class' => 'site-footer-help-nav',
					'link_before'     => '',
					'link_after'      => '',
					'fallback_cb'     => false,
				)
			);
			?>
		</div>
		<div class="footer-credits">
			<span class="copyright"><?php do_action( 'makotokw_credits' ); ?></span>
			<?php
				$wp_theme   = wp_get_theme();
				$theme_name = $wp_theme->display( 'Name' );
				$powered_by = sprintf(
					__( 'Powered by %s', 'makotokw' ),
					'<a href="https://wordpress.org/" title="' . esc_attr( __( 'Semantic Personal Publishing Platform', 'makotokw' ) ) . '">WordPress</a>'
				);
				?>
			<span class="powered-by">
				<?php echo $powered_by; ?><i class="fas fa-heart"></i><a href="https://github.com/makotokw/wp-theme-makotokw/tree/<?php echo $theme_name; ?>">makotokw theme.<i class="fab fa-github-alt"></i></a>
			</span>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
