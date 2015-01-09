<?php

require_once TEMPLATEPATH . '/functions/apperance/sidebars.php';

class SG_Sidebars_Module extends SG_Module {
	
	const moduleName = 'Sidebars';
	
	protected static $instance;
	protected static $_vars = NULL;

	protected static $_params = array(
		'used_sidebars' => array(),
		'gl_used_sidebars' => array(),
	);
	
	protected static $_fields = array(
		'content' => array(
			'name' => 'Sidebar in content',
			'type' => 'select',
			'options' => array(),
			'default' => 'right_sidebar',
			'show' => self::SHOW_ALL,
			'help' => 'Choose the Sidebar which will be displayed at the side of content',
		),
		'footer' => array(
			'name' => 'Sidebar in footer',
			'type' => 'select',
			'options' => array(),
			'default' => self::USE_NONE,
			'show' => self::SHOW_ALL,
			'help' => 'Widgets from the selected sidebar will be displayed in the footer',
		),
	);
	
	protected static $_description = 'To create a new sidebar you need to go to the "Theme Options -> Sidebars". In order to fill the sidebar you need to go to "Appearance -> Widgets" and add widgets';
	
	protected static $_sidebar_options = array(
		self::USE_NONE => '-Hide-',
		self::USE_DEFAULT => '-Default-',
	);


	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Sidebars_Module;
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
		$us = is_null($post_id) ? $p['gl_used_sidebars'] : $p['used_sidebars'];
		$fields = self::$_fields;
		
		$sidebars_list = sg_get_sidebars();
		
		foreach ($fields as $field => $field_opt) {
			if (isset($us[$field])) {
				$opt = is_array($us[$field]) ? $us[$field] : array(TRUE, $us[$field]);
				$sidebars = array();
				foreach ($sidebars_list as $id => $ps) {
					if ($ps['pos'] == $field) $sidebars[$id] = $ps['name'];
				}
				$opt_options = array_merge(self::$_sidebar_options, $sidebars);
				if (!$opt[0]) unset($opt_options[self::USE_NONE]);
				if (!$opt[1]) unset($opt_options[self::USE_DEFAULT]);
				$opt_default = ($opt[1]) ? self::USE_DEFAULT : $fields[$field]['default'];
				$fields[$field]['options'] = $opt_options;
				$fields[$field]['default'] = $opt_default;
			} else {
				$fields[$field]['show'] = self::SHOW_NONE;
			}
		}
		
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
		return __('Sidebars', SG_TDN);
	}
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		$p = self::_getParams($params, self::$_params);
		$us = is_null($post_id) ? $p['gl_used_sidebars'] : $p['used_sidebars'];
		$fields = self::$_fields;
		
		$sidebars_list = sg_get_sidebars();
		
		foreach ($fields as $field => $field_opt) {
			if (isset($us[$field])) {
				$opt = is_array($us[$field]) ? $us[$field] : array(TRUE, $us[$field]);
				$sidebars = array();
				foreach ($sidebars_list as $id => $ps) {
					if ($ps['pos'] == $field) $sidebars[$id] = $ps['name'];
				}
				$opt_options = array_merge(self::$_sidebar_options, $sidebars);
				if (!$opt[0]) unset($opt_options[self::USE_NONE]);
				if (!$opt[1]) unset($opt_options[self::USE_DEFAULT]);
				$opt_default = ($opt[1]) ? self::USE_DEFAULT : $fields[$field]['default'];
				$fields[$field]['options'] = $opt_options;
				$fields[$field]['default'] = $opt_default;
			} else {
				$fields[$field]['show'] = self::SHOW_NONE;
			}
		}
		
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, $fields, self::$_description, $params, $defaults, $global, $post_id);
	}
	
	public function getSidebar($position) {
		return self::$_vars[$position];
	}
	
	public function getSidebarName($sbid) {
		$sidebars_list = sg_get_sidebars();
		return isset($sidebars_list[$sbid]) ? $sidebars_list[$sbid]['name'] : $sbid;
	}

}