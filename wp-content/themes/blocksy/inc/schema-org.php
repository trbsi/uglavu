<?php

function blocksy_schema_org_definitions_e($place) {
	echo wp_kses_post(blocksy_schema_org_definitions($place));
}

function blocksy_schema_org_definitions($place) {
	if (get_theme_mod('enable_schema_org_markup', 'yes') === 'no') {
		return '';
	}

	if ($place === 'single') {
		if ( is_page() ) {
			return 'itemscope itemtype="http://schema.org/WebPage"';
		} else {
			return 'itemscope itemtype="http://schema.org/Article"';
		}
	}

	if ($place === 'header') {
		return 'itemscope="itemscope" itemtype="http://schema.org/WPHeader"';
	}

	if ($place === 'logo') {
		return 'itemscope itemtype="http://schema.org/Brand"';
	}

	// Navigation
	if ($place === 'navigation') {
		return 'itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement"';
	}

	// Main
	if ($place === 'blog') {
		return 'itemtype="http://schema.org/Blog" itemscope';
	}

	if ($place === 'breadcrumb') {
		return 'itemscope itemtype="http://schema.org/BreadcrumbList"';
	}

	if ( $place === 'breadcrumb_list') {
		return 'itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"';
	}

	if ($place === 'breadcrumb_itemprop') {
		return 'itemprop="breadcrumb"';
	}

	if ($place === 'sidebar') {
		return 'itemscope="itemscope" itemtype="http://schema.org/WPSideBar"';
	}

	if ($place === 'footer') {
		return 'itemscope="itemscope" itemtype="http://schema.org/WPFooter"';
	}

	if ($place === 'headline') {
		return 'itemprop="headline"';
	}

	if ( $place === 'entry_content') {
		return 'itemprop="text"';
	}

	if ($place === 'publish_date') {
		return 'itemprop="datePublished"';
	}

	if ($place === 'author_name') {
		return 'itemprop="name"';
	}

	if ($place === 'author_link') {
		return 'itemprop="author"';
	}

	if ($place === 'item') {
		return 'itemprop="item"';
	}

	if ($place === 'url') {
		return 'itemprop="url"';
	}

	if ($place === 'position') {
		return 'itemprop="position"';
	}

	if ($place === 'image') {
		return 'itemprop="image"';
	}
}

