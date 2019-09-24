<?php

if (! function_exists('is_woocommerce')) {
	return;
}

if (! is_woocommerce()) {
	return;
}

blocksy_output_colors([
	'value' => get_theme_mod('cardProductTitleColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.shop-entry-card',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.shop-entry-card',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('cardProductCategoriesColor'),
	'default' => [
		'default' => [ 'color' => 'rgba(44,62,80,0.7)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => 'article .product-categories',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => 'article .product-categories',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('cardProductPriceColor'),
	'default' => ['default' => ['color' => 'var(--paletteColor3)']],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.shop-entry-card .price',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('cardStarRatingColor'),
	'default' => ['default' => ['color' => '#FDA256']],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.shop-entry-card',
			'variable' => 'starRatingColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('saleBadgeColor'),
	'default' => [
		'text' => [ 'color' => '#ffffff' ],
		'background' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'text' => [
			'selector' => '.shop-entry-card',
			'variable' => 'saleBadgeTextColor'
		],

		'background' => [
			'selector' => '.shop-entry-card',
			'variable' => 'saleBadgeBackgroundColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('cardProductImageOverlay'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.shop-entry-card',
			'variable' => 'imageOverlay'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('cardProductAction1Color'),
	'default' => [
		'default' => ['color' => 'var(--paletteColor3)'],
		'hover' => ['color' => 'var(--paletteColor1)'],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.woo-card-actions',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.woo-card-actions',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('cardProductAction2Color'),
	'default' => [
		'default' => [ 'color' => 'var(--buttonInitialColor)' ],
		'hover' => [ 'color' => 'var(--buttonHoverColor)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.woo-card-actions',
			'variable' => 'wooButtonInitialColor'
		],

		'hover' => [
			'selector' => '.woo-card-actions',
			'variable' => 'wooButtonHoverColor'
		],
	],
]);


// woo single product
$productGalleryWidth = get_theme_mod( 'productGalleryWidth', 50 );
$css->put( ':root', '--productGalleryWidth: ' . $productGalleryWidth . '%' );

blocksy_output_colors([
	'value' => get_theme_mod('singleProductPriceColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-summary .price',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('singleSaleBadgeColor'),
	'default' => [
		'text' => [ 'color' => '#ffffff' ],
		'background' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'text' => [
			'selector' => '.product > span.onsale',
			'variable' => 'saleBadgeTextColor'
		],

		'background' => [
			'selector' => '.product > span.onsale',
			'variable' => 'saleBadgeBackgroundColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('singleStarRatingColor'),
	'default' => [
		'default' => [ 'color' => '#FDA256' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.entry-summary,.woocommerce-tabs',
			'variable' => 'starRatingColor'
		],
	],
]);

