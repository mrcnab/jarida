<?php

class SG_Contact_Module extends SG_Module {
	
	const moduleName = 'Contact';
	
	protected static $instance;
	protected static $_vars = NULL;
	protected static $_params = array();
	
	protected static $_fields = array(
		'title' => array(
			'name' => 'Title',
			'type' => 'input',
			'default' => 'General information',
			'help' => 'Title for the Contact information module as default. Info module will not be displayed in sidebar if left blank',
		),
		'address' => array(
			'name' => 'Address',
			'type' => 'input',
			'class' => 'sg-metabox-field sg-metabox-long',
			'default' => '',
			'help' => 'Enter your address',
		),
		'phone' => array(
			'name' => 'Phone',
			'type' => 'input',
			'default' => '',
			'help' => 'Enter your phone number',
		),
		'fax' => array(
			'name' => 'Fax',
			'type' => 'input',
			'default' => '',
			'help' => 'Enter your fax number',
		),
		'free' => array(
			'name' => 'Toll Fee',
			'type' => 'input',
			'default' => '',
			'help' => 'Enter your phone number',
		),
		'map' => array(
			'name' => 'Map',
			'type' => 'map',
			'class' => 'sg-metabox-field sg-metabox-map',
			'default' => array(
				'locations' => array(),
				'value' => 0,
			),
			'help' => 'You can set multiple places on the map. Able to find Longitude and Latitude of your place is <a target="_blank" href="http://universimmedia.pagesperso-orange.fr/geo/loc.htm">here</a>',
		),
		'show_form' => array(
			'name' => 'Show Contact Form',
			'type' => 'select',
			'options' => array(
				'yes' => 'Show',
				'no' => 'Hide',
			),
			'default' => 'yes',
			'help' => 'Hide or show the feedback form',
		),
		'form_title' => array(
			'name' => 'Contact Form Title',
			'type' => 'input',
			'default' => 'Fill free to contact Us',
			'help' => 'Enter your feedback form title',
		),
		'email' => array(
			'name' => 'Your Email',
			'type' => 'input',
			'default' => '',
			'help' => 'Enter your email address to receive messages from the feedback form. If it is empty then messages will be sent to the default address which set in the main WordPress options',
		),
	);
	
	protected static $_description = 'Enter your contact information below to set up thecontact page. If left blank information will not be displayed';
	
	private function __construct() {}
	private function __clone() {}

	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new SG_Contact_Module;
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
		$px = self::_getPx($uniq, self::moduleName);
		
