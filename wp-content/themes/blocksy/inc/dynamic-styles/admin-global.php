<?php

// Color palette
$colorPalette = blocksy_get_colors(
	get_theme_mod('colorPalette'),
	[
		'color1' => [ 'color' => '#3eaf7c' ],
		'color2' => [ 'color' => '#33a370' ],
		'color3' => [ 'color' => 'rgba(44, 62, 80, 0.9)' ],
		'color4' => [ 'color' => 'rgba(44, 62, 80, 1)' ],
		'color5' => [ 'color' => '#ffffff' ],
	]
);

$css->put(
	':root',
	"--paletteColor1: {$colorPalette['color1']}"
);

$css->put(
	':root',
	"--paletteColor2: {$colorPalette['color2']}"
);

$css->put(
	':root',
	"--paletteColor3: {$colorPalette['color3']}"
);

$css->put(
	':root',
	"--paletteColor4: {$colorPalette['color4']}"
);

$css->put(
	':root',
	"--paletteColor5: {$colorPalette['color5']}"
);

// font color
blocksy_output_colors([
	'value' => get_theme_mod('fontColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'color'],
		'hover' => ['variable' => 'colorHover'],
	],
]);


// buttons
$buttonTextColor = blocksy_get_colors( get_theme_mod('buttonTextColor'),
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	]
);

$css->put(
	':root',
	"--buttonTextInitialColor: {$buttonTextColor['default']}"
);

$css->put(
	':root',
	"--buttonTextHoverColor: {$buttonTextColor['hover']}"
);

$button_color = blocksy_get_colors( get_theme_mod('buttonColor'),
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
);

$css->put(
	':root',
	"--buttonInitialColor: {$button_color['default']}"
);

$css->put(
	':root',
	"--buttonHoverColor: {$button_color['hover']}"
);