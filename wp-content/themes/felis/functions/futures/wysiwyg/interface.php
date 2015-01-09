<?php

define('WP_DEBUG', false);
define('DOING_AJAX', true);
define('WP_ADMIN', true);

require_once('../../../../../../wp-load.php');

if (!is_user_logged_in() OR !current_user_can('edit_posts'))
	wp_die(__('You are not allowed to be here', SG_TDN));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Shortcodes</title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
		<script language="javascript" type="text/javascript" src="<?php echo get_template_directory_uri() ?>/functions/futures/wysiwyg/wysiwyg.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
		<base target="_self" />
	</head>
	<body onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none" id="link">
		<form name="kotofey_shortcode_form" action="#">
			<div class="shortcode_wrap" style="height:100px;width:250px;margin:0 auto;margin-top:30px;text-align:center;" >
				<div id="shortcode_panel" class="current" style="height:50px;">
					<fieldset style="border:0;width:100%;text-align:center;">
						<select id="style_shortcode" name="style_shortcode" style="width:250px">
							<option value="0">Select a Shortcode...</option>
							<optgroup label="Elements">
								<option value="wb">White Box</option>
							</optgroup>
							<optgroup label="Dividers">
								<option value="hr">Basic Divider</option>
								<option value="hr2">Blank Divider</option>
								<option value="clear">Clear Fix</option>
							</optgroup>
							<optgroup label="Cufon">
								<option value="h1-cufon">H1</option>
								<option value="h2-cufon">H2</option>
								<option value="h3-cufon">H3</option>
								<option value="h4-cufon">H4</option>
								<option value="h5-cufon">H5</option>
								<option value="h6-cufon">H6</option>
								<option value="h1-cufon2">H1 and Line</option>
								<option value="h2-cufon2">H2 and Line</option>
								<option value="h3-cufon2">H3 and Line</option>
								<option value="h4-cufon2">H4 and Line</option>
								<option value="h5-cufon2">H5 and Line</option>
								<option value="h6-cufon2">H6 and Line</option>
							</optgroup>
							<optgroup label="Widgets">
								<option value="tabs">Tabs</option>
								<option value="accordion">Accordion</option>
								<option value="latest">Latest from the Blog</option>
							</optgroup>
							<optgroup label="Column Shortcodes">
								<option value="two_columns">2 Columns</option>
								<option value="three_columns">3 Columns</option>
								<option value="four_columns">4 Columns</option>
								<option value="five_columns">5 Columns</option>
								<option value="six_columns">6 Columns</option>
								<option value="1/4+3/4">1/4 Column + 3/4 Column</option>
								<option value="3/4+1/4">3/4 Column + 1/4 Column</option>
								<option value="1/3+2/3">1/3 Column + 2/3 Column</option>
								<option value="2/3+1/3">2/3 Column + 1/3 Column</option>
							</optgroup>
							<optgroup label="Block Quote">
								<option value="block-quote-left">Block quote left</option>
								<option value="block-quote-right">Block quote right</option>
								<option value="testimonials">Testimonials</option>
							</optgroup>
							<optgroup label="List Shortcodes">
								<option value="checkboxes-list">Check Boxes List</option>
								<option value="cat-list">Cat List</option>
								<option value="comments-list">Comments List</option>
								<option value="stars-list">Stars List</option>
								<option value="arrows-list">Arrows List</option>
								<option value="links-list">Links List</option>
								<option value="stick-list">Stick List</option>
								<option value="recent-posts-list">Recent Posts List</option>
							</optgroup>
							<optgroup label="Alert Boxes">
								<option value="alert-info">Info alert</option>
								<option value="alert-success">Success alert</option>
								<option value="alert-alert">Attention alert</option>
							</optgroup>
							<optgroup label="Buttons">
								<option value="link-button">Read more link</option>
								<option value="link2-button">More link</option>
								<option value="custom-button">Button</option>
							</optgroup>
							<optgroup label="Highlight">
								<option value="hl-theme">Main theme color highlight</option>
								<option value="hl-red">Red highlight</option>
								<option value="hl-blue">Blue highlight</option>
								<option value="hl-green">Green highlight</option>
								<option value="hl-grey">Grey highlight</option>
								<option value="hl-black">Black highlight</option>
								<option value="hl-orange">Orange highlight</option>
							</optgroup>
							<optgroup label="Media">
								<option value="youtube">Youtube video</option>
								<option value="vimeo">Vimeo video</option>
							</optgroup>
						</select>
					</fieldset>
				</div>
				<div style="float:left"><input type="button" id="cancel" name="cancel" value="<?php echo "Close"; ?>" onClick="tinyMCEPopup.close();" /></div>
				<div style="float:right"><input type="submit" id="insert" name="insert" value="<?php echo "Insert"; ?>" onClick="embedshortcode();" /></div>
			</div>
		</form>
	</body>
</html>
