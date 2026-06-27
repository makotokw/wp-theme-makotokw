<?php
/**
 * @package makotokw
 * Template Name: Tags
 * Template Post Type: page
 * @link /tags/
 */

__( 'Tags', 'makotokw' );
$makotokw_title = get_the_title();
ob_start();
?>
<?php makotokw_tag_cloud( array( 'number' => '' ) ); ?>
<?php
$makotokw_contents = ob_get_contents();
ob_end_clean();
get_template_part(
	'templates/inc/simple-page',
	null,
	array(
		'title'    => $makotokw_title,
		'contents' => $makotokw_contents,
	)
);
