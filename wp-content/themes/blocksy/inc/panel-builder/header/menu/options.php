<?php

$options = [
	'menu' => [
		'label' => __('Select Menu', 'blocksy'),
		'type' => 'ct-select',
		'value' => blocksy_get_default_menu(),
		'view' => 'text',
		'design' => 'inline',
		'setting' => [ 'transport' => 'postMessage' ],
		'placeholder' => __('Select menu...', 'blocksy'),
		'desc' => sprintf(
			// translators: placeholder here means the actual URL.
			__( 'Assign a menu for this element. You can edit your menu %shere%s.', 'blocksy' ),
			sprintf(
				'<a href="%s" data-trigger-section="nav_menus">',
				admin_url('/customize.php?autofocus[section]=nav_menus')
			),
			'</a>'
		),
		'choices' => blocksy_ordered_keys(blocksy_get_menus_items())
	],


	blocksy_rand_md5() => [
		'type' => 'ct-title',
		'label' => __( 'Top Level Options', 'blocksy' ),
	],

	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'header_menu_type' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'type-1',
				'attr' => [ 'data-type' => 'background' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'switchDeviceOnChange' => 'desktop',
				'choices' => [

					'type-1' => [
						'src'   => blocksy_image_picker_url( 'menu-type-1.svg' ),
						'title' => __( 'Type 1', 'blocksy' ),
					],

					'type-2' => [
						'src'   => blocksy_image_picker_url( 'menu-type-2.svg' ),
						'title' => __( 'Type 2', 'blocksy' ),
					],

					'type-4' => [
						'src'   => blocksy_image_picker_url( 'menu-type-4.svg' ),
						'title' => __( 'Type 4', 'blocksy' ),
					],

					'type-3' => [
						'src'   => blocksy_image_picker_url( 'menu-type-3.svg' ),
						'title' => __( 'Type 3', 'blocksy' ),
					],
				],
			],

			'headerMenuItemsSpacing' => [
				'label' => __( 'Items Spacing', 'blocksy' ),
				'type' => 'ct-slider',
				'value' => 25,
				'min' => 5,
				'max' => 80,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'header_menu_type' => '!type-1' ],
				'options' => [

					'headerMenuItemsHeight' => [
						'label' => __( 'Items Height', 'blocksy' ),
						'type' => 'ct-slider',
						'value' => 100,
						'min' => 30,
						'max' => 100,
						'defaultUnit' => '%',
						'setting' => [ 'transport' => 'postMessage' ],
					],

				],
			],

			'stretch_menu' => [
				'label' => __( 'Stretch Menu', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'no',
				'desc' => __('Enabling this option will make the menu to stretch and fit the width of its parent column. ', 'blocksy'),
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'headerMenuFont' => [
				'type' => 'ct-typography',
				'label' => __( 'Font', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '12px',
					'variation' => 'n7',
					'line-height' => '1.3',
					'text-transform' => 'uppercase',
				]),
				'typography_responsive' => [
					'desktop' => true,
					'tablet' => false,
					'mobile' => false,
				],
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'menuFontColor' => [
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

					'active' => [
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

					[
						'title' => __( 'Active', 'blocksy' ),
						'id' => 'active',
					],
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ 'header_menu_type' => '!type-1' ],
				'options' => [

					'menuIndicatorColor' => [
						'label' => __( 'Active Indicator Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'divider' => 'top',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'active' => [
								'color' => 'var(--paletteColor1)',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Active', 'blocksy' ),
								'id' => 'active',
							],
						],
					],

				],
			],

			'headerMenuMargin' => [
				'label' => __( 'Margin', 'blocksy' ),
				'type' => 'ct-spacing',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'top' => 'auto',
					'bottom' => 'auto',
					'linked' => true,
				]),
				'responsive' => true
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-title',
		'label' => __( 'Dropdown Options', 'blocksy' ),
	],

	blocksy_rand_md5() => [
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'dropdown_animation' => [
				'label' => __('Entrance animation', 'blocksy'),
				'type' => 'ct-radio',
				'value' => 'type-1',
				'view' => 'radio',
				'design' => 'block',
				'divider' => 'bottom',
				'attr' => [ 'data-columns' => '2' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'type-1' => __( 'Default', 'blocksy' ),
					'type-3' => __( 'Inner Reveal', 'blocksy' ),
					'type-2' => __( 'Opacity', 'blocksy' ),
					'type-4' => __( 'Simple', 'blocksy' ),
				],
			],

			'dropdownTopOffset' => [
				'label' => __( 'Dropdown Top Offset', 'blocksy' ),
				'type' => 'ct-slider',
				'value' => 15,
				'min' => 0,
				'max' => 50,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'dropdownMenuWidth' => [
				'label' => __( 'Dropdown Width', 'blocksy' ),
				'type' => 'ct-slider',
				'value' => 200,
				'min' => 100,
				'max' => 300,
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'headerDropdownFont' => [
				'type' => 'ct-typography',
				'label' => __( 'Font', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '12px',
					'variation' => 'n5',
					'line-height' => '1.6',
				]),
				'typography_responsive' => [
					'desktop' => true,
					'tablet' => false,
					'mobile' => false,
				],
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'headerDropdownFontColor' => [
				'label' => __( 'Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'bottom',
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

			'headerDropdownDivider' => [
				'label' => __( 'Items Divider', 'blocksy' ),
				'type' => 'ct-border',
				'design' => 'inline',
				'divider' => 'bottom',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'width' => 1,
					'style' => 'dashed',
					'color' => [
						'color' => 'rgba(255, 255, 255, 0.1)',
					],
				]
			],

			'headerDropdownBackground' => [
				'label' => __( 'Background Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'divider' => 'bottom',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => '#29333C',
					],
				],

				'pickers' => [
					[
						'title' => __( 'Initial', 'blocksy' ),
						'id' => 'default',
					],
				],
			],

			'headerDropdownRadius' => [
				'label' => __( 'Border Radius', 'blocksy' ),
				'type' => 'ct-spacing',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'linked' => true,
					'top' => '2px',
					'left' => '2px',
					'right' => '2px',
					'bottom' => '2px',
				]),
				'responsive' => true
			],

		],
	],
];
