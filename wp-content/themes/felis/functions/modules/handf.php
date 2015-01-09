<?php

class SG_HandF_Module extends SG_Module {
	
	const moduleName = 'HandF';
	
	protected static $instance;
	protected static $_vars = NULL;
	
	protected static $_params = array(
		'social_list' => array(
			'soc_twitter',
			'soc_facebook',
			'soc_linkedin',
			'soc_digg',
			'soc_flickr',
			'soc_vimeo',
			'soc_youtube',
		),
	);
	
	protected static $_fields = array(
		'header_text' => array(
			'name' => 'Header Text',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'help' => 'Litle description of the page in the header',
		),
		'top_text' => array(
			'name' => 'Top Text',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Litle description in the top of the page',
		),
		'search' => array(
			'name' => 'Search',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'yes',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Show or hide search in the top of the page',
		),
		'header_images' => array(
			'name' => 'Header Images',
			'type' => 'slides',
			'class' => 'sg-metabox-field sg-metabox-slides2',
			'default' => array(
				'value' => self::USE_GLOBAL,
				'slides' => array(),
			),
			'show' => self::SHOW_ALL,
			'help' => 'Add your images into the narrow slider (156px x 980px preferably)',
		),
		'hire_us_url' => array(
			'name' => 'Hire Us Url',
			'type' => 'input',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Add link for the label at the right side of the narrow slider. The label will not be displayed if leave the field blank',
		),
		'near_posts' => array(
			'name' => 'Prev and Next Pages/Posts link',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'title' => 'Show Titles',
				'no' => 'Hide',
			),
			'default' => 'yes',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Show or hide previous and next post navigation',
		),
		'copyright' => array(
			'name' => 'Copyright in Footer',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '&copy; 2011 Felis - Flexible &amp; Multipurpose theme by <a href="http://themeforest.net/user/fireform?ref=fireform">Fireform</a>',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Paste your copyrights text here. You may use HTML tags and attributes',
		),
		'soc_txt' => array(
			'name' => 'Social Text in Footer',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => 'Get social with Us',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Paste your social text here',
		),
		'soc_twitter' => array(
			'name' => 'Social Twiter',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '#',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Enter the link to your Twitter account or leave this field blank',
		),
		'soc_facebook' => array(
			'name' => 'Social Facebook',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '#',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Enter the link to your Facebook account or leave this field blank',
		),
		'soc_linkedin' => array(
			'name' => 'Social LinkedIn',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '#',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Enter the link to your LinkedIn or leave this field blank',
		),
		'soc_digg' => array(
			'name' => 'Social Digg',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '#',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Enter the link to your Digg account or leave this field blank',
		),
		'soc_flickr' => array(
			'name' => 'Social Flickr',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '#',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Enter the link to your Flickr account or leave this field blank',
		),
		'soc_vimeo' => array(
			'name' => 'Social Vimeo',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '#',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Enter the link to your Vimeo account or leave this field blank',
		),
		'soc_youtube' => array(
			'name' => 'Social YouTube',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '#',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Enter the link to your YouTube account or leave this field blank',
		),
		'contactus_title' => array(
			'name' => 'Contact Widget Title',
			'type' => 'input',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Title for the contact widget in the footer as default',
		),
		'contactus_phone' => array(
			'name' => 'Contact Widget Phone Number',
			'type' => 'input',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Phone number for the contact widget in the footer as default',
		),
		'contactus_email' => array(
			'name' => 'Contact Widget Email',
			'type' => 'input',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Email for the contact widget in the footer as default',
		),
		'contactus_address' => array(
			'name' => 'Contact Widget Address',
			'type' => 'text',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Address for the contact widget in the footer as default',
		),
		'important_title' => array(
			'name' => 'Title for Widget Text ',
			'type' => 'input',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Title for the text widget in the footer as default',
		),
		'important_text' => array(
			'name' => 'Content for Widget Text',
			'type' => 'text',
			'default' => '',
			'show' => self::SHOW_GLOBAL,
			'help' => 'Content for the text widget in the footer as default',
		),
	);
	
	protected static $_description = 'Copyrights and social networks data';
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_HandF_Module;
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
		
		if (isset($post_data[$px . '_header_images']['slides'])) {
			$slides = $post_data[$px . '_header_images']['slides'];
			foreach ($slides as $id => $slide) {
				if (!isset($slide['img']) OR empty($slide['img']) OR $slide['img'] == -1) {
					unset($post_data[$px . '_header_images']['slides'][$id]);
				}
			}
		} else {
			$post_data[$px . '_header_images']['slides'] = array();
		}
		if (empty($post_data[$px . '_header_images']['slides'])) {
			$post_data[$px . '_header_images']['value'] = self::USE_GLOBAL;
			$post_data[$px . '_header_images']['slides'] = array();
			$post_data[$px . '_header_images']['last'] = 0;
		} else {
			$post_data[$px . '_header_images']['value'] = self::USE_DEFAULT;
		}
		
		return self::_setVars(self::moduleName, $uniq, self::$_fields, $post_data, $post_id);
	}
	
	public function resetVars($uniq, $post_id = NULL)
	{
		return self::_resetVars(self::moduleName, $uniq, $post_id);
	}

	public function getMenuItem()
	{
		return __('Header & Footer', SG_TDN);
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
		$fields = self::$_fields;
		if (isset($params['himg_mode'])) {
			foreach (self::$_fields as $id => $opt) {
				if (isset($opt['show']) AND $opt['show'] == self::SHOW_GLOBAL) $fields[$id]['show'] = self::SHOW_NONE;
			}
		}
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, $fields, self::$_description, $params, $defaults, $global, $post_id);
	}
	
	public function eTopText()
	{
		if (!empty(self::$_vars['top_text'])) {
			echo '&nbsp;<span class="phone">' . __(self::$_vars['top_text']) . '</span>';
		}
	}
	
	public function eCopyright()
	{
		echo __(self::$_vars['copyright']);
	}
	
	protected function isSocial()
	{
		foreach (self::$_params['social_list'] as $name) {
			if (!empty(self::$_vars[$name])) {
				return TRUE;
			}
		}
		return FALSE;
	}
	
	public function eSocial()
	{
		if (!$this->isSocial())	return;
		
		$titles = array(
			'soc_twitter' => 'Twitter',
			'soc_facebook' => 'Facebook',
			'soc_linkedin' => 'LinkedIn',
			'soc_digg' => 'Digg',
			'soc_flickr' => 'Flickr',
			'soc_vimeo' => 'Vimeo',
			'soc_youtube' => 'YouTube',
		);
		
		$c = '<div class="float-r social">';
			$c .= '<span class="float-l">' . __(self::$_vars['soc_txt']) . '</span>';
			$c .= '<ul class="float-r">';

			foreach (self::$_params['social_list'] as $name) {
				if (!empty(self::$_vars[$name])) {
					$c .= '<li><a href="' . self::$_vars[$name] . '" title="' . $titles[$name] . '" target="_blank">';
						$name = ($name == 'soc_linkedin') ? 'soc_in' : $name;
						$c .= '<img src="' . get_template_directory_uri() . '/images/soc-icns/' . str_replace('soc_', '', $name) . '.png" alt="">';
					$c .= '</a></li>';
				}
			}

			$c .= '</ul>';
		$c .= '</div>';
		
		echo $c;
	}
	
	public function getImportantSettings()
	{
		return array(
			'title' => __(self::$_vars['important_title']),
			'text' => __(self::$_vars['important_text']),
			'filter' => TRUE,
		);
	}
	
	public function getContactUsSettings()
	{
		return array(
			'title' => __(self::$_vars['contactus_title']),
			'phone' => self::$_vars['contactus_phone'],
			'email' => self::$_vars['contactus_email'],
			'address' => __(self::$_vars['contactus_address']),
		);
	}
	
	public function eHireUs()
	{
		echo empty(self::$_vars['hire_us_url']) ? '' : '<span class="corner float-r"><a class="float-r hire" href="' . self::$_vars['hire_us_url'] . '"></a></span>';
	}
	
	public function showHeaderText()
	{
		return !empty(self::$_vars['header_text']);
	}
	
	public function eHeaderText()
	{
		echo '<span class="float-l">' . __(self::$_vars['header_text']) . '</span>';
	}
	
	public function showNear()
	{
		return (self::$_vars['near_posts'] != 'no');
	}
	
	public function showSearch()
	{
		return (self::$_vars['search'] == 'yes');
	}
	
	public function nearType()
	{
		return self::$_vars['near_posts'];
	}
	
	public function getHeaderImagesCount()
	{
		return isset(self::$_vars['header_images']['slides']) ? count(self::$_vars['header_images']['slides']) : 0;
	}
	
	public function eHeaderImages()
	{
		if ($this->getHeaderImagesCount() > 0) {
			$atr = ($this->getHeaderImagesCount() > 1) ? array('title' => '#htmlcaption') : array();
			echo '<div id="head"' . ($this->getHeaderImagesCount() > 1 ? ' class="nivoSlider"' : '') . '>';
			foreach (self::$_vars['header_images']['slides'] as $id => $slide) {
				echo wp_get_attachment_image($slide['img'], 'sg_slider2', FALSE, $atr);
			}
			echo '</div>';
		}
	}
}