<?php

// general
blocksy_output_colors([
	'value' => get_theme_mod('formTextColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'focus' => [ 'color' => 'var(--paletteColor3)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'formTextInitialColor'],
		'focus' => ['variable' => 'formTextFocusColor'],
	],
]);

$formFontSize = get_theme_mod( 'formFontSize', 15 );
$css->put( ':root', '--formFontSize: ' . $formFontSize . 'px' );

blocksy_output_colors([
	'value' => get_theme_mod('formBackgroundColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'formBackgroundInitialColor'],
		'focus' => ['variable' => 'formBackgroundFocusColor'],
	],
]);

$formInputHeight = get_theme_mod( 'formInputHeight', 45 );
$css->put( ':root', '--formInputHeight: ' . $formInputHeight . 'px' );


$formTextAreaHeight = get_theme_mod( 'formTextAreaHeight', 170 );
$css->put( 'textarea', '--formInputHeight: ' . $formTextAreaHeight . 'px' );

blocksy_output_colors([
	'value' => get_theme_mod('formBorderColor'),
	'default' => [
		'default' => [ 'color' => 'rgba(232, 235, 240, 1)' ],
		'focus' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'formBorderInitialColor'],
		'focus' => ['variable' => 'formBorderFocusColor'],
	],
]);

$formBorderSize = get_theme_mod( 'formBorderSize', 1 );
$css->put( ':root', '--formBorderSize: ' . $formBorderSize . 'px' );


// select box
blocksy_output_colors([
	'value' => get_theme_mod('selectDropdownTextColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor3)' ],
		'active' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'selectDropdownTextInitialColor'],
		'hover' => ['variable' => 'selectDropdownTextHoverColor'],
		'active' => ['variable' => 'selectDropdownItemActiveColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('selectDropdownItemColor'),
	'default' => [
		'hover' => [ 'color' => 'rgba(232, 235, 240, 0.4)' ],
		'active' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'hover' => ['variable' => 'selectDropdownItemHoverColor'],
		'active' => ['variable' => 'selectDropdownItemActiveColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('selectDropdownBackground'),
	'default' => [
		'default' => ['color' => '#ffffff'],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'selectDropdownBackground'],
	],
]);

// radio & checkbox
blocksy_output_colors([
	'value' => get_theme_mod('radioCheckboxColor'),
	'default' => [
		'default' => [ 'color' => '#e8ebf0' ],
		'accent' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'radioCheckboxInitialColor'],
		'accent' => ['variable' => 'radioCheckboxAccentColor'],
	],
]);

