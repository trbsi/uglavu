<?php
/**
 * Colors options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'sidebar_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'sidebar_type' => [
						'label' => false,
						'type' => 'ct-image-picker',
						'value' => 'type-1',
						'attr' => [ 'data-type' => 'background' ],
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [

							'type-1' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-1.svg' ),
							],

							'type-2' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-2.svg' ),
							],

							'type-3' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-3.svg' ),
							],


							'type-4' => [
								'src' => blocksy_image_picker_url( 'sidebar-type-4.svg' ),
							],

						],
					],

					'sidebarWidth' => [
						'label' => __( 'Sidebar Width', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => 27,
						'min' => 10,
						'max' => 70,
						'defaultUnit' => '%',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'sidebarGap' => [
						'label' => __( 'Sidebar Gap', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => '4%',
						'units' => blocksy_units_config([
							[ 'unit' => '%', 'min' => 0, 'max' => 50 ],
							[ 'unit' => 'px', 'min' => 0, 'max' => 600 ],
							[ 'unit' => 'pt', 'min' => 0, 'max' => 500 ],
							[ 'unit' => 'em', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'rem', 'min' => 0, 'max' => 100 ],
							[ 'unit' => 'vw', 'min' => 0, 'max' => 50 ],
							[ 'unit' => 'vh', 'min' => 0, 'max' => 50 ],
						]),
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					'sidebarWidgetsSpacing' => [
						'label' => __( 'Widgets Vertical Spacing', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 100,
						'responsive' => true,
						'value' => [
							'mobile' => 30,
							'tablet' => 40,
							'desktop' => 60,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2' ],
						'options' => [

							'separated_widgets' => [
								'label' => __( 'Separate Widgets', 'blocksy' ),
								'type' => 'ct-switch',
								'value' => 'no',
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],


					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					'has_sticky_sidebar' => [
						'label' => __( 'Sticky Sidebar', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'has_sticky_sidebar' => 'yes' ],
						'options' => [

							'sidebarOffset' => [
								'label' => __( 'Sidebar Top Offset', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => 50,
								'min' => 0,
								'max' => 200,
								'defaultUnit' => 'px',
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					'sidebar_visibility' => [
						'label' => __( 'Visibility', 'blocksy' ),
						'type' => 'ct-visibility',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'desktop' => true,
							'tablet' => false,
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

					'sidebarWidgetsTitleFont' => [
						'type' => 'ct-typography',
						'label' => __( 'Widget Title Font', 'blocksy' ),
						'value' => blocksy_typography_default_values([
							'size' => '18px',
						]),
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'sidebarWidgetsTitleColor' => [
						'label' => __( 'Title Font Color', 'blocksy' ),
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

					'sidebarWidgetsHeadingsFont' => [
						'type' => 'ct-typography',
						'label' => __( 'Headings Font', 'blocksy' ),
						'value' => blocksy_typography_default_values([
							'size' => '15px',
							'variation' => 'n5',
							'line-height' => '1.4'
						]),
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'sidebarWidgetsFontColor' => [
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

					'sidebarWidgetsLink' => [
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

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2 | type-4' ],
						'options' => [

							'sidebarBackgroundColor' => [
								'label' => __( 'Background Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'default' => [
										'color' => 'var(--paletteColor5)',
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

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2' ],
						'options' => [

							'sidebarBorderColor' => [
								'label' => __( 'Border Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'default' => [
										'color' => 'rgba(224, 229, 235, 0.8)',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blocksy' ),
										'id' => 'default',
									],
								],
							],

							'sidebarBorderSize' => [
								'label' => __( 'Border Size', 'blocksy' ),
								'type' => 'ct-number',
								'design' => 'inline',
								'value' => 0,
								'min' => 0,
								'max' => 5,
								'setting' => [ 'transport' => 'postMessage' ],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-3' ],
						'options' => [

							'sidebarDividerColor' => [
								'label' => __( 'Divider Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],
								'value' => [
									'default' => [
										'color' => 'rgba(224, 229, 235, 0.8)',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blocksy' ),
										'id' => 'default',
									],
								],
							],

							'sidebarDividerSize' => [
								'label' => __( 'Divider Size', 'blocksy' ),
								'type' => 'ct-number',
								'design' => 'inline',
								'value' => 1,
								'min' => 1,
								'max' => 5,
								'setting' => [ 'transport' => 'postMessage' ],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'sidebar_type' => 'type-2 | type-3 | type-4' ],
						'options' => [

							'sidebarInnerSpacing' => [
								'label' => __( 'Cotainer Inner Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'min' => 5,
								'max' => 80,
								'responsive' => true,
								'value' => [
									'mobile' => 35,
									'tablet' => 35,
									'desktop' => 35,
								],
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],
				],
			],
		],
	],
];
