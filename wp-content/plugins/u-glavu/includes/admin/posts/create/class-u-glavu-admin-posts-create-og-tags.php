<?php 

class U_Glavu_Admin_Posts_Create_Og_Tags { 

	public function __construct(U_Glavu_Loader $loader) 
	{
		$loader->add_action( 'acf/save_post', $this, 'save_external_url', 15);
	}
		
	public function save_external_url( $post_id )
	{
		global $wpdb;

		if (!isset($_POST['og_title'])) {
			return;
		}

	    if (empty($_POST['og_title'])) {
	    	return;
	    }

	    $fieldValues = get_fields( $post_id );
	    $externalUrl = strtok($fieldValues['external_url'], '?');
	    $siteData = $this->get_site_and_site_post_id($externalUrl);
	    $ogTagsTable = $wpdb->prefix . 'og_tags';
		$query = "INSERT INTO $ogTagsTable
			( post_id, title, image, url, site_id, site_post_id )
			VALUES 
			( %s, %s, %s, %s, %s, %s )";
	 
	    $wpdb->query($wpdb->prepare($query, [
	    	$post_id,
	    	$_POST['og_title'],
	    	$_POST['og_image'],
	    	$_POST['og_url'],
	    	$siteData['siteId'],
	    	$siteData['sitePostId'],
	    ]));
	}

	public function get_site_and_site_post_id(string $externalUrl)
	{
		global $wpdb;

		//get site id
		$host = $this->get_host_from_url($externalUrl);

		$ogTagsSitesTable = $wpdb->prefix . 'og_tags_sites';
		$query = "SELECT * FROM $ogTagsSitesTable WHERE site_key = %s";
		$siteData = $wpdb->get_row($wpdb->prepare($query, [$host]));

		//get site post id from url
		$sitePostId = $this->get_site_post_id($externalUrl, (bool) $siteData->generate_id);

		return [
			'siteId' => $siteData->id,
			'sitePostId' => $sitePostId
		];
	}

	public function get_host_from_url(string $externalUrl)
	{
		$parsedUrl = parse_url($externalUrl);
		return str_replace('www.', '', $parsedUrl['host']);
	}

	public function get_site_post_id(string $externalUrl, bool $generateId)
	{
		$externalUrl = strtok($externalUrl, '?');
		$urlData = parse_url($externalUrl);
		preg_match_all('/\d+/', $urlData['path'], $matches);

		if (true === $generateId) {
			$sitePostId = $this->extract_site_post_id_from_url($urlData);
		} else if (!empty($matches[0])) {
		    $sitePostId = end($matches[0]);
		    //sometimes there can be some other numbers in url that are not post id but article info
		    //usually post ids are big numbers
		    if ($sitePostId < 10000) {
				$sitePostId = $this->extract_site_post_id_from_url($urlData);
		    }
		} else {
		    $sitePostId = $this->extract_site_post_id_from_url($urlData);
		}

		return $sitePostId;
	}

	/**
	 * @see https://stackoverflow.com/questions/8520969/php-hashing-function-that-returns-an-integer-32bit-int
	 */
	public function extract_site_post_id_from_url(array $urlData): int
	{
		$path = strtolower($urlData['path']);

		return crc32($path);
	}
}