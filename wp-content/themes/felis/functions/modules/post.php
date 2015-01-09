<?php

class SG_Post_Module extends SG_Module {
	
	const moduleName = 'Post';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'show_thumbnail' => array(
			'name' => 'Show Hide Thumbnail',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'yes',
			'show' => self::SHOW_ALL,
			'help' => 'Show or hide post thumbnail',
		),
		'show_comments' => array(
			'name' => 'Show Hide Comments',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'yes',
			'show' => self::SHOW_ALL,
			'help' => 'Allow or disallow comments',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Post_Module;
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
		return __('Content', SG_TDN);
	}
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, self::$_fields, NULL, $params, $defaults, $global, $post_id);
	}
	
	public function showThumbnail()
	{
		return (self::$_vars['show_thumbnail'] == 'yes');
	}
	
	public function showComments()
	{
		return (self::$_vars['show_comments'] == 'yes');
	}
	
	public function showSearch()
	{
		return (self::$_vars['show_search'] == 'yes');
	}

}