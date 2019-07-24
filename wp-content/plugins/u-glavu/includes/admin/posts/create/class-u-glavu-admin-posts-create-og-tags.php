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

	public function get_site_and_site_post_id($externalUrl)
	{
		global $wpdb;

		//get site id
		$host = $this->get_host_from_url($externalUrl);

		$ogTagsSitesTable = $wpdb->prefix . 'og_tags_sites';
		$query = "SELECT * FROM $ogTagsSitesTable WHERE site_key = %s";
		$siteData = $wpdb->get_row($wpdb->prepare($query, [$host]));

		//get site post id from url
		$sitePostId = $this->get_site_post_id($externalUrl);

		return [
			'siteId' => $siteData->id,
			'sitePostId' => $sitePostId
		];
	}

	public function get_host_from_url($externalUrl)
	{
		$parsedUrl = parse_url($externalUrl);
		return str_replace('www.', '', $parsedUrl['host']);
	}

	public function get_site_post_id($externalUrl)
	{
		$externalUrl = strtok($externalUrl, '?');
		$urlData = parse_url($externalUrl);
		preg_match_all('/\d+/', $urlData['path'], $matches);

		if (!empty($matches[0])) {
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

	public function extract_site_post_id_from_url(array $urlData): int
	{
		$path = strtolower($urlData['path']);
		$pathArray = str_split(str_replace(['-', '/'], '', $path));
		$letters = array_flip(range('a', 'z'));

		$sitePostId = 0;
		foreach ($pathArray as $character) {
			if (is_numeric($character)) {
				$sitePostId+= $character;
			} elseif(isset($letters[$character])) {
				$sitePostId+= $letters[$character] + 1;
			} else {
				$sitePostId+= 1;
			}
		}
		$sitePostId+= strlen($externalUrl);

		return $sitePostId;
	}
}