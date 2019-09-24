<?php

// Container max-width
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-text',
	'variableName' => 'maxWidth',
	'value' => blocksy_akg('headerTextMaxWidth', $atts, [
		'mobile' => 100,
		'tablet' => 100,
		'desktop' => 100,
	]),
	'unit' => '%'
]);


blocksy_output_font_css([
	'font_value' => blocksy_akg( 'headerTextFont', $atts,
		blocksy_typography_default_values([
			'size' => '15px',
			'variation' => 'n4',
			'line-height' => '1.3',
		])
	),
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-text'
]);


// Font color
blocksy_output_colors([
	'value' => blocksy_akg('headerTextColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-header-text',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.ct-header-text',
			'variable' => 'linkHoverColor'
		],
	],
]);


// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-text',
	'value' => blocksy_default_akg(
		'headerTextMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);