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
	blocksy_output_font_css([
		'font_value' => blocksy_akg_or_customizer(
			'pageTitleFont',
			$page_title_source,
			blocksy_typography_default_values([
				'size' => [
					'desktop' => '32px',
					'tablet'  => '30px',
					'mobile'  => '25px'
				],
				'variation' => 'n7',
				'line-height' => '1.3',
			])
		),
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'selector' => '.entry-header .page-title'
	]);

	// font color
	$pageTitleFontColor = blocksy_get_colors(
		blocksy_akg_or_customizer(
			'pageTitleFontColor',
			$page_title_source
		),
		[
			'default' => [ 'color' => 'var(--paletteColor4)' ],
			'hover' => [ 'color' => 'var(--paletteColor1)' ],
		]
	);

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
		$pageTitleOverlay = blocksy_get_colors(
			blocksy_akg_or_customizer(
				'pageTitleOverlay',
				$page_title_source
			),
			[ 'default' => [ 'color' => 'rgba(41, 51, 60, 0.2)' ] ]
		);

		$css->put(
			':root',
			"--pageTitleOverlay: {$pageTitleOverlay['default']}"
		);

		// background color
		$pageTitleBackground = blocksy_get_colors(
			blocksy_akg_or_customizer(
				'pageTitleBackground',
				$page_title_source
			),
			[ 'default' => [ 'color' => '#EDEFF2' ] ]
		);

		$css->put(
			':root',
			"--pageTitleBackground: {$pageTitleBackground['default']}"
		);
	}
}
