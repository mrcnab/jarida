<?php

add_filter('nav_menu_css_class', 'sg_nav_menu_css_class', 10, 2);
add_filter('page_css_class', 'sg_page_css_class', 10, 2);
add_action('init', 'sg_register_menus');

function sg_register_menus()
{
	register_nav_menus(
		array(
			'top_navigation' => 'Top Navigation',
			'main_navigation' => 'Main Navigation',
		)
	);
}

function sg_nav_menu_css_class($classes = array(), $menu_item = false)
{
	if (in_array('current-menu-item', $menu_item->classes) OR in_array('current-menu-parent', $menu_item->classes)) {
		if ($menu_item->menu_item_parent == 0) {
			$classes[] = 'curr';
		}
	}
	return $classes;
}

function sg_page_css_class($classes = array(), $page = null)
{
	if (in_array('current_page_item', $classes) OR in_array('current_page_parent', $classes)) {
		if ($page->post_parent == 0) $classes[] = 'curr';
	}
	return $classes;
}

function sg_page_menu($args = array())
{
	$defaults = array('title_li' => '');
	$args = wp_parse_args($args, $defaults);
	$args = apply_filters('wp_page_menu_args', $args);
	
	echo '<ul class="' . $args['menu_class'] . '">';
	wp_list_pages($args);
	echo '</ul>';
}

function sg_none_menu($args = array())
{
	
}

class SG_Walker_Nav_Menu extends Walker {
	var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
	var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
	
	static $start = 0;
	
	function start_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent\n";
	}
	
	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent\n";
	}
	
	function start_el(&$output, $item, $depth, $args) {
		self::$start++;
		if (self::$start < 4) {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			$class_names = ' class="' . esc_attr( $class_names ) . '"';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . (self::$start > 1 ? '<img src="' . get_template_directory_uri() . '/images/v-sep.gif" alt="">' : '');

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	
	function end_el(&$output, $item, $depth) {
		if (self::$start < 4) {
			$output .= "\n";
		}
	}
}