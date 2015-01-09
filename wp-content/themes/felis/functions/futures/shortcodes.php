<?php

/* ----- HR ----- */
function sg_sc_hr($atts, $content = "", $shortcodename = "")
{
	if (is_array($atts)) extract($atts);
	$class = (isset($class) AND !empty($class)) ? ' class="' . trim($class) . '"' : '';
	return '<hr' . $class . ' />';
}

function sg_sc_clear($atts, $content = "", $shortcodename = "")
{
	return '<div class="clear"></div>';
}

add_shortcode('hr', 'sg_sc_hr');
add_shortcode('clear', 'sg_sc_clear');

/* ----- BLOCK QUOTES ----- */
function sg_sc_block_quotes($atts, $content = "", $shortcodename = "")
{
	return '<blockquote class="block' . $shortcodename . '">' . sg_remove_autop($content) . '</blockquote>';
}

add_shortcode('quote-left', 'sg_sc_block_quotes');
add_shortcode('quote-right', 'sg_sc_block_quotes');

function sg_sc_testimonials($atts, $content = "", $shortcodename = "")
{
	extract($atts);
	return '<div class="testimonials">' . sg_remove_autop($content) . '<h6>' . $name . '</h6></div>';
}

add_shortcode('testimonials', 'sg_sc_testimonials');


/* ----- ALERT BOXES ----- */
function sg_sc_alerts($atts, $content = "", $shortcodename = "")
{
	$class = 'alertBox-' . str_replace('alert-', '', $shortcodename);
	$class = str_replace('info', 'warning', $class);
	return '<div class="' . $class . '">' . sg_remove_autop($content) . '</div>';
}

add_shortcode('alert-info', 'sg_sc_alerts');
add_shortcode('alert-success', 'sg_sc_alerts');
add_shortcode('alert-alert', 'sg_sc_alerts');

/* ----- CUFON HEADINGS ----- */
function sg_sc_cufons($atts, $content = "", $shortcodename = "")
{
	if (is_array($atts)) extract($atts);
	$class = (isset($class) AND !empty($class)) ? ' ' . trim($class) : '';
	$h = str_replace('-cufon', '', $shortcodename);
	return '<div class="heading' . $class . '"><' . $h . '>' . sg_remove_autop($content) . '</' . $h . '></div>';
}

add_shortcode('h1-cufon', 'sg_sc_cufons');
add_shortcode('h2-cufon', 'sg_sc_cufons');
add_shortcode('h3-cufon', 'sg_sc_cufons');
add_shortcode('h4-cufon', 'sg_sc_cufons');
add_shortcode('h5-cufon', 'sg_sc_cufons');
add_shortcode('h6-cufon', 'sg_sc_cufons');

/* ----- HIGHTLIGHT ----- */
function sg_sc_highlights($atts, $content = "", $shortcodename = "")
{
	$class = 'highlight-' . str_replace('h1-', '', $shortcodename);
	return '<span class="' . $class . '">' . sg_remove_autop($content) . '</span>';
}

add_shortcode('hl-theme', 'sg_sc_highlights');
add_shortcode('hl-red', 'sg_sc_highlights');
add_shortcode('hl-blue', 'sg_sc_highlights');
add_shortcode('hl-green', 'sg_sc_highlights');
add_shortcode('hl-grey', 'sg_sc_highlights');
add_shortcode('hl-black', 'sg_sc_highlights');
add_shortcode('hl-orange', 'sg_sc_highlights');


/* ----- LISTS ----- */
function sg_sc_lists($atts, $content = "", $shortcodename = "")
{
	$class = str_replace('-list', '', $shortcodename);
	$content = str_replace('[/li]<br />', '[/li]', $content);
	return '<ul class="' . $class . '">' . sg_remove_autop($content) . '</ul>';
}

function sg_sc_lists_ittem($atts, $content = "", $shortcodename = "")
{
	return '<li>' . sg_remove_autop($content) . '</li>';
}

add_shortcode('checkboxes-list', 'sg_sc_lists');
add_shortcode('cat-list', 'sg_sc_lists');
add_shortcode('comments-list', 'sg_sc_lists');
add_shortcode('stars-list', 'sg_sc_lists');
add_shortcode('arrows-list', 'sg_sc_lists');
add_shortcode('links-list', 'sg_sc_lists');
add_shortcode('stick-list', 'sg_sc_lists');
add_shortcode('recent-posts-list', 'sg_sc_lists');
add_shortcode('li', 'sg_sc_lists_ittem');