		if (isset($post_data[$px . '_map']['locations'])) {
			$locations = $post_data[$px . '_map']['locations'];
			foreach ($locations as $id => $location) {
				if (!isset($location['lng']) OR empty($location['lng']) OR !isset($location['lat']) OR empty($location['lat']) OR !isset($location['title']) OR empty($location['title'])) {
					unset($post_data[$px . '_map']['locations'][$id]);
				}
			}
			if (empty($post_data[$px . '_map']['locations'])) {
				$post_data[$px . '_map']['value'] = 0;
			}
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
	
	protected function _getMapField($uid, $params, $value, $default, $ug)
	{	
		$locations = (isset($value['locations'])) ? $value['locations'] : array();
		$last = (isset($value['value'])) ? $value['value'] : 0;
		
		$c = '';
		
		foreach ($locations as $id => $location) {
			$c .= '<div class="sg-location">';
				$c .= '<div class="sg-location-in" id="' . $uid . '-' . $id . '" rel="' . $uid . '[locations][' . $id . ']">';
					$c .= '<a class="button sg-location-rm" href="#">-</a>';
					$c .= '<div class="sg-location-info">';
						$c .= '<table>';
							$c .= '<tr>';
								$c .= '<td>' . SG_Form::label($uid . '[locations][' . $id . '][lat]', __('Latitude:', SG_TDN)) . '</td>';
								$c .= '<td>' . SG_Form::input($uid . '[locations][' . $id . '][lat]', $location['lat']) . '</td>';
							$c .= '</tr>';
							$c .= '<tr>';
								$c .= '<td class="sg-location-lable">' . SG_Form::label($uid . '[locations][' . $id . '][lng]', __('Longitude:', SG_TDN)) . '</td>';
								$c .= '<td>' . SG_Form::input($uid . '[locations][' . $id . '][lng]', $location['lng']) . '</td>';
							$c .= '</tr>';
							$c .= '<tr>';
								$c .= '<td>' . SG_Form::label($uid . '[locations][' . $id . '][title]', __('Title:', SG_TDN)) . '</td>';
								$c .= '<td>' . SG_Form::input($uid . '[locations][' . $id . '][title]', $location['title']) . '</td>';
							$c .= '</tr>';
							$c .= '<tr>';
								$c .= '<td>' . SG_Form::label($uid . '[locations][' . $id . '][txt]', __('Bubble Text:', SG_TDN)) . '</td>';
								$c .= '<td>' . SG_Form::textarea($uid . '[locations][' . $id . '][txt]', $location['txt']) . '</td>';
							$c .= '</tr>';
						$c .= '</table>';
					$c .= '</div>';
				$c .= '</div>';
			$c .= '</div>';
		}
		
		$c .= '<div class="sg-location">';
			$c .= '<div class="sg-location-in-add">';
				$c .= '<a id="' . $uid . '-add" class="button sg-location-add" href="#">+</a>';
				$c .= SG_Form::hidden($uid . '[value]', $last, array('id' => $uid . '-last'));
			$c .= '</div>';
		$c .= '</div>';
		
		$c .= '<script type="text/javascript">';
		$c .= '
//<![CDATA[
jQuery(document).ready(function($){
	$("#' . $uid . '-add").click(function(e){
		var i = $("#' . $uid . '-last").val();
		$("<div class=\"sg-location\"><div rel=\"' . $uid . '[locations][" + i + "]\" id=\"' . $uid . '-" + i + "\" class=\"sg-location-in\"><a href=\"#\" class=\"button sg-location-rm\">-</a><div class=\"sg-location-info\"><table><tbody><tr><td><label for=\"' . $uid . '[locations][" + i + "][lat]\">' . __('Latitude:', SG_TDN) . '</label></td><td><input type=\"text\" name=\"' . $uid . '[locations][" + i + "][lat]\"></td></tr><tr><td class=\"sg-location-lable\"><label for=\"' . $uid . '[locations][" + i + "][lng]\">' . __('Longitude:', SG_TDN) . '</label></td><td><input type=\"text\" name=\"' . $uid . '[locations][" + i + "][lng]\"></td></tr><tr><td><label for=\"' . $uid . '[locations][" + i + "][title]\">' . __('Title:', SG_TDN) . '</label></td><td><input type=\"text\" value=\"\" name=\"' . $uid . '[locations][" + i + "][title]\"></td></tr><tr><td><label for=\"' . $uid . '[locations][" + i + "][txt]\">' . __('Bubble Text:', SG_TDN) . '</label></td><td><textarea rows=\"" + i + "0\" cols=\"50\" name=\"' . $uid . '[locations][" + i + "][txt]\"></textarea></td></tr></tbody></table></div></div></div>").insertBefore($("#' . $uid . '-add").parent().parent());
		$("#' . $uid . '-last").val(++i);
		$(".sg-location-rm").click(function(e){$(this).parent().parent().remove();return false;});
		return false;
	});
	
	$(".sg-location-rm").click(function(e){
		$(this).parent().parent().remove();
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
		return self::_getAdminContent(self::moduleName, $uniq, self::$_params, self::$_fields, self::$_description, $params, $defaults, $global, $post_id);
	}
	
	public function showForm()
	{
		return (self::$_vars['show_form'] == 'yes');
	}
	
	public function showMap()
	{
		return (isset(self::$_vars['map']['value']) AND self::$_vars['map']['value'] != 0);
	}
	
	public function getTitle()
	{
		return __(self::$_vars['title']);
	}
	
	public function getAddress()
	{
		return __(self::$_vars['address']);
	}
	
	public function getPhone()
	{
		return self::$_vars['phone'];
	}
	
	public function getFax()
	{
		return self::$_vars['fax'];
	}
	
	public function getFree()
	{
		return self::$_vars['free'];
	}
	
	public function getEmail()
	{
		return self::$_vars['email'];
	}
	
	public function eFormTitle()
	{
		echo self::$_vars['form_title'];
	}
	
	public function eMap()
	{
		if (isset(self::$_vars['map']['locations']) AND count(self::$_vars['map']['locations']) > 0) {
			echo '<div class="heading bott-15"><h3>' . __('Our location', SG_TDN) . '</h3></div>';
			echo '<div id="map" class="bott-15"></div>';
			echo '<div id="map-side-bar">';
			
			foreach (self::$_vars['map']['locations'] as $id => $loc) {
				echo '<div class="map-location" data-jmapping="{id: ' . $id . ', point: {lng: ' . $loc['lng'] . ', lat: ' . $loc['lat'] . '}}">';
					echo '<img src="' . get_template_directory_uri() . '/images/maps.png" alt=""><a href="#" class="map-link ml-10">' . __($loc['title']) . '</a>';
					echo '<div class="info-box"><p>' . (empty($loc['txt']) ? $loc['title'] : nl2br(strip_tags(__($loc['txt'])))) . '</p></div>';
				echo '</div>';
			}
			
			echo '</div>';
			echo '<script type="text/javascript">sg_jmaping = ' . (count(self::$_vars['map']['locations']) > 1 ? '{}' : '{default_zoom_level: 16}') . ';</script>';
		}
	}
	
}