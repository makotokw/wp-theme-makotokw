<?php
function makotokw_feedburner_url() {
	if (defined('WP_THEME_FEEDBURNER_PATH')) {
		return 'http://feeds.feedburner.com/' . WP_THEME_FEEDBURNER_PATH;
	}
	return false;
}

function makotokw_feedburner_redirect() {
	if ($url = makotokw_feedburner_url()) {
		if (function_exists('status_header')) {
			status_header( 302 );
		}
		header("Location:" . $url);
		header("HTTP/1.1 302 Temporary Redirect");
		exit();
	}
}

function makotokw_feed_redirect() {
	global $wp, $feed, $withcomments;
	if (is_feed() && $feed != 'comments-rss2' && !is_single() && $wp->query_vars['category_name'] == '' && ($withcomments != 1)) {
		makotokw_feedburner_redirect();
	}
}

function makotokw_check_feed_url() {
	switch (basename($_SERVER['PHP_SELF'])) {
		case 'wp-rss.php':
		case 'wp-rss2.php':
		case 'wp-atom.php':
		case 'wp-rdf.php':
			makotokw_feedburner_redirect();
			break;
	}
}

if (!preg_match("/feedburner|feedvalidator/i", $_SERVER['HTTP_USER_AGENT'])) {
	add_action('template_redirect', 'makotokw_feed_redirect');
	add_action('init', 'makotokw_check_feed_url');
}