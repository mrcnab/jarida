<?php
/*-----------------------------------------------------------------------------------*/
# Register main Scripts and Styles
/*-----------------------------------------------------------------------------------*/
function tie_register() {
	## Register All Scripts
    wp_register_script( 'tie-scripts', get_template_directory_uri() . '/js/tie-scripts.js', array( 'jquery' ) );  
    wp_register_script( 'tie-tabs', get_template_directory_uri() . '/js/tabs.min.js', array( 'jquery' ) );  
    wp_register_script( 'tie-cycle', get_template_directory_uri() . '/js/jquery.cycle.all.js', array( 'jquery' ) );
    wp_register_script( 'tie-validation', get_template_directory_uri() . '/js/validation.js', array( 'jquery' ) );  
    wp_register_script( 'tie-jplayer', get_template_directory_uri() . '/js/jquery.jplayer.min.js', array( 'jquery' ) );

	## Register Main style.css file
	wp_register_style( 'tie-style', get_stylesheet_uri() , array(), '', 'all' );
	wp_enqueue_style( 'tie-style' );
	
	## Get Global Scripts
    wp_enqueue_script( 'tie-scripts' );
		
	## Get Validation Script
	if( tie_get_option('comment_validation') && ( is_page() || is_single() ) && comments_open() )
		wp_enqueue_script( 'tie-validation' );
	
	$protocol = is_ssl() ? 'https' : 'http';
	wp_enqueue_style( "Oswald" , "$protocol://fonts.googleapis.com/css?family=Oswald:400,700");
		
	## For facebook & Google + share
	if(  is_page() || is_single() )	tie_og_image();  ?>
 
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri() ?>/js/html5.js"></script>
<script src="<?php echo get_template_directory_uri() ?>/js/selectivizr-min.js"></script>
<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() ?>/css/ie9.css" />
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri() ?>/css/ie8.css" />
<![endif]-->

<script type='text/javascript'>
	/* <![CDATA[ */
	var tievar = {'go_to' : '<?php _e('Go to...', 'tie') ?>'};
	/* ]]> */
</script>


<?php
}


/*-----------------------------------------------------------------------------------*/
# Enqueue Fonts From Google
/*-----------------------------------------------------------------------------------*/
function tie_enqueue_font ( $got_font) {
	if ($got_font) {
		$char_set ='';
		if( tie_get_option('typography_latin_extended') || tie_get_option('typography_cyrillic') ||
		tie_get_option('typography_cyrillic_extended') || tie_get_option('typography_greek') ||
		tie_get_option('typography_greek_extended') ){
		
			$char_set = '&subset=latin';
			if( tie_get_option('typography_latin_extended') ) 
				$char_set .= ',latin-ext';
			if( tie_get_option('typography_cyrillic') )
				$char_set .= ',cyrillic';
			if( tie_get_option('typography_cyrillic_extended') )
				$char_set .= ',cyrillic-ext';
			if( tie_get_option('typography_greek') )
				$char_set .= ',greek';
			if( tie_get_option('typography_greek_extended') )
				$char_set .= ',greek-ext';
		}
		
		$font_pieces = explode(":", $got_font);
			
		$font_name = $font_pieces[0];
		$font_name = str_replace (" ","+", $font_pieces[0] );
				
		$font_variants = $font_pieces[1];
		$font_variants = str_replace ("|",",", $font_pieces[1] );
				
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( $font_name , $protocol.'://fonts.googleapis.com/css?family='.$font_name . ':' . $font_variants.$char_set );

	}
}


/*-----------------------------------------------------------------------------------*/
# Get Font Name
/*-----------------------------------------------------------------------------------*/
function tie_get_font ( $got_font ) {
	if ($got_font) {
		$font_pieces = explode(":", $got_font);
		$font_name = $font_pieces[0];
		return $font_name;
	}
}


