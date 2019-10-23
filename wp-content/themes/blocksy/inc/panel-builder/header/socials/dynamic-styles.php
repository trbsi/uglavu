<?php

// Icon size
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-socials',
	'variableName' => 'iconSize',
	'value' => blocksy_akg('socialsIconSize', $atts, [
		'mobile' => 12,
		'tablet' => 12,
		'desktop' => 12,
	])
]);


// Icon spacing
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-socials',
	'variableName' => 'spacing',
	'value' => blocksy_akg('socialsIconSpacing', $atts, [
		'mobile' => 10,
		'tablet' => 10,
		'desktop' => 10,
	])
]);


// Icons custom color
blocksy_output_colors([
	'value' => blocksy_akg('headerSocialsIconColor', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => '.ct-header-socials',
			'variable' => 'color'
		],

		'hover' => [
			'selector' => '.ct-header-socials',
			'variable' => 'colorHover'
		]
	],

	'responsive' => true
]);

// Icons custom background
blocksy_output_colors([
	'value' => blocksy_akg('headerSocialsIconBackground', $atts),
	'default' => [
		'default' => [ 'rgba(218, 222, 228, 0.3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,

	'variables' => [
		'default' => [
			'selector' => '.ct-header-socials',
			'variable' => 'backgroundColor'
		],

		'hover' => [
			'selector' => '.ct-header-socials',
			'variable' => 'backgroundColorHover'
		]
	],

	'responsive' => true
]);


// Margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-header-socials',
	'important' => true,
	'value' => blocksy_default_akg(
		'headerSocialsMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);
