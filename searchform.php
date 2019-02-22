<?php
/**
 * The template for displaying search forms in makotokw
 *
 * @package makotokw
 */
?>
<!--suppress HtmlUnknownAttribute -->
<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input type="text" class="search-form-text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Search the site', 'makotokw' ); ?>"/>
	<button type="submit" class="btn btn-contained btn-search">
		<i class="fas fa-search"></i>
		<span class="screen-reader-text">
			<?php echo _x( 'Search', 'submit button', 'makotokw' ); ?>
		</span>
	</button>
</form>
