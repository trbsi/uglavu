<?php

add_action('acf/save_post', 'save_external_url', 15);
function save_external_url( $post_id ) {
	global $wpdb;

	if (!isset($_POST['og_title'])) {
		return;
	}

    if (empty($_POST['og_title'])) {
    	return;
    }

    $fieldValues = get_fields( $post_id );
    $externalUrl = strtok($fieldValues['external_url'], '?');
    $siteData = get_site_and_site_post_id($externalUrl);
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

function get_site_and_site_post_id($externalUrl)
{
	global $wpdb;

	//get site id
	$host = get_host_from_url($externalUrl);

	$ogTagsSitesTable = $wpdb->prefix . 'og_tags_sites';
	$query = "SELECT * FROM $ogTagsSitesTable WHERE site_key = %s";
	$siteData = $wpdb->get_row($wpdb->prepare($query, [$host]));

	//get site post id from url
	$sitePostId = get_site_post_id($externalUrl);

	return [
		'siteId' => $siteData->id,
		'sitePostId' => $sitePostId
	];
}

function get_host_from_url($externalUrl)
{
	$parsedUrl = parse_url($externalUrl);
	return str_replace('www.', '', $parsedUrl['host']);
}

function get_site_post_id($externalUrl)
{
	$externalUrl = strtok($externalUrl, '?');
	preg_match_all('/\d+/', $externalUrl, $matches);
	if (!empty($matches[0])) {
	    $sitePostId = end($matches[0]);
	} else {
	    $urlData = parse_url($url);
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
		$sitePostId+= strlen($url);
	}

	return $sitePostId;
}