/*-----------------------------------------------------------------------------------*/
# Typography Elements Array
/*-----------------------------------------------------------------------------------*/
$custom_typography = array(
	"body"													=>		"typography_general",
	".logo h1, .logo h2"									=>		"typography_site_title",
	".logo span"											=>		"typography_tagline",
	".top-nav, .top-nav ul li a, .breaking-news span "		=>		"typography_top_menu",
	"#main-nav, #main-nav ul li a"							=>		"typography_main_nav",
	".page-title"											=>		"typography_page_title",
	".post-title"											=> 		"typography_post_title",
	"h2.post-box-title"										=> 		"typography_post_title_boxes",
	"h3.post-box-title"										=> 		"typography_post_title2_boxes",
	".ei-title h2 , .slider-caption h2 a "					=> 		"typography_slider_title",
	"p.post-meta, p.post-meta a"							=> 		"typography_post_meta",
	"body.single .entry, body.page .entry"					=> 		"typography_post_entry",
	".widget-top h4, .widget-top h4 a"						=> 		"typography_widgets_title",
	".footer-widget-top h4, .footer-widget-top h4 a"		=> 		"typography_footer_widgets_title",
	".entry h1"												=> 		"typography_post_h1",
	".entry h2"												=> 		"typography_post_h2",
	".entry h3"												=> 		"typography_post_h3",
	".entry h4"												=> 		"typography_post_h4",
	".entry h5"												=> 		"typography_post_h5",
	".entry h6"												=> 		"typography_post_h6",
	"h2.cat-box-title, h2.cat-box-title a, .block-head h3, #respond h3, #comments-title, h2.review-box-header  "			=> 		"typography_boxes_title",
);
	
	
/*-----------------------------------------------------------------------------------*/
# Get Custom Typography
/*-----------------------------------------------------------------------------------*/
function tie_typography(){
	global $custom_typography;

	foreach( $custom_typography as $selector => $value){
		$option = tie_get_option( $value );
		tie_enqueue_font( $option['font'] ) ;
	}
}


/*-----------------------------------------------------------------------------------*/
# Tie Wp Head
/*-----------------------------------------------------------------------------------*/
add_action('wp_head', 'tie_wp_head');
function tie_wp_head() {
	global $custom_typography; 
	
	if( tie_get_option( 'disable_responsive' ) ){?>
	
<meta name="viewport" content="width=1220" />
	<?php }else{ ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<?php
	}
?>
<style type="text/css" media="screen"> 
<?php echo "\n"; ?>
<?php if( tie_get_option('background_type') == 'pattern' ):
	if(tie_get_option('background_pattern') ): ?>
body {background: <?php echo tie_get_option('background_pattern_color') ?> url(<?php echo get_template_directory_uri(); ?>/images/patterns/<?php echo tie_get_option('background_pattern') ?>.png) center;}
	<?php endif; ?>
<?php elseif( tie_get_option('background_type') == 'custom' ):
	$bg = tie_get_option( 'background' ); 
	if( tie_get_option('background_full') ): ?>
.background-cover{<?php echo "\n"; ?>
	<?php if( !empty($bg['color']) ){ ?>background-color:<?php echo $bg['color'] ?>; <?php } ?>
	background-image : url('<?php echo $bg['img'] ?>') ;<?php echo "\n"; ?>
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $bg['img'] ?>',sizingMethod='scale');<?php echo "\n"; ?>
	-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $bg['img'] ?>',sizingMethod='scale')";<?php echo "\n"; ?>
}
<?php else: ?>
body{background:<?php echo $bg['color'] ?> url('<?php echo $bg['img'] ?>') <?php echo $bg['repeat'] ?> <?php echo $bg['attachment'] ?> <?php echo $bg['hor'] ?> <?php echo $bg['ver'] ?>;}<?php echo "\n"; ?>
<?php endif; ?>
<?php endif; ?>
<?php
foreach( $custom_typography as $selector => $value){
$option = tie_get_option( $value );
if( $option['font'] || $option['color'] || $option['size'] || $option['weight'] || $option['style'] ):
echo "\n".$selector."{\n"; ?>
<?php if($option['font'] )
	echo "	font-family: '". tie_get_font( $option['font']  )."' !important;\n"?>
<?php if($option['color'] )
	echo "	color :". $option['color']." !important;\n"?>
<?php if($option['size'] )
	echo "	font-size : ".$option['size']."px !important;\n"?>
<?php if($option['weight'] )
	echo "	font-weight: ".$option['weight']." !important;\n"?>
<?php if($option['style'] )
	echo "	font-style: ". $option['style']." !important;\n"?>
}
<?php endif;
} ?>
<?php if( tie_get_option( 'global_color' ) ): ?>
#main-nav ul li.current-menu-item a,
#main-nav ul li.current-menu-item a:hover,
#main-nav ul li.current-menu-parent a,
#main-nav ul li.current-menu-parent a:hover,
#main-nav ul li.current-page-ancestor a,
#main-nav ul li.current-page-ancestor a:hover,
.pagination span.current,
.ei-slider-thumbs li.ei-slider-element,
.breaking-news span,
.ei-title h2,h2.cat-box-title,
a.more-link,.scroll-nav a,
.flex-direction-nav a,
.tagcloud a:hover,
#tabbed-widget ul.tabs li.active a,
.slider-caption h2, .full-width .content .slider-caption h2,
.review-percentage .review-item span span,.review-final-score   {
	background-color:<?php echo tie_get_option( 'global_color' );?> !important;
}
::-webkit-scrollbar-thumb{background-color:<?php echo tie_get_option( 'global_color' );?> !important;}
#main-nav,.top-nav {border-bottom-color: <?php echo tie_get_option( 'global_color' );?>;}
.cat-box , .footer-bottom .container{border-top-color: <?php echo tie_get_option( 'global_color' );?>;}

