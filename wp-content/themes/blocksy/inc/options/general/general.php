<?php
/**
 * General options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'general_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'customizer_section' => 'layout',
		'inner-options' => [

			[
				'site_background' => [
					'label' => __( 'Site Background', 'blocksy' ),
					'type' => 'ct-background',
					'design' => 'inline',
					'setting' => [ 'transport' => 'postMessage' ],
					'value' => blocksy_background_default_value([
						'backgroundColor' => [
							'default' => [
								'color' => '#f8f9fb'
							],
						],
					])
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				'maxSiteWidth' => [
					'label' => __( 'Maximum Site Width', 'blocksy' ),
					'type' => 'ct-slider',
					'value' => 1290,
					'min' => 950,
					'max' => 1900,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
					'attr' => [ 'data-type' => 'small' ],
				],

				'contentAreaSpacing' => [
					'label' => __( 'Content Area Spacing', 'blocksy' ),
					'type' => 'ct-slider',
					'value' => [
						'desktop' => '80px',
						'tablet' => '60px',
						'mobile' => '50px',
					],
					'units' => blocksy_units_config([
						[ 'unit' => 'px', 'min' => 0, 'max' => 300 ],
					]),
					'responsive' => true,
					'setting' => [ 'transport' => 'postMessage' ],
					'desc' => __( 'Main content area top and bottom spacing.', 'blocksy' ),
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
					'attr' => [ 'data-type' => 'small' ],
				],

				'narrowContainerWidth' => [
					'label' => __( 'Narrow Container Width', 'blocksy' ),
					'type' => 'ct-slider',
					'defaultUnit' => '%',
					'value' => 60,
					'min' => 40,
					'max' => 80,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'wideOffset' => [
					'label' => __( 'Wide Alignment Offset', 'blocksy' ),
					'type' => 'ct-slider',
					'defaultUnit' => 'px',
					'value' => 130,
					'min' => 50,
					'max' => 200,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],
			],

			
			blocksy_get_options('general/form-elements'),


			'has_back_top' => [
				'label' => __( 'Scroll to Top', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'no',
				'setting' => [ 'transport' => 'postMessage' ],
				'inner-options' => [

					blocksy_rand_md5() => [
						'title' => __( 'General', 'blocksy' ),
						'type' => 'tab',
						'options' => [

							'top_button_type' => [
								'label' => false,
								'type' => 'ct-image-picker',
								'value' => 'type-1',
								'attr' => [
									'data-type' => 'background',
									'data-columns' => '3',
								],
								'setting' => [ 'transport' => 'postMessage' ],
								'choices' => [

									'type-1' => [
										'src'   => blocksy_image_picker_file( 'top-1' ),
										'title' => __( 'Type 1', 'blocksy' ),
									],

									'type-2' => [
										'src'   => blocksy_image_picker_file( 'top-2' ),
										'title' => __( 'Type 2', 'blocksy' ),
									],

									'type-3' => [
										'src'   => blocksy_image_picker_file( 'top-3' ),
										'title' => __( 'Type 3', 'blocksy' ),
									],
								],
							],

							'top_button_shape' => [
								'label' => __( 'Shape', 'blocksy' ),
								'type' => 'ct-radio',
								'value' => 'square',
								'view' => 'radio',
								'inline' => true,
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],
								'choices' => [
									'square' => __( 'Square', 'blocksy' ),
									'circle' => __( 'Circle', 'blocksy' ),
								],
							],

							'topButtonOffset' => [
								'label' => __( 'Bottom Offset', 'blocksy' ),
								'type' => 'ct-slider',
								'min' => 25,
								'max' => 300,
								'value' => 25,
								'responsive' => true,
								'divider' => 'top',
								'setting' => [ 'transport' => 'postMessage' ],
							],

							'top_button_alignment' => [
								'label' => __( 'Alignment', 'blocksy' ),
								'type' => 'ct-radio',
								'value' => 'right',
								'setting' => [ 'transport' => 'postMessage' ],
								'view' => 'text',
								'divider' => 'top',
								'attr' => [ 'data-type' => 'alignment' ],
								'choices' => [
									'left' => '',
									'right' => '',
								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
							],

							'back_top_visibility' => [
								'label' => __( 'Visibility', 'blocksy' ),
								'type' => 'ct-visibility',
								'design' => 'block',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'desktop' => true,
									'tablet' => true,
									'mobile' => false,
								],

								'choices' => blocksy_ordered_keys([
									'desktop' => __( 'Desktop', 'blocksy' ),
									'tablet' => __( 'Tablet', 'blocksy' ),
									'mobile' => __( 'Mobile', 'blocksy' ),
								]),
							],

						],
					],

					blocksy_rand_md5() => [
						'title' => __( 'Design', 'blocksy' ),
						'type' => 'tab',
						'options' => [

							'topButtonIconColor' => [
								'label' => __( 'Icon Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => '#ffffff',
									],

									'hover' => [
										'color' => '#ffffff',
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

							'topButtonShapeBackground' => [
								'label' => __( 'Shape Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => 'var(--paletteColor3)',
									],

									'hover' => [
										'color' => 'var(--paletteColor4)',
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

				],
			],


			'has_passepartout' => [
				'label' => __( 'Passepartout', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'no',
				'setting' => [ 'transport' => 'postMessage' ],
				'inner-options' => [

					'passepartoutSize' => [
						'label' => __( 'Passepartout Size', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 50,
						'responsive' => true,
						'value' => [
							'mobile' => 0,
							'tablet' => 10,
							'desktop' => 10,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'passepartoutColor' => [
						'label' => __( 'Passepartout Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'default' => [
								'color' => 'var(--paletteColor1)',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
							],
						],
					],

				],
			],


			'has_lazy_load' => [
				'label' => __( 'Lazy Load', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'yes',
				'inner-options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-notification',
						'text' => __( 'This option controls how images are loading on your page. Please note, that this option will be auto disabled if you have JetPack\'s lazy load enabled.', 'blocksy' ),
					],

					'lazy_load_type' => [
						'label' => __( 'Animation Type', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'fade',
						'inline' => true,
						'view' => 'radio',
						'choices' => [
							'fade' => __( 'Fade', 'blocksy' ),
							'circle' => __( 'Circle Loader', 'blocksy' ),
							'none' => __( 'None', 'blocksy' ),
						],
					],

				],
			],
		],
	],

	'customizer_color_scheme' => [
		'label' => __( 'Color scheme', 'blocksy' ),
		'type' => 'hidden',
		'label' => '',
		'value' => 'no',
		'setting' => [ 'transport' => 'postMessage' ],
	],
];
