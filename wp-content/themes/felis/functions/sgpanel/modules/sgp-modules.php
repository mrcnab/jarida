<?php

class SGP_Modules_Module extends SGP_Module {
	
	const moduleName = 'Modules';
	
	protected static $instance;
	protected static $_vars = NULL;
	
	protected static $_params = array();
	
	protected static $_fields = array(
		'SEO' => array(
			'name' => 'Enable SEO module',
			'type' => 'select',
			'options' => array(
				'yes' => 'Enable',
				'no' => 'Disable',
			),
			'default' => 'yes',
			'help' => 'Enable or Disable SEO module',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SGP_Modules_Module;
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
		return self::_setVars(self::moduleName, self::$_fields, $post_data);
	}
	
	public function resetVars()
	{
		return self::_resetVars(self::moduleName);
	}
	
	public function getAdminContent($params, $defaults)
	{
		return self::_getAdminContent(self::moduleName, self::$_params, self::$_fields, self::$_description, $params, $defaults);
	}
	
	public function enabled($module_name) {
		return (isset(self::$_vars[$module_name]) ? (self::$_vars[$module_name] == 'yes') : TRUE);
	}

}