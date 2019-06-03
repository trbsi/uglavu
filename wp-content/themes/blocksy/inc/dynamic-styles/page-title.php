<?php

$page_title_source = blocksy_get_page_title_source(is_customize_preview());

if ($page_title_source) {
	$type = blocksy_akg_or_customizer(
		'hero_section',
		$page_title_source,
		'type-1'
	);

	if (
		function_exists('is_woocommerce')
		&&
		(
			is_product_category()
			||
			is_product_tag()
		)
	) {
		$type = 'type-2';
	}

	// title size
	blocksy_output_responsive([
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => ':root',
		'variableName' => 'pageTitleFontSize',
		'value' => blocksy_akg_or_customizer(
			'pageTitleFontSize',
			$page_title_source,
			[
				'mobile' => 25,
				'tablet' => 30,
				'desktop' => 32,
			]
		),
	]);

	// font color
	$pageTitleFontColor = blocksy_get_colors( blocksy_akg_or_customizer(
		'pageTitleFontColor',
		$page_title_source,
		[
			'default' => [ 'color' => 'var(--paletteColor3)' ],
			'hover' => [ 'color' => 'var(--paletteColor1)' ],
		]
	));

	$css->put(
		':root',
		"--pageTitleFontInitialColor: {$pageTitleFontColor['default']}"
	);

	$css->put(
		':root',
		"--pageTitleFontHoverColor: {$pageTitleFontColor['hover']}"
	);

	if ($type === 'type-2' || is_customize_preview()) {
		// height
		blocksy_output_responsive([
			'css' => $css,
			'tablet_css' => $tablet_css,
			'mobile_css' => $mobile_css,
			'selector' => ':root',
			'variableName' => 'pageTitleMinHeight',
			'unit' => '',
			'value' => blocksy_akg_or_customizer(
				'hero_height',
				$page_title_source,
				'230px'
			)
		]);

		// overlay color
		$pageTitleOverlay = blocksy_get_colors( blocksy_akg_or_customizer(
			'pageTitleOverlay',
			$page_title_source,
			[ 'default' => [ 'color' => 'rgba(41, 51, 60, 0.2)' ] ]
		));

		$css->put(
			':root',
			"--pageTitleOverlay: {$pageTitleOverlay['default']}"
		);

		// background color
		$pageTitleBackground = blocksy_get_colors( blocksy_akg_or_customizer(
			'pageTitleBackground',
			$page_title_source,
			[ 'default' => [ 'color' => '#EDEFF2' ] ]
		));

		$css->put(
			':root',
			"--pageTitleBackground: {$pageTitleBackground['default']}"
		);
	}
}
