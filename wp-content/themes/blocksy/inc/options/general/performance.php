<?php
/**
 * Performance options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'performance_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			apply_filters(
				'blocksy_performance_end_customizer_options',
				[]
			),

			[
				'emoji_scripts' => [
					'label' => __( 'Emojis Script', 'blc' ),
					'type' => 'ct-switch',
					'value' => 'no',
					'setting' => [ 'transport' => 'postMessage' ],
					'desc' => __( 'Disable WordPress emojis script if you don\'t use them in order to improve the performance. ', 'blc' ),
				],

				blocksy_rand_md5() => [
					'type' => 'ct-divider',
				],

				'has_lazy_load' => [
					'label' => __( 'Lazy Load Images', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
					'setting' => [ 'transport' => 'postMessage' ],
					'desc' => __( 'This option will be auto disabled if you have JetPack\'s lazy load option enabled.', 'blocksy' ),
				],

				blocksy_rand_md5() => [
					'type' => 'ct-condition',
					'condition' => [ 'has_lazy_load' => 'yes' ],
					'options' => [

						'lazy_load_type' => [
							'label' => __( 'Images Loading Animation Type', 'blocksy' ),
							'type' => 'ct-radio',
							'value' => 'fade',
							'inline' => true,
							'view' => 'text',
							'choices' => [
								'fade' => __( 'Fade', 'blocksy' ),
								'circle' => __( 'Circles', 'blocksy' ),
								'none' => __( 'None', 'blocksy' ),
							],
						],

					],
				],
			],
		],
	],
];
