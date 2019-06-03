<?php

$options = [
	'label' => __( 'Subscribe Form', 'blc' ),
	'type' => 'ct-panel',
	'switch' => true,
	'value' => 'yes',
	'setting' => [ 'transport' => 'postMessage' ],
	'inner-options' => [

		blocksy_rand_md5() => [
			'title' => __( 'General', 'blocksy' ),
			'type' => 'tab',
			'options' => [

				'mailchimp_title' => [
					'type' => 'text',
					'label' => __( 'Title', 'blc' ),
					'field_attr' => [ 'id' => 'widget-title' ],
					'design' => 'block',
					'value' => __( 'Newsletter Updates', 'blc' ),
					'disableRevertButton' => true,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'mailchimp_text' => [
					'label' => __( 'Message', 'blc' ),
					'type' => 'textarea',
					'value' => __( 'Enter your email address below to subscribe to our newsletter', 'blc' ),
					'design' => 'block',
					'disableRevertButton' => true,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
					'attr' => [ 'data-type' => 'small' ],
				],

				'mailchimp_list_id_source' => [
					'type' => 'ct-radio',
					'label' => __( 'List Source', 'blc' ),
					'value' => 'default',
					'view' => 'radio',
					'inline' => true,
					'design' => 'inline',
					'disableRevertButton' => true,
					'choices' => [
						'default' => __('Default', 'blc'),
						'custom' => __('Custom', 'blc'),
					],

					'setting' => [ 'transport' => 'postMessage' ],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [ 'mailchimp_list_id_source' => 'custom' ],
					'options' => [

						'mailchimp_list_id' => [
							'label' => __( 'List ID', 'blc' ),
							'type' => 'blocksy-mailchimp',
							'value' => '',
							'design' => 'inline',
							'disableRevertButton' => true,
							'setting' => [ 'transport' => 'postMessage' ],
						],

					],
				],

				'has_mailchimp_name' => [
					'type'  => 'ct-switch',
					'label' => __( 'Name Field', 'blc' ),
					'value' => 'no',
					'disableRevertButton' => true,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'mailchimp_button_text' => [
					'type' => 'text',
					'label' => __( 'Button Text', 'blc' ),
					'design' => 'block',
					'value' => __( 'Subscribe', 'blc' ),
					'disableRevertButton' => true,
					'setting' => [ 'transport' => 'postMessage' ],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
					'attr' => [ 'data-type' => 'small' ],
				],

				'mailchimp_subscribe_visibility' => [
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

				'mailchimpContent' => [
					'label' => __( 'Content Color', 'blocksy' ),
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

				'mailchimpButton' => [
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

				'mailchimpBackground' => [
					'label' => __( 'Background Color', 'blocksy' ),
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

				'mailchimpShadow' => [
					'label' => __( 'Shadow Color', 'blocksy' ),
					'type'  => 'ct-color-picker',
					'design' => 'inline',
					'setting' => [ 'transport' => 'postMessage' ],

					'value' => [
						'default' => [
							'color' => 'rgba(210, 213, 218, 0.4)',
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

				'mailchimpSpacing' => [
					'label' => __( 'Container Inner Spacing', 'blocksy' ),
					'type' => 'ct-slider',
					'value' => '40px',
					'units' => blocksy_units_config([
						[
							'unit' => 'px',
							'min' => 0,
							'max' => 300,
						],
					]),
					'responsive' => true,
					'setting' => [ 'transport' => 'postMessage' ],
				],

			],
		],

	],
];