<?php

blocksy_get_variables_from_file(
	get_template_directory() . '/inc/panel-builder/header/middle-row/dynamic-styles.php',
	[],
	[
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'atts' => $atts,
		'selector' => '[data-row="bottom"]',
		'default_height' => [
			'mobile' => 80,
			'tablet' => 80,
			'desktop' => 80,
		],
		'default_background' => blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => '#fdfdfd',
				],
			],
		])
	]
);
