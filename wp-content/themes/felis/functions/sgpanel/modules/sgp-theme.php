<?php

class SGP_Theme_Module extends SGP_Module {
	
	const moduleName = 'Theme';

	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'type' => array(
			'name' => 'Type',
			'type' => 'select',
			'options' => array(
				'light' => 'Light',
				'dark' => 'Dark',
			),
			'default' => 'light',
			'help' => 'Dark or light variant of the theme',
		),
		'color' => array(
			'name' => 'Color',
			'type' => 'color',
			'default' => '#43A02A',
			'help' => 'Main theme color',
		),
		'patterns' => array(
			'name' => 'Pattern',
			'type' => 'pattern',
			'class' => 'sg-metabox-field sg-metabox-slides2',
			'default' => array(
				'value' => '-1',
				'value2' => '-2',
				'slides' => array(),
			),
			'help' => 'Select a patterns for the header and footer. The top checkbox is for header and the lower is for footer',
		),
		'header_images' => array(
			'name' => 'Header Image',
			'type' => 'slides',
			'class' => 'sg-metabox-field sg-metabox-slides2',
			'default' => array(
				'value' => self::USE_NONE,
				'slides' => array(),
			),
			'help' => 'Image in header instead of pattern (1920px x 587px preferably). If a few images uploaded then will be randomly displayed after every page load',
		),
	);
	
	protected static $_dslides = array(
		'-1'  => 'pattern3',
		'-2'  => 'pattern3-footer',
		'-3'  => 'pattern4',
		'-4'  => 'pattern4-footer',
		'-5'  => 'pattern5',
		'-6'  => 'pattern5-footer',
		'-7'  => 'pattern6',
		'-8'  => 'pattern6-footer',
		'-9'  => 'pattern7',
		'-10' => 'pattern7-footer',
		'-11' => 'pattern8',
		'-12' => 'pattern8-footer',
		'-13' => 'pattern9',
		'-14' => 'pattern9-footer',
		'-15' => 'pattern10',
		'-16' => 'pattern10-footer',
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SGP_Theme_Module;
		}
		return self::$instance;
	}
	
	public function inited()
	{
		return !is_null(self::$_vars);
	}
	
	public function initVars($params, $defaults)
	{
		self::$_vars = self::_initVars(self::moduleName, self::$_params, self::$_fields, $params, $defaults);
		return TRUE;
	}
	
	public function setVars($post_data)
	{
		$px = self::_getPx('sgp_', self::moduleName);
		
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
			$post_data[$px . '_header_images']['value'] = self::USE_NONE;
			$post_data[$px . '_header_images']['slides'] = array();
			$post_data[$px . '_header_images']['last'] = 0;
		} else {
			$post_data[$px . '_header_images']['value'] = self::USE_DEFAULT;
		}
		
		$patterns = array();
		
		if (isset($post_data[$px . '_patterns']['slides'])) {
			$slides = $post_data[$px . '_patterns']['slides'];
			foreach ($slides as $id => $slide) {
				if (!isset($slide['img']) OR empty($slide['img']) OR $slide['img'] == -1) {
					unset($post_data[$px . '_patterns']['slides'][$id]);
				} else {
					$patterns[] = $slide['img'];
				}
			}
		} else {
			$post_data[$px . '_patterns']['slides'] = array();
			$post_data[$px . '_patterns']['last'] = 0;
		}
		
		if (!isset($post_data[$px . '_patterns']['value'])) $post_data[$px . '_patterns']['value'] = -1;
		if (!isset($post_data[$px . '_patterns']['value2'])) $post_data[$px . '_patterns']['value2'] = -1;
		if ($post_data[$px . '_patterns']['value'] > 0 AND !in_array($post_data[$px . '_patterns']['value'], $patterns))
			$post_data[$px . '_patterns']['value'] = -1;
		if ($post_data[$px . '_patterns']['value2'] > 0 AND !in_array($post_data[$px . '_patterns']['value2'], $patterns))
			$post_data[$px . '_patterns']['value2'] = -1;
		
		return self::_setVars(self::moduleName, self::$_fields, $post_data);
	}
	
	public function resetVars()
	{
		return self::_resetVars(self::moduleName);
	}
	
	protected function _getColorField($uid, $params, $value, $default, $ug)
	{
		$c = SG_Form::input($uid, $value, array('id' => 'link-color'));
		$c .= '<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>';
		$c .= '<div id="colorPickerDiv"></div>';
		
		return $c;
	}
	
	protected function _getPatternField($uid, $params, $value, $default, $ug)
	{
		global $post_ID;
		$nonce = wp_create_nonce('set_post_thumbnail-' . (empty($post_ID) ? 0 : $post_ID));
		$btn_name = __('Get Pattern', SG_TDN);
		$ajax_url = get_template_directory_uri() . '/functions/modules/includes/pattern/ajax.php';
		
		$slides = (isset($value['slides'])) ? $value['slides'] : array();
		$last = (isset($value['last'])) ? $value['last'] : 0;
		
		$c = '';
		
		foreach (self::$_dslides as $id => $slide) {
			$c .= '<div class="sg-slide-top">';
				$c .= '<div class="sg-slide">';
					$c .= '<div class="sg-slide-in" id="' . $uid . '-' . $id . '" rel="' . $uid . '[slides][' . $id . ']">';
						$c .= '<div class="sg-slide-img-p">';
							$c .= '<span class="sg-pattern" style="background: url(\'' . get_template_directory_uri() . '/images/patterns/' . $slide . '.png\') ;"></span>';
							$c .= SG_Form::radio($uid . '[value]', $id, $id == $value['value'], array('class' => 'sg-pattern-top'));
							$c .= SG_Form::radio($uid . '[value2]', $id, $id == $value['value2'], array('class' => 'sg-pattern-btm'));
						$c .= '</div>';
					$c .= '</div>';
				$c .= '</div>';
			$c .= '</div>';
		}
		
		foreach ($slides as $id => $slide) {
			$c .= '<div class="sg-slide-top">';
				$c .= '<div class="sg-slide">';
					$c .= '<div class="sg-slide-in" id="' . $uid . '-' . $id . '" rel="' . $uid . '[slides][' . $id . ']">';
						$c .= '<a class="button sg-slide-rm ' . $uid . '-rm" href="#">-</a>';
						$c .= '<div class="sg-slide-img-p">';
							$c .= '<span class="sg-pattern" style="background: url(\'' . wp_get_attachment_url($slide['img']) . '\') ;"></span>';
							$c .= SG_Form::radio($uid . '[value]', $slide['img'], $slide['img'] == $value['value'], array('class' => 'sg-pattern-top'));
							$c .= SG_Form::radio($uid . '[value2]', $slide['img'], $slide['img'] == $value['value2'], array('class' => 'sg-pattern-btm'));
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
sg_pattern_btn_name = "' . $btn_name . '";
sg_pattern_ajaxurl = "' . $ajax_url . '";
jQuery(document).ready(function($){
	function ' . $uid . 'sg_get_slide(cur){
		var pID = jQuery("#post_ID").val() || 0;
		window.sg_current_upload_slide = $(cur).parent().attr("id");
		tb_show("Insert", "media-upload.php?post_id=" + pID + "&custom-media-upload=PP&type=image&TB_iframe=true");
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
	
	$(".sg-slide-img-p").click(function(e){
		var y = e.pageY - $(this).offset().top;
		if (y <= 90) {
			$(this).find(".sg-pattern-top").attr("checked", "checked");
		} else {
			$(this).find(".sg-pattern-btm").attr("checked", "checked");
		}
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
	
	public function getAdminContent($params, $defaults)
	{
		$c = self::_getAdminContent(self::moduleName, self::$_params, self::$_fields, self::$_description, $params, $defaults);
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){
	function sgp_get_theme_class(){
		var cd = $("select[name=sgp_Theme_type]");
		if (cd.val() == "dark") {
			$(".sgp-Theme").addClass("sgp-patterns-dark");
		} else {
			$(".sgp-Theme").removeClass("sgp-patterns-dark");
		}
	}
	
	sgp_get_theme_class();
	$("select[name=sgp_Theme_type]").change(sgp_get_theme_class);
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	public function eCSS()
	{
		$hcolor = (self::$_vars['type'] == 'light') ? '#E8E8E8' : '#282828';
		$fcolor = (self::$_vars['type'] == 'light') ? '#282828' : '#282828';
		$acolor = self::$_vars['color'];
		
		$hpv = (int) self::$_vars['patterns']['value'];
		$fpv = (int) self::$_vars['patterns']['value2'];
		
		$hpattern = ($hpv > 0) ? wp_get_attachment_url($hpv) : get_template_directory_uri() . '/images/patterns/' . self::$_dslides[$hpv] . '.png';
		$fpattern = ($fpv > 0) ? wp_get_attachment_url($fpv) : get_template_directory_uri() . '/images/patterns/' . self::$_dslides[$fpv] . '.png';
		
		$himg = '';
		
		if (self::$_vars['header_images']['value'] == self::USE_DEFAULT) {
			$slides = array();
			
			foreach (self::$_vars['header_images']['slides'] as $id => $slide) {
				$slides[] = wp_get_attachment_url($slide['img']);
			}
			
			if (count($slides) > 1) {
				$himg = $slides[rand(0, count($slides) - 1)];
			} else {
				$himg = $slides[0];
			}
		}
		
		echo '<style type="text/css">';
			echo '#top-container {background: ' . (empty($himg) ? 'url(' . $hpattern . ')' : 'url(' . $himg . ') no-repeat center top') . ' ' . $hcolor . ';}' . "\n";
			echo '#footer-wrap {background: url(' . $fpattern . ') ' . $fcolor . ';}' . "\n" . "\n";
			echo 'a:hover,p a,.clr,.short-tour h2 span,ul.navmenu li ul li a:hover,.tweet_text a,.post p span strong a:hover,#map-side-bar div.map-location a:hover,#footer-wrap div.tagcloud a:hover,p.auth-cat strong a:hover,.sidebar .widget_recent_comments a:hover {color:' . $acolor . ';}' . "\n";
			echo '.tipswift,ul.accordion li a.title:hover {border-color:' . $acolor . ';}' . "\n";
			echo '.nivo-caption p span,.nivo-caption p p,.breadcramp p,.breadcramp span,.tipswift-inner,.proj-img a:hover,.proj-img a.zoom:hover,.search-btn input:hover,#search div.search-btn input:hover,ul.accordion li a.title:hover,span.highlight-hl-theme,.inner-pages-slider div.cont a.hire {background-color:' . $acolor . ';}';
		echo '</style>';
		
		echo '<script type="text/javascript">sg_template_color = "' . $acolor . '";</script>';
	}

}