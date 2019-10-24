<?php

namespace UGlavu\Includes\Admin;

use function UGlavu\getContainer;
use UGlavu\Includes\Admin\Posts\Create\UGlavuAdminPostsCreateScrapeOgTags;

class UGlavuAdminLoader
{

    private $container;

    public function __construct()
    {
        $this->container = getContainer();
    }

    /**
     * Used in uglavu_acf_field_external_url
     */
    public function loadOgTagsScraper(): UGlavuAdminPostsCreateScrapeOgTags
    {
        return $this->container->get(UGlavuAdminPostsCreateScrapeOgTags::class);
    }
}