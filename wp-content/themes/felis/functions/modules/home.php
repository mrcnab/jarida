<?php

class SG_Home_Module extends SG_Module {
	
	const moduleName = 'Home';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'show_extras' => array(
			'name' => 'Show Extras',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'no',
			'help' => 'Hide or show Extras module on the page (show max 6 posts)',
		),
		'extras_title' => array(
			'name' => 'Extras Title',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'help' => 'Enter Extras Title',
		),
		'extras_category' => array(
			'name' => 'Category of Extras',
			'type' => 'select',
			'options' => array(),
			'default' => 0,
			'help' => 'Select categories of extras will be chosen from',
		),
		'show_latest' => array(
			'name' => 'Latest From The Portfolio',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'yes',
			'help' => 'Show or hide "Latest Works" module (Will be displayed only posts with thumbnails)',
		),
		'latest_title' => array(
			'name' => 'Title for Latest From The Portfolio',
			'type' => 'input',
			'default' => 'Our latest works',
			'help' => 'Enter a title of "Latest Works" to be displayed',
		),
		'latest_category' => array(
			'name' => 'Category for Latest From The Portfolio',
			'type' => 'select',
			'options' => array(),
			'default' => 0,
			'help' => 'Select categories of "Latest Works" will be chosen from',
		),
		'latest_count' => array(
			'name' => 'Latest From The Portfolio Count',
			'type' => 'select',
			'options' => array(
				'2' => '2',
				'4' => '4',
				'6' => '6',
				'8' => '8',
				'10' => '10',
			),
			'default' => '6',
			'help' => 'Enter the number of recent works that you want to display in "Latest Works" module (will be used a slider, if more than 2)',
		),
		'latest_height' => array(
			'name' => 'Latest From The Portfolio Images',
			'type' => 'select',
			'options' => array(
				'yes' => 'Image + text',				
				'no' => 'Only Image',
			),
			'default' => 'yes',
			'help' => 'Choose the type of displaying latest portfolio posts',
		),
		'latest_text' => array(
			'name' => 'Latest From The Portfolio Text',
			'type' => 'text',
			'default' => '',
			'help' => 'Enter the text to be displayed from the left side of lastest from portfolio',
		),
	);
	
	protected static $_description = 'You can show or hide modules on the home page';
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Home_Module;
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
		if ($post_data['page_template'] == 'pg-home.php') {
			update_option('show_on_front', 'page');
			update_option('page_on_front', $post_data['post_ID']);
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
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		$fields = self::$_fields;
		
		$categories = get_terms('extra_category', array('hide_empty' => FALSE));
		$ec = array(0 => 'All');
		
		foreach ($categories as $category) {
			$ec[$category->term_id] = $category->name;
		}
		
		$categories = get_terms('portfolio_category', array('hide_empty' => FALSE));
		$lc = array(0 => 'All');
		
		foreach ($categories as $category) {
			$lc[$category->term_id] = $category->name;
		}
		
		$fields['extras_category']['options'] = $ec;
		$fields['latest_category']['options'] = $lc;
		
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, $fields, self::$_description, $params, $defaults, $global, $post_id);
	}
	
	public function showExtras()
	{
		return (self::$_vars['show_extras'] == 'yes');
	}
	
	public function showExtrasTitle()
	{
		return !empty(self::$_vars['extras_title']);
	}
	
	public function showLatest()
	{
		return (self::$_vars['show_latest'] == 'yes');
	}
	
	public function showLatestEx()
	{
		return (self::$_vars['latest_height'] == 'yes');
	}
	
	public function getExtrasCategory()
	{
		return self::$_vars['extras_category'];
	}
	
	public function getLatestCategory()
	{
		return self::$_vars['latest_category'];
	}
	
	public function eExtrasTitle()
	{
		echo __(self::$_vars['extras_title']);
	}
	
	public function eLatestTitle()
	{
		echo __(self::$_vars['latest_title']);
	}
	
	public function eLatestText()
	{
		echo __(wpautop(self::$_vars['latest_text']));
	}
	
	public function getLatestCount()
	{
		return self::$_vars['latest_count'];
	}
}