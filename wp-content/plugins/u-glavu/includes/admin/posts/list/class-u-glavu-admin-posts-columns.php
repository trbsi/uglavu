<?php

/**
 * @see  https://codex.wordpress.org/Plugin_API/Action_Reference/manage_posts_custom_column#Custom_post_type
 */
class U_Glavu_Admin_Posts_Columns {

	public function __construct(U_Glavu_Loader $loader)
	{
		$loader->add_action( 'manage_posts_columns', $this, 'add_datetime_column', 15);
		$loader->add_action( 'manage_posts_custom_column', $this, 'custom_columns', 10, 2); 
	}
 
	public function add_datetime_column( $columns )
	{
	    return array_merge(
	    	$columns, 
	        ['time' => __( 'Time', 'your_text_domain' )]
	    );
	}
 
	public function custom_columns( $column, $post_id )
	{
		$post = get_post($post_id);

		switch ($column) {
			case 'time':
				echo get_the_date('H:i:s', $post); 
				break;
		}
	}
}