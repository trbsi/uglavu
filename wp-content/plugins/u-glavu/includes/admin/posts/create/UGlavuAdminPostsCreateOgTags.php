<?php

namespace UGlavu\Includes\Admin\Posts\Create;

use UGlavu\Includes\UGlavuLoader;

class UGlavuAdminPostsCreateOgTags {

    private $loader;

	public function __construct(UGlavuLoader $loader)
	{
	    $this->loader = $loader;
	    $this->run();
	}

	public function run()
    {
        $this->loader->add_action( 'acf/save_post', $this, 'saveExternalUrl', 15);
    }
		
	public function saveExternalUrl($post_id )
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
	    $siteData = $this->getSiteAndSitePostId($externalUrl);
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

	public function getSiteAndSitePostId(string $externalUrl)
	{
		global $wpdb;

		//get site id
		$host = $this->getHostFromUrl($externalUrl);

		$ogTagsSitesTable = $wpdb->prefix . 'og_tags_sites';
		$query = "SELECT * FROM $ogTagsSitesTable WHERE site_key = %s";
		$siteData = $wpdb->get_row($wpdb->prepare($query, [$host]));

		//get site post id from url
		$sitePostId = $this->getSitePostId($externalUrl, (bool) $siteData->generate_id);

		return [
			'siteId' => $siteData->id,
			'sitePostId' => $sitePostId
		];
	}

	public function getHostFromUrl(string $externalUrl)
	{
		$parsedUrl = parse_url($externalUrl);
		return str_replace('www.', '', $parsedUrl['host']);
	}

	public function getSitePostId(string $externalUrl, bool $generateId)
	{
		$externalUrl = strtok($externalUrl, '?');
		$urlData = parse_url($externalUrl);
		preg_match_all('/\d+/', $urlData['path'], $matches);

		if (true === $generateId) {
			$sitePostId = $this->extractSitePostIdFromUrl($urlData);
		} else if (!empty($matches[0])) {
		    $sitePostId = end($matches[0]);
		    //sometimes there can be some other numbers in url that are not post id but article info
		    //usually post ids are big numbers
		    if ($sitePostId < 10000) {
				$sitePostId = $this->extractSitePostIdFromUrl($urlData);
		    }
		} else {
		    $sitePostId = $this->extractSitePostIdFromUrl($urlData);
		}

		return $sitePostId;
	}

	/**
	 * @see https://stackoverflow.com/questions/8520969/php-hashing-function-that-returns-an-integer-32bit-int
	 */
	public function extractSitePostIdFromUrl(array $urlData): int
	{
		$path = strtolower($urlData['path']);

		return crc32($path);
	}
}