<?php

namespace UGlavu\Includes\Admin\Posts\Create;

class UGlavuAdminPostsCreateScrapeOgTags
{

    private $createOgTags;

    public function __construct(
        UGlavuAdminPostsCreateOgTags $createOgTags
    )
    {
        $this->createOgTags = $createOgTags;
    }

    /**
     * Ajax function
     */
    public function scrapeFbOgTags()
    {
        $externalUrl = str_replace([' '], '', $_POST['external_url']);

        //check if this is URL
        $this->checkIfThisIsUrl($externalUrl);

        //check if site is supported
        $this->isSiteSupported($externalUrl);

        //check if someone already posted this story
        $this->isStoryAlreadyPosted($externalUrl);

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
            if (!isset($webSiteMetaData['og:url'])) {
                $webSiteMetaData['og:url'] = strtok($externalUrl, '?');
            }
            echo json_encode($webSiteMetaData);
        } catch (\Exception $e) {
            echo json_encode([]);
        }

        wp_die();
    }

    private function checkIfThisIsUrl($externalUrl)
    {
        if (false === filter_var($externalUrl, FILTER_VALIDATE_URL)) {
            wp_send_json_error(['message' => 'Wrong URL bi-yatch']);
            wp_die();
        }
    }

    private function isSiteSupported($externalUrl)
    {
        global $wpdb;
        $ogTagsSitesTable = $wpdb->prefix . 'og_tags_sites';
        $query = "SELECT * FROM $ogTagsSitesTable WHERE site_key = %s";
        $siteData = $wpdb->get_row($wpdb->prepare($query, [$this->createOgTags->getHostFromUrl($externalUrl)]));

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

    private function isStoryAlreadyPosted($externalUrl)
    {
        global $wpdb;
        $siteData = $this->createOgTags->getSiteAndSitePostId($externalUrl);

        $ogTagsTable = $wpdb->prefix . 'og_tags';
        $query = "SELECT * FROM $ogTagsTable 
		WHERE site_id = %s AND site_post_id = %s 
		AND (created_at BETWEEN CAST('%s' AS DATETIME) AND CAST('%s' AS DATETIME))
		";
        $siteData = $wpdb->get_row($wpdb->prepare($query, [
            $siteData['siteId'],
            $siteData['sitePostId'],
            date('Y-m-d 00:00:00'),
            date('Y-m-d 23:59:59')
        ]));

        if (null !== $siteData) {
            wp_send_json_error(['message' => 'Someone already posted this story']);
            wp_die();
        }
    }

    public function getOgPostById($id)
    {
        global $wpdb;
        $ogTagsTable = $wpdb->prefix . 'og_tags';
        $query = "SELECT * FROM $ogTagsTable WHERE post_id = %s";
        return $wpdb->get_row($wpdb->prepare($query, [$id]));
    }
}