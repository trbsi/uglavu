<?php 

class U_Glavu_Admin_Posts_Create_Scrape_Og_Tags { 

	private $createOgTags;

	public function __construct(
		U_Glavu_Loader $loader,
		U_Glavu_Admin_Posts_Create_Og_Tags $createOgTags
	) {
		$this->createOgTags = $createOgTags;
	}

	public function scrape_fb_og_tags() 
	{
		file_put_contents('t.txt', 333);
		$externalUrl = str_replace([' '], '', $_POST['external_url']);

		//check if this is URL
		$this->check_if_this_is_url($externalUrl);

		//check if site is supported
		//is_site_supported($externalUrl);

		//check if someone already posted this story
		$this->is_story_already_posted($externalUrl);

		try {
			$webSiteMetaData = [];
			$doc = new \DOMDocument();
			@$doc->loadHTML(mb_convert_encoding(file_get_contents($externalUrl), 'HTML-ENTITIES', 'UTF-8'));
			$metas = $doc->getElementsByTagName('meta');
			/** @var \DOMElement $meta */
			foreach ($metas as $meta) {
			    if ($meta->hasAttribute('property') && false !== strpos($meta->getAttribute('property'), 'og')) {
			        $webSiteMetaData[$meta->getAttribute('property')] = $meta->getAttribute('content');
			    }
			}

			//sometimes some sites don't habe og:url in meta tags
			if(!isset($webSiteMetaData['og:url'])) {
				$webSiteMetaData['og:url'] = strtok($externalUrl, '?');
			}
			echo json_encode($webSiteMetaData);
		} catch (\Exception $e) {
			echo json_encode([]);
		}

		wp_die();
	}

	public function check_if_this_is_url($externalUrl)
	{
		if (false === filter_var($externalUrl, FILTER_VALIDATE_URL)) {
		    wp_send_json_error(['message' => 'Wrong URL bi-yatch']);
		    wp_die();
		}
	}

	public function is_site_supported($externalUrl)
	{
		global $wpdb;
		$ogTagsSitesTable = $wpdb->prefix . 'og_tags_sites';
		$query = "SELECT * FROM $ogTagsSitesTable WHERE site_key = %s";
		$siteData = $wpdb->get_row($wpdb->prepare($query, [get_host_from_url($externalUrl)]));

		if (null === $siteData) {
			$query = "SELECT * FROM $ogTagsSitesTable";
			$sites = $wpdb->get_results($wpdb->prepare($query, []));
			foreach ($sites as $site) {
				$siteNames[] = $site->site_key;
			}

			$msg = sprintf('Site is not supported. Supported sites are: %s', implode(', ', $siteNames));
			wp_send_json_error(['message' => $msg]);
		    wp_die();
		}
	}

	public function is_story_already_posted($externalUrl)
	{
		global $wpdb;
		$siteData = $this->createOgTags->get_site_and_site_post_id($externalUrl);

		$ogTagsTable = $wpdb->prefix . 'og_tags';
		$query = "SELECT * FROM $ogTagsTable WHERE site_id = %s AND site_post_id = %s";
		$siteData = $wpdb->get_row($wpdb->prepare($query, [
			$siteData['siteId'],
			$siteData['sitePostId'],
		]));

		if (null !== $siteData) {
			wp_send_json_error(['message' => 'Someone already posted this story']);
		    wp_die();
		}
	}

	public function get_og_post_by_id($id)
	{
		global $wpdb;
		$ogTagsTable = $wpdb->prefix . 'og_tags';
		$query = "SELECT * FROM $ogTagsTable WHERE post_id = %s";
		return $wpdb->get_row($wpdb->prepare($query, [$id]));
	}
}