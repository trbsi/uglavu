<?php

namespace UGlavu\Includes\Admin\Posts\Listing;

use UGlavu\Includes\UGlavuLoader;

/**
 * @see  https://codex.wordpress.org/Plugin_API/Action_Reference/manage_posts_custom_column#Custom_post_type
 */
class UGlavuAdminPostsColumns {

    private $loader;

	public function __construct(UGlavuLoader $loader)
	{
	    $this->loader = $loader;
	    $this->run();
	}

	public function run()
    {
        $this->loader->add_action( 'manage_posts_columns', $this, 'addDatetimeColumn', 15);
        $this->loader->add_action( 'manage_posts_custom_column', $this, 'customColumns', 10, 2);
    }

	public function addDatetimeColumn($columns )
	{
	    return array_merge(
	    	$columns, 
	        ['time' => __( 'Time', 'your_text_domain' )]
	    );
	}
 
	public function customColumns($column, $post_id )
	{
		$post = get_post($post_id);

		switch ($column) {
			case 'time':
				echo get_the_date('H:i:s', $post); 
				break;
		}
	}
}