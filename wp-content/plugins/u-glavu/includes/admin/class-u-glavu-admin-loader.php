<?php 
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/posts/list/class-u-glavu-admin-posts-filter.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/posts/create/class-u-glavu-admin-posts-create-og-tags.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/posts/create/class-u-glavu-admin-posts-create-scrape-og-tags.php';

class U_Glavu_Admin_Loader { 

	private $loader;

	public function __construct(U_Glavu_Loader $loader) 
	{
		$this->loader = $loader;
	}

	public function load_posts_filter(): U_Glavu_Admin_Posts_Filter
	{
		$class = new U_Glavu_Admin_Posts_Filter($this->loader);
		return $class;
	}

	public function load_og_tags_scraper_and_saver(): array
	{
		$createOgTags = new U_Glavu_Admin_Posts_Create_Og_Tags($this->loader);
		$scrapeOgTags = new U_Glavu_Admin_Posts_Create_Scrape_Og_Tags($this->loader, $createOgTags);

		return [
			'createOgTags' => $createOgTags,
			'scrapeOgTags' => $scrapeOgTags
		];
	}
}