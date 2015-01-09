<?php

require_once TEMPLATEPATH . '/functions/sgpanel/modules/sgp-sidebars.php';

function sg_get_default_sidebars()
{
	$sb = array(
		'right_sidebar' => array(
			'name' => __('Right Sidebar', SG_TDN),
			'desc' => __('Widgets inserted here will show up in the sidebar sections for pages.', SG_TDN),
			'pos' => 'content',
		),
	);
	
	return $sb;
}

function sg_get_sidebars_positions()
{
	$sbp = array(
		'content' => 'Content',
		'footer' => 'Footer',
	);
	
	return $sbp;
}

function sg_get_sidebars()
{
	$dsb = sg_get_default_sidebars();
	$sb = SGP_Sidebars_Module::getVars();
	
	return array_merge($dsb, $sb);
}

add_action('widgets_init', 'sg_register_sidebars');

function sg_register_sidebars()
{
	$sb = sg_get_sidebars();
	$sbp = sg_get_sidebars_positions();
	
	foreach ($sb as $id => $p) {
		if ($p['pos'] == 'content') {
			register_sidebar(
				array(
					'id' => $id,
					'name' => $p['name'],
					'description' => $p['desc'] . ' (Position: ' . $sbp[$p['pos']] . ')',
					'before_widget' => '<div id="%1$s" class="%2$s bott-27">',
					'after_widget' => '</div>',
					'before_title' => '<div class="heading"><h5>',
					'after_title' => '</h5></div>'
				)
			);
		}
		if ($p['pos'] == 'footer') {
			register_sidebar(
				array(
					'id' => $id,
					'name' => $p['name'],
					'description' => $p['desc'] . ' (Position: ' . $sbp[$p['pos']] . ')',
					'before_widget' => '<div id="%1$s" class="%2$s col1-4">',
					'after_widget' => '</div>',
					'before_title' => '<h4>',
					'after_title' => '<img src="' . get_template_directory_uri() . '/images/heading-bg-footer.gif" alt=""></h4>'
				)
			);
		}
	}
}