<?php endif; ?>
<?php if( tie_get_option( 'links_color' ) || tie_get_option( 'links_decoration' )  ): ?>
a {
	<?php if( tie_get_option( 'links_color' ) ) echo 'color: '.tie_get_option( 'links_color' ).';'; ?>
	<?php if( tie_get_option( 'links_decoration' ) ) echo 'text-decoration: '.tie_get_option( 'links_decoration' ).';'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'links_color_hover' ) || tie_get_option( 'links_decoration_hover' )  ): ?>
a:hover {
	<?php if( tie_get_option( 'links_color_hover' ) ) echo 'color: '.tie_get_option( 'links_color_hover' ).';'; ?>
	<?php if( tie_get_option( 'links_decoration_hover' ) ) echo 'text-decoration: '.tie_get_option( 'links_decoration_hover' ).';'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'highlighted_color' ) ): ?>
::-moz-selection { background: <?php echo tie_get_option( 'highlighted_color' ) ?>;}
::selection { background: <?php echo tie_get_option( 'highlighted_color' ) ?>; }
<?php endif; ?>
<?php 
if( tie_get_option( 'topbar_background' )): ?>
.top-nav, .top-nav ul ul {background-color:<?php echo tie_get_option( 'topbar_background' );?>;}<?php echo "\n"; ?>
<?php endif; ?>
<?php if( tie_get_option( 'topbar_links_color' ) || tie_get_option( 'topbar_shadow_color' ) ): ?>
.top-nav ul li a , .top-nav ul ul a {
	<?php if( tie_get_option( 'topbar_links_color' ) ) echo 'color: '.tie_get_option( 'topbar_links_color' ).' !important;'; ?>
	<?php if( tie_get_option( 'topbar_shadow_color' ) ) echo 'text-shadow: 0 1px 1px '.tie_get_option( 'topbar_shadow_color' ).' !important;'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'topbar_links_color_hover' ) || tie_get_option( 'topbar_shadow_color_hover' ) ): ?>
.top-nav ul li a:hover, .top-nav ul li:hover > a, .top-nav ul :hover > a , .top-nav ul li.current-menu-item a  {
	<?php if( tie_get_option( 'topbar_links_color_hover' ) ) echo 'color: '.tie_get_option( 'topbar_links_color_hover' ).' !important;'; ?>
	<?php if( tie_get_option( 'topbar_shadow_color_hover' ) ) echo 'text-shadow: 0 1px 1px '.tie_get_option( 'topbar_shadow_color_hover' ).' !important;'; ?>

}
<?php endif; ?>
<?php $header_bg = tie_get_option( 'header_background' ); 
if( !empty( $header_bg['img']) || !empty( $header_bg['color'] ) ): ?>
header {background:<?php echo $header_bg['color'] ?> url('<?php echo $header_bg['img'] ?>') <?php echo $header_bg['repeat'] ?> <?php echo $header_bg['attachment'] ?> <?php echo $header_bg['hor'] ?> <?php echo $header_bg['ver'] ?>;}<?php echo "\n"; ?>
<?php endif; ?>
<?php 
if( tie_get_option( 'nav_background' )): ?>
#main-nav, #main-nav ul ul {background-color:<?php echo tie_get_option( 'nav_background' ).' !important;';?>;}<?php echo "\n"; ?>
<?php endif; ?>
<?php if( tie_get_option( 'nav_links_color' ) || tie_get_option( 'nav_shadow_color' ) ): ?>
#main-nav ul li a , #main-nav ul ul a , #main-nav ul.sub-menu a {
	<?php if( tie_get_option( 'nav_links_color' ) ) echo 'color: '.tie_get_option( 'nav_links_color' ).' !important;'; ?>
	<?php if( tie_get_option( 'nav_shadow_color' ) ) echo 'text-shadow: 0 1px 1px '.tie_get_option( 'nav_shadow_color' ).' !important;'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'nav_links_color_hover' ) || tie_get_option( 'nav_shadow_color_hover' ) ): ?>
