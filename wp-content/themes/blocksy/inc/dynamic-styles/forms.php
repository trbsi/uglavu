<?php

// general
$formTextColor = blocksy_get_colors(
	get_theme_mod('formTextColor'),
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'focus' => [ 'color' => 'var(--paletteColor3)' ],
	]
);

$css->put( ':root', "--formTextInitialColor: {$formTextColor['default']}" );
$css->put( ':root', "--formTextFocusColor: {$formTextColor['focus']}" );


$formFontSize = get_theme_mod( 'formFontSize', 15 );
$css->put( ':root', '--formFontSize: ' . $formFontSize . 'px' );


$formBackgroundColor = blocksy_get_colors(
	get_theme_mod('formBackgroundColor'),
	[
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
	]
);

$css->put( ':root', "--formBackgroundInitialColor: {$formBackgroundColor['default']}" );
$css->put( ':root', "--formBackgroundFocusColor: {$formBackgroundColor['focus']}" );


$formInputHeight = get_theme_mod( 'formInputHeight', 45 );
$css->put( ':root', '--formInputHeight: ' . $formInputHeight . 'px' );


$formTextAreaHeight = get_theme_mod( 'formTextAreaHeight', 170 );
$css->put( 'textarea', '--formInputHeight: ' . $formTextAreaHeight . 'px' );


$formBorderColor = blocksy_get_colors(
	get_theme_mod('formBorderColor'),
	[
		'default' => [ 'color' => 'rgba(232, 235, 240, 1)' ],
		'focus' => [ 'color' => 'var(--paletteColor1)' ],
	]
);

$css->put( ':root', "--formBorderInitialColor: {$formBorderColor['default']}" );
$css->put( ':root', "--formBorderFocusColor: {$formBorderColor['focus']}" );


$formBorderSize = get_theme_mod( 'formBorderSize', 1 );
$css->put( ':root', '--formBorderSize: ' . $formBorderSize . 'px' );


// select box
$selectDropdownTextColor = blocksy_get_colors(
	get_theme_mod('selectDropdownTextColor'),
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor3)' ],
		'active' => [ 'color' => '#ffffff' ],
	]
);

$css->put( ':root', "--selectDropdownTextInitialColor: {$selectDropdownTextColor['default']}" );
$css->put( ':root', "--selectDropdownTextHoverColor: {$selectDropdownTextColor['hover']}" );
$css->put( ':root', "--selectDropdownTextActiveColor: {$selectDropdownTextColor['active']}" );


$selectDropdownItemColor = blocksy_get_colors(
	get_theme_mod('selectDropdownItemColor'),
	[
		'hover' => [ 'color' => 'rgba(232, 235, 240, 0.4)' ],
		'active' => [ 'color' => 'var(--paletteColor1)' ],
	]
);

$css->put( ':root', "--selectDropdownItemHoverColor: {$selectDropdownItemColor['hover']}" );
$css->put( ':root', "--selectDropdownItemActiveColor: {$selectDropdownItemColor['active']}" );


$selectDropdownBackground = blocksy_get_colors(
	get_theme_mod('selectDropdownBackground'),
	['default' => ['color' => '#ffffff']]
);

$css->put( ':root', "--selectDropdownBackground: {$selectDropdownBackground['default']}" );


// radio & checkbox
$radioCheckboxColor = blocksy_get_colors(
	get_theme_mod('radioCheckboxColor'),
	[
		'default' => [ 'color' => '#e8ebf0' ],
		'accent' => [ 'color' => 'var(--paletteColor1)' ],
	]
);

$css->put( ':root', "--radioCheckboxInitialColor: {$radioCheckboxColor['default']}" );
$css->put( ':root', "--radioCheckboxAccentColor: {$radioCheckboxColor['accent']}" );
