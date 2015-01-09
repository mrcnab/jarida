<!DOCTYPE html>
<!--
    Theme Name: Felis
    Description: Flexible & Multipurpose Wordpress Theme
    Author: fireform
    License: GNU General Public License version 3.0
    License URI: http://www.gnu.org/licenses/gpl-3.0.html
    Version: 1.5

    Designed & Coded by Fireform
    All files, unless otherwise stated, are released under the GNU General Public License
    version 3.0 (http://www.gnu.org/licenses/gpl-3.0.html)
 -->

<?php sg_init_config($post); ?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <?php sg_header_meta(); ?>
	<?php sg_header_css(); ?>
	<?php sg_header_js(); ?>
	<?php _sg('General')->eFavIcon(); ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
	<?php _sg('Theme')->eCSS(); ?>
</head>
<body <?php body_class('sg-nojs'); ?>>
	<script type="text/javascript">jQuery('body').addClass('sg-jsinit');</script>
    <div id="top-container">
    	<div class="shine-top">
			<div class="top-wrap">
				<header>
					<div class="top-info">
						<div class="mini-menu">
							<?php wp_nav_menu(array('theme_location' => 'top_navigation', 'fallback_cb' => 'sg_none_menu', 'walker' => new SG_Walker_Nav_Menu(), 'depth' => 1, 'container' => 'span', 'items_wrap' => '<span class="mini float-l"><span>%3$s</span></span>')); ?>
							<?php _sg('HandF')->eTopText(); ?>
							<?php if (_sg('HandF')->showSearch()) { ?>
								<div class="search float-r"><?php get_search_form(); ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="logo-menu">
						<a class="logo" href="<?php echo home_url(); ?>"><img src="<?php _sg('General')->eLogoURL(); ?>" alt="<?php bloginfo('name'); ?>" /></a>
						<?php wp_nav_menu(array('theme_location' => 'main_navigation', 'fallback_cb' => 'sg_page_menu', 'depth' => 3, 'container' => 'ul', 'menu_class' => 'navmenu')); ?>
						<script type="text/javascript">jQuery('ul.navmenu ul').parent().find('a:first').addClass('drop');</script>
					</div>
					<?php if (sg_get_tpl() == 'page|home') { ?>
						<?php _sg('Slider')->eSlider(); ?>
					<?php } else { ?>
						<?php if (_sg('HandF')->getHeaderImagesCount() > 0) { ?>
							<div class="inner-pages-slider">
								<?php if (sg_get_tpl() != 'our-team|default' AND sg_get_tpl() != 'extra|default') { ?>
									<div class="cont">
										<?php sg_breadcrumbs(); ?>
										<?php _sg('HandF')->eHireUs(); ?>
									</div>
								<?php } ?>
								<?php _sg('HandF')->eHeaderImages(); ?>
							</div>
						<?php } ?>
					<?php } ?>
				</header>
			</div>
			<div class="bottom-mask"></div>
		</div>
    </div>
	<section id="content">
		<?php if (sg_get_tpl() == 'page|home') { ?>
			<?php _sg('Slider')->eHeaderText(); ?>
		<?php } elseif (is_day() OR is_month() OR is_year() OR is_404() OR is_search() OR is_archive() OR is_author() OR is_attachment() OR is_category()) { ?>
		<?php } elseif (sg_get_tpl() == 'our-team|default' OR sg_get_tpl() == 'extra|default') { ?>
		<?php } elseif (_sg('HandF')->showNear() OR _sg('HandF')->showHeaderText()) { ?>
			<div class="inner">
				<div class="page-description">
					<?php _sg('HandF')->eHeaderText(); ?>
					<?php if (_sg('HandF')->showNear()) sg_navigation(_sg('HandF')->nearType()); ?>
				</div>
			</div>
		<?php } ?>
        <div class="shady bott-27"></div>