<?php

$options = [
	'woo_single_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'type'  => 'ct-title',
				'label' => __( 'Gallery Style', 'blocksy' ),
			],

			'gallery_style' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'horizontal',
				'attr' => [ 'data-type' => 'background' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [

					'horizontal' => [
						'src'   => blocksy_image_picker_url( 'woo-gallery-type-1.svg' ),
						'title' => __( 'Horizontal', 'blocksy' ),
					],

					'vertical' => [
						'src'   => blocksy_image_picker_url( 'woo-gallery-type-2.svg' ),
						'title' => __( 'Vertical', 'blocksy' ),
					],

				],
			],

			'productGalleryWidth' => [
				'label' => __( 'Image/Gallery Width', 'blocksy' ),
				'type' => 'ct-slider',
				'defaultUnit' => '%',
				'value' => 48,
				'min' => 20,
				'max' => 70,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type'  => 'ct-title',
				'label' => __( 'Page Elements', 'blocksy' ),
			],

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'has_product_breadcrumbs' => [
						'label' => __( 'Breadcrumbs', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'has_product_single_onsale' => [
						'label' => __( 'Sale Badge', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'has_product_single_rating' => [
						'label' => __( 'Star Rating', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'has_product_single_lightbox' => [
						'label' => __( 'Image Lightbox', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'no'
					],

					'has_product_single_meta' => [
						'label' => __( 'Product Meta', 'blocksy' ),
						'type' => 'ct-switch',
						'value' => 'yes',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'product_gallery_ratio' => [
						'label' => __( 'Product Image/Gallery Ratio', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => '3/4',
						'view' => 'text',
						'design' => 'block',
						'attr' => [ 'data-type' => 'compact' ],
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'1/1' => '1/1',
							'4/3' => '4/3',
							'3/4' => '3/4',
						],
					],
				],
			],

			blocksy_rand_md5() => [
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'singleProductPriceColor' => [
						'label' => __( 'Price Color', 'blocksy' ),
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

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'has_product_single_onsale' => 'yes' ],
						'options' => [

							'singleSaleBadgeColor' => [
								'label' => __( 'Sale Badge Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'background' => [
										'color' => 'var(--paletteColor1)',
									],

									'text' => [
										'color' => '#ffffff',
									],
								],

								'pickers' => [
									[
										'title' => __( 'Background', 'blocksy' ),
										'id' => 'background',
									],

									[
										'title' => __( 'Text', 'blocksy' ),
										'id' => 'text',
									],
								],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'has_product_single_rating' => 'yes' ],
						'options' => [

							'singleStarRatingColor' => [
								'label' => __( 'Star Rating Color', 'blocksy' ),
								'type'  => 'ct-color-picker',
								'design' => 'inline',
								'setting' => [ 'transport' => 'postMessage' ],

								'value' => [
									'default' => [
										'color' => '#FDA256',
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

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'has_product_related' => [
				'label' => __( 'Related Products', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'yes',
				'setting' => [ 'transport' => 'postMessage' ],
				'inner-options' => [

					'related_products' => [
						'label' => __( 'Items Count', 'blocksy' ),
						'type' => 'ct-number',
						'value' => 4,
						'min' => 2,
						'max' => 8,
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'related_products_columns' => [
						'label' => __( 'Items Per Row', 'blocksy' ),
						'type' => 'ct-number',
						'value' => 4,
						'min' => 2,
						'max' => 4,
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					'related_products_visibility' => [
						'label' => __( 'Visibility', 'blocksy' ),
						'type' => 'ct-visibility',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],
						'allow_empty' => true,

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
				'type' => 'ct-divider',
			],

			'has_ajax_add_to_cart' => [
				'label' => __( 'AJAX add to cart', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
			],

		],
	],
];
