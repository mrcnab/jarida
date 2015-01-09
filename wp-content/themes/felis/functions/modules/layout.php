<?php

class SG_Layout_Module extends SG_Module {
	
	const moduleName = 'Layout';
	
	protected static $instance;
	protected static $_vars = NULL;

	protected static $_params = array(
		'show_description' => TRUE,
		'used_layouts' => array('page_l', 'page_r', 'page_n', 'page_d'),
		'default_layout' => 'page_n',
	);
	
	protected static $_fields = array(
		'layout' => array(
			'name' => 'Layout',
			'type' => 'layout',
			'options' => array(
				'page_l' => 'Sidebar on Left',
				'page_r' => 'Sidebar on Right',
				'page_d' => 'Sidebars on Left and Right',
				'page_t' => 'Sidebar on Top',
				'page_n' => 'No Sidebar',
				'portfolio_2' => '2 Colum Portfolio',
				'portfolio_3' => '3 Colum Portfolio',
				'portfolio_4' => '4 Colum Portfolio',
				'portfolio_s' => 'Portfolio as Gallery',
				'portfolio_2a' => '2 Colum Portfolio and Ajax',
				'portfolio_3a' => '3 Colum Portfolio and Ajax',
				'portfolio_4a' => '4 Colum Portfolio and Ajax',
				'portfolio_a' => 'Portfolio as Accordion',
			),
			'default' => '',
			'show' => self::SHOW_ALL,
			'help' => 'Select the layout type',
		),
	);
	
	protected static $_description = 'Layout Setup';
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Layout_Module;
		}
		return self::$instance;
	}
	
	public function inited()
	{
		return !is_null(self::$_vars);
	}
	
	public function initVars($uniq, $params, $defaults, $global, $post_id)
	{
		$p = self::_getParams($params, self::$_params);
		$fields = self::$_fields;
		$fields['layout']['default'] = $p['default_layout'];
		
		self::$_vars = self::_initVars(self::moduleName, $uniq, self::$_params, $fields, $params, $defaults, $global, $post_id);
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
		return __('Layout', SG_TDN);
	}
	
	protected function _getLayoutField($uid, $params, $value, $default, $ug)
	{
		if ($ug) $params['options'][self::USE_GLOBAL] = 'Global (' . $params['options'][$default] . ')';
		
		$c = '<div class="sg-layout-group" align="center">';
			foreach ($params['options'] as $oval => $oname) {
				$radio = SG_Form::radio($uid, $oval, $oval == $value);
				$global = ($oval == self::USE_GLOBAL) ? 'GLOBAL' : '';
				$class = ($oval == self::USE_GLOBAL) ? $default : $oval;
				$item = '<span class="sg-layout-' . $class . '">' . $global  . '</span>' . $radio;
				$c .= SG_Form::label(NULL, $item, array('class' => 'sg-layout-item', 'title' => $oname));
			}
			$c .= '<div class="clear"></div>';
		$c .= '</div>';
		
		return $c;
	}
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		$p = self::_getParams($params, self::$_params);
		$description = ($p['show_description']) ? self::$_description : NULL;
		$fields = self::$_fields;
		$fields['layout']['default'] = $p['default_layout'];
		
		foreach (self::$_fields['layout']['options'] as $layout => $name) {
			if (!in_array($layout, $p['used_layouts'])) unset($fields['layout']['options'][$layout]);
		}
		
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, $fields, $description, $params, $defaults, $global, $post_id);
	}
	
	public function getLayout()
	{
		return self::$_vars['layout'];
	}

}