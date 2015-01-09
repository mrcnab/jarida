<?php

class SG_OurTeam_Module extends SG_Module {
	
	const moduleName = 'OurTeam';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'gender' => array(
			'name' => 'Gender',
			'type' => 'select',
			'options' => array(
				'male' => 'Male',
				'female' => 'Female',
			),
			'default' => 'male',
			'help' => 'Choose the gender of a team member',
		),
		'position' => array(
			'name' => 'Position',
			'type' => 'input',
			'default' => '',
			'help' => 'Choose the position of a team member',
		),
		'photo' => array(
			'name' => 'Photo',
			'type' => 'ot',
			'default' => '',
			'help' => 'Get a photo of a team member',
		),
		'soc1' => array(
			'name' => 'First Social',
			'type' => 'select',
			'options' => array(
				'none' => 'None',
				'skype-icn' => 'Skype',
				'twitter-icn' => 'Twitter',
				'facebook-icn' => 'Facebook',
				'in-icn' => 'LinkedIn',
			),
			'default' => 'none',
			'help' => 'Choose social profile icon',
		),
		'soc1_url' => array(
			'name' => 'First Social URL',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'help' => 'Enter the link to your social network profile (for Skype use skype:username?call)',
		),
		'soc2' => array(
			'name' => 'Second Social',
			'type' => 'select',
			'options' => array(
				'none' => 'None',
				'skype-icn' => 'Skype',
				'twitter-icn' => 'Twitter',
				'facebook-icn' => 'Facebook',
				'in-icn' => 'LinkedIn',
			),
			'default' => 'none',
			'help' => 'Choose social profile icon',
		),
		'soc2_url' => array(
			'name' => 'Second Social URL',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'help' => 'Enter the link to your social network profile (for Skype use skype:username?call)',
		),
		'soc3' => array(
			'name' => 'Last Social',
			'type' => 'select',
			'options' => array(
				'none' => 'None',
				'skype-icn' => 'Skype',
				'twitter-icn' => 'Twitter',
				'facebook-icn' => 'Facebook',
				'in-icn' => 'LinkedIn',
			),
			'default' => 'none',
			'help' => 'Choose social profile icon',
		),
		'soc3_url' => array(
			'name' => 'Last Social URL',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'help' => 'Enter the link to your social network profile (for Skype use skype:username?call)',
		),
	);
	
	protected static $_description = 'Enter the name of a team member in the post title and configure settings below';
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_OurTeam_Module;
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
		return __('Our Team', SG_TDN);
	}

	protected function _getOtField($uid, $params, $value, $default, $ug)
	{
		global $post_ID;
		$nonce = wp_create_nonce('set_post_thumbnail-' . $post_ID);
		$btn_name = __('Get Photo', SG_TDN);
		$img = wp_get_attachment_image(get_post_meta($post_ID, '_thumbnail_id', true), 'post-thumbnail');
		$clear = empty($img) ? ' style="display: none;"' : '';
		
		$c = '<span class="sg-upload-btns">';
		$c .= '<input type="submit" value="' . __('Load Photo', SG_TDN) . '" class="button" id="' . $uid . '_load" name="' . $uid . '_load">';
		$c .= '&nbsp;<input type="submit" value="' . __('Clear Photo', SG_TDN) . '" class="button sg-photo-clear" id="' . $uid . '_clear" name="' . $uid . '_clear"' . $clear . '><br /><br />';
		$c .= '</span>';
		$c .= '<span id="' . $uid . '_img">' . $img . '</span>';
		
		$c .= SG_Form::hidden($uid, '');
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
sg_post_nonce = "' . $nonce . '";
sg_current_uid = "' . $uid . '";
sg_media_upload_btn_name = "' . $btn_name . '";
jQuery(document).ready(function($){
	if ($("input[name=' . $uid . ']").val() != "") {
		$("#' . $uid . '_clear").show();
	}
	$("#' . $uid . '_clear").click(function() {
		window.SGRemoveThumbnail();
		$("#' . $uid . '_clear").hide();
		return false;
	});	
	$("#' . $uid . '_load").click(function() {
		var pID = jQuery("#post_ID").val();
		tb_show("Insert", "media-upload.php?post_id=" + pID + "&custom-media-upload=PI&type=image&TB_iframe=true");
		return false;
	});
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	public function getAdminContent($uniq, $params, $defaults, $global = NULL, $post_id = NULL)
	{
		$c = self::_getAdminContent(self::moduleName, $uniq, self::$_params, self::$_fields, self::$_description, $params, $defaults, $global, $post_id);
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){	
	function ' . $uniq . '_set_soc(){
		if ($("select[name=' . $uniq . 'OurTeam_soc1]").val() == "none") {
			$("input[name=' . $uniq . 'OurTeam_soc1_url]").parent().parent().hide();
			$("input[name=' . $uniq . 'OurTeam_soc1_url]").val("");
		} else {
			$("input[name=' . $uniq . 'OurTeam_soc1_url]").parent().parent().show();
		}
		if ($("select[name=' . $uniq . 'OurTeam_soc2]").val() == "none") {
			$("input[name=' . $uniq . 'OurTeam_soc2_url]").parent().parent().hide();
			$("input[name=' . $uniq . 'OurTeam_soc2_url]").val("");
		} else {
			$("input[name=' . $uniq . 'OurTeam_soc2_url]").parent().parent().show();
		}
		if ($("select[name=' . $uniq . 'OurTeam_soc3]").val() == "none") {
			$("input[name=' . $uniq . 'OurTeam_soc3_url]").parent().parent().hide();
			$("input[name=' . $uniq . 'OurTeam_soc3_url]").val("");
		} else {
			$("input[name=' . $uniq . 'OurTeam_soc3_url]").parent().parent().show();
		}
	}
	
	$("#postdivrich").addClass("extra-editorcontainer");

	' . $uniq . '_set_soc();
	
	$("select[name=' . $uniq . 'OurTeam_soc1]").change(' . $uniq . '_set_soc);
	$("select[name=' . $uniq . 'OurTeam_soc2]").change(' . $uniq . '_set_soc);
	$("select[name=' . $uniq . 'OurTeam_soc3]").change(' . $uniq . '_set_soc);
});
//]]>
			';
		$c .= '</script>';
		
		return $c;
	}
	
	public function getPerson($post_id, $uniq = 'otl') {
		$vars = self::_getVars(self::moduleName, 'sg_' . $uniq, NULL, $post_id);
		
		if (!empty($vars)) {
			$dphoto = ($vars['gender'] == 'male') ? '/images/content/ava-m.gif' : '/images/content/ava-f.gif';
			$dphoto = get_template_directory_uri() . $dphoto;
			$dphoto = '<img src="' . $dphoto . '" alt="" />';
			$photo = get_the_post_thumbnail($post_id, 'sg_our_team', array('class' => 'o-t'));
			$vars['photo'] = empty($photo) ? $dphoto : $photo;
			if ($vars['soc1'] == 'none' AND $vars['soc2'] == 'none' AND $vars['soc3'] == 'none') {
				$vars['soc'] = '';
			} else {
				$socsrc = get_template_directory_uri() . '/images/soc-icns/';
				$vars['soc'] = '<div class="team-social">';
				foreach (array('soc1', 'soc2', 'soc3') as $key) {
					if ($vars[$key] != 'none') {
						$vars['soc'] .= '<a href="' . $vars[$key . '_url'] . '" target="_blank" class="button-t-s"><span><img src="' . $socsrc . $vars[$key] . '.png" alt=""></span></a>';
					}
				}
				$vars['soc'] .= '</div>';
			}
		}
		
		return (object) $vars;
	}

}