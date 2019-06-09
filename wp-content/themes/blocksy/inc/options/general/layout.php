<?php
/**
 * Layout options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'layout_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'customizer_section' => 'layout',
		'inner-options' => [

			'maxSiteWidth' => [
				'label' => __( 'Maximum Site Width', 'blocksy' ),
				'type' => 'ct-slider',
				'value' => 1290,
				'min' => 950,
				'max' => 1900,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'contentAreaSpacing' => [
				'label' => __( 'Content Area Spacing', 'blocksy' ),
				'type' => 'ct-slider',
				'value' => [
					'desktop' => '80px',
					'tablet' => '60px',
					'mobile' => '50px',
				],
				'units' => blocksy_units_config([
					[ 'unit' => 'px', 'min' => 0, 'max' => 300 ],
				]),
				'responsive' => true,
				'setting' => [ 'transport' => 'postMessage' ],
				'desc' => __( 'Main content area top and bottom spacing.', 'blocksy' ),
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'narrowContainerWidth' => [
				'label' => __( 'Narrow Container Width', 'blocksy' ),
				'type' => 'ct-slider',
				'defaultUnit' => '%',
				'value' => 60,
				'min' => 40,
				'max' => 80,
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'wideOffset' => [
				'label' => __( 'Wide Alignment Offset', 'blocksy' ),
				'type' => 'ct-slider',
				'defaultUnit' => 'px',
				'value' => 130,
				'min' => 50,
				'max' => 200,
				'setting' => [ 'transport' => 'postMessage' ],
			],
		],
	],

	'customizer_color_scheme' => [
		'label' => __( 'Color scheme', 'blocksy' ),
		'type' => 'hidden',
		'label' => '',
		'value' => 'no',
		'setting' => [ 'transport' => 'postMessage' ],
	],
];