#main-nav ul li a:hover, #main-nav ul li:hover > a, #main-nav ul :hover > a , #main-nav  ul ul li:hover > a, #main-nav  ul ul :hover > a  {
	<?php if( tie_get_option( 'nav_links_color_hover' ) ) echo 'color: '.tie_get_option( 'nav_links_color_hover' ).' !important;'; ?>
	<?php if( tie_get_option( 'nav_shadow_color_hover' ) ) echo 'text-shadow: 0 1px 1px '.tie_get_option( 'nav_shadow_color_hover' ).' !important;'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'nav_current_links_color' ) || tie_get_option( 'nav_current_shadow_color' ) ): ?>
#main-nav ul li.current-menu-item a  {
	<?php if( tie_get_option( 'nav_current_links_color' ) ) echo 'color: '.tie_get_option( 'nav_current_links_color' ).' !important;'; ?>
	<?php if( tie_get_option( 'nav_current_shadow_color' ) ) echo 'text-shadow: 0 1px 1px '.tie_get_option( 'nav_current_shadow_color' ).' !important;'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'nav_sep1' ) ): ?>
#main-nav ul li {
	border-color: <?php echo tie_get_option( 'nav_sep1' ); ?>;
}
#main-nav ul ul li, #main-nav ul ul li:first-child {
	border-top-color: <?php echo tie_get_option( 'nav_sep1' ); ?>;
}
<?php endif; ?>
<?php if( tie_get_option( 'nav_sep2' ) ): ?>
#main-nav ul li a {
	border-left-color: <?php echo tie_get_option( 'nav_sep2' ); ?>;
}
#main-nav ul ul li, #main-nav ul ul li:first-child {
	border-bottom-color: <?php echo tie_get_option( 'nav_sep2' ); ?>;
}
<?php endif; ?>
<?php $content_bg = tie_get_option( 'main_content_bg' ); 
if( !empty( $content_bg['img']) || !empty( $content_bg['color'] ) ): ?>
.wrapper{background:<?php echo $content_bg['color'] ?> url('<?php echo $content_bg['img'] ?>') <?php echo $content_bg['repeat'] ?> <?php echo $content_bg['attachment'] ?> <?php echo $content_bg['hor'] ?> <?php echo $content_bg['ver'] ?>;}<?php echo "\n"; ?>
<?php endif; ?>
<?php if( tie_get_option( 'post_links_color' ) || tie_get_option( 'post_links_decoration' )  ): ?>
body.single .post .entry a, body.page .post .entry a {
	<?php if( tie_get_option( 'post_links_color' ) ) echo 'color: '.tie_get_option( 'post_links_color' ).';'; ?>
	<?php if( tie_get_option( 'post_links_decoration' ) ) echo 'text-decoration: '.tie_get_option( 'post_links_decoration' ).';'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'post_links_color_hover' ) || tie_get_option( 'post_links_decoration_hover' )  ): ?>
body.single .post .entry a:hover, body.page .post .entry a:hover {
	<?php if( tie_get_option( 'post_links_color_hover' ) ) echo 'color: '.tie_get_option( 'post_links_color_hover' ).';'; ?>
	<?php if( tie_get_option( 'post_links_decoration_hover' ) ) echo 'text-decoration: '.tie_get_option( 'post_links_decoration_hover' ).';'; ?>
}
<?php endif; ?>
<?php $footer_bg = tie_get_option( 'footer_background' ); 
if( !empty( $footer_bg['img']) || !empty( $footer_bg['color'] ) ): ?>
footer {background:<?php echo $footer_bg['color'] ?> url('<?php echo $footer_bg['img'] ?>') <?php echo $footer_bg['repeat'] ?> <?php echo $footer_bg['attachment'] ?> <?php echo $footer_bg['hor'] ?> <?php echo $footer_bg['ver'] ?>;}<?php echo "\n"; ?>
<?php endif; ?>
<?php if( tie_get_option( 'footer_title_color' ) ): ?>
.footer-widget-top h3 {	<?php if( tie_get_option( 'footer_title_color' ) ) echo 'color: '.tie_get_option( 'footer_title_color' ).';'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'footer_links_color' ) ): ?>
footer a  {	<?php if( tie_get_option( 'footer_links_color' ) ) echo 'color: '.tie_get_option( 'footer_links_color' ).' !important;'; ?>
}
<?php endif; ?>
<?php if( tie_get_option( 'footer_links_color_hover' ) ): ?>
footer a:hover {<?php if( tie_get_option( 'footer_links_color_hover' ) ) echo 'color: '.tie_get_option( 'footer_links_color_hover' ).' !important;'; ?>
}
<?php endif; ?>
<?php global $post ;
if( is_category() || is_single() ): 
	if( is_category() ) $category_id = get_query_var('cat') ;
	if( is_single() ){ 
		$categories = get_the_category( $post->ID );
		$category_id = $categories[0]->term_id ;
	}
