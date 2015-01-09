<?php

class SG_Page_Module extends SG_Module {
	
	const moduleName = 'Page';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'top_module' => array(
			'name' => 'Module at top',
			'type' => 'select',
			'options' => array(
				self::USE_NONE => 'Hidden',
				'team' => 'Our Team',
				'extra' => 'Extras',
			),
			'default' => self::USE_NONE,
			'help' => 'Show or hide the module at the top (available Our team or Extras)',
		),
		'team_title' => array(
			'name' => 'Title for Our Team',
			'type' => 'input',
			'default' => 'Our team',
			'help' => 'Enter a title of our team to be displayed',
		),
		'team_text' => array(
			'name' => 'Our Team Text',
			'type' => 'text',
			'default' => '',
			'help' => 'Enter the text to be displayed from the left side of our team module',
		),
		'team_category' => array(
			'name' => 'Category of Our Team',
			'type' => 'select',
			'options' => array(),
			'default' => 0,
			'help' => 'Select categories of our team will be chosen from',
		),
		'extras_title' => array(
			'name' => 'Title for Extras',
			'type' => 'input',
			'default' => '',
			'help' => 'Enter a title of Extras to be displayed',
		),
		'extras_category' => array(
			'name' => 'Category of Extras',
			'type' => 'select',
			'options' => array(),
			'default' => 0,
			'help' => 'Select categories of extras will be chosen from',
		),
		'extras_count' => array(
			'name' => 'Extras Count',
			'type' => 'select',
			'options' => array(
				'2' => '2',
				'4' => '4',
				'6' => '6',
			),
			'default' => '4',
			'help' => 'Select an amount of extras to display',
		),
		'show_latest' => array(
			'name' => 'Latest From The Portfolio',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'no',
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
			'help' => 'Enter the number of recent works that you want to display in "Latest Works" module (will be used a slider frame, if more than 2)',
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
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Page_Module;
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
		$fields = self::$_fields;
		
		$categories = get_terms('extra_category', array('hide_empty' => FALSE));
		$ec = array(0 => 'All');
		
		foreach ($categories as $category) {
			$ec[$category->term_id] = $category->name;
		}
		
		$categories = get_terms('our-team_category', array('hide_empty' => FALSE));
		$tc = array(0 => 'All');
		
		foreach ($categories as $category) {
			$tc[$category->term_id] = $category->name;
		}
		
		$categories = get_terms('portfolio_category', array('hide_empty' => FALSE));
		$lc = array(0 => 'All');
		
		foreach ($categories as $category) {
			$lc[$category->term_id] = $category->name;
		}
		
		$fields['extras_category']['options'] = $ec;
		$fields['team_category']['options'] = $tc;
		$fields['latest_category']['options'] = $lc;
		
		$c = self::_getAdminContent(self::moduleName, $uniq, self::$_params, $fields, self::$_description, $params, $defaults, $global, $post_id);

		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){
	function ' . $uniq . '_set_module_type(){
		var cd = $("select[name=' . $uniq . 'Page_top_module]");
		if (cd.val() == "extra") {
			$("input[name=' . $uniq . 'Page_extras_title]").parent().parent().show();
			$("select[name=' . $uniq . 'Page_extras_category]").parent().parent().show();
			$("select[name=' . $uniq . 'Page_extras_count]").parent().parent().show();
			$("input[name=' . $uniq . 'Page_team_title]").parent().parent().hide();
			$("textarea[name=' . $uniq . 'Page_team_text]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_team_category]").parent().parent().hide();
		} else if (cd.val() == "team") {
			$("input[name=' . $uniq . 'Page_extras_title]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_extras_category]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_extras_count]").parent().parent().hide();
			$("input[name=' . $uniq . 'Page_team_title]").parent().parent().show();
			$("textarea[name=' . $uniq . 'Page_team_text]").parent().parent().show();
			$("select[name=' . $uniq . 'Page_team_category]").parent().parent().show();
		} else {
			$("input[name=' . $uniq . 'Page_extras_title]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_extras_category]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_extras_count]").parent().parent().hide();
			$("input[name=' . $uniq . 'Page_team_title]").parent().parent().hide();
			$("textarea[name=' . $uniq . 'Page_team_text]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_team_category]").parent().parent().hide();
		}
	}

	' . $uniq . '_set_module_type();
	
	$("select[name=' . $uniq . 'Page_top_module]").change(' . $uniq . '_set_module_type);
		
	function ' . $uniq . '_set_latest(){
		var cd = $("select[name=' . $uniq . 'Page_show_latest]");
		if (cd.val() == "yes") {
			$("input[name=' . $uniq . 'Page_latest_title]").parent().parent().show();
			$("select[name=' . $uniq . 'Page_latest_count]").parent().parent().show();
			$("select[name=' . $uniq . 'Page_latest_height]").parent().parent().show();
			$("textarea[name=' . $uniq . 'Page_latest_text]").parent().parent().show();
		} else {
			$("input[name=' . $uniq . 'Page_latest_title]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_latest_count]").parent().parent().hide();
			$("select[name=' . $uniq . 'Page_latest_height]").parent().parent().hide();
			$("textarea[name=' . $uniq . 'Page_latest_text]").parent().parent().hide();
		}
	}

	' . $uniq . '_set_latest();
	
	$("select[name=' . $uniq . 'Page_show_latest]").change(' . $uniq . '_set_latest);
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	public function getTopType()
	{
		return self::$_vars['top_module'];
	}
	
	public function showExtrasTitle()
	{
		return !empty(self::$_vars['extras_title']);
	}
	
	public function eExtrasTitle()
	{
		echo __(self::$_vars['extras_title']);
	}
	
	public function getExtrasCategory()
	{
		return self::$_vars['extras_category'];
	}
	
	public function getExtrasCount()
	{
		return self::$_vars['extras_count'];
	}
	
	public function eTeamTitle()
	{
		echo __(self::$_vars['team_title']);
	}
	
	public function eTeamText()
	{
		echo __(self::$_vars['team_text']);
	}
	
	public function getTeamCategory()
	{
		return self::$_vars['team_category'];
	}
	
	public function showLatest()
	{
		return (self::$_vars['show_latest'] == 'yes');
	}
	
	public function eLatestTitle()
	{
		echo __(self::$_vars['latest_title']);
	}
	
	public function showLatestEx()
	{
		return (self::$_vars['latest_height'] == 'yes');
	}
	
	public function eLatestText()
	{
		echo __(wpautop(self::$_vars['latest_text']));
	}
	
	public function getLatestCategory()
	{
		return self::$_vars['latest_category'];
	}
	
	
	public function getLatestCount()
	{
		return self::$_vars['latest_count'];
	}
}