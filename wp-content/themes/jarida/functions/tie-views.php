<?php
// function to display number of posts.
function tie_views( $postID = '' ){
	if( !tie_get_option( 'post_views' ) ) return false;

	global $post;
	if( empty($postID) ) $postID = $post->ID ;
	
    $count_key = 'tie_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        $count = "0";
    }
    return '<span class="post-views">'.$count.' '.__( 'Views' , 'tie' ).'</span> ';
}

// function to count views.
function tie_setPostViews() {
	if( !tie_get_option( 'post_views' ) ) return false;

	global $post;
	$postID = $post->ID ;
    $count_key = 'tie_views';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Add it to a column in WP-Admin 
add_filter('manage_posts_columns', 'tie_posts_column_views');
add_action('manage_posts_custom_column', 'tie_posts_custom_column_views',5,2);
function tie_posts_column_views($defaults){
    $defaults['tie_post_views'] = __('Views');
    return $defaults;
}
function tie_posts_custom_column_views($column_name, $id){
	if($column_name === 'tie_post_views'){
        echo tie_views(get_the_ID());
    }
}
?>