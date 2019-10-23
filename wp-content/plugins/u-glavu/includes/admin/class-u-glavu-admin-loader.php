<?php

namespace UGlavu\Includes\Admin;

use function UGlavu\getContainer;
use UGlavu\Includes\Admin\Posts\Create\UGlavuAdminPostsCreateOgTags;
use UGlavu\Includes\Admin\Posts\Create\UGlavuAdminPostsCreateScrapeOgTags;
use UGlavu\Includes\UGlavuLoader;

class UGlavuAdminLoader {

    private $loader;
    private $container;

	public function __construct(UGlavuLoader $loader)
	{
	    $this->container = getContainer();
		$this->loader = $loader;
	}

    /**
     * Used in uglavu_acf_field_external_url
     */
	public function load_og_tags_scraper_and_saver(): array
	{
		$createOgTags = $this->container->get(UGlavuAdminPostsCreateOgTags::class);
		$scrapeOgTags = $this->container->get(UGlavuAdminPostsCreateScrapeOgTags::class);

		return [
			'createOgTags' => $createOgTags,
			'scrapeOgTags' => $scrapeOgTags
		];
	}
}