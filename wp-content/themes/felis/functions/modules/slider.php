<?php

class SG_Slider_Module extends SG_Module {
	
	const moduleName = 'Slider';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'show' => array(
			'name' => 'Slider Visibility',
			'type' => 'radio',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'no',
			'help' => 'Show or hide the slider on the page',
		),
		'effect' => array(
			'name' => 'Effect',
			'type' => 'select',
			'options' => array(
				'random' => 'Random',
				'sliceDownRight' => 'Slice Down Right',
				'sliceDownLeft' => 'Slice Down Left',
				'sliceUpRight' => 'Slice Up Right',
				'sliceUpLeft' => 'Slice Up Left',
				'sliceUpDown' => 'Slice Up Down',
				'sliceUpDownLeft' => 'Slice Up Down Left',
				'fold' => 'Fold',
				'fade' => 'Fade',
				'boxRandom' => 'Box Random',
				'boxRain' => 'Box Rain',
				'boxRainReverse' => 'Box Rain Reverse',
				'boxRainGrow' => 'Box Rain Grow',
				'boxRainGrowReverse' => 'Box Rain Grow Reverse',
			),
			'default' => 'no',
			'help' => 'Animation effect',
		),
		'delay' => array(
			'name' => 'Delay',
			'type' => 'select',
			'options' => array(
				'3e3' => '3000 mc',
				'4e3' => '4000 mc',
				'5e3' => '5000 mc',
				'6e3' => '6000 mc',
				'7e3' => '7000 mc',
				'8e3' => '8000 mc',
				'9e3' => '9000 mc',
			),
			'default' => '3e3',
			'help' => 'Select the delay value before slide changing (milliseconds)',
		),
		'animation_time' => array(
			'name' => 'Animation Time',
			'type' => 'select',
			'options' => array(
				'300' => '300 mc',
				'400' => '400 mc',
				'500' => '500 mc',
				'600' => '600 mc',
				'700' => '700 mc',
				'800' => '800 mc',
				'900' => '900 mc',
			),
			'default' => '500',
			'help' => 'Select the duration value of sliding animation (milliseconds)',
		),
		'text' => array(
			'name' => 'Slider Text',
			'type' => 'text',
			'default' => '',
			'help' => 'Add your content. Allows HTML tags and attributes',
		),
		'slides' => array(
			'name' => 'Slides',
			'type' => 'slides',
			'class' => 'sg-metabox-field sg-metabox-slides',
			'default' => array(
				'slides' => array(),
				'value' => 0,
			),
			'help' => 'Add your images in the slider (980px x 416px preferably). Add Link (no link on the image if left #), Title and Description (will be displayed in the slider caption under Title)',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Slider_Module;
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
		
		if (isset($post_data[$px . '_slides']['slides'])) {
			$slides = $post_data[$px . '_slides']['slides'];
			foreach ($slides as $id => $slide) {
				if (!isset($slide['img']) OR empty($slide['img']) OR $slide['img'] == -1) {
					unset($post_data[$px . '_slides']['slides'][$id]);
				}
			}
			if (empty($post_data[$px . '_slides']['slides'])) {
				$post_data[$px . '_slides']['value'] = 0;
			}
		}
			
		return self::_setVars(self::moduleName, $uniq, self::$_fields, $post_data, $post_id);
	}
	
	public function resetVars($uniq, $post_id = NULL)
	{
		return self::_resetVars(self::moduleName, $uniq, $post_id);
	}

	public function getMenuItem()
	{
		return __('Slider', SG_TDN);
	}
	
