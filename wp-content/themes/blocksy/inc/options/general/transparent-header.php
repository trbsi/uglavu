<?php

$options = [

	'transparent_header_panel' => [
		'label' => __( 'Transparent Header', 'blocksy' ),
		'type' => 'ct-panel',
		'wrapperAttr' => [ 'data-label' => 'heading-label' ],
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'has_global_transparent_header' => [
						'label' => __( 'Global Transparent Header', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'has_global_transparent_header' => 'yes' ],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
							],

							'disable_transparent_header' => [
								'label' => __( 'Disable Transparent Header On:', 'blocksy' ),
								'type' => 'ct-checkboxes',
								'attr' => [ 'data-columns' => '2' ],
								// 'setting' => [ 'transport' => 'postMessage' ],
								'choices' => blocksy_ordered_keys(
									[
										'blog_home' => __( 'Blog Home', 'blocksy' ),
										'blog_archives' => __( 'Blog Archives', 'blocksy' ),
										'posts' => __( 'Single Posts', 'blocksy' ),
										'pages' => __( 'Pages', 'blocksy' ),
										'search' => __( 'Search Page', 'blocksy' ),
										'error' => __( '404 Page', 'blocksy' ),
										'shop_home' => __( 'Shop Home', 'blocksy' ),
										'shop_arhives' => __( 'Shop Archives', 'blocksy' ),
									]
								),

								'value' => [
									'blog_home' => true,
									'blog_archives' => true,
									'posts' => false,
									'pages' => false,
									'search' => true,
									'error' => true,
									'shop_home' => true,
									'shop_arhives' => true,
								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'has_transparent_different_logo' => [
						'label' => __( 'Different Logo', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no',
						'setting' => [ 'transport' => 'postMessage' ],
						'selective_refresh' => [
							'selector' => '.site-branding',
							'render_callback' => 'blocksy_output_site_branding',
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'has_transparent_different_logo' => 'yes' ],
						'options' => [

							'transparent_header_logo' => [
								'label' => false,
								'type' => 'ct-image-uploader',
								'value' => [ 'attachment_id' => null ],
								'attr' => [ 'data-height' => 'small' ],
								'setting' => [ 'transport' => 'postMessage' ],
								'selective_refresh' => [
									'selector' => '.site-branding',
									'render_callback' => 'blocksy_output_site_branding',
								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
							],

							'has_transparent_retina_logo' => [
								'label' => __( 'Retina Logo', 'blocksy' ),
								'type' => 'ct-switch',
								'value' => 'no',
								'desc' => __( 'Set up a different logo for retina devices.', 'blocksy' ),
								'setting' => [ 'transport' => 'postMessage' ],
								'selective_refresh' => [
									'selector' => '.site-branding',
									'render_callback' => 'blocksy_output_site_branding',
								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-condition',
								'condition' => [ 'has_transparent_retina_logo' => 'yes' ],
								'options' => [

									'transparent_retina_header_logo' => [
										'label' => false,
										'type' => 'ct-image-uploader',
										'value' => [ 'attachment_id' => null ],
										'attr' => [ 'data-height' => 'small' ],
										'setting' => [ 'transport' => 'postMessage' ],
										'selective_refresh' => [
											'selector' => '.site-branding',
											'render_callback' => 'blocksy_output_site_branding',
										],
									],

								],
							],

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ],
							],

							'transparentLogoMaxHeight' => [
								'label' => __( 'Logo Maximum Height', 'blocksy' ),
								'type' => 'ct-slider',
								'min' => 0,
								'max' => 300,
								'value' => 50,
								'responsive' => true,
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
					],

					'transparent_header_visibility' => [
						'label' => __( 'Transparent on:', 'blocksy' ),
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

					'transparentHeaderFontColor' => [
						'label' => __( 'Content Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
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


					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					'transparentHeaderBackground' => [
						'label' => __( 'Background Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'noColorTransparent' => true,
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'default' => [
								'color' => 'rgba(255, 255, 255, 0.1)',
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

		],
	],

];
