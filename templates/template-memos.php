<?php
/**
 * @subpackage makotokw
 * Template Name: Memos
 * Template Post Type: page
 * /memo/
 */

$t_title = get_the_title();
ob_start();
?>
	<ul class="memo-list">
		<?php
		wp_list_pages(
			array(
				'title_li' => false,
				'child_of' => WP_THEME_MEMO_POST_ID,
			)
		);
		?>
	</ul>
<?php
$t_contents = ob_get_contents();
ob_end_clean();
require __DIR__ . '/inc/simple-page.php';
