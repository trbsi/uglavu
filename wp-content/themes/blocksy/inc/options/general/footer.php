<?php
/**
 * Footer options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [

	'footer_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'label' => __( 'Footer Base', 'blocksy' ),
				'type' => 'ct-title',
			],

			'footer_base' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'type-2',
				'attr' => [ 'data-type' => 'background' ],

				'setting' => [
					'transport' => 'postMessage',
				],

				'choices' => [
					'type-1' => [
						'src' => blocksy_image_picker_url( 'footer-type-1.svg' ),
					],

					'type-2' => [
						'src' => blocksy_image_picker_url( 'footer-type-2.svg' ),
					],
				],
			],

			'footer_reveal' => [
				'label' => __( 'Reveal Effect', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'no',
				'desc' => __( 'This option enables a nice footer reveal effect as you scroll down.', 'blocksy' ),
				'setting' => [ 'transport' => 'postMessage' ],
			],

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
								'label' => __( 'Button Shape', 'blocksy' ),
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

							'top_button_alignment' => [
								'label' => __( 'Button Alignment', 'blocksy' ),
								'type' => 'ct-radio',
								'value' => 'right',
								'setting' => [ 'transport' => 'postMessage' ],
								'view' => 'text',
								'attr' => [ 'data-type' => 'alignment' ],
								'choices' => [
									'left' => '',
									'right' => '',
								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
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

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'has_primary_area' => [
				'label' => __( 'Primary Area', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'wrapperAttr' => [ 'data-label' => 'heading-label' ],
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'has_primary_area' => 'yes' ],
				'options' => [

					blocksy_rand_md5() => [
						'title' => __( 'General', 'blocksy' ),
						'type' => 'tab',
						'options' => [

							blocksy_get_options('general/footer-primary-area', [
								'number' => '1',
								'default_section' => 'footer_menu',
							]),

							[
								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],
							],

							blocksy_get_options('general/footer-primary-area', [
								'number' => '2',
								'default_section' => 'disabled',
							]),

							[
								blocksy_rand_md5() => [
									'type' => 'ct-divider',
									'attr' => [ 'data-type' => 'small' ],
								],

								'footer_main_area_container' => [
									'label' => __( 'Container Width', 'blocksy' ),
									'type' => 'ct-radio',
									'value' => 'fixed',
									'view' => 'text',
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
									'choices' => [
										'fixed' => __( 'Fixed', 'blocksy' ),
										'fluid' => __( 'Fluid', 'blocksy' ),
									],
								],

								'footer_main_area_stacking' => [
									'label' => __( 'Stack Sections on', 'blocksy' ),
									'type' => 'ct-visibility',
									'design' => 'block',
									'setting' => [ 'transport' => 'postMessage' ],
									'allow_empty' => true,

									'value' => [
										'tablet' => true,
										'mobile' => true,
									],

									'choices' => blocksy_ordered_keys([
										'tablet' => __( 'Tablet', 'blocksy' ),
										'mobile' => __( 'Mobile', 'blocksy' ),
									]),
								],

								'footer_primary_area_visibility' => [
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
					],

					blocksy_rand_md5() => [
						'title' => __( 'Design', 'blocksy' ),
						'type' => 'tab',
						'options' => [

							'footerPrimaryColor' => [
								'label' => __( 'Font Color', 'blocksy' ),
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

							'footerPrimaryBackground' => [
								'label' => __( 'Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => '#eef0f4',
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
								'type' => 'ct-condition',
								'condition' => [
									'any' => [
										'footer_section_1' => 'footer_menu',
										'footer_section_2' => 'footer_menu',
									],
								],
								'options' => [

									'footerMenuItemsSpacing' => [
										'label' => __( 'Menu Items Spacing', 'blocksy' ),
										'type' => 'ct-slider',
										'min' => 5,
										'max' => 80,
										'responsive' => true,
										'value' => [
											'mobile' => 20,
											'tablet' => 20,
											'desktop' => 20,
										],
										'setting' => [ 'transport' => 'postMessage' ],
									],

								],
							],

							'footerPrimarySpacing' => [
								'label' => __( 'Container Inner Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => [
									'mobile' => '30px',
									'tablet' => '30px',
									'desktop' => '30px',
								],
								'units' => blocksy_units_config([
									[
										'unit' => 'px',
										'min' => 0,
										'max' => 150,
									],
								]),
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'has_widget_area' => [
				'label' => __( 'Widgets Area', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'wrapperAttr' => [ 'data-label' => 'heading-label' ],
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'has_widget_area' => 'yes' ],
				'options' => [

					blocksy_rand_md5() => [
						'title' => __( 'General', 'blocksy' ),
						'type' => 'tab',
						'options' => [

							'footer_widgets_structure' => [
								'label' => false,
								'type' => 'ct-image-picker',
								'value' => '3',
								'attr' => [ 'data-type' => 'background' ],
								'setting' => [ 'transport' => 'postMessage' ],
								'choices' => [
									'1' => [
										'src' => blocksy_image_picker_url( 'footer-widgets-1.svg' ),
									],

									'2' => [
										'src' => blocksy_image_picker_url( 'footer-widgets-2.svg' ),
									],

									'3' => [
										'src' => blocksy_image_picker_url( 'footer-widgets-3.svg' ),
									],

									'4' => [
										'src' => blocksy_image_picker_url( 'footer-widgets-4.svg' ),
									],

									'2-1' => [
										'src' => blocksy_image_picker_url( 'footer-widgets-2-1.svg' ),
									],

									'1-2' => [
										'src' => blocksy_image_picker_url( 'footer-widgets-1-2.svg' ),
									],
								],
							],

							'footer_widgets_container' => [
								'label' => __( 'Container Width', 'blocksy' ),
								'type' => 'ct-radio',
								'value' => 'fixed',
								'view' => 'text',
								'design' => 'block',
								'setting' => [ 'transport' => 'postMessage' ],
								'choices' => [
									'fixed' => __( 'Fixed', 'blocksy' ),
									'fluid' => __( 'Fluid', 'blocksy' ),
								],
							],

							'footer_widgets_visibility' => [
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

							'footerWidgetsTitleColor' => [
								'label' => __( 'Title Color', 'blocksy' ),
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

							'footerWidgetsFontColor' => [
								'label' => __( 'Font Color', 'blocksy' ),
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

							'footerWidgetsLink' => [
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

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
							],

							'widgetsAreaDivider' => [
								'label' => __( 'Widgets Divider', 'blocksy' ),
								'type' => 'ct-border',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'width' => 1,
									'style' => 'dashed',
									'color' => [
										'color' => '#dddddd',
									],
								]
							],

							'widgetsAreaBackground' => [
								'label' => __( 'Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => '#f4f5f8',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blocksy' ),
										'id' => 'default',
									],
								],
							],

							'widgetAreaSpacing' => [
								'label' => __( 'Container Inner Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => [
									'mobile' => '40px',
									'tablet' => '50px',
									'desktop' => '70px',
								],
								'units' => blocksy_units_config([
									[
										'unit' => 'px',
										'min' => 0,
										'max' => 150,
									],
								]),
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'has_copyright' => [
				'label' => __( 'Copyright Section', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'no',
				'wrapperAttr' => [ 'data-label' => 'heading-label' ],
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'has_copyright' => 'yes' ],
				'options' => [

					blocksy_rand_md5() => [
						'title' => __( 'General', 'blocksy' ),
						'type' => 'tab',
						'options' => [

							'copyright_text' => [
								'label' => false,
								'type' => 'textarea',
								'value' => __( '© Blocksy 2019. All Rights Reserved.', 'blocksy' ),
								'setting' => [ 'transport' => 'postMessage' ],
							],

							'copyright_visibility' => [
								'label' => __( 'Visibility', 'blocksy' ),
								'type' => 'ct-visibility',
								'design' => 'block',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'desktop' => true,
									'tablet' => true,
									'mobile' => true,
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

							'copyrightText' => [
								'label' => __( 'Font Color', 'blocksy' ),
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

							'copyrightBackground' => [
								'label' => __( 'Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => '#eef0f4',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blocksy' ),
										'id' => 'default',
									],
								],
							],

							'copyrightSpacing' => [
								'label' => __( 'Container Inner Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => [
									'mobile' => '15px',
									'tablet' => '25px',
									'desktop' => '25px',
								],
								'units' => blocksy_units_config([
									[
										'unit' => 'px',
										'min' => 0,
										'max' => 150,
									],
								]),
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],
				],
			],
		],
	],
];
