<?php

function blocksy_header_get_transparency() {
	$post_options = blocksy_get_post_options();
	return blocksy_akg('has_transparent_header', $post_options, 'default');
}

function blocksy_header_has_custom_transparency() {
	if (is_singular('post') || blocksy_is_page()) {
		$post_options = blocksy_get_post_options();

		if (
			blocksy_akg(
				'has_transparent_header', $post_options, 'default'
			) !== 'default'
		) {
			return true;
		}
	}

	return false;
}

function blocksy_has_transparent_custom_logo() {
	$transparent_logo_id = null;

	if (
		blocksy_has_transparent_header()
		&&
		get_theme_mod('has_transparent_different_logo', 'no') === 'yes'
	) {
		$transparent_custom_logo_id = get_theme_mod( 'transparent_header_logo' );

		if (! isset($transparent_custom_logo_id['attachment_id'])) {
			$transparent_custom_logo_id = null;
		}

		if ($transparent_custom_logo_id['attachment_id']) {
			$transparent_logo_id = $transparent_custom_logo_id['attachment_id'];
		}
	}

	return !! $transparent_logo_id;
}

function blocksy_has_transparent_header($check_only_forced = false) {
	$has_transparent_header = get_theme_mod(
		'has_global_transparent_header', 'no'
	) === 'yes';

	if ($has_transparent_header || $check_only_forced) {
		$rules = get_theme_mod('disable_transparent_header', [
			'blog_home' => true,
			'blog_archives' => true,
			'posts' => false,
			'pages' => false,
			'search' => true,
			'error' => true,
			'shop_home' => true,
			'shop_arhives' => true,
		]);

		$is_enabled_by_rules = false;
		$has_transparent_header = false;

		if (is_home() && is_front_page()) {
			if (!blocksy_akg('blog_home', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if (is_category() || is_tag()) {
			if (!blocksy_akg('blog_archives', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if (is_singular('post')) {
			if (!blocksy_akg('posts', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if (blocksy_is_page()) {
			if (!blocksy_akg('pages', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if (is_search()) {
			if (!blocksy_akg('search', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if (is_404()) {
			if (!blocksy_akg('error', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if (function_exists('is_shop') && is_shop()) {
			if (!blocksy_akg('shop_home', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if (
			function_exists('is_shop') && (
				is_product_category() || is_product_tag()
			) && blocksy_akg('shop_arhives', $rules)
		) {
			if (!blocksy_akg('shop_home', $rules)) {
				$has_transparent_header = true;
				$is_enabled_by_rules = true;
			}
		}

		if ($check_only_forced) {
			return $is_enabled_by_rules;
		}
	}

	if (is_singular('post') || blocksy_is_page()) {
		$post_options = blocksy_get_post_options();

		if (
			blocksy_akg(
				'has_transparent_header', $post_options, 'default'
			) !== 'default'
		) {
			$has_transparent_header = blocksy_akg(
				'has_transparent_header', $post_options, 'default'
			) === 'enabled';
		}
	}

	return $has_transparent_header;
}
