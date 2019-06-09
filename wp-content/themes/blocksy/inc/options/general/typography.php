<?php
/**
 * Typography options
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

$options = [
	'typography_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [
			'rootTypography' => [
				'type' => 'ct-typography',
				'label' => __( 'Base Font', 'blocksy' ),
				'isDefault' => true,
				'value' => blocksy_typography_default_values([
					'family' => 'System Default',
					'variation' => 'n4'
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'h1Typography' => [
				'type' => 'ct-typography',
				'label' => __( 'Heading 1 (H1)', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '40px',
					'variation' => 'n7',
					'line-height' => '1.5'
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'h2Typography' => [
				'type' => 'ct-typography',
				'label' => __( 'Heading 2 (H2)', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '35px',
					'variation' => 'n7',
					'line-height' => '1.5'
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'h3Typography' => [
				'type' => 'ct-typography',
				'label' => __( 'Heading 3 (H3)', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '30px',
					'variation' => 'n7',
					'line-height' => '1.5'
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'h4Typography' => [
				'type' => 'ct-typography',
				'label' => __( 'Heading 4 (H4)', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '25px',
					'variation' => 'n7',
					'line-height' => '1.5'
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'h5Typography' => [
				'type' => 'ct-typography',
				'label' => __( 'Heading 5 (H5)', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '20px',
					'variation' => 'n7',
					'line-height' => '1.5'
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'h6Typography' => [
				'type' => 'ct-typography',
				'label' => __( 'Heading 6 (H6)', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '16px',
					'variation' => 'n7',
					'line-height' => '1.5'
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'siteTitle' => [
				'type' => 'ct-typography',
				'label' => __( 'Site Title', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'size' => '25px',
					'variation' => 'n7',
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'blockquote' => [
				'type' => 'ct-typography',
				'label' => __( 'Blockquote', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'family' => 'Georgia',
					'size' => '25px',
					'variation' => 'n6',
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			'pre' => [
				'type' => 'ct-typography',
				'label' => __( 'Preformatted', 'blocksy' ),
				'value' => blocksy_typography_default_values([
					'family' => 'monospace',
					'size' => '16px',
				]),
				'setting' => [ 'transport' => 'postMessage' ],
			],

			blocksy_rand_md5() => [
				'type' => 'ct-divider',
				'attr' => [ 'data-type' => 'small' ],
			],

			'font_subset' => [
				'label' => __( 'Google Fonts Subset', 'blocksy' ),
				'type' => 'ct-checkboxes',
				'attr' => [ 'data-columns' => 'no-gap' ],
				'allow_empty' => true,
				'choices' => blocksy_ordered_keys(
					[
						'latin-ext' => __( 'Latin Ext', 'blocksy' ),
						'vietnamese' => __( 'Vietnamese', 'blocksy' ),
						'cyrillic' => __( 'Cyrillic', 'blocksy' ),
						'cyrillic-ext' => __( 'Cyrillic Extended', 'blocksy' ),
						'greek' => __( 'Greek', 'blocksy' ),
						'greek-ext' => __( 'Greek Extended', 'blocksy' ),
					]
				),

				'value' => [
					'latin-ext' => false,
					'vietnamese' => false,
					'cyrillic' => false,
					'cyrillic-ext' => false,
					'greek' => false,
					'greek-ext' => false,
				],

				// 'setting' => [ 'transport' => 'postMessage' ],
			],


		],
	],
];
