<?php

class SG_Blog_Module extends SG_Module {
	
	const moduleName = 'Blog';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'big_posts_count' => array(
			'name' => 'Big Posts Count',
			'type' => 'select',
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'10' => '10',
				'20' => '20',
			),
			'default' => '1',
			'help' => 'Number of big posts which will be displayed per page',
		),
		'posts_count' => array(
			'name' => 'Small Posts Count',
			'type' => 'select',
			'options' => array(
				'0' => '0',
				'2' => '2',
				'4' => '4',
				'6' => '6',
				'8' => '8',
				'10' => '10',
				'12' => '12',
				'14' => '14',
				'16' => '16',
			),
			'default' => '4',
			'help' => 'Number of small posts which will be displayed per page',
		),
		'required_categories' => array(
			'name' => 'Select Required Categories',
			'type' => 'select2',
			'options' => array(),
			'default' => array(
				'value' => self::USE_ALL,
				'custom' => NULL,
			),
			'show_none' => FALSE,
			'help' => 'Posts from selected categories will be displayed in the blog. If nothing selected all posts will be shown.',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Blog_Module;
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
		return __('Theme', SG_TDN);
	}
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		$fields = self::$_fields;
		
		$cats = get_terms('category', array('hide_empty' => FALSE));
		$topc = array();
		
		foreach ($cats as $cat) {
			$topc[$cat->term_id] = $cat->name;
		}
		
		$fields['required_categories']['options'] = $topc;
		
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, $fields, self::$_description, $params, $defaults, $global, $post_id);
	}
	
	public function getBigPostsCount()
	{
		return self::$_vars['big_posts_count'];
	}
	
	public function getPostsCount()
	{
		return self::$_vars['posts_count'];
	}
	
	public function getRequiredCategories()
	{
		if (self::$_vars['required_categories']['value'] == self::USE_ALL) return '';
		return self::$_vars['required_categories']['custom'];
	}
	
}