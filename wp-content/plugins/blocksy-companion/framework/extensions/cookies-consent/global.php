<?php

// Content color
$cookieContentColor = blocksy_get_colors(
	get_theme_mod('cookieContentColor'),
	['default' => ['color' => 'var(--paletteColor3)']]
);

$css->put(
	'.cookie-notification',
	"--cookieContentColor: {$cookieContentColor['default']}"
);


// Button color
$cookieButtonBackground = blocksy_get_colors(
	get_theme_mod('cookieButtonBackground'),
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
);

$css->put(
	'.cookie-notification',
	"--buttonInitialColor: {$cookieButtonBackground['default']}"
);

$css->put(
	'.cookie-notification',
	"--buttonHoverColor: {$cookieButtonBackground['hover']}"
);

// Background color
$cookieBackground = blocksy_get_colors(
	get_theme_mod('cookieBackground'),
	[ 'default' => [ 'color' => '#ffffff' ] ]
);

$css->put(
	'.cookie-notification',
	"--backgroundColor: {$cookieBackground['default']}"
);

$cookieMaxWidth = get_theme_mod( 'cookieMaxWidth', 400 );
$css->put( ':root', '--cookieMaxWidth: ' . $cookieMaxWidth . 'px' );

