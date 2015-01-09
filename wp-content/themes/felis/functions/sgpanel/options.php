<?php

/* Modules */
require_once TEMPLATEPATH . '/functions/sgpanel/modules/sgp-module.php';

function sgp_options()
{
	$sgp_options = array(
		'general' => array(
			'name' => 'General',
			'modules' => array(
				'General' => array(),
				'Modules' => array(),
			),
		),
		'view' => array(
			'name' => 'View',
			'modules' => array(
				'GlobalSettings' => array(),
			),
		),
		'style' => array(
			'name' => 'Style',
			'modules' => array(
				'Theme' => array(),
			),
		),
		'sidebars' => array(
			'name' => 'Sidebars',
			'modules' => array(
				'Sidebars' => array(),
			),
		),
	);
	
	return $sgp_options;
}