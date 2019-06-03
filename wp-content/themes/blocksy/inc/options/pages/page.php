<?php

/**
 * Page options.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'page_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			'single_page_title_enabled' => [
				'label' => __( 'Page Title', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'yes',
				'wrapperAttr' => [ 'data-label' => 'heading-label' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'inner-options' => [

					blocksy_get_options('general/page-title', [
						'prefix' => 'single_page',
						'is_single' => true,
						'is_page' => true
					])

				],
			],

			blocksy_rand_md5() => [
				'label' => __( 'Page Structure', 'blocksy' ),
				'type' => 'ct-title',
			],

			'single_page_structure' => [
				'label' => false,
				'type' => 'ct-image-picker',
				'value' => 'type-4',
				'attr' => [ 'data-type' => 'background' ],
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [

					'type-3' => [
						'src'   => blocksy_image_picker_url( 'narrow.svg' ),
						'title' => __( 'Narrow Width', 'blocksy' ),
					],

					'type-4' => [
						'src'   => blocksy_image_picker_url( 'normal.svg' ),
						'title' => __( 'Normal Width', 'blocksy' ),
					],

					'type-2' => [
						'src'   => blocksy_image_picker_url( 'left-single-sidebar.svg' ),
						'title' => __( 'Left Sidebar', 'blocksy' ),
					],

					'type-1' => [
						'src'   => blocksy_image_picker_url( 'right-single-sidebar.svg' ),
						'title' => __( 'Right Sidebar', 'blocksy' ),
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
			],

			'has_page_comments' => [
				'label' => __( 'Comments', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes',
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],
];
