<?php 
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'front/posts/class-u-glavu-front-posts-excerpt.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'front/posts/class-u-glavu-front-posts-posts.php';

class U_Glavu_Front_Loader { 

	private $loader;

	public function __construct(U_Glavu_Loader $loader) 
	{
		$this->loader = $loader;
	}

	public function load_posts_excerpt_modifier(): U_Glavu_Front_Posts_Excerpt
	{
		$class = new U_Glavu_Front_Posts_Excerpt($this->loader);
		return $class;
	}

	/**
	 * Load posts modifier for extra join and select queries
	 */
	public function load_posts_front_modifier(): U_Glavu_Front_Posts_Posts
	{
		$class = new U_Glavu_Front_Posts_Posts($this->loader);
		return $class;
	}

}			
