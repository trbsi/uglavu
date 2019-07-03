<?php

// Mailchimp
$mailchimpContent = blocksy_get_colors( get_theme_mod(
	'mailchimpContent',
	[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
));

$css->put(
	':root',
	"--mailchimpContent: {$mailchimpContent['default']}"
);

$mailchimpButton = blocksy_get_colors( get_theme_mod(
	'mailchimpButton',
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
));

$css->put(
	'.ct-mailchimp-block',
	"--buttonInitialColor: {$mailchimpButton['default']}"
);

$css->put(
	'.ct-mailchimp-block',
	"--buttonHoverColor: {$mailchimpButton['hover']}"
);

$mailchimpBackground = blocksy_get_colors( get_theme_mod(
	'mailchimpBackground',
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--mailchimpBackground: {$mailchimpBackground['default']}"
);

$mailchimpShadow = blocksy_get_colors( get_theme_mod(
	'mailchimpShadow',
	[ 'default' => [ 'color' => 'rgba(210, 213, 218, 0.4)' ] ]
));

$css->put(
	':root',
	"--mailchimpShadow: {$mailchimpShadow['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'mailchimpSpacing',
	'value' => get_theme_mod('mailchimpSpacing', [
		'mobile' => '40px',
		'tablet' => '40px',
		'desktop' => '40px',
	]),
	'unit' => ''
]);

