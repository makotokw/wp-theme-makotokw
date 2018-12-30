<?php
/**
 * @subpackage makotokw
 * Template Name: Tags
 * /tags/
 */

$t_title = get_the_title();
ob_start();
?>
<?php makotokw_tag_cloud( array( 'number' => '' ) ); ?>
<?php
$t_contents = ob_get_contents();
ob_end_clean();
include __DIR__ . '/inc/simple-page.php';
