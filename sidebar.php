<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package makotokw
 */

if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
	<div id="tertiary" class="sidebar-container" role="complementary">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div>
			<!-- .widget-area -->
		</div>
		<!-- .sidebar-inner -->
	</div><!-- #tertiary -->
	<?php
endif;