	protected function _getSlidesField($uid, $params, $value, $default, $ug)
	{
		global $post_ID;
		$nonce = wp_create_nonce('set_post_thumbnail-' . $post_ID);
		$btn_name = __('Get Image', SG_TDN);
		$ajax_url = get_template_directory_uri() . '/functions/modules/includes/slider/ajax.php';
		
		$slides = (isset($value['slides'])) ? $value['slides'] : array();
		$last = (isset($value['value'])) ? $value['value'] : 0;
		
		$c = '';
		
		foreach ($slides as $id => $slide) {
			$c .= '<div class="sg-slide">';
				$c .= '<div class="sg-slide-in" id="' . $uid . '-' . $id . '" rel="' . $uid . '[slides][' . $id . ']">';
					$c .= '<a class="button sg-slide-rm ' . $uid . '-rm" href="#">-</a>';
					$c .= '<div class="sg-slide-img ' . $uid . '">';
						$c .= wp_get_attachment_image($slide['img'], 'post-thumbnail');
						$c .= SG_Form::hidden($uid . '[slides][' . $id . '][img]', $slide['img']);
					$c .= '</div>';
					$c .= '<div class="sg-slide-txt">';
						$ip = array('onfocus' => 'if (this.value==\'#\') this.value=\'\';',
									'onblur' => 'if (this.value==\'\'){this.value=\'#\'}');
						$iv = (empty($slide['url']) OR $slide['url'] == '#') ? '#' : $slide['url'];
						$c .= SG_Form::input($uid . '[slides][' . $id . '][url]', $iv, $ip);
						$c .= SG_Form::input($uid . '[slides][' . $id . '][title]', $slide['title']);
						$c .= SG_Form::textarea($uid . '[slides][' . $id . '][txt]', $slide['txt']);
					$c .= '</div>';
				$c .= '</div>';
			$c .= '</div>';
		}
		
		$c .= '<div class="sg-slide">';
			$c .= '<div class="sg-slide-in-add">';
				$c .= '<a id="' . $uid . '-add" class="button sg-slide-add" href="#">+</a>';
				$c .= SG_Form::hidden($uid . '[value]', $last, array('id' => $uid . '-last'));
			$c .= '</div>';
		$c .= '</div>';
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
sg_post_nonce = "' . $nonce . '";
sg_slider_btn_name = "' . $btn_name . '";
sg_slider_ajaxurl = "' . $ajax_url . '";
jQuery(document).ready(function($){
	function ' . $uid . 'sg_get_slide(cur){
		var pID = jQuery("#post_ID").val();
		window.sg_current_upload_slide = $(cur).parent().attr("id");
		tb_show("Insert", "media-upload.php?post_id=" + pID + "&custom-media-upload=SI&type=image&TB_iframe=true");
	}

	$("#' . $uid . '-add").click(function(e){
		var i = $("#' . $uid . '-last").val();
		$("<div class=\"sg-slide\"><div class=\"sg-slide-in\" id=\"' . $uid . '-" + i + "\" rel=\"' . $uid . '[slides][" + i + "]\"><a href=\"#\" class=\"button sg-slide-rm ' . $uid . '-rm\">-</a><div class=\"sg-slide-img ' . $uid . '\"></div><div class=\"sg-slide-txt\"><input type=\"text\" onblur=\"if (this.value==\'\'){this.value=\'#\'}\" onfocus=\"if (this.value==\'#\') this.value=\'\';\" value=\"#\" name=\"' . $uid . '[slides][" + i + "][url]\"><input type=\"text\" value=\"\" name=\"' . $uid . '[slides][" + i + "][title]\"> <textarea name=\"' . $uid . '[slides][" + i + "][txt]\"></textarea></div></div></div>").insertBefore($("#' . $uid . '-add").parent().parent());
		$("#' . $uid . '-last").val(++i);
		$(".' . $uid . '-rm").click(function(e){$(this).parent().parent().remove();return false;});
		$(".' . $uid . ':last").click(function(){' . $uid . 'sg_get_slide(this);return false;});
		return false;
	});
	
	$(".' . $uid . '-rm").click(function(e){
		$(this).parent().parent().remove();
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
		$c = self::_getAdminContent(self::moduleName, $uniq, self::$_params, self::$_fields, self::$_description, $params, $defaults, $global, $post_id);
		
		return $c;
	}
	
	public function eHeaderText()
	{
		if (!empty(self::$_vars['text'])) {
			echo '<div class="inner">';
				echo '<div class="short-tour">';
					echo __(self::$_vars['text']);
				echo '</div>';
			echo '</div>';
		}
	}
	
	public function getSlidesCount()
	{
		return isset(self::$_vars['slides']['slides']) ? count(self::$_vars['slides']['slides']) : 0;
	}
	
	public function eSlider()
	{
		if (self::$_vars['show'] == 'yes' AND $this->getSlidesCount() > 1) {
			$js = '<script type="text/javascript">';
			$js .= '
//<![CDATA[
	jQuery("#slider").nivoSlider({
		effect: "' . self::$_vars['effect'] . '",
		slices: 15,
		boxCols: 8,
		boxRows: 4,
		animSpeed: ' . self::$_vars['animation_time'] . ',
		pauseTime: ' . self::$_vars['delay'] . ',
		startSlide: 0,
		directionNav: true,
		directionNavHide: true,
		controlNav: true,
		keyboardNav: true,
		pauseOnHover: true,
		captionOpacity: 1
	});
//]]>
			';
			$js .= '</script>';
			$c = 1;
			$cn = '';
			echo '<div class="main-slider">';
				echo '<div id="slider" class="nivoSlider">';
				foreach (self::$_vars['slides']['slides'] as $id => $slide) {
					$atr = array('title' => '#htmlcaption' . $c);
					$cn .= '<div id="htmlcaption' . $c++ . '" class="nivo-html-caption">';
						$cn .= '<p>' . strip_tags(__($slide['title'])) . '</p>';
						$cn .= '<span>' . nl2br(strip_tags(__($slide['txt']))) . '</span>';
					$cn .= '</div>';
					echo (!empty($slide['url']) AND $slide['url'] != '#') ? '<a href="' . $slide['url'] . '">' : '';
					echo wp_get_attachment_image($slide['img'], 'sg_slider', FALSE, $atr);
					echo (!empty($slide['url']) AND $slide['url'] != '#') ? '</a>' : '';
				}
				echo '</div>';
				echo $cn;
				echo $js;
			echo '</div>';
		} elseif (self::$_vars['show'] == 'yes' AND $this->getSlidesCount() == 0) {
			echo sg_message(__('No Slides in Slider', SG_TDN));
		} elseif (self::$_vars['show'] == 'yes' AND $this->getSlidesCount() == 1) {
			echo sg_message(__('Add more slides', SG_TDN));
		}
	}
	
}