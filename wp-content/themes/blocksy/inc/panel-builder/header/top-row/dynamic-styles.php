<?php

blocksy_get_variables_from_file(
	get_template_directory() . '/inc/panel-builder/header/middle-row/dynamic-styles.php',
	[],
	[
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,
		'atts' => $atts,
		'selector' => '[data-row="top"]',
		'default_height' => [
			'mobile' => 50,
			'tablet' => 50,
			'desktop' => 50,
		],
		'default_background' => blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => '#f9f9f9',
				],
			],
		])

	]
);

