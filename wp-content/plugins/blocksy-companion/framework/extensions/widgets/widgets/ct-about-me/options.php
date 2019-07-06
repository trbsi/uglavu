<?php
/**
 * About me widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

require_once dirname( __FILE__ ) . '/helpers.php';

$options = [

	'title' => [
		'type' => 'text',
		'label' => __( 'Title', 'blc' ),
		'field_attr' => [ 'id' => 'widget-title' ],
		'design' => 'inline',
		'value' => __( 'About me', 'blc' ),
		'disableRevertButton' => true,
	],

	'about_type' => [
		'label' => __( 'Type', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'simple',
		'view' => 'radio',
		'design' => 'inline',
		'inline' => true,
		'disableRevertButton' => true,
		'choices' => [
			'simple' => __( 'Simple', 'blc' ),
			'bordered' => __( 'Bordered', 'blc' ),
		],
	],

	'about_source' => [
		'label' => __( 'Source', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'from_wp',
		'view' => 'radio',
		'design' => 'inline',
		'inline' => true,
		'disableRevertButton' => true,
		'choices' => [
			'from_wp' => __( 'From WP', 'blc' ),
			'custom' => __( 'Custom', 'blc' ),
		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'about_source' => 'from_wp' ],
		'options' => [

			'wp_user' => [
				'type' => 'ct-select',
				'label' => __( 'User', 'blc' ),
				'value' => array_keys(blc_get_user_choices())[0],
				'design' => 'inline',
				'choices' => blocksy_ordered_keys(blc_get_user_choices()),
			],

		]
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'about_source' => 'custom' ],
		'options' => [

			'about_avatar' => [
				'label' => __('Avatar', 'blc'),
				'type' => 'ct-image-uploader',
				'design' => 'inline',
				'value' => [ 'attachment_id' => null ],
				'emptyLabel' => __('Select Image', 'blc'),
				'filledLabel' => __('Change Image', 'blc'),
			],

			'about_name' => [
				'type' => 'text',
				'label' => __( 'Name', 'blc' ),
				'field_attr' => [ 'id' => 'widget-title' ],
				'design' => 'inline',
				'value' => __( 'John Doe', 'blc' ),
				'disableRevertButton' => true,
			],

			'about_text' => [
				'label' => __( 'Description', 'blc' ),
				'type' => 'textarea',
				'value' => '',
				'design' => 'inline',
				'disableRevertButton' => true,
			],

		],
	],

	'about_socials' => [
		'type' => 'ct-layers',
		'label' => __( 'Social Channels', 'blc' ),
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

			'rss' => [
				'label' => __( 'RSS', 'blc' ),
			],
		],
	],

	'about_social_icons_size' => [
		'label' => __( 'Icons Size', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'small',
		'view' => 'text',
		'design' => 'block',
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => [
			'small' => __( 'Small', 'blc' ),
			'medium' => __( 'Medium', 'blc' ),
			'large' => __( 'Large', 'blc' ),
		],
	],

	'about_social_type' => [
		'label' => __( 'Icons Type', 'blc' ),
		'type' => 'ct-radio',
		'value' => 'rounded',
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
		'condition' => [ 'about_social_type' => '!simple' ],
		'options' => [

			'about_social_icons_fill' => [
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
