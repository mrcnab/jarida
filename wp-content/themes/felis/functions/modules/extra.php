<?php

class SG_Extra_Module extends SG_Module {
	
	const moduleName = 'Extra';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'icon-type' => array(
			'name' => 'Select Title Type',
			'type' => 'select',
			'options' => array(
				'icon' => 'Icon',
				'icon2' => 'Icon and Title',
			),
			'default' => 'icon',
			'help' => 'Select the type of icon (can be digit or icon)',
		),
		'icon' => array(
			'name' => 'Select Icon',
			'type' => 'icon',
			'options' => array(
				'icn1' => 'Bla Bla',
				'icn2' => 'Bla Bla',
				'icn3' => 'Bla Bla',
				'icn4' => 'Bla Bla',
				'icn5' => 'Bla Bla',
				'icn6' => 'Bla Bla',
			),
			'default' => 'icn1',
			'help' => 'Select an icon to be displayed before the text',
		),
		'icon2' => array(
			'name' => 'Select Icon',
			'type' => 'icon',
			'options' => array(
				'serv1' => 'Bla Bla',
				'serv2' => 'Bla Bla',
				'serv3' => 'Bla Bla',
				'serv4' => 'Bla Bla',
			),
			'default' => 'serv1',
			'help' => 'Select an icon to be displayed before the title',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Extra_Module;
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
		return self::_setVars(self::moduleName, $uniq, self::$_fields, $post_data, $post_id);
	}
	
	public function resetVars($uniq, $post_id = NULL)
	{
		return self::_resetVars(self::moduleName, $uniq, $post_id);
	}

	public function getMenuItem()
	{
		return __('Extra', SG_TDN);
	}
	
	protected function _getIconField($uid, $params, $value, $default, $ug)
	{	
		$c = '<div class="sg-icon-group" align="center">';
			foreach ($params['options'] as $oval => $oname) {
				$radio = SG_Form::radio($uid, $oval, $oval == $value);
				$img_href = get_template_directory_uri() . '/images/icons/' . $oval . '.png';
				$img = SG_HTML::image($img_href);
				$item = '<span class="sg-icon-' . $oval . '">' . $img  . '</span>' . $radio;
				$c .= SG_Form::label(NULL, $item, array('class' => 'sg-icon-item', 'title' => $oname));
			}
			$c .= '<div class="clear"></div>';
		$c .= '</div>';
		
		return $c;
	}
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		$c = self::_getAdminContent(self::moduleName, $uniq, self::$_params, self::$_fields, NULL, $params, $defaults, $global, $post_id);
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){
	function ' . $uniq . '_set_icon_type(){
		var cd = $("select[name=' . $uniq . 'Extra_icon-type]");
		if (cd.val() == "icon") {
			$("input[name=' . $uniq . 'Extra_icon2]").parent().parent().parent().parent().hide();
			$("input[name=' . $uniq . 'Extra_icon]").parent().parent().parent().parent().show();
		} else {
			$("input[name=' . $uniq . 'Extra_icon]").parent().parent().parent().parent().hide();
			$("input[name=' . $uniq . 'Extra_icon2]").parent().parent().parent().parent().show();
		}
	}
	
	$("#postdivrich").addClass("extra-editorcontainer");

	' . $uniq . '_set_icon_type();
	
	$("select[name=' . $uniq . 'Extra_icon-type]").change(' . $uniq . '_set_icon_type);
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	public function eExtraIcon($post_id, $title = '', $uniq = 'eal') {
		$vars = self::_getVars(self::moduleName, 'sg_' . $uniq, NULL, $post_id);
		if (!empty($vars)) {
			$img_href = get_template_directory_uri() . '/images/icons/' . $vars[$vars['icon-type']] . '.png';
			$class = ($vars['icon-type'] == 'icon') ? 'icn' : 'serv-icns';
			echo SG_HTML::image($img_href, array('class' => $class));
			echo ($vars['icon-type'] == 'icon') ? '' : '<div class="heading bg-none"><h3>' . __($title) . '</h3></div>';
		}
	}
}