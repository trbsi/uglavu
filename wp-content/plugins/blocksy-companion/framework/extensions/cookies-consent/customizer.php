<?php

$options = [
	'title' => __('Cookie Consent', 'blc'),
	'container' => [ 'priority' => 8 ],
	'options' => [

		'cookie_consent_section_options' => [
			'type' => 'ct-options',
			'setting' => [ 'transport' => 'postMessage' ],
			'inner-options' => [

				blocksy_rand_md5() => [
					'title' => __( 'General', 'blocksy' ),
					'type' => 'tab',
					'options' => [

						'cookie_consent_type' => [
							'label' => false,
							'type' => 'ct-image-picker',
							'value' => 'type-1',
							'attr' => [ 'data-type' => 'background' ],
							'setting' => [ 'transport' => 'postMessage' ],
							'choices' => [

								'type-1' => [
									'src'   => BLOCKSY_URL . 'framework/extensions/cookies-consent/static/images/type-1.svg',
									'title' => __( 'Type 1', 'blocksy' ),
								],

								'type-2' => [
									'src'   => BLOCKSY_URL . 'framework/extensions/cookies-consent/static/images/type-2.svg',
									'title' => __( 'Type 2', 'blocksy' ),
								],

							],
						],

						'cookie_consent_period' => [
							'label' => __('Cookie period', 'blc'),
							'type' => 'ct-select',
							'value' => 'onemonth',
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
							'choices' => blocksy_ordered_keys(

								[
									'onehour' => __( 'One hour', 'blc' ),
									'oneday' => __( 'One day', 'blc' ),
									'oneweek' => __( 'One week', 'blc' ),
									'onemonth' => __( 'One month', 'blc' ),
									'threemonths' => __( 'Three months', 'blc' ),
									'sixmonths' => __( 'Six months', 'blc' ),
									'oneyear' => __( 'One year', 'blc' ),
									'forever' => __('Forever', 'blc')
								]

							),
						],


						'cookie_consent_content' => [
							'label' => __( 'Content', 'blc' ),
							'type' => 'textarea',
							'design' => 'block',
							'value' => __('We use cookies to ensure that we give you the best experience on our website.', 'blc'),
							'setting' => [ 'transport' => 'postMessage' ],
						],

						'cookie_consent_button_text' => [
							'label' => __( 'Button text', 'blc' ),
							'type' => 'text',
							'design' => 'block',
							'value' => __('Accept', 'blc'),
							'setting' => [ 'transport' => 'postMessage' ],
						],

					],
				],

				blocksy_rand_md5() => [
					'title' => __( 'Design', 'blocksy' ),
					'type' => 'tab',
					'options' => [

						'cookieContentColor' => [
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

						'cookieButtonBackground' => [
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

						'cookieBackground' => [
							'label' => __( 'Background Color', 'blocksy' ),
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
							'type' => 'ct-condition',
							'condition' => [ 'cookie_consent_type' => 'type-1' ],
							'options' => [

								'cookieMaxWidth' => [
									'label' => __( 'Maximum Width', 'blocksy' ),
									'type' => 'ct-slider',
									'value' => 400,
									'min' => 200,
									'max' => 500,
									'setting' => [ 'transport' => 'postMessage' ],
								],

							],
						],

					],
				],

			],
		],
	],
];