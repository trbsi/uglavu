<?php

// Icon color
blocksy_output_colors([
	'value' => blocksy_akg('triggerIconColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-header-trigger',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.ct-header-trigger',
			'variable' => 'linkHoverColor'
		],
	],
]);

