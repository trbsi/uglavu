<?php

// pattern
$patternColor = blocksy_get_colors(
	get_theme_mod('patternColor'),
	['default' => ['color' => '#e5e7ea']]
);

$css->put(
	':root',
	"--patternColor: {$patternColor['default']}"
);

// background image
$background_image = get_theme_mod('site_background_image', [
	'attachment_id' => null,
	'x' => 0.5,
	'y' => 0.5
]);

$image_url = wp_get_attachment_url($background_image['attachment_id']);

$css->put(
	':root',
	"--siteBackgroundImage: url(" . $image_url . ")"
);

$css->put(
	':root',
	"--siteBackgroundPosition: " . (floatval($background_image['x']) * 100) . "% " . (
		floatval($background_image['y']) * 100
	) . '%'
);

$background_size = get_theme_mod('site_background_size', 'auto');

$css->put(
	':root',
	"--siteBackgroundSize: {$background_size}"
);


$background_attachment = get_theme_mod('site_background_attachment', 'scroll');

$css->put(
	':root',
	"--siteBackgroundAttachment: {$background_attachment}"
);

$background_repeat = get_theme_mod('site_background_repeat', 'no-repeat');

$css->put(
	':root',
	"--siteBackgroundRepeat: {$background_repeat}"
);