/* ----- COLUMN LAYOUTS ----- */
function sg_sc_column_layouts($atts, $content = "", $shortcodename = "")
{	
	return '<div class="' . str_replace('_last', ' omega', $shortcodename) . '">' . sg_remove_autop($content) . '</div>';
}

add_shortcode('one_sixth', 'sg_sc_column_layouts');
add_shortcode('one_sixth_last', 'sg_sc_column_layouts');
add_shortcode('one_fifth', 'sg_sc_column_layouts');
add_shortcode('one_fifth_last', 'sg_sc_column_layouts');
add_shortcode('one_fourth', 'sg_sc_column_layouts');
add_shortcode('one_fourth_last', 'sg_sc_column_layouts');
add_shortcode('one_third', 'sg_sc_column_layouts');
add_shortcode('one_third_last', 'sg_sc_column_layouts');
add_shortcode('one_half', 'sg_sc_column_layouts');
add_shortcode('one_half_last', 'sg_sc_column_layouts');
add_shortcode('two_thirds', 'sg_sc_column_layouts');
add_shortcode('two_thirds_last', 'sg_sc_column_layouts');
add_shortcode('three_fourth', 'sg_sc_column_layouts');
add_shortcode('three_fourth_last', 'sg_sc_column_layouts');


/* ----- BUTTONS ----- */
function sg_sc_shortcode_button($atts, $content = "", $shortcodename = "")
{
	extract($atts);
	if(empty($url) OR $url == '#') $url = get_permalink();
	return '<a class="button" href="' . $url . '"><span>' . $text . '<img src="' . get_template_directory_uri() . '/images/arr.gif" alt=""></span></a>';
}

add_shortcode('button', 'sg_sc_shortcode_button');


/* ----- TABS ----- */
function sg_sc_tabs($atts, $content = null)
{
	extract(shortcode_atts(array(), $atts));
	global $tab_count_1;
	global $tab_count_2;
	$tab_count_1++;
	$tab_count_2++;
	$out = '<div class="sg-sc-tabs">';
	$out .= '<ul class="tabs-nav clearfix">';
	$counter = 1;

	foreach ($atts as $tab) {
		if ($counter == 1) {
			$first = 'first';
		} else {
			$first = '';
		}
		$out .= '<li class="' . $first . '"><a title="' . $tab . '" href="#tab-' . $tab_count_1 . '">' . $tab . '</a></li>';
		$tab_count_1++;
		$counter++;
	}
	$out .= '</ul>';
	$content = str_replace('[/tab]<br />', '[/tab]', $content);
	$out .= sg_remove_autop($content) . '</div>';
	return $out;
}

function sg_sc_panes($atts, $content = null)
{
	global $tab_count_2;
	$out = '<div class="tab" id="tab-' . $tab_count_2 . '">' . sg_remove_autop($content) . '</div>';
	$tab_count_2++;
	return $out;
}

add_shortcode('tabs', 'sg_sc_tabs');
add_shortcode('tab', 'sg_sc_panes');


/* ----- ACCORDION ----- */
function sg_sc_accordion($atts, $content = null)
{
	$content = str_replace('[/section]<br />', '[/section]', $content);
	return '<ul class="accordion">' . sg_remove_autop($content) . '</ul>';
}

function sg_sc_section($atts, $content = null)
{
	extract($atts);
	$out = '<li>';
		$out .= '<a class="title" href="#"><strong>' . $title . '</strong><span class="acc-arr"></span></a>';
		$out .= '<ul><li><div>' . sg_remove_autop($content) . '</div></li></ul>';
	$out .= '</li>';
	return $out;
}

add_shortcode('accordion', 'sg_sc_accordion');
add_shortcode('section', 'sg_sc_section');


