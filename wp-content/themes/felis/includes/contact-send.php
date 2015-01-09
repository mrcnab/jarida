<?php

if (!isset($_REQUEST['sg_post_id'])) die('(.)(.)');
define('WP_USE_THEMES', false);
require_once('../../../../wp-load.php');

$post = array(
	'ID' => $_REQUEST['sg_post_id'],
	'post_type' => 'page',
);
$post = (object) $post;
sg_init_config($post);
$link = get_post_permalink($post->ID);

$aErrors = array();
	
if(!isset($_REQUEST['sg_ct_name']) OR empty($_REQUEST['sg_ct_name'])) {
	$aErrors[] = 'Please fill your name.';
}
if(!isset($_REQUEST['sg_ct_email']) OR !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_REQUEST['sg_ct_email'])) {
	$aErrors[] = 'Please fill your mail.';
}
if(!isset($_REQUEST['sg_ct_message']) OR empty($_REQUEST['sg_ct_message'])) {
	$aErrors[] = 'Please fill a message.';
}

if(count($aErrors) === 0) {
	$name = strip_tags($_REQUEST['sg_ct_name']);
	$email = strip_tags($_REQUEST['sg_ct_email']);
	$website = strip_tags($_REQUEST['sg_ct_website']);
	
	$mail_to = _sg('Contact')->getEmail();
	$mail_to = empty($mail_to) ? get_bloginfo('admin_email') : $mail_to;
	$mail_subject = "Message from " . get_bloginfo('name');
	
	$headers = "From: " . $name . " <" . $email . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/plain;\n";
	
	$mailbody = "Message sent from IP: " . $_SERVER['REMOTE_ADDR'] . "\n";
	$mailbody .= "Name: " . $name . "\n";
	$mailbody .= "Email: " . $email . "\n";
	$mailbody .= "WebSite: " . $website . "\n";
	$mailbody .= "\nMessage:\n";
	$mailbody .= strip_tags($_REQUEST['sg_ct_message']);
	
	if (mail($mail_to, $mail_subject, $mailbody, $headers)) {
		$msg = __('Your message is sent.', SG_TDN) . '<br />';
		$msg .= '<br /><a href="' . $link . '" class="button">' . __('Go Back', SG_TDN) . '</a>';
	} else {
		$msg = __('There was a problem. Try again later.', SG_TDN) . '<br />';
		$msg .= '<br /><a href="' . $link . '" class="button">' . __('Go Back', SG_TDN) . '</a>';
	}
} else {
	$msg = '';
	foreach ($aErrors as $error) {
		$msg .= $error . '<br />';
	}
	$msg .= '<br /><a href="' . $link . '" class="button">' . __('Go Back', SG_TDN) . '</a>';
}

wp_die($msg);