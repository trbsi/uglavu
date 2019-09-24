<?php

if (empty($selector)) {
	$selector = '[data-row="middle"]';
}

if (empty($default_height)) {
	$default_height = [
		'mobile' => 70,
		'tablet' => 70,
		'desktop' => 120,
	];
}

if (empty($default_background)) {
	$default_background = blocksy_background_default_value([
		'backgroundColor' => [
			'default' => [
				'color' => '#ffffff',
			],
		],
	]);
}

// Row height
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => $selector,
	'variableName' => 'height',
	'value' => blocksy_akg('headerRowHeight', $atts, $default_height)
]);


// Row background
blocksy_output_background_css([
	'selector' => $selector,
	'css' => $css,
	'value' => blocksy_akg('headerRowBackground', $atts,
		$default_background
	)
]);


// Top Border
blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => $selector . '[data-border] > div:before',
	'variableName' => 'border',
	'value' => blocksy_akg('headerRowTopBorder', $atts, [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(44,62,80,0.2)',
		],
	]),
	'responsive' => true
]);


// Bottom Border
blocksy_output_border([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => $selector . '[data-border] > div:after',
	'variableName' => 'border',
	'value' => blocksy_akg('headerRowBottomBorder', $atts, [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(44,62,80,0.2)',
		],
	]),
	'responsive' => true
]);

