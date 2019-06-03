<?php
/**
 * Blog options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'blog_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			[
				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [ 'show_on_front' => 'posts' ],
					'global' => true,
					'options' => [

						'blog_page_title_enabled' => [
							'label' => __( 'Page Title', 'blocksy' ),
							'type' => 'ct-panel',
							'switch' => true,
							'value' => 'no',
							'wrapperAttr' => [ 'data-label' => 'heading-label' ],
							'setting' => [ 'transport' => 'postMessage' ],
							'inner-options' => [

								blocksy_get_options('general/page-title', [
									'prefix' => 'blog',
									'is_home' => true
								])

							],
						],

					]
				]
			],

			blocksy_get_options('general/posts-listing', [
				'prefix' => 'blog',
			]),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'blog',
			])
		],
	],
];
