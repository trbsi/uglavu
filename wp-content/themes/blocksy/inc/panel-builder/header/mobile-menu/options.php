<?php

$options = [
	'menu' => [
		'label' => __('Select Menu', 'blocksy'),
		'type' => 'ct-select',
		'value' => blocksy_get_default_menu(),
		'view' => 'text',
		'design' => 'inline',
		'setting' => [ 'transport' => 'postMessage' ],
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
		'title' => __( 'General', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'mobile_menu_type' => [
				'label' => __('Menu Type', 'blocksy'),
				'type' => 'ct-radio',
				'value' => 'type-1',
				'view' => 'radio',
				'design' => 'block',
				'attr' => [ 'data-columns' => '2' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'type-1' => __( 'Default', 'blocksy' ),
					'type-2' => __( 'Bordered', 'blocksy' ),
				],
			],

		],
	],

	blocksy_rand_md5() => [
		'title' => __( 'Design', 'blocksy' ),
		'type' => 'tab',
		'options' => [

			'mobileMenuFont' => [
				'type' => 'ct-typography',
				'label' => __( 'Font', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => [
						'desktop' => '30px',
						'tablet'  => '30px',
						'mobile'  => '23px'
					],
					'variation' => 'n7',
				]),
				'typography_responsive' => [
					'desktop' => false,
					'tablet' => true,
					'mobile' => true,
				],
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'mobileMenuColor' => [
				'label' => __( 'Font Color', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => [
					'default' => [
						'color' => '#ffffff',
					],

					'hover' => [
						'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT'),
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
						'inherit' => 'var(--colorHover)'
					],
				],
			],

			'mobileMenuMargin' => [
				'label' => __( 'Margin', 'blocksy' ),
				'type' => 'ct-spacing',
				'divider' => 'top',
				'setting' => [ 'transport' => 'postMessage' ],
				'value' => blocksy_spacing_value([
					'left' => 'auto',
					'right' => 'auto',
					'linked' => true,
				]),
				'responsive' => true
			],

		],
	],
];
