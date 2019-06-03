<?php
/**
 * Options for socials widget.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$options = [

	'title' => [
		'type' => 'text',
		'label' => __( 'Title', 'blc' ),
		'field_attr' => [ 'id' => 'widget-title' ],
		'design' => 'inline',
		'value' => __( 'Social Icons', 'blc' ),
		'disableRevertButton' => true,
	],

	'socials' => [
		'type' => 'ct-layers',
		'label' => false,
		'manageable' => true,
		'desc' => sprintf(
			__( 'You can configure social URLs in %s.', 'blc' ),
			sprintf(
				'<a href="%s" target="_blank">%s</a>',
				admin_url('/customize.php?autofocus[section]=social_accounts'),
				__('Customizer', 'blc')
			)
		),
		'value' => [
			[
				'id' => 'facebook',
				'enabled' => true,
			],

			[
				'id' => 'twitter',
				'enabled' => true,
			],

			[
				'id' => 'gplus',
				'enabled' => true,
			],

			[
				'id' => 'instagram',
				'enabled' => true,
			],
		],

		'settings' => [
			'facebook' => [
				'label' => __( 'Facebook', 'blc' ),
			],

			'twitter' => [
				'label' => __( 'Twitter', 'blc' ),
			],

			'gplus' => [
				'label' => __( 'Google Plus', 'blc' ),
			],

			'instagram' => [
				'label' => __( 'Instagram', 'blc' ),
			],

			'pinterest' => [
				'label' => __( 'Pinterest', 'blc' ),
			],

			'dribbble' => [
				'label' => __( 'Dribbble', 'blc' ),
			],

			'linkedin' => [
				'label' => __( 'LinkedIn', 'blc' ),
			],

			'medium' => [
				'label' => __( 'Medium', 'blc' ),
			],

			'patreon' => [
				'label' => __( 'Patreon', 'blc' ),
			],

			'vk' => [
				'label' => __( 'VK', 'blc' ),
			],

			'youtube' => [
				'label' => __( 'YouTube', 'blc' ),
			],

			'vimeo' => [
				'label' => __( 'Vimeo', 'blc' ),
			],
		],
	],

	'social_icons_size' => [
		'label' => __( 'Icons Size', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'medium',
		'view' => 'text',
		'design' => 'block',
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => [
			'small' => __( 'Small', 'blc' ),
			'medium' => __( 'Medium', 'blc' ),
			'large' => __( 'Large', 'blc' ),
		],
	],

	'social_type' => [
		'label' => __( 'Icons Type', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'simple',
		'view' => 'text',
		'design' => 'block',
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => [
			'simple' => __( 'Simple', 'blc' ),
			'rounded' => __( 'Rounded', 'blc' ),
			'square' => __( 'Square', 'blc' ),
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'social_type' => '!simple' ],
		'options' => [

			'social_icons_fill' => [
				'label' => __( 'Icons Fill Type', 'blc' ),
				'type' => 'ct-radio',
				'value' => 'outline',
				'view' => 'text',
				'design' => 'block',
				'setting' => [ 'transport' => 'postMessage' ],
				'choices' => [
					'outline' => __( 'Outline', 'blc' ),
					'solid' => __( 'Solid', 'blc' ),
				],
			],

		],
	],

];
