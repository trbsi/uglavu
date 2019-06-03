<?php

add_action('pre_get_posts', function ($query) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if (! (
		is_home() || is_archive() || is_search()
	)) {
		return;
	}

	if (function_exists('is_woocommerce')) {
		if (is_woocommerce()) {
			return;
		}
	}

	$listing_source = blocksy_get_posts_listing_source();

	$query->set(
		'posts_per_page',

		intval(blocksy_akg_or_customizer(
			'archive_per_page',
			$listing_source,
			10
		))
	);
});


function blocksy_get_posts_listing_source() {
	static $result = null;

	if (! is_null($result)) {
		return $result;
	}

	if (is_category() || is_tag()) {
		$result = [
			'strategy' => 'customizer',
			'prefix' => 'categories'
		];

		return $result;
	}

	if (is_search()) {
		$result = [
			'strategy' => 'customizer',
			'prefix' => 'search'
		];

		return $result;
	}

	if (is_author()) {
		$result = [
			'strategy' => 'customizer',
			'prefix' => 'author'
		];

		return $result;
	}

	$result = [
		'strategy' => 'customizer',
		'prefix' => 'blog'
	];

	return $result;
}
