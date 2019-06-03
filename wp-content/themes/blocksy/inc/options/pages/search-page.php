<?php
/**
 * Search page
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'search_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			[
				'search_page_title_enabled' => [
					'label' => __( 'Page Title', 'blocksy' ),
					'type' => 'ct-panel',
					'switch' => true,
					'value' => 'yes',
					'wrapperAttr' => [ 'data-label' => 'heading-label' ],
					'setting' => [ 'transport' => 'postMessage' ],
					'inner-options' => [

						blocksy_get_options('general/page-title', [
							'prefix' => 'search',
							'is_search' => true
						])

					],
				],
			],

			blocksy_get_options('general/posts-listing', [
				'prefix' => 'search',
				'title' => __('search results', 'blocksy')
			]),

			[
				blocksy_rand_md5() => [
					'type' => 'ct-title',
					'label' => __( 'Search Options', 'blocksy' ),
				],

				'search_include_pages' => [
					'label' => __( 'Include pages in Searches', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'no',
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],
			],

			blocksy_get_options('general/sidebar-particular', [
				'prefix' => 'search',
			]),

		],
	],
];
