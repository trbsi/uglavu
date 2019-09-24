<?php

// link font
blocksy_output_font_css([
	'font_value' => blocksy_akg('mobileMenuFont', $atts,
		blocksy_typography_default_values([
			'size' => [
				'desktop' => '30px',
				'tablet'  => '30px',
				'mobile'  => '23px'
			],
			'variation' => 'n7',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.mobile-menu'
]);


// link color
blocksy_output_colors([
	'value' => blocksy_akg('mobileMenuColor', $atts),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.mobile-menu',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.mobile-menu',
			'variable' => 'linkHoverColor'
		],
	],
]);


// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '[data-id="mobile-menu"]',
	'value' => blocksy_default_akg(
		'mobileMenuMargin', $atts,
		blocksy_spacing_value([
			'left' => 'auto',
			'right' => 'auto',
			'linked' => true,
		])
	)
]);
