<?php
/**
 * Misc general options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'misc_general_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			'has_lazy_load' => [
				'label' => __( 'Lazy Load Images', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'yes',
				'inner-options' => [

					blocksy_rand_md5() => [
						'type' => 'ct-notification',
						'text' => __( 'This option controls how images are loading on your page. Please note, that this option will be auto disabled if you have JetPack\'s lazy load enabled.', 'blocksy' ),
					],

					'lazy_load_type' => [
						'label' => __( 'Animation Type', 'blocksy' ),
						'type' => 'ct-radio',
						'value' => 'fade',
						'inline' => true,
						'view' => 'radio',
						'choices' => [
							'fade' => __( 'Fade', 'blocksy' ),
							'circle' => __( 'Circle Loader', 'blocksy' ),
							'none' => __( 'None', 'blocksy' ),
						],
					],

				],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'has_posts_reveal' => [
				'label' => __( 'Posts Reveal Effect', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'no',
				'desc' => __( 'This option enables a nice posts reveal effect as you scroll.', 'blocksy' ),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'has_passepartout' => [
				'label' => __( 'Passepartout', 'blocksy' ),
				'type' => 'ct-panel',
				'switch' => true,
				'value' => 'no',
				'setting' => [ 'transport' => 'postMessage' ],
				'inner-options' => [

					'passepartoutSize' => [
						'label' => __( 'Passepartout Size', 'blocksy' ),
						'type' => 'ct-slider',
						'min' => 0,
						'max' => 50,
						'responsive' => true,
						'value' => [
							'mobile' => 0,
							'tablet' => 10,
							'desktop' => 10,
						],
						'setting' => [ 'transport' => 'postMessage' ],
					],

					'passepartoutColor' => [
						'label' => __( 'Passepartout Color', 'blocksy' ),
						'type'  => 'ct-color-picker',
						'design' => 'inline',
						'setting' => [ 'transport' => 'postMessage' ],
						'value' => [
							'default' => [
								'color' => 'var(--paletteColor1)',
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
