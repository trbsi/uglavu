<?php

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

if (! isset($title)) {
	$title = __('blog', 'blocksy');
}

$options = [
	blocksy_rand_md5() => [
		'type'  => 'ct-title',
		'label' => sprintf(
			// translators: placeholder here means the actual structure title.
			__( '%s Structure', 'blocksy' ),
			$title
		),
		'desc'  => sprintf(
			// translators: placeholder here means the actual structure title.
			__( 'Set the %s entries default structure.', 'blocksy' ),
			$title
		),
	],

	$prefix . 'structure' => [
		'label' => false,
		'type' => 'ct-image-picker',
		'value' => 'grid',
		'attr' => [ 'data-type' => 'background' ],
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => [

			'simple' => [
				'src'   => blocksy_image_picker_url( 'simple.svg' ),
				'title' => __( 'Simple', 'blocksy' ),
			],

			'classic' => [
				'src'   => blocksy_image_picker_url( 'classic.svg' ),
				'title' => __( 'Classic', 'blocksy' ),
			],

			'grid' => [
				'src'   => blocksy_image_picker_url( 'grid.svg' ),
				'title' => __( 'Grid', 'blocksy' ),
			],

			'enhanced-grid' => [
				'src'   => blocksy_image_picker_url( 'enhanced-grid.svg' ),
				'title' => __( 'Simple', 'blocksy' ),
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-divider',
		'attr' => [ 'data-type' => 'small' ]
	],

	$prefix . 'archive_listing_panel' => [
		'label' => __( 'Card Options', 'blocksy' ),
		'type' => 'ct-panel',
		'value' => 'yes',
		'wrapperAttr' => [ 'data-panel' => 'only-arrow' ],
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					$prefix . 'card_type' => [
						'label' => __( 'Card Type', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'boxed',
						'view' => 'text',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'boxed' => __( 'Boxed', 'blocksy' ),
							'simple' => __( 'Simple', 'blocksy' ),
						],
					],

					$prefix . 'archive_order' => [
						'label' => __( 'Card Elements', 'blocksy' ),
						'type' => 'ct-layers',
						'value' => [
							[
								'id' => 'post_meta',
								'enabled' => true,
								'meta' => [
									'categories' => true,
									'author' => false,
									'date' => false,
									'comments' => false,
								],
							],

							[
								'id' => 'title',
								'heading_tag' => 'h2',
								'enabled' => true,
							],

							[
								'id' => 'featured_image',
								'thumb_ratio' => '4/3',
								'is_boundless' => 'yes',
								'enabled' => true,
							],

							[
								'id' => 'excerpt',
								'excerpt_length' => '40',
								'enabled' => true,
							],

							[
								'id' => 'post_meta',
								'enabled' => true,
								'meta' => [
									'categories' => false,
									'author' => true,
									'date' => true,
									'comments' => true,
								],
								'meta_type' => 'simple',
								'has_meta_label' => 'no',
								'category_style' => 'simple',
								'has_author_avatar' => 'no',
								'avatar_size' => '30'
							],
						],

						'settings' => [
							'title' => [
								'label' => __( 'Title', 'blocksy' ),
								'options' => [

									'heading_tag' => [
										'label' => __( 'Heading tag', 'blocksy' ),
										'type' => 'ct-select',
										'value' => 'h2',
										'view' => 'text',
										'design' => 'inline',
										'choices' => blocksy_ordered_keys(
											[
												'h1' => 'H1',
												'h2' => 'H2',
												'h3' => 'H3',
												'h4' => 'H4',
												'h5' => 'H5',
												'h6' => 'H6',
											]
										),
									],

								],
							],

							'featured_image' => [
								'label' => __( 'Featured Image', 'blocksy' ),
								'options' => [

									'thumb_ratio' => [
										'label' => __( 'Image Ratio', 'blocksy' ),
										'type' => 'ct-radio',
										'value' => '4/3',
										'view' => 'text',
										'design' => 'inline',
										'attr' => [ 'data-type' => 'compact' ],
										'choices' => [
											'4/3' => '4/3',
											'3/4' => '3/4',
										],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [ $prefix . 'card_type' => 'boxed' ],
                                        'global' => true,
										'options' => [

											'is_boundless' => [
												'label' => __( 'Boundless', 'blocksy' ),
												'type' => 'ct-switch',
												'value' => 'yes',
											],

										],
									],

								],
							],

							'excerpt' => [
								'label' => __( 'Excerpt', 'blocksy' ),
								'options' => [

									'excerpt_length' => [
										'label' => __( 'Length', 'blocksy' ),
										'type' => 'ct-number',
										'design' => 'inline',
										'value' => 40,
										'min' => 10,
										'max' => 100,
									],

								],
							],

							'post_meta' => [
								'label' => __( 'Post Meta', 'blocksy' ),
								'clone' => true,
								'options' => [

									'meta' => [
										'label' => false,
										'type' => 'ct-checkboxes',
										'attr' => [ 'data-columns' => '2' ],
										'choices' => blocksy_ordered_keys(
											[
												'author' => __( 'Author', 'blocksy' ),
												'date' => __( 'Date', 'blocksy' ),
												'categories' => __( 'Categories', 'blocksy' ),
												'comments' => __( 'Comments', 'blocksy' ),
											]
										),

										'value' => [
											'author' => true,
											'date' => true,
											'categories' => true,
											'comments' => true,
										],
									],

									'meta_type' => [
										'label' => __( 'Meta Type', 'blocksy' ),
										'type' => 'ct-radio',
										'value' => 'simple',
										'setting' => [ 'transport' => 'postMessage' ],
										'inline' => true,
										'view' => 'radio',
										'choices' => [
											'simple' => __( 'Simple', 'blocksy' ),
											'icons' => __( 'With Icons', 'blocksy' ),
										],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [ 'meta_type' => 'simple' ],
										'options' => [

											'has_meta_label' => [
												'label' => __( 'Meta Label', 'blocksy' ),
												'type' => 'ct-switch',
												'value' => 'no',
											],

										],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [
											'meta/categories' => true,
											'meta_type' => 'simple'
										],
										'options' => [

											'category_style' => [
												'type' => 'ct-radio',
												'value' => 'simple',
												'setting' => [ 'transport' => 'postMessage' ],
												'inline' => true,
												'view' => 'radio',
												'choices' => [
													'simple' => __( 'Simple', 'blocksy' ),
													'pill' => __( 'Pill', 'blocksy' ),
													'underline' => __( 'Underline', 'blocksy' ),
												],
											],

										],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [
											'meta/author' => true,
										],
										'options' => [

											'has_author_avatar' => [
												'label' => __( 'Avatar', 'blocksy' ),
												'type' => 'ct-switch',
												'value' => 'no',
											],

										],
									],

									blocksy_rand_md5() => [
										'type' => 'ct-condition',
										'condition' => [
											'meta/author' => 'true',
											'has_author_avatar' => 'yes',
										],
										'options' => [
											'avatar_size' => [
												'label' => __( 'Avatar Size', 'blocksy' ),
												'type' => 'ct-number',
												'design' => 'inline',
												'value' => 30,
												'min' => 15,
												'max' => 50,
											],
										],
									],

								],
							],
						],

						'setting' => [ 'transport' => 'postMessage' ],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					$prefix . 'cardsGap' => [
						'label' => __( 'Cards Gap', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 60,
						'responsive' => true,
						'value' => [
							'mobile' => 30,
							'tablet' => 30,
							'desktop' => 30,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],
				],
			],

			blocksy_rand_md5() => [
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					$prefix . 'cardTitleSize' => [
						'label' => __( 'Title Font Size', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 100,
						'responsive' => true,
						'value' => [
							'mobile' => 18,
							'tablet' => 20,
							'desktop' => 20,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					$prefix . 'cardTitleColor' => [
						'label' => __( 'Title Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => 'var(--paletteColor4)',
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

					$prefix . 'cardExcerptSize' => [
						'label' => __( 'Excerpt Font Size', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 100,
						'responsive' => true,
						'value' => [
							'mobile' => 16,
							'tablet' => 16,
							'desktop' => 16,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					$prefix . 'cardExcerptColor' => [
						'label' => __( 'Excerpt Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => 'rgba(44,62,80,0.9)',
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
						'attr' => [ 'data-type' => 'small' ]
					],

					$prefix . 'cardMetaSize' => [
						'label' => __( 'Meta Font Size', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 100,
						'responsive' => true,
						'value' => [
							'mobile' => 12,
							'tablet' => 12,
							'desktop' => 12,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					$prefix . 'cardMetaColor' => [
						'label' => __( 'Meta Color', 'blocksy' ),
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
						'type' => 'ct-condition',
						'condition' => [ $prefix . 'card_type' => 'boxed' ],
						'options' => [

							blocksy_rand_md5() => [
								'type' => 'ct-divider',
								'attr' => [ 'data-type' => 'small' ]
							],

							$prefix . 'cardBackground' => [
								'label' => __( 'Card Background Color', 'blocksy' ),
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

							$prefix . 'card_spacing' => [
								'label' => __( 'Card Inner Spacing', 'blocksy' ),
								'type' => 'ct-slider',
								'min' => 0,
								'max' => 100,
								'responsive' => true,
								'value' => [
									'mobile' => 25,
									'tablet' => 35,
									'desktop' => 35,
								],
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

				],
			],
		]
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ $prefix . 'structure' => 'grid' ],
		'options' => [

			$prefix . 'columns' => [
				'label' => __( 'Cards Per Row', 'blocksy' ),
				'type' => 'ct-number',
				'value' => 3,
				'min' => 2,
				'max' => 4,
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],

	$prefix . 'archive_per_page' => [
		'label' => __( 'Cards Per page', 'blocksy' ),
		'type' => 'ct-number',
		'value' => 10,
		'min' => 1,
		'max' => 30,
		'design' => 'inline',
		// 'setting' => [ 'transport' => 'postMessage' ],
	],

];
