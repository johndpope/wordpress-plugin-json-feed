<?php

/*
  Plugin Name: JSON Feed Plugin for WordPress
  Description: This is a 'fork' of Chris Northwood's popular JSON Feed plugin for WordPress version 1.3 -- See http://wordpress.org/support/plugin/json-feed. It provides he ability to generate feeds in JSON format from any place on your WordPress site.
  Version: 1.0
  Author: Modified by Claude Betancourt. Original by Chris Northwood and Dan Phiffer.
 */

	const DEFAULT_MAX_STORIES = 10;
	const DEFAULT_DATE_FORMAT = 'F j, Y G:i e';

add_filter('query_vars', 'json_feed_queryvars');

function json_feed_queryvars($qvars) {
    $qvars[] = 'callback'; //JSONP support
    $qvars[] = 'df'; // date format
    $qvars[] = 'limit';
    return $qvars;
}

function json_feed() {
    // set max items to display
    $_limit = trim(get_query_var('limit'));
    $items = ($_limit != '' && is_numeric($_limit) && $_limit > 0) ? $_limit : DEFAULT_MAX_STORIES;

    $output = array();
    $count = 1;
    while (have_posts() && $count <= $items) {
	the_post();
	$post_date = strtotime(get_the_date(DATE_W3C));
	$output[] = array(
	    'title' => htmlentities(strip_tags(get_the_title())),
	    'excerpt' => htmlentities(strip_tags(get_the_excerpt())),
	    'permalink' => get_permalink(),
	    'display_date' => date(get_date_format(), $post_date),
	    'unix_date' => $post_date * 1000
	);
	$count++;
    }

    if (!get_query_var('callback') == '') {
	header('Content-Type: application/javascript; charset=' . get_option('blog_charset'), true);
	echo get_query_var('callback') . '(' . json_encode($output) . ')';
    } else {
	header('Content-Type: application/json; charset=' . get_option('blog_charset'), true);
	echo json_encode($output);
    }
}

/*
 * Retrieves the default date constant or uses the one passed via query param.
 *
 * Optionally, you can retrieve the date format configured for the blog,
 * get_option('date_format')
 *
 */

function get_date_format() {
    if (get_query_var('df')) {
	return get_query_var('df');
    } else {
	return DEFAULT_DATE_FORMAT;
    }
}

add_action('do_feed_json', 'json_feed');
