<?php

define('SG_SLUG', 'ab-');

if (get_option('page_for_posts') != 0) {
	update_option('page_for_posts', 0);
	wp_redirect($_SERVER['REQUEST_URI']); exit;
}

if (!isset($content_width)) $content_width = 598;

add_action('after_setup_theme', 'sg_user_theme_setup');
add_action('after_setup_theme', 'sg_theme_setup');
add_filter('excerpt_length', 'sg_custom_excerpt_length');
//add_filter('get_the_excerpt', 'sg_excerpt_replace');
//add_filter('get_comment_author_url', 'sg_comment_author_url_replace');

function sg_theme_setup()
{
	/* Add theme-supported features. */
	add_theme_support('nav-menus');
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/* Add post thumbnail size */
	set_post_thumbnail_size(260, 180, true);
	/* Add images sizes */
	add_image_size('sg_post', 310, 140, true);
	add_image_size('sg_post_big', 680, 300, true);
	add_image_size('sg_portfolio', 300, 145, true);
	add_image_size('sg_portfolio2', 300, 222, true);
	add_image_size('sg_portfolio_big', 680, 418, true);
	add_image_size('sg_portfolio_big2', 620, 418, true);
	add_image_size('sg_slider', 980, 416, true);
	add_image_size('sg_slider2', 980, 156, true);
	add_image_size('sg_our_team', 140, 105, true);

	/* Localization */
	load_theme_textdomain(SG_TDN, TEMPLATEPATH . '/languages');
}

function sg_custom_excerpt_length() {
	return 500;
}

function sg_excerpt_replace($text)
{
	return str_replace('[...]', '...', $text);
}

function sg_comment_author_url_replace($text)
{
	if ($text == 'http://Website') return '';
	return $text;
}