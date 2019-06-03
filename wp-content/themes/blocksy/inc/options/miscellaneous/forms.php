<?php
/**
 * Forms options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'forms_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Form Elements Style', 'blocksy' ),
				'variation' => 'small',
			],

			'forms_type' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'classic-forms',
				'attr' => [ 'data-type' => 'background' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'switchDeviceOnChange' => 'desktop',
				'choices' => [

					'classic-forms' => [
						'src'   => blocksy_image_picker_url( 'forms-type-1.svg' ),
						'title' => __( 'Classic', 'blocksy' ),
					],

					'modern-forms' => [
						'src'   => blocksy_image_picker_url( 'forms-type-2.svg' ),
						'title' => __( 'Modern', 'blocksy' ),
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'General', 'blocksy' ),
				'variation' => 'small',
			],

			'formTextColor' => [
				'label' => __( 'Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => 'var(--paletteColor3)',
					],

					'focus' => [
						'color' => 'var(--paletteColor3)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],

					[
						'title' => __( 'Focus', 'blocksy' ),
						'id' => 'focus',
					],
				],
			],

			'formFontSize' => [
				'label' => __( 'Font Size', 'blocksy' ),
				'type' => 'ct-number',
				'design' => 'inline',
				'value' => 15,
				'min' => 5,
				'max' => 50,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Input & Textarea', 'blocksy' ),
				'variation' => 'small',
			],

			'formLabelColor' => [
				'label' => __( 'Label Color', 'blocksy' ),
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

			'formBorderColor' => [
				'label' => __( 'Border Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => 'rgba(232, 235, 240, 1)',
					],

					'focus' => [
						'color' => 'var(--paletteColor1)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],

					[
						'title' => __( 'Focus', 'blocksy' ),
						'id' => 'focus',
					],
				],
			],

			'formBackgroundColor' => [
				'label' => __( 'Background Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword(),
					],

					'focus' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword(),
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],

					[
						'title' => __( 'Focus', 'blocksy' ),
						'id' => 'focus',
					],
				],
			],

			'formBorderSize' => [
				'label' => __( 'Border Size', 'blocksy' ),
				'type' => 'ct-number',
				'design' => 'inline',
				'value' => 1,
				'min' => 0,
				'max' => 5,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'formInputHeight' => [
				'label' => __( 'Input Height', 'blocksy' ),
				'type' => 'ct-number',
				'design' => 'inline',
				'value' => 45,
				'min' => 20,
				'max' => 80,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'formTextAreaHeight' => [
				'label' => __( 'Textarea Height', 'blocksy' ),
				'type' => 'ct-number',
				'design' => 'inline',
				'value' => 170,
				'min' => 50,
				'max' => 250,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Select Box', 'blocksy' ),
				'variation' => 'small',
			],

			'selectDropdownTextColor' => [
				'label' => __( 'Dropdown Text Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => 'var(--paletteColor3)',
					],

					'hover' => [
						'color' => 'var(--paletteColor3)',
					],

					'active' => [
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

					[
						'title' => __( 'Active', 'blocksy' ),
						'id' => 'active',
					],
				],
			],

			'selectDropdownItemColor' => [
				'label' => __( 'Dropdown Items Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'hover' => [
						'color' => 'rgba(232, 235, 240, 0.4)',
					],

					'active' => [
						'color' => 'var(--paletteColor1)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Hover', 'blocksy' ),
						'id' => 'hover',
					],

					[
						'title' => __( 'Active', 'blocksy' ),
						'id' => 'active',
					],
				],
			],

			'selectDropdownBackground' => [
				'label' => __( 'Dropdown background', 'blocksy' ),
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


			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Radio & Checkbox', 'blocksy' ),
				'variation' => 'small',
			],

			'radioCheckboxColor' => [
				'label' => __( 'Colors', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => '#e8ebf0',
					],

					'accent' => [
						'color' => 'var(--paletteColor1)',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],

					[
						'title' => __( 'Active', 'blocksy' ),
						'id' => 'accent',
					],
				],
			],
		],
	],
];
