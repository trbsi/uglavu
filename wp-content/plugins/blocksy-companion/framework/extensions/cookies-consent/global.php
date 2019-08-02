<?php

// Cookie
$cookieContentColor = blocksy_get_colors(
	get_theme_mod('cookieContentColor'),
	['default' => ['color' => 'var(--paletteColor3)']]
);

$css->put(
	':root',
	"--cookieContentColor: {$cookieContentColor['default']}"
);

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

$cookieBackground = blocksy_get_colors(
	get_theme_mod('cookieBackground'),
	[ 'default' => [ 'color' => '#ffffff' ] ]
);

$css->put(
	':root',
	"--cookieBackground: {$cookieBackground['default']}"
);

$cookieMaxWidth = get_theme_mod( 'cookieMaxWidth', 400 );
$css->put( ':root', '--cookieMaxWidth: ' . $cookieMaxWidth . 'px' );

