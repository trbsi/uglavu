<?php

if (! isset($prefix)) {
	$prefix = '';
} else {
	$prefix = $prefix . '_';
}

$options = [

	$prefix . 'site_background_panel' => [
		'label' => __( 'Site Background', 'blocksy' ),
		'type' => 'ct-panel',
		'switch' => false,
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			$prefix . 'site_background_type' => [
				'label' => false,
				'type' => 'ct-radio',
				'value' => 'color',
				'view' => 'text',
				'design' => 'block',
				'allow_empty' => true,
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'color' => __( 'Color', 'blocksy' ),
					'pattern' => __( 'Pattern', 'blocksy' ),
					'image' => __( 'Image', 'blocksy' ),
				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ $prefix . 'site_background_type' => 'pattern' ],
				'options' => [

					$prefix . 'background_pattern' => [
						'label' => __( 'Pattern Type', 'blocksy' ),
						'type' => 'ct-image-picker',
						'value' => 'type-1',
						'attr' => [
							'data-type' => 'pattern',
							'data-columns' => '3',
						],
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [

							'type-1' => [
								'src'   => blocksy_image_picker_url( 'patterns/hideout.svg' ),
								'title' => __( 'Hideout', 'blocksy' ),
							],

							'type-2' => [
								'src'   => blocksy_image_picker_url( 'patterns/triangles.svg' ),
								'title' => __( 'Triangles', 'blocksy' ),
							],

							'type-3' => [
								'src'   => blocksy_image_picker_url( 'patterns/bubbles.svg' ),
								'title' => __( 'Bubbles', 'blocksy' ),
							],

							'type-4' => [
								'src'   => blocksy_image_picker_url( 'patterns/wiggle.svg' ),
								'title' => __( 'Wiggle', 'blocksy' ),
							],

							'type-5' => [
								'src'   => blocksy_image_picker_url( 'patterns/polka-dots.svg' ),
								'title' => __( 'Polka Dots', 'blocksy' ),
							],

							'type-6' => [
								'src'   => blocksy_image_picker_url( 'patterns/overlaping-circles.svg' ),
								'title' => __( 'Overlaping Circles', 'blocksy' ),
							],

							'type-7' => [
								'src'   => blocksy_image_picker_url( 'patterns/texture.svg' ),
								'title' => __( 'Texture', 'blocksy' ),
							],

							'type-8' => [
								'src'   => blocksy_image_picker_url( 'patterns/diagonal-lines.svg' ),
								'title' => __( 'Diagonal Lines', 'blocksy' ),
							],

							'type-9' => [
								'src'   => blocksy_image_picker_url( 'patterns/rain.svg' ),
								'title' => __( 'Rain', 'blocksy' ),
							],

							'type-10' => [
								'src'   => blocksy_image_picker_url( 'patterns/stripes.svg' ),
								'title' => __( 'Stripes', 'blocksy' ),
							],

							'type-11' => [
								'src'   => blocksy_image_picker_url( 'patterns/diagonal-stripes.svg' ),
								'title' => __( 'Diagonal Stripes', 'blocksy' ),
							],

							'type-12' => [
								'src'   => blocksy_image_picker_url( 'patterns/intersecting-circles.svg' ),
								'title' => __( 'Intersecting Circles', 'blocksy' ),
							],

							'type-13' => [
								'src'   => blocksy_image_picker_url( 'patterns/bank-note.svg' ),
								'title' => __( 'Bank Note', 'blocksy' ),
							],

							'type-14' => [
								'src'   => blocksy_image_picker_url( 'patterns/zig-zag.svg' ),
								'title' => __( 'Zig Zag', 'blocksy' ),
							],

							'type-15' => [
								'src'   => blocksy_image_picker_url( 'patterns/endless-clouds.svg' ),
								'title' => __( 'Endless Clouds', 'blocksy' ),
							],

							'type-16' => [
								'src'   => blocksy_image_picker_url( 'patterns/honey-comb.svg' ),
								'title' => __( 'Honey Comb', 'blocksy' ),
							],

							'type-17' => [
								'src'   => blocksy_image_picker_url( 'patterns/cross-stripes.svg' ),
								'title' => __( 'Cross Stripes', 'blocksy' ),
							],

							'type-18' => [
								'src'   => blocksy_image_picker_url( 'patterns/autumn.svg' ),
								'title' => __( 'Autumn', 'blocksy' ),
							],
						],
					],

					$prefix . 'patternColor' => [
						'label' => __( 'Pattern Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],

						'value' => [
							'default' => [
								'color' => '#e5e7ea',
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

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [ $prefix . 'site_background_type' => 'image' ],
				'options' => [

					$prefix . 'site_background_image' => [
						'label' => __( 'Background Image', 'blocksy' ),
						'type' => 'ct-image-uploader',
						'has_position_picker' => true,
						'emptyLabel' => __('Select Image', 'blocksy'),
						'filledLabel' => __('Change Image', 'blocksy'),
						'value' => [
							'attachment_id' => null,
							'x' => 0.5,
							'y' => 0.5
						],
						'setting' => ['transport' => 'postMessage']
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-condition',
				'condition' => [
					$prefix . 'site_background_type' => 'image',
					$prefix . 'site_background_image/attachment_id:truthy' => 'yes'
				],
				'options' => [

					$prefix . 'site_background_repeat' => [
						'label' => __( 'Background Repeat', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'no-repeat',
						'view' => 'text',
						'design' => 'block',
						'attr' => [ 'data-type' => 'repeat' ],
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'no-repeat' => blocksy_image_picker_file('norepeat'),
							'repeat-x' => blocksy_image_picker_file('repeat_h'),
							'repeat-y' => blocksy_image_picker_file('repeat_v'),
							'repeat' => blocksy_image_picker_file('repeat'),
						],
					],

					$prefix . 'site_background_size' => [
						'label' => __( 'Background Size', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'auto',
						'view' => 'text',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'auto' => __( 'Auto', 'blocksy' ),
							'cover' => __( 'Cover', 'blocksy' ),
							'contain' => __( 'Contain', 'blocksy' ),
						],
					],

					$prefix . 'site_background_attachment' => [
						'label' => __( 'Background Attachment', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'scroll',
						'view' => 'text',
						'design' => 'block',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => [
							'scroll' => __( 'Scroll', 'blocksy' ),
							'fixed' => __( 'Fixed', 'blocksy' ),
							'inherit' => __( 'Inherit', 'blocksy' ),
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

				],
			],


			$prefix . 'siteBackground' => [
				'label' => __( 'Site Background', 'blocksy' ),
				'type'  => 'ct-color-picker',
				'design' => 'inline',
				'setting' => [ 'transport' => 'postMessage' ],

				'value' => [
					'default' => [
						'color' => '#f8f9fb',
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

];
