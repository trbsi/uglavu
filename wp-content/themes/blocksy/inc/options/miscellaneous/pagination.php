<?php
/**
 * Pagination options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'pagination_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			blocksy_rand_md5() => [
				'title' => __( 'General', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'pagination_global_type' => [
						'label' => __( 'Pagination Type', 'blocksy' ),
						'type' => 'ct-select',
						'value' => 'simple',
						'view' => 'text',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'choices' => blocksy_ordered_keys(
							[
								'simple' => __( 'Standard', 'blocksy' ),
								'next_prev' => __( 'Next/Prev', 'blocksy' ),
								'load_more' => __( 'Load More', 'blocksy' ),
								'infinite_scroll' => __( 'Infinite Scroll', 'blocksy' ),
							]
						),

						'selective_refresh' => [
							[
								'id' => 'pagination_global_type',
								'container_inclusive' => true,
								'selector' => '.ct-pagination',
								'render_callback' => function () {
									/**
									 * Note to code reviewers: This line doesn't need to be escaped.
									 * Function blocksy_display_posts_pagination() used here escapes the value properly.
									 */
									echo blocksy_display_posts_pagination();
								}
]
						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-condition',
						'condition' => [ 'pagination_global_type' => 'load_more' ],
						'options' => [

							'load_more_label' => [
								'label' => __( 'Label', 'blocksy' ),
								'type' => 'text',
								'design' => 'inline',
								'value' => __( 'Load More', 'blocksy' ),
								'setting' => [ 'transport' => 'postMessage' ],
							],

						],
					],

					blocksy_rand_md5() => [
						'type' => 'ct-divider',
						'attr' => [ 'data-type' => 'small' ],
					],

					'paginationSpacing' => [
						'label' => __( 'Pagination Top Spacing', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 200,
						'responsive' => true,
						'value' => [
							'mobile' => 50,
							'tablet' => 60,
							'desktop' => 80,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

				],
			],

			blocksy_rand_md5() => [
				'title' => __( 'Design', 'blocksy' ),
				'type' => 'tab',
				'options' => [

					'paginationFontColor' => [
						'label' => __( 'Font Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'default' => [
								'color' => 'var(--paletteColor3)',
							],

							'hover' => [
								'color' => '#ffffff',
							],
						],

						'pickers' => [
							[
								'title' => __( 'Initial', 'blocksy' ),
								'id' => 'default',
							],

							[
								'title' => __( 'Active/Hover', 'blocksy' ),
								'id' => 'hover',
							],
						],
					],

					'paginationAccentColor' => [
						'label' => __( 'Accent Color', 'blocksy' ),
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

					'paginationDivider' => [
						'label' => __( 'Divider', 'blocksy' ),
						'type' => 'ct-border',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'width' => 1,
							'style' => 'none',
							'color' => [
								'color' => 'rgba(224, 229, 235, 0.5)',
							],
						]
					],

				],
			],

		],
	],
];
