<?php
function join_og_tags ($join, $query) {
    global $wpdb;
	if ($query->is_main_query()) {
	    $join .= " LEFT JOIN wp_og_tags ON ({$wpdb->posts}.ID = wp_og_tags.post_id)";
	}
    return $join;
}
add_filter('posts_join', 'join_og_tags', 10, 2);


function select_extra_fields($fields, $query) { 
	global $wpdb;
	if ($query->is_main_query()) {
	    $ogTagsTable = $wpdb->prefix . 'og_tags';
	    $fields =  sprintf('%2$s, %1$s.image AS og_image, %1$s.url AS og_url', $ogTagsTable, $fields);
	}
    return $fields; 
}; 
add_filter( 'posts_fields', 'select_extra_fields', 10, 2); 


/*
function dump_whole_query( $input ) {
	print_r( $input ); die;
	return $input;
}
add_filter( 'posts_request', 'dump_whole_query' );
*/


/*
function exclude_category( $query ) {
    
}
add_action( 'pre_get_posts', 'exclude_category' );
*/
