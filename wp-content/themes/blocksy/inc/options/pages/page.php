<?php

/**
 * Page options.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'page_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			'single_page_title_enabled' => [
				'label' => __( 'Page Title', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'yes',
				'wrapperAttr' => [ 'data-label' => 'heading-label' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'inner-options' => [

					blocksy_get_options('general/page-title', [
						'prefix' => 'single_page',
						'is_single' => true,
						'is_page' => true
					])

				],
			],

			blocksy_rand_md5() => [
				'label' => __( 'Page Structure', 'blocksy' ),
				'type' => 'ct-title',
			],

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'single_page_structure' => [
						'label' => false,
						'type' => 'ct-image-picker',
						'value' => 'type-4',
						'attr' => [ 'data-type' => 'background' ],
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [

							'type-3' => [
								'src'   => blocksy_image_picker_url( 'narrow.svg' ),
								'title' => __( 'Narrow Width', 'blocksy' ),
							],

							'type-4' => [
								'src'   => blocksy_image_picker_url( 'normal.svg' ),
								'title' => __( 'Normal Width', 'blocksy' ),
							],

							'type-2' => [
								'src'   => blocksy_image_picker_url( 'left-single-sidebar.svg' ),
								'title' => __( 'Left Sidebar', 'blocksy' ),
							],

							'type-1' => [
								'src'   => blocksy_image_picker_url( 'right-single-sidebar.svg' ),
								'title' => __( 'Right Sidebar', 'blocksy' ),
							],

						],
					],

					'page_content_style' => [
						'label' => __( 'Content Area Style', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'wide',
						'view' => 'text',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'wide' => __( 'Wide', 'blocksy' ),
							'boxed' => __( 'Boxed', 'blocksy' ),
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'pageBackground' => [
						'label' => __( 'Page Background', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => Blocksy_Css_Injector::get_skip_rule_keyword(),
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
						'condition' => [ 'page_content_style' => 'boxed' ],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
							],

							'pageContentBackground' => [
								'label' => __( 'Content Area Background', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => '#ffffff',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Initial', 'blocksy' ),
										'id' => 'default',
									],
								],
							],

							'pageContentBoxedSpacing' => [
								'label' => __( 'Content Area Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'value' => '40px',
								'units' => blocksy_units_config([
									[
										'unit' => 'px',
										'min' => 0,
										'max' => 200,
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

			'has_page_comments' => [
				'label' => __( 'Comments', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],
];
