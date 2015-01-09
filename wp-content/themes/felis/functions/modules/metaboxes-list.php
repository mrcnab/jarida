<?php

require_once TEMPLATEPATH . '/functions/modules/module.php';

function sg_modules_list()
{
	$sg_meta_boxes = array(
		'global' => array(
			'HandF' => array(),
			'Sidebars' => array(
				'params' => array(
					'gl_used_sidebars' => array(
						'footer' => TRUE,
					),
				),
			),
			'SEO' => array(
				'params' => array(
					'fields' => array(
						'keywords_type' => array(
							'show' => SG_Module::SHOW_ALL,
						),
					),
				),
			),
		),
		'page' => array(
			'default' => array(
				'sg-page-layout' => array(
					'title' => __('Page Layout & Other Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'ap',
					'modules' => array(
						'Layout' => array(
							'params' => array(
								'show_description' => FALSE,
								'used_layouts' => array('page_r', 'page_n'),
							),
							'global' => TRUE,
						),
						'HandF' => array(),
						'Page' => array(),
						'Sidebars' => array(
							'params' => array(
								'used_sidebars' => array(
									'content' => FALSE,
									'footer' => TRUE,
								),
								'gl_used_sidebars' => array(
									'content' => FALSE,
								),
							),
							'global' => TRUE,
						),
						'SEO' => array(),
					),
				),
			),
			'home' => array(
				'sg-home-layout' => array(
					'title' => __('Home Page Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'hpl',
					'modules' => array(
						'Slider' => array(),
						'Home' => array(),
						'Sidebars' => array(
							'params' => array(
								'used_sidebars' => array(
									'footer' => TRUE,
								),
							),
						),
						'SEO' => array(),
					),
				),
			),
			'contact' => array(
				'sg-contact-layout' => array(
					'title' => __('Contact Page Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'cpl',
					'modules' => array(
						'HandF' => array(),
						'Contact' => array(),
						'Sidebars' => array(
							'params' => array(
								'fields' => array(
									'content' => array(
										'show' => SG_Module::SHOW_ENTITY,
										'default' => SG_Module::USE_NONE,
									),
								),
								'used_sidebars' => array(
									'content' => FALSE,
									'footer' => TRUE,
								),
							),
						),
						'SEO' => array(),
					),
				),
			),
			'blog' => array(
				'sg-blog' => array(
					'title' => __('Blog Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'bps',
					'params' => array(
						'class' => 'no-editor',
					),
					'modules' => array(
						'Blog' => array(),
					),
				),
				'sg-blog-layout' => array(
					'title' => __('Blog Layout & Other Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'bpl',
					'modules' => array(
						'HandF' => array(),
						'Sidebars' => array(
							'params' => array(
								'fields' => array(
									'content' => array(
										'show' => SG_Module::SHOW_ENTITY,
									),
								),
								'used_sidebars' => array(
									'content' => array(FALSE, TRUE),
									'footer' => TRUE,
								),
							),
						),
						'SEO' => array(),
					),
				),
			),
			'portfolio' => array(
				'sg-portfolio' => array(
					'title' => __('Portfolio Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'pps',
					'params' => array(
						'class' => 'no-editor',
					),
					'modules' => array(
						'Portfolio' => array(),
					),
				),
				'sg-portfolio-layout' => array(
					'title' => __('Portfolio Layout & Other Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'ppl',
					'modules' => array(
						'Layout' => array(
							'params' => array(
								'show_description' => FALSE,
								'used_layouts' => array('portfolio_3', 'portfolio_3a', 'portfolio_a'),
								'default_layout' => 'portfolio_a',
							),
						),
						'HandF' => array(),
						'Sidebars' => array(
							'params' => array(
								'fields' => array(
									'content' => array(
										'show' => SG_Module::SHOW_ENTITY,
									),
								),
								'used_sidebars' => array(
									'content' => array(FALSE, TRUE),
									'footer' => TRUE,
								),
							),
						),
						'SEO' => array(),
					),
				),
			),
		),
		'post' => array(
			'default' => array(
				'sg-post-layout' => array(
					'title' => __('Post Layout & Other Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'ptl',
					'modules' => array(
						'HandF' => array(),
						'Post' => array(
							'global' => TRUE,
						),
						'Sidebars' => array(
							'params' => array(
								'used_sidebars' => array(
									'content' => array(FALSE, TRUE),
									'footer' => TRUE,
								),
								'gl_used_sidebars' => array(
									'content' => array(FALSE, TRUE),
								),
							),
							'global' => TRUE,
						),
						'SEO' => array(
							'params' => array(
								'fields' => array(
									'keywords_type' => array(
										'show' => SG_Module::SHOW_ALL,
									),
								),
							),
						),
					),
				),
			),
		),
		'portfolio' => array(
			'default' => array(
				'sg-portfolio-post' => array(
					'title' => __('Portfolio Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'pos',
					'modules' => array(
						'HandF' => array(),
						'PortfolioPost' => array(
							'global' => TRUE,
						),
						'Sidebars' => array(
							'params' => array(
								'used_sidebars' => array(
									'content' => array(FALSE, TRUE),
									'footer' => TRUE,
								),
								'gl_used_sidebars' => array(
									'content' => array(FALSE, TRUE),
								),
							),
							'global' => TRUE,
						),
						'SEO' => array(
							'params' => array(
								'fields' => array(
									'keywords_type' => array(
										'show' => SG_Module::SHOW_ALL,
									),
								),
							),
						),
					),
				),
			),
		),
		'our-team' => array(
			'default' => array(
				'sg-our-team-layout' => array(
					'title' => __('Member Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'otl',
					'modules' => array(
						'OurTeam' => array(),
					),
				),
			),
		),
		'extra' => array(
			'default' => array(
				'sg-extra-layout' => array(
					'title' => __('Extra Settings', SG_TDN),
					'position' => 'normal',
					'priority' => 'high',
					'unique' => 'eal',
					'modules' => array(
						'Extra' => array(),
					),
				),
			),
		),
	);

	return $sg_meta_boxes;
}