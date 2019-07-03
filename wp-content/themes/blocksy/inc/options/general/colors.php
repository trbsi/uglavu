<?php
/**
 * Colors options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'colors_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			'colorPalette' => [
				'label' => __( 'Global Colors', 'blocksy' ),
				'type'  => 'ct-color-palettes-picker',
				'design' => 'block',
				'setting' => [ 'transport' => 'postMessage' ],
				'predefined' => true,
				'wrapperAttr' => [ 'data-type' => 'color-palette' ],

				'value' => [
					'color1' => [
						'color' => '#3eaf7c',
					],

					'color2' => [
						'color' => '#33a370',
					],

					'color3' => [
						'color' => 'rgba(44, 62, 80, 0.9)',
					],

					'color4' => [
						'color' => 'rgba(44, 62, 80, 1)',
					],

					'color5' => [
						'color' => '#ffffff',
					],

					'current_palette' => 'palette-1',

					'palettes' => [
						[
							'id' => 'palette-1',

							'color1' => [
								'color' => '#3eaf7c',
							],

							'color2' => [
								'color' => '#33a370',
							],

							'color3' => [
								'color' => 'rgba(44, 62, 80, 0.9)',
							],

							'color4' => [
								'color' => 'rgba(44, 62, 80, 1)',
							],

							'color5' => [
								'color' => '#ffffff',
							],
						],

						[
							'id' => 'palette-2',

							'color1' => [
								'color' => '#2872fa',
							],

							'color2' => [
								'color' => '#1559ed',
							],

							'color3' => [
								'color' => 'rgba(36,59,86,0.9)',
							],

							'color4' => [
								'color' => 'rgba(36,59,86,1)',
							],

							'color5' => [
								'color' => '#ffffff',
							],
						],

						[
							'id' => 'palette-3',

							'color1' => [
								'color' => '#FB7258',
							],

							'color2' => [
								'color' => '#F74D67',
							],

							'color3' => [
								'color' => '#6e6d76',
							],

							'color4' => [
								'color' => '#0e0c1b',
							],

							'color5' => [
								'color' => '#ffffff',
							],
						]
					]
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'fontColor' => [
				'label' => __( 'Base Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor3)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'h1Color' => [
				'label' => __( 'Heading 1 (H1)', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor4)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'h2Color' => [
				'label' => __( 'Heading 2 (H2)', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor4)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'h3Color' => [
				'label' => __( 'Heading 3 (H3)', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor4)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'h4Color' => [
				'label' => __( 'Heading 4 (H4)', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor4)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'h5Color' => [
				'label' => __( 'Heading 5 (H5)', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor4)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'h6Color' => [
				'label' => __( 'Heading 6 (H6)', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor4)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],


			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'linkColor' => [
				'label' => __( 'Link Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor3)',
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

			'buttonColor' => [
				'label' => __( 'Button Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => 'var(--paletteColor1)',
					],

					'hover' => [
						'color' => 'var(--paletteColor2)',
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

		],
	],
];
