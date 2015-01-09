<?php

class SGP_General_Module extends SGP_Module {
	
	const moduleName = 'General';

	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'logo' => array(
			'name' => 'Logo',
			'type' => 'logo',
			'default' => '',
			'help' => 'Upload a logo image. Default logo gets applied if the input field is left blank. Logo dimension - 40px in height preferably (if your logo is larger you might need to modify the style.css to align it perfectly)',
		),
		'favicon' => array(
			'name' => 'Favicon',
			'type' => 'favicon',
			'default' => '',
			'help' => 'Upload the favicon image (16x16px preferably)',
		),
		'analytics_code' => array(
			'name' => 'Analytics code',
			'type' => 'text',
			'default' => '',
			'help' => 'Enter your Google analytics tracking Code here. It will automatically be added to the themes footer so google can track your visitors behaviour',
		),
		'portfolio_slug' => array(
			'name' => 'Portfolio Base',
			'type' => 'input',
			'default' => 'portfolio',
			'help' => 'Slug for portfolio posts (if left blang it will be like "portfolio"',
		),
		'portfolio_cslug' => array(
			'name' => 'Portfolio Category Base',
			'type' => 'input',
			'default' => '',
			'help' => 'Slug for portfolio categorys (if left blang it will be like "{Portfolio Base}-category")',
		),
		'portfolio_tslug' => array(
			'name' => 'Portfolio Tag Base',
			'type' => 'input',
			'default' => '',
			'help' => 'Slug for portfolio tags (if left blang it will be like "{Portfolio Base}-tag")',
		),
	);
	
	protected static $_description = NULL;
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SGP_General_Module;
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
		update_option(SG_SLUG . 'sgp-general-changed', TRUE);
		return self::_setVars(self::moduleName, self::$_fields, $post_data);
	}
	
	public function resetVars()
	{
		return self::_resetVars(self::moduleName);
	}
	
	protected function _getLogoField($uid, $params, $value, $default, $ug)
	{
		$btn_name = __('Get Logo', SG_TDN);
		$durl = get_template_directory_uri() . '/images/content/logo.png';
		
		if (empty($value)) {
			$img = '<img src="' . $durl . '" />';
			$clear = ' style="display: none;"';
		} else {
			$img = '<img src="' . $value . '" />';
			$clear = '';
		}
		
		$c = '<span class="sg-upload-btns">';
		$c .= '<input type="submit" value="' . __('Load Logo', SG_TDN) . '" class="button" id="' . $uid . '_load" name="' . $uid . '_load">';
		$c .= '&nbsp;<input type="submit" value="' . __('Clear Logo', SG_TDN) . '" class="button sg-photo-clear" id="' . $uid . '_clear" name="' . $uid . '_clear"' . $clear . '><br /><br />';
		$c .= '</span>';
		$c .= '<span id="' . $uid . '_img">' . $img . '</span>';
		
		$c .= SG_Form::hidden($uid, $value);
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){
	if ($("input[name=' . $uid . ']").val() != "") {
		$("#' . $uid . '_clear").show();
	}
	$("#' . $uid . '_clear").click(function() {
		$("input[name=' . $uid . ']").val("");
		$("#' . $uid . '_img").html("<img src=\"' . $durl . '\" />");
		$("#' . $uid . '_clear").hide();
		return false;
	});
	$("#' . $uid . '_load").click(function() {
		window.sg_media_upload_btn_name = "' . $btn_name . '";
		window.send_to_editor = function(html) {
			var returned = $(html);
			var img = returned.attr("src") || returned.find("img").attr("src") || returned.attr("href");
			var width = returned.attr("width") || returned.find("img").attr("width");
			var height = returned.attr("height") || returned.find("img").attr("height");
			img = img.replace("-" + width + "x" + height + ".", ".");
			$("input[name=' . $uid . ']").val(img);
			$("#' . $uid . '_img").html("<img src=\"" + img + "\" />");
			$("#' . $uid . '_clear").show();
			tb_remove();
		}
		tb_show("Insert", "media-upload.php?post_id=0&custom-media-upload=LFI&type=image&TB_iframe=true");
		return false;
	});
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	protected function _getFaviconField($uid, $params, $value, $default, $ug)
	{
		$btn_name = __('Get FavIcon', SG_TDN);
		
		if (empty($value)) {
			$img = '';
			$clear = ' style="display: none;"';
		} else {
			$img = '<img src="' . $value . '" />';
			$clear = '';
		}
		
		$c = '<span class="sg-upload-btns">';
		$c .= '<input type="submit" value="' . __('Load FavIcon', SG_TDN) . '" class="button" id="' . $uid . '_load" name="' . $uid . '_load">';
		$c .= '&nbsp;<input type="submit" value="' . __('Clear FavIcon', SG_TDN) . '" class="button sg-photo-clear" id="' . $uid . '_clear" name="' . $uid . '_clear"' . $clear . '><br /><br />';
		$c .= '</span>';
		$c .= '<span id="' . $uid . '_img">' . $img . '</span>';
		
		$c .= SG_Form::hidden($uid, $value);
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){
	if ($("input[name=' . $uid . ']").val() != "") {
		$("#' . $uid . '_clear").show();
	}
	$("#' . $uid . '_clear").click(function() {
		$("input[name=' . $uid . ']").val("");
		$("#' . $uid . '_img").html("");
		$("#' . $uid . '_clear").hide();
		return false;
	});
	$("#' . $uid . '_load").click(function() {
		window.sg_media_upload_btn_name = "' . $btn_name . '";
		window.send_to_editor = function(html) {
			var returned = $(html);
			var img = returned.attr("src") || returned.find("img").attr("src") || returned.attr("href");
			$("input[name=' . $uid . ']").val(img);
			$("#' . $uid . '_img").html("<img src=\"" + img + "\" />");
			$("#' . $uid . '_clear").show();
			tb_remove();
		}
		tb_show("Insert", "media-upload.php?post_id=0&custom-media-upload=LFI&type=image&TB_iframe=true");
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
		return self::_getAdminContent(self::moduleName, self::$_params, self::$_fields, self::$_description, $params, $defaults);
	}
	
	public function eFavIcon()
	{
		if (!empty(self::$_vars['favicon'])) {
			$path = str_replace(str_replace(array('www.', 'https://', 'http://'), '', site_url()), ABSPATH, str_replace(array('www.', 'https://', 'http://'), '', self::$_vars['favicon']));
			if (file_exists($path)) {
				$type = SG_File::mime($path);
				echo '<link rel="icon" type="' . $type . '" href="' . self::$_vars['favicon'] . '">';
				echo '<link rel="profile" href="http://gmpg.org/xfn/11" />';
			}
		}
	}
	
	public function getLogoURL()
	{
		if (empty(self::$_vars['logo'])) {
			return get_template_directory_uri() . '/images/content/logo.png';
		} else {
			return self::$_vars['logo'];
		}
	}
	
	public function eLogoURL()
	{
		echo $this->getLogoURL();
	}
	
	public function eAnalyticsCode()
	{
		echo self::$_vars['analytics_code'];
	
	}
	
	public function getPortfolioSlug()
	{
		$slug = (isset(self::$_vars['portfolio_slug'])) ? str_replace(' ', '-', trim(self::$_vars['portfolio_slug'])) : '';
		return (empty($slug)) ? 'portfolio' : $slug;
	}
	
	public function getPortfolioCSlug()
	{
		$slug = (isset(self::$_vars['portfolio_cslug'])) ? str_replace(' ', '-', trim(self::$_vars['portfolio_cslug'])) : '';
		return (empty($slug)) ? $this->getPortfolioSlug() . '-category' : $slug;
	}
	
	public function getPortfolioTSlug()
	{
		$slug = (isset(self::$_vars['portfolio_cslug'])) ? str_replace(' ', '-', trim(self::$_vars['portfolio_cslug'])) : '';
		return (empty($slug)) ? $this->getPortfolioSlug() . '-tag' : $slug;
	}
	
}