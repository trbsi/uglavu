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
    $siteData = get_site_and_site_post_id($fieldValues['external_url']);
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
	if (isset($matches[0])) {
	    $sitePostId = end($matches[0]);
	} else {
	    $sitePostId = 0;
	}

	return $sitePostId;
}