/* ----- YOUTUBE VIDEO ----- */
function youtubeVideo($atts, $content = null)
{
	extract($atts);
	$class = ($height == 'auto') ? ' class="auto-height"' : '';
	return "<div class=\"youtube-short\"><object$class style=\"height:$height;width:$width;\">
				<param name='movie' value='http://www.youtube.com/v/$id?version=3'><param name='allowFullScreen' value='true'>
				<param name='allowScriptAccess' value='always'>
				<param name='wmode' value='transparent'>
			<embed height=$height width=$width src='http://www.youtube.com/v/$id?version=3' type='application/x-shockwave-flash' wmode='transparent' allowfullscreen='true' allowScriptAccess='always'></object></div>";
}

add_shortcode("youtube", "youtubeVideo");


/* ----- VIMEO VIDEO ----- */
function vimeoVideo($atts, $content = null)
{
	extract($atts);
	$class = ($height == 'auto') ? ' class="auto-height"' : '';
	return "<div class=\"vimeo\"><object$class width=\"$width\" height=\"$height\" type=\"application/x-shockwave-flash\" data=\"http://vimeo.com/moogaloop.swf?clip_id=$id&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0\">
				<param name=\"allowfullscreen\" value=\"true\" />
				<param name=\"allowscriptaccess\" value=\"always\" />
				<param name=\"wmode\" value=\"transparent\" />
				<param name=\"movie\" value=\"http://vimeo.com/moogaloop.swf?clip_id=$id&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0\" />
			</object></div>";
}

add_shortcode("vimeo", "vimeoVideo");


/* ----- LATEST ----- */
function sg_sc_latest_from_blog($atts, $content = null)
{
	if (is_array($atts)) extract($atts);
	$count = (isset($count) AND !empty($count)) ? (int)$count : 3;
	$cat = (isset($category) AND !empty($category)) ? $category : 'all';
	if ($count < 1)	return;
	
	global $post;
	$tmp_post = $post;
	
	$cats = get_terms('category', array('hide_empty' => FALSE));
	$topc = array();
	foreach ($cats as $catl) {
		$topc[$catl->name] = $catl->term_id;
	}
	
	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $count,
	);
	if ($cat != 'all' AND array_key_exists($cat, $topc)) $args['category__in'] = $topc[$cat];
	
	$postslist = get_posts($args);
	$c = '';
	
	foreach ($postslist as $post) {
		setup_postdata($post);
		$c .= '<div class="post-mod">';
			$c .= '<a href="' . get_permalink() . '" class="date-comments">';
				$c .= '<div>' . get_the_time('d M') . ',<br />' . get_the_time('Y') . '</div><span>' . sg_comments_count() . '</span>';
			$c .= '</a>';
			$c .= '<h6><a href="' . get_permalink() . '">' . get_the_title() . '</a></h6>';
			$c .= '<p class="auth-cat">' . __('Posted by', SG_TDN) . '&nbsp;<strong>' . get_the_author_link() . '</strong>&nbsp;' . __('in', SG_TDN) . '&nbsp;' . sg_the_category(FALSE) . '<img class="ml-10" src="' . get_template_directory_uri() . '/images/pencil.gif" alt="" /></p>';
		$c .= '</div>';
	}
	
	$post = $tmp_post;
	
	return $c;
}

add_shortcode('latest_from_blog', 'sg_sc_latest_from_blog');


/* ----- WHITE BOX ----- */
function sg_sc_white_box($atts, $content = "")
{
	return '<div class="inner clearfix"><div class="inner-t">' . sg_remove_autop($content) . '</div></div><div class="shady bott-27"></div>';
}

add_shortcode('white_box', 'sg_sc_white_box');


function sg_remove_autop($content) 
{
	$content = do_shortcode(shortcode_unautop($content));
	$content = preg_replace('#^<br\s?\/?>|<br\s?\/?>$#', '', $content);
	$content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
	$content = preg_replace('#(^<p>)*<\/p>#', '', $content);
	$content = preg_replace('#<\/div><br \/>|<\/div><p><\/p>#', '</div>', $content);
	$content = preg_replace('#<\/div><\/p>#', '</div>', $content);
	return $content;
}


add_action('the_content', 'sg_the_content');
function sg_the_content($content) 
{
	$content = do_shortcode(shortcode_unautop($content));
	$content = preg_replace('#^<br\s?\/?>|<br\s?\/?>$#', '', $content);
	$content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
	$content = preg_replace('#<\/div><br \/>|<\/div><\/p>#', '</div>', $content);
	$content = preg_replace('#<p><div#', '<div', $content);
	return $content;
}