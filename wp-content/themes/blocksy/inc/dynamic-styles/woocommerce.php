<?php

if (function_exists('is_woocommerce') && is_woocommerce()) {

	$cardProductTitleColor = blocksy_get_colors( get_theme_mod(
		'cardProductTitleColor',
		[
			'default' => [ 'color' => 'var(--paletteColor3)' ],
			'hover' => [ 'color' => 'var(--paletteColor1)' ],
		]
	));

	$css->put(
		'.shop-entry-card',
		"--linkInitialColor: {$cardProductTitleColor['default']}"
	);

	$css->put(
		'.shop-entry-card',
		"--linkHoverColor: {$cardProductTitleColor['hover']}"
	);


	$cardProductCategoriesColor = blocksy_get_colors( get_theme_mod(
		'cardProductCategoriesColor',
		[
			'default' => [ 'color' => 'rgba(44,62,80,0.7)' ],
			'hover' => [ 'color' => 'var(--paletteColor1)' ],
		]
	));

	$css->put(
		'.product-categories',
		"--linkInitialColor: {$cardProductCategoriesColor['default']}"
	);

	$css->put(
		'.product-categories',
		"--linkHoverColor: {$cardProductCategoriesColor['hover']}"
	);

	$cardProductPriceColor = blocksy_get_colors( get_theme_mod( 'cardProductPriceColor',
		[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
	));

	$css->put(
		'.shop-entry-card .price',
		"--fontColor: {$cardProductPriceColor['default']}"
	);

	$cardStarRatingColor = blocksy_get_colors( get_theme_mod( 'cardStarRatingColor',
		[ 'default' => [ 'color' => '#FDA256' ] ]
	));

	$css->put(
		'.shop-entry-card',
		"--starRatingColor: {$cardStarRatingColor['default']}"
	);

	$saleBadgeColor = blocksy_get_colors( get_theme_mod(
		'saleBadgeColor',
		[
			'text' => [ 'color' => '#ffffff' ],
			'background' => [ 'color' => 'var(--paletteColor1)' ],
		]
	));

	$css->put(
		'.shop-entry-card',
		"--saleBadgeTextColor: {$saleBadgeColor['text']}"
	);

	$css->put(
		'.shop-entry-card',
		"--saleBadgeBackgroundColor: {$saleBadgeColor['background']}"
	);

	$cardProductImageOverlay = blocksy_get_colors( get_theme_mod( 'cardProductImageOverlay',
		[ 'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ] ]
	));

	$css->put(
		'.shop-entry-card',
		"--imageOverlay: {$cardProductImageOverlay['default']}"
	);

	$cardProductAction1Color = blocksy_get_colors( get_theme_mod(
		'cardProductAction1Color',
		[
			'default' => [ 'color' => 'var(--paletteColor3)' ],
			'hover' => [ 'color' => 'var(--paletteColor1)' ],
		]
	));

	$css->put(
		'.woo-card-actions',
		"--linkInitialColor: {$cardProductAction1Color['default']}"
	);

	$css->put(
		'.woo-card-actions',
		"--linkHoverColor: {$cardProductAction1Color['hover']}"
	);

	$cardProductAction2Color = blocksy_get_colors( get_theme_mod(
		'cardProductAction2Color',
		[
			'default' => [ 'color' => 'var(--buttonInitialColor)' ],
			'hover' => [ 'color' => 'var(--buttonHoverColor)' ],
		]
	));

	$css->put(
		'.woo-card-actions',
		"--wooButtonInitialColor: {$cardProductAction2Color['default']}"
	);

	$css->put(
		'.woo-card-actions',
		"--wooButtonHoverColor: {$cardProductAction2Color['hover']}"
	);


	// woo single product
	$productGalleryWidth = get_theme_mod( 'productGalleryWidth', 50 );
	$css->put( ':root', '--productGalleryWidth: ' . $productGalleryWidth . '%' );


	$singleProductPriceColor = blocksy_get_colors( get_theme_mod( 'singleProductPriceColor',
		[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
	));

	$css->put(
		'.entry-summary .price',
		"--fontColor: {$singleProductPriceColor['default']}"
	);


	$singleSaleBadgeColor = blocksy_get_colors( get_theme_mod(
		'singleSaleBadgeColor',
		[
			'text' => [ 'color' => '#ffffff' ],
			'background' => [ 'color' => 'var(--paletteColor1)' ],
		]
	));

	$css->put(
		'.product > span.onsale',
		"--saleBadgeTextColor: {$singleSaleBadgeColor['text']}"
	);

	$css->put(
		'.product > span.onsale',
		"--saleBadgeBackgroundColor: {$singleSaleBadgeColor['background']}"
	);


	$singleStarRatingColor = blocksy_get_colors( get_theme_mod( 'singleStarRatingColor',
		[ 'default' => [ 'color' => '#FDA256' ] ]
	));

	$css->put(
		'.entry-summary,.woocommerce-tabs',
		"--starRatingColor: {$singleStarRatingColor['default']}"
	);
}

