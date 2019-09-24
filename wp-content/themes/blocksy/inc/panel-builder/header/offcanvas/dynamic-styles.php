<?php

// Offcanvas background
blocksy_output_background_css([
	'selector' => '#offcanvas',
	'css' => $css,
	'value' => blocksy_akg('offcanvasBackground', $atts,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => 'rgba(18, 21, 25, 0.98)'
				],
			],
		])
	)
]);