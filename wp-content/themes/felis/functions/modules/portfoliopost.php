<?php

class SG_PortfolioPost_Module extends SG_Module {
	
	const moduleName = 'PortfolioPost';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'img' => array(
			'name' => 'Select Image',
			'type' => 'portfolio',
			'default' => '',
			'help' => 'Get the thumbnail for the project (680px x 329px preferably)',
		),
		'slider' => array(
			'name' => 'Header Images',
			'type' => 'slides',
			'class' => 'sg-metabox-field sg-metabox-slides2',
			'default' => array(
				'value' => self::USE_NONE,
				'slides' => array(),
			),
			'help' => 'Add images in portfolio slider (680px x 329px preferably)',
		),
		'show_back' => array(
			'name' => '"Back to all works" button',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'yes',
			'show' => self::SHOW_ALL,
			'help' => 'Show or hide "Back to all works" link',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_PortfolioPost_Module;
		}
		return self::$instance;
	}
	
	public function inited()
	{
		return !is_null(self::$_vars);
	}
	
	public function initVars($uniq, $params, $defaults, $global, $post_id)
	{
		self::$_vars = self::_initVars(self::moduleName, $uniq, self::$_params, self::$_fields, $params, $defaults, $global, $post_id);
		return TRUE;
	}
	
	public function setVars($uniq, $post_data, $post_id = NULL)
	{
		$px = self::_getPx($uniq, self::moduleName);
		
		if (isset($post_data[$px . '_slider']['slides'])) {
			$slides = $post_data[$px . '_slider']['slides'];
			foreach ($slides as $id => $slide) {
				if (!isset($slide['img']) OR empty($slide['img']) OR $slide['img'] == -1) {
					unset($post_data[$px . '_slider']['slides'][$id]);
				}
			}
		} else {
			$post_data[$px . '_slider']['slides'] = array();
		}
		if (empty($post_data[$px . '_slider']['slides'])) {
			$post_data[$px . '_slider']['value'] = self::USE_NONE;
			$post_data[$px . '_slider']['slides'] = array();
			$post_data[$px . '_slider']['last'] = 0;
		} else {
			$post_data[$px . '_slider']['value'] = self::USE_DEFAULT;
		}
		
		return self::_setVars(self::moduleName, $uniq, self::$_fields, $post_data, $post_id);
	}
	
	public function resetVars($uniq, $post_id = NULL)
	{
		return self::_resetVars(self::moduleName, $uniq, $post_id);
	}

	public function getMenuItem()
	{
		return __('Content', SG_TDN);
	}
	
	protected function _getPortfolioField($uid, $params, $value, $default, $ug)
	{
		global $post_ID;
		$nonce = wp_create_nonce('set_post_thumbnail-' . $post_ID);
		$btn_name = __('Get Image', SG_TDN);
		$img = wp_get_attachment_image(get_post_meta($post_ID, '_thumbnail_id', true), 'post-thumbnail');
		$clear = empty($img) ? ' style="display: none;"' : '';
		
		$c = '<span class="sg-upload-btns">';
		$c .= '<input type="submit" value="' . __('Load Image', SG_TDN) . '" class="button" id="' . $uid . '_load" name="' . $uid . '_load">';
		$c .= '&nbsp;<input type="submit" value="' . __('Clear Image', SG_TDN) . '" class="button sg-photo-clear" id="' . $uid . '_clear" name="' . $uid . '_clear"' . $clear . '><br /><br />';
		$c .= '</span>';
		$c .= '<span id="' . $uid . '_img">' . $img . '</span>';
		
		$c .= SG_Form::hidden($uid, '');
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
sg_post_nonce = "' . $nonce . '";
sg_current_uid = "' . $uid . '";
sg_media_upload_btn_name = "' . $btn_name . '";
jQuery(document).ready(function($){
	if ($("input[name=' . $uid . ']").val() != "") {
		$("#' . $uid . '_clear").show();
	}
	$("#' . $uid . '_clear").click(function() {
		window.SGRemoveThumbnail();
		$("#' . $uid . '_clear").hide();
		return false;
	});	
	$("#' . $uid . '_load").click(function() {
		var pID = jQuery("#post_ID").val();
		tb_show("Insert", "media-upload.php?post_id=" + pID + "&custom-media-upload=PI&type=image&TB_iframe=true");
		return false;
	});
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	protected function _getSlidesField($uid, $params, $value, $default, $ug)
	{
		global $post_ID;
		$nonce = wp_create_nonce('set_post_thumbnail-' . (empty($post_ID) ? 0 : $post_ID));
		$btn_name = __('Get Image', SG_TDN);
		$ajax_url = get_template_directory_uri() . '/functions/modules/includes/slider/ajax.php';
		
		$slides = (isset($value['slides'])) ? $value['slides'] : array();
		$last = (isset($value['last'])) ? $value['last'] : 0;
		
		$c = '';
		
		foreach ($slides as $id => $slide) {
			$c .= '<div class="sg-slide-top">';
				$c .= '<div class="sg-slide">';
					$c .= '<div class="sg-slide-in" id="' . $uid . '-' . $id . '" rel="' . $uid . '[slides][' . $id . ']">';
						$c .= '<a class="button sg-slide-rm ' . $uid . '-rm" href="#">-</a>';
						$c .= '<div class="sg-slide-img ' . $uid . '">';
							$c .= wp_get_attachment_image($slide['img'], 'post-thumbnail');
							$c .= SG_Form::hidden($uid . '[slides][' . $id . '][img]', $slide['img']);
						$c .= '</div>';
					$c .= '</div>';
				$c .= '</div>';
			$c .= '</div>';
		}
		
		$c .= '<div class="sg-slide-top">';
			$c .= '<div class="sg-slide">';
				$c .= '<div class="sg-slide-in-add">';
					$c .= '<a id="' . $uid . '-add" class="button sg-slide-add" href="#">+</a>';
					$c .= SG_Form::hidden($uid . '[last]', $last, array('id' => $uid . '-last'));
				$c .= '</div>';
			$c .= '</div>';
		$c .= '</div>';
		
		$c .= '<div class="clear"></div>';
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
sg_post_nonce = "' . $nonce . '";
sg_slider_btn_name = "' . $btn_name . '";
sg_slider_ajaxurl = "' . $ajax_url . '";
jQuery(document).ready(function($){
	function ' . $uid . 'sg_get_slide(cur){
		var pID = jQuery("#post_ID").val() || 0;
		window.sg_current_upload_slide = $(cur).parent().attr("id");
		tb_show("Insert", "media-upload.php?post_id=" + pID + "&custom-media-upload=SI&type=image&TB_iframe=true");
	}

	$("#' . $uid . '-add").click(function(e){
		var i = $("#' . $uid . '-last").val();
		$("<div class=\"sg-slide-top\"><div class=\"sg-slide\"><div class=\"sg-slide-in\" id=\"' . $uid . '-" + i + "\" rel=\"' . $uid . '[slides][" + i + "]\"><a href=\"#\" class=\"button sg-slide-rm ' . $uid . '-rm\">-</a><div class=\"sg-slide-img ' . $uid . '\"></div></div></div>").insertBefore($("#' . $uid . '-add").parent().parent().parent());
		$("#' . $uid . '-last").val(++i);
		$(".' . $uid . '-rm").click(function(e){$(this).parent().parent().remove();return false;});
		$(".' . $uid . ':last").click(function(){' . $uid . 'sg_get_slide(this);return false;});
		return false;
	});
	
	$(".' . $uid . '-rm").click(function(e){
		$(this).parent().parent().parent().remove();
		return false;
	});
	
	$(".' . $uid . '").click(function(){
		' . $uid . 'sg_get_slide(this);
		return false;
	});
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, self::$_fields, self::$_description, $params, $defaults, $global, $post_id);
	}
	
	public function eBackLink()
	{
		if (self::$_vars['show_back'] == 'yes') {
			$get_posts = new WP_Query;
			$ppages = array();
			$pages = $get_posts->query('post_type=page&posts_per_page=-1');
			foreach ($pages as $page) {
				$post_custom = get_post_custom($page->ID);
				if ($post_custom['_wp_page_template'][0] == 'pg-portfolio.php') {
					$ppages[] = $page->ID;
				}
			}
			if (!empty($ppages)) {
				echo '<a href="' . get_permalink($ppages[0]) . '" class="button"><span>' . __('Back to all works', SG_TDN) . '<img src="' . get_template_directory_uri() . '/images/arr.gif" alt=""></span></a>';
			}
		}
	}
	
	public function showSlider($post_id = FALSE)
	{
		if ($post_id === FALSE) return (self::$_vars['slider']['value'] == self::USE_DEFAULT);
		
		$vars = self::_getVars(self::moduleName, 'sg_pos', NULL, $post_id);
		if (!empty($vars)) return ($vars['slider']['value'] == self::USE_DEFAULT);
		
		return FALSE;
	}
	
	public function eSlider($post_id = FALSE)
	{
		if ($post_id === FALSE) {
			foreach (self::$_vars['slider']['slides'] as $id => $slide) {
				echo wp_get_attachment_image($slide['img'], 'sg_portfolio_big', FALSE, array('title' => '#htmlcaption'));
			}
		} else {
			$vars = self::_getVars(self::moduleName, 'sg_pos', NULL, $post_id);
			if (!empty($vars)) {
				foreach ($vars['slider']['slides'] as $id => $slide) {
					echo wp_get_attachment_image($slide['img'], 'sg_portfolio_big2', FALSE, array('title' => '#htmlcaption'));
				}
			}
		}
	}

}