<?php
/**
 * The template for displaying search forms in makotokw
 *
 * @package makotokw
 */
?>
<form method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" _lpchecked="1">
	<fieldset class="search-form-fieldset">
		<label for="s" class="screen-reader-text"><?php _e( 'Search', 'makotokw' ); ?></label>
		<input type="text" class="search-form-text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php _e( 'Search the site', 'makotokw' ); ?>"/>
		<input id="search-image" class="search-form-submit" type="submit" value=""/>
		<i class="fa fa-search"></i>
	</fieldset>
</form>
