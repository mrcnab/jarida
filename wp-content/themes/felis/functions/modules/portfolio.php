<?php

class SG_Portfolio_Module extends SG_Module {
	
	const moduleName = 'Portfolio';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'posts_count' => array(
			'name' => 'Projects Count',
			'type' => 'select',
			'options' => array(
				'-1' => 'All',
				'6' => '6',
				'9' => '9',
				'12' => '12',
			),
			'default' => '9',
			'help' => 'Number of projects which will be displayed per page. Will be used animated filter for the portfolio if "All" value is selected',
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
			'help' => 'Projects from selected categories will be displayed in the portfolio page. If nothing is selected, it will display all projects',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Portfolio_Module;
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
		
		$tags = get_terms('portfolio_category', array('hide_empty' => FALSE));
		$topt = array();
		
		foreach ($tags as $tag) {
			$topt[$tag->term_id] = $tag->name;
		}
		
		$fields['required_categories']['options'] = $topt;
		
		$c = self::_getAdminContent(self::moduleName, $uniq, self::$_params, $fields, self::$_description, $params, $defaults, $global, $post_id);
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){
	function ' . $uniq . '_set_layout_type(){
		var cd = $("select[name=' . $uniq . 'Portfolio_posts_count]");
		if (cd.val() == "-1") {
			$("#sg-portfolio-layout .sg-layout-portfolio_a").parent().hide();
			if ($("#sg-portfolio-layout .sg-layout-portfolio_a").parent().find("input:first").attr("checked") == "checked") {
				$("#sg-portfolio-layout .sg-layout-portfolio_3a").parent().find("input:first").attr("checked", "checked");
			}
		} else {
			$("#sg-portfolio-layout .sg-layout-portfolio_a").parent().show();
		}
	}

	' . $uniq . '_set_layout_type();
	
	$("select[name=' . $uniq . 'Portfolio_posts_count]").change(' . $uniq . '_set_layout_type);
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
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