$cat_bg = tie_get_option("cat".$category_id."_background");
if( $cat_bg['color'] || $cat_bg['img']):
	if( tie_get_option("cat".$category_id."_background_full") ): ?>
.background-cover{<?php echo "\n"; ?>
	background-color:<?php echo $cat_bg['color'] ?>;
	background-image : url('<?php echo $cat_bg['img'] ?>') ;<?php echo "\n"; ?>
	filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $cat_bg['img'] ?>',sizingMethod='scale');<?php echo "\n"; ?>
	-ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $cat_bg['img'] ?>',sizingMethod='scale')";<?php echo "\n"; ?>
}
<?php else: ?>
body{background:<?php echo $cat_bg['color'] ?> url('<?php echo $cat_bg['img'] ?>') <?php echo $cat_bg['repeat'] ?> <?php echo $cat_bg['attachment'] ?> <?php echo $cat_bg['hor'] ?> <?php echo $cat_bg['ver'] ?>;}<?php echo "\n"; ?>
<?php endif;
endif; 
if( tie_get_option("cat_".$category_id."_color") ): ?>
#main-nav,.top-nav{border-bottom-color: <?php echo tie_get_option("cat_".$category_id."_color");?>;}
#main-nav ul li.current-menu-item a,
#main-nav ul li.current-menu-item a:hover,
#main-nav ul li.current-menu-parent a,
#main-nav ul li.current-menu-parent a:hover,
#main-nav ul li.current-page-ancestor a,
#main-nav ul li.current-page-ancestor a:hover,
.pagination span.current,
.ei-slider-thumbs li.ei-slider-element,
.breaking-news span,
.ei-title h2,h2.cat-box-title,
a.more-link,.scroll-nav a,
.flex-direction-nav a,
.tagcloud a:hover,
#tabbed-widget ul.tabs li.active a,
.slider-caption h2, .full-width .content .slider-caption h2,
.review-percentage .review-item span span,.review-final-score  {
	background-color:<?php echo  tie_get_option("cat_".$category_id."_color");?> !important;
}
::-webkit-scrollbar-thumb{background-color:<?php echo  tie_get_option("cat_".$category_id."_color");?> !important;}
.cat-box , .footer-bottom .container{border-top-color: <?php echo tie_get_option("cat_".$category_id."_color"); ?>}
	<?php
	endif;  
	?>
<?php endif; ?>
<?php echo htmlspecialchars_decode( tie_get_option('css') ) , "\n";?>
<?php if( tie_get_option('css_tablets') ) : ?>
@media only screen and (max-width: 985px) and (min-width: 768px){
<?php echo htmlspecialchars_decode( tie_get_option('css_tablets') ) , "\n";?>
}
<?php endif; ?>
<?php if( tie_get_option('css_wide_phones') ) : ?>
@media only screen and (max-width: 767px) and (min-width: 480px){
<?php echo htmlspecialchars_decode( tie_get_option('css_wide_phones') ) , "\n";?>
}
<?php endif; ?>
<?php if( tie_get_option('css_phones') ) : ?>
@media only screen and (max-width: 479px) and (min-width: 320px){
<?php echo htmlspecialchars_decode( tie_get_option('css_phones') ) , "\n";?>
}
<?php endif; ?>

<?php
	if( is_home() && tie_get_option('on_home') == 'boxes' && tie_get_option('homepage_cats_colors') ){
		$categories_obj = get_categories('hide_empty=0');
		$categories2 = array();
		foreach ($categories_obj as $pn_cat) {
			$category_id2 = $pn_cat->cat_ID ;
			if( tie_get_option("cat_".$category_id2."_color") ){ ?>
.tie-cat-<?php echo $category_id2 ?> .cat-box-title, .tie-cat-<?php echo $category_id2 ?> .scroll-nav a, .tie-cat-<?php echo $category_id2 ?> a.more-link{background-color:<?php echo  tie_get_option("cat_".$category_id2."_color");?> !important;}
.tie-cat-<?php echo $category_id2 ?> {border-top-color:<?php echo  tie_get_option("cat_".$category_id2."_color");?> !important; }
		<?php
			}
		}
	}
	
?>
</style> 

<?php
echo htmlspecialchars_decode( tie_get_option('header_code') ) , "\n";
}
?>