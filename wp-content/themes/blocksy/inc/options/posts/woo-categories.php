<?php

$options = [
	'woo_categories_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			[
				'woo_categories_has_page_title' => [
					'label' => __( 'Page Title', 'blocksy' ),
					'type' => 'ct-panel',
					'switch' => true,
					'value' => 'yes',
					'wrapperAttr' => [ 'data-label' => 'heading-label' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_get_options('general/page-title', [
							'prefix' => 'woo_categories',
							'is_woo' => true
						]),

					],
				],

				blocksy_rand_md5() => [
					'type'  => 'ct-title',
					'label' => __( 'Shop Structure', 'blocksy' ),
				],

				'shop_structure' => [
					'label' => false,
					'type' => 'ct-image-picker',
					'value' => 'grid',
					'attr' => [ 'data-type' => 'background' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'choices' => [

						'grid' => [
							'src'   => blocksy_image_picker_url( 'grid.svg' ),
							'title' => __( 'Grid', 'blocksy' ),
						],

						'shop-simple' => [
							'src'   => blocksy_image_picker_url( 'simple.svg' ),
							'title' => __( 'Simple', 'blocksy' ),
						],

					],
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
					'attr' => [ 'data-type' => 'small' ]
				],

				'product_catalog_panel' => [
					'label' => __( 'Product Catalog', 'blocksy' ),
					'type' => 'ct-panel',
					'wrapperAttr' => [ 'data-panel' => 'only-arrow' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						'woocommerce_shop_page_display' => [
							'label' => __( 'Shop page display', 'blocksy' ),
							'type' => 'ct-select',
							'value' => '',
							'view' => 'text',
							'placeholder' => __('Show products', 'blocksy'),
							'design' => 'block',
							'desc' => __( 'Choose what to display on the main shop page.', 'blocksy' ),
							'choices' => blocksy_ordered_keys(
								[
									'' => __('Show products', 'blocksy'),
									'subcategories' => __('Show categories', 'blocksy'),
									'both' => __('Show categories & products', 'blocksy'),
								]
							),
						],

						'woocommerce_category_archive_display' => [
							'label' => __( 'Category display', 'blocksy' ),
							'type' => 'ct-select',
							'value' => '',
							'view' => 'text',
							'placeholder' => __('Show products', 'blocksy'),
							'design' => 'block',
							'desc' => __( 'Choose what to display on product category pages.', 'blocksy' ),
							'choices' => blocksy_ordered_keys(
								[
									'' => __('Show products', 'blocksy'),
									'subcategories' => __('Show subcategories', 'blocksy'),
									'both' => __('Show subcategories & products', 'blocksy'),
								]
							),
						],

						'woocommerce_default_catalog_orderby' => [
							'label' => __( 'Default product sorting', 'blocksy' ),
							'type' => 'ct-select',
							'value' => 'menu_order',
							'view' => 'text',
							'design' => 'block',
							'desc' => __( 'How should products be sorted in the catalog by default?', 'blocksy' ),
							'choices' => blocksy_ordered_keys(
								[
									'menu_order' => __('Default sorting (custom ordering + name)', 'blocksy'),
									'popularity' => __('Popularity (sales)', 'blocksy'),
									'rating' => __('Average rating', 'blocksy'),
									'date' => __('Sort by most recent', 'blocksy'),
									'price' => __('Sort by price (asc)', 'blocksy'),
									'price-desc' => __('Sort by price (desc)', 'blocksy'),
								]
							),
						],

					],
				],

				'product_card_options_panel' => [
					'label' => __( 'Card Options', 'blocksy' ),
					'type' => 'ct-panel',
					'wrapperAttr' => [ 'data-panel' => 'only-arrow' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_rand_md5() => [
							'title' => __( 'General', 'blocksy' ),
							'type' => 'tab',
							'options' => [
								[
									'has_star_rating' => [
										'label' => __( 'Star Rating', 'blocksy' ),
										'type' => 'ct-switch',
										'value' => 'yes',
										'setting' => [ 'transport' => 'postMessage' ],
									],

									'has_sale_badge' => [
										'label' => __( 'Sale Badge', 'blocksy' ),
										'type' => 'ct-switch',
										'value' => 'yes',
										'setting' => [ 'transport' => 'postMessage' ],
									],

									'has_product_categories' => [
										'label' => __( 'Product Categories', 'blocksy' ),
										'type' => 'ct-switch',
										'value' => 'yes',
										'setting' => [ 'transport' => 'postMessage' ],
									],
								],

								apply_filters(
									'blocksy_woo_card_options_elements',
									[]
								)

							],
						],

						blocksy_rand_md5() => [
							'title' => __( 'Design', 'blocksy' ),
							'type' => 'tab',
							'options' => [

								'cardProductTitleFont' => [
									'type' => 'ct-typography',
									'label' => __( 'Title Font', 'blocksy' ),
									'value' => blocksy_typography_default_values([
										'size' => '17px',
										'variation' => 'n5',
									]),
									'setting' => [ 'transport' => 'postMessage' ],
								],

								'cardProductTitleColor' => [
									'label' => __( 'Title Color', 'blocksy' ),
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
									'attr' => [ 'data-type' => 'small' ]
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'has_star_rating' => 'yes' ],
									'options' => [

										'cardStarRatingColor' => [
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

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'has_sale_badge' => 'yes' ],
									'options' => [

										'saleBadgeColor' => [
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

								'cardProductImageOverlay' => [
									'label' => __( 'Image Overlay Color', 'blocksy' ),
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
									'condition' => [ 'has_product_categories' => 'yes' ],
									'options' => [

										'cardProductCategoriesColor' => [
											'label' => __( 'Categories Color', 'blocksy' ),
											'type'  => 'ct-color-picker',
											'design' => 'inline',
											'setting' => [ 'transport' => 'postMessage' ],

											'value' => [
												'default' => [
													'color' => 'rgba(44,62,80,0.7)',
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

									],
								],

								'cardProductPriceColor' => [
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
									'condition' => [ 'shop_structure' => 'grid' ],
									'options' => [

										'cardProductAction1Color' => [
											'label' => __( 'Action Button Color', 'blocksy' ),
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

									],
								],

								blocksy_rand_md5() => [
									'type' => 'ct-condition',
									'condition' => [ 'shop_structure' => 'shop-simple' ],
									'options' => [

										'cardProductAction2Color' => [
											'label' => __( 'Action Button Color', 'blocksy' ),
											'type'  => 'ct-color-picker',
											'design' => 'inline',
											'setting' => [ 'transport' => 'postMessage' ],

											'value' => [
												'default' => [
													'color' => 'var(--buttonInitialColor)',
												],

												'hover' => [
													'color' => 'var(--buttonHoverColor)',
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

					],
				],


				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [ 'shop_structure' => 'grid' ],
					'options' => [

						'shop_columns' => [
							'label' => __( 'Products Per Row', 'blocksy' ),
							'type' => 'ct-number',
							'value' => 3,
							'min' => 2,
							'max' => 4,
							'design' => 'inline',
							'setting' => [ 'transport' => 'postMessage' ],
						],

					],
				],

				'shop_products' => [
					'label' => __( 'Products Per Page', 'blocksy' ),
					'type' => 'ct-number',
					'value' => 9,
					'min' => 1,
					'max' => 30,
					'design' => 'inline',
					'setting' => [ 'transport' => 'postMessage' ],
				],


				blocksy_rand_md5() => [
					'type'  => 'ct-title',
					'label' => __( 'Page Elements', 'blocksy' ),
				],

				'has_shop_sort' => [
					'label' => __( 'Shop Sort', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'has_shop_results_count' => [
					'label' => __( 'Shop Results Count', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'setting' => [ 'transport' => 'postMessage' ],
				],

				'has_shop_breadcrumbs' => [
					'label' => __( 'Breadcrumbs', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'setting' => [ 'transport' => 'postMessage' ],
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'woo',
			]),
		],
	],
];
