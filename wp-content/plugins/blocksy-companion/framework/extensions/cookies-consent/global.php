<?php

// Content color
blocksy_output_colors([
	'value' => get_theme_mod('cookieContentColor'),

	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],

	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => '.cookie-notification',
			'variable' => 'cookieContentColor'
		],
	],
]);


// Button color
blocksy_output_colors([
	'value' => get_theme_mod('cookieButtonBackground'),

	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],

	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => '.cookie-notification',
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => '.cookie-notification',
			'variable' => 'buttonHoverColor'
		]
	],
]);

// Background color
blocksy_output_colors([
	'value' => get_theme_mod('cookieBackground'),

	'default' => [
		'default' => [ 'color' => '#ffffff' ],
	],

	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => '.cookie-notification',
			'variable' => 'backgroundColor'
		],
	],
]);

$cookieMaxWidth = get_theme_mod( 'cookieMaxWidth', 400 );
$css->put( ':root', '--cookieMaxWidth: ' . $cookieMaxWidth . 'px' );

