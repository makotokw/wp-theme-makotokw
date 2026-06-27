<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the id=main div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package makotokw
 */

?>
	</main><!-- .site-content -->
	<?php get_sidebar(); ?>
</div><!-- .site-main -->
<footer class="site-footer">
	<div class="section-inner">
		<div class="footer-navs">
			<?php
			wp_nav_menu(
				array(
					'theme_location'  => 'footer-menu',
					'container_class' => 'site-footer-help-nav',
					'link_before'     => '',
					'link_after'      => '',
					'fallback_cb'     => false,
				)
			);
			?>
		</div>
		<div class="footer-credits">
			<span class="copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>&nbsp;<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span>
			<?php
				$makotokw_wp_theme   = wp_get_theme();
				$makotokw_theme_name = $makotokw_wp_theme->display( 'Name' );
				$makotokw_powered_by = sprintf(
					/* translators: %s: WordPress link */
					__( 'Powered by %s', 'makotokw' ),
					'<a href="https://wordpress.org/" title="' . esc_attr( __( 'Semantic Personal Publishing Platform', 'makotokw' ) ) . '">WordPress</a>'
				);
				?>
				<span class="powered-by">
					<?php echo wp_kses_post( $makotokw_powered_by ); ?>
					<svg class="footer-heart" viewBox="0 0 24 24" width="12" height="12" aria-hidden="true" focusable="false"><path fill="currentColor" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
					<a href="<?php echo esc_url( 'https://github.com/makotokw/wp-theme-makotokw/tree/' . $makotokw_theme_name ); ?>">Theme <i class="fab fa-github"></i></a> by <a href="https://makotokw.com">makoto_kw</a>
				</span>
		</div>
	</div>
</footer>
<a id="scrollToTop" class="scroll-to-top" href="#top" aria-label="<?php esc_attr_e( 'Back to top', 'makotokw' ); ?>">
	<i class="fas fa-arrow-up" aria-hidden="true"></i>
</a>
<?php wp_footer(); ?>
</body>
</html>
