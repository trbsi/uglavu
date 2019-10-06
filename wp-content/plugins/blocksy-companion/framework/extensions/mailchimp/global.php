<?php

// Mailchimp
blocksy_output_colors([
	'value' => get_theme_mod('mailchimpContent'),

	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],

	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'mailchimpContent'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('mailchimpButton'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'buttonHoverColor'
		]
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('mailchimpBackground'),
	'default' => ['default' => [ 'color' => '#ffffff' ]],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'backgroundColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('mailchimpShadow'),
	'default' => ['default' => [ 'color' => 'rgba(210, 213, 218, 0.4)' ]],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-mailchimp-block',
			'variable' => 'mailchimpShadow'
		],
	],
]);

blocksy_output_box_shadow([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-mailchimp-block',
	'value' => get_theme_mod('mailchimpShadow', blocksy_box_shadow_value([
		'enable' => true,
		'h_offset' => 0,
		'v_offset' => 50,
		'blur' => 90,
		'spread' => 0,
		'inset' => false,
		'color' => [
			'color' => 'rgba(210, 213, 218, 0.4)',
		],
	])),
	'responsive' => true
]);


blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-mailchimp-block',
	'variableName' => 'padding',
	'value' => get_theme_mod('mailchimpSpacing', [
		'mobile' => '40px',
		'tablet' => '40px',
		'desktop' => '40px',
	]),
	'unit' => ''
]);
