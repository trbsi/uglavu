<?php

$options = [

	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'has_transparent_header' => [
				'label' => __('Transparent header', 'blocksy'),
				'type' => 'ct-radio',
				'value' => 'default',
				'view' => 'text',
				'inline' => true,
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'default' => __( 'Default', 'blocksy' ),
					'enabled' => __( 'Enabled', 'blocksy' ),
					'disabled' => __( 'Disabled', 'blocksy' ),
				],
			],

			'has_header_top_bar' => [
				'label' => __('Top Bar', 'blocksy'),
				'type' => 'ct-radio',
				'value' => 'default',
				'view' => 'text',
				'inline' => true,
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'default' => __( 'Default', 'blocksy' ),
					'disabled' => __( 'Disabled', 'blocksy' ),
				],
			],

		]
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'condition' => [ 'has_transparent_header' => 'enabled' ],
		'options' => [

			'transparentHeaderFontColor' => [
				'label' => __( 'Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => '#ffffff',
					],

					'hover' => [
						'color' => 'var(--paletteColor1)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],

					[
						'title' => __( 'Hover', 'blocksy' ),
						'id' => 'hover',
					],
				],
			],

			'transparentHeaderBackground' => [
				'label' => __( 'Background Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'noColorTransparent' => true,
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => 'rgba(255, 255, 255, 0.1)',
					],

				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

		]
	]

];

