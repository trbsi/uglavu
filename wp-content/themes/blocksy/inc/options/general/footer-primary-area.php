<?php

if ( ! isset( $number ) ) {
	$number = '1';
}

if ( ! isset( $default_section ) ) {
	$default_section = 'footer_menu';
}

$options = [
	'footer_section_' . $number => [
		'label' => sprintf(
			// translators: placeholder here means the section number
			__( 'Section %s', 'blocksy' ),
			$number
		),
		'type' => 'ct-select',
		'value' => $default_section,
		'view' => 'text',
		'design' => 'inline',
		'setting' => [ 'transport' => 'postMessage' ],
		'choices' => blocksy_ordered_keys(
			[
				'footer_menu' => __( 'Footer Menu', 'blocksy' ),
				'custom_text' => __( 'Custom Text', 'blocksy' ),
				'social_icons' => __( 'Social Icons', 'blocksy' ),
				'disabled' => __( 'Disabled', 'blocksy' ),
			]
		),
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'footer_section_' . $number => 'custom_text' ],
		'options' => [

			'section_' . $number . '_text' => [
				'label' => false,
				'type' => 'textarea',
				'value' => __( 'Sample text', 'blocksy' ),
				'setting' => [ 'transport' => 'postMessage' ],
			],

		],
	],

	blocksy_rand_md5() => [
		'type' => 'ct-condition',
		'condition' => [ 'footer_section_' . $number => 'social_icons' ],
		'options' => [

			'footer_socials_' . $number => [
				'label' => false,
				'type' => 'ct-layers',
				'manageable' => true,
				'desc' => sprintf(
					// translators: placeholder here means the actual URL.
					__( 'You can configure social URLs %shere%s.', 'blocksy' ),
					sprintf(
						'<a href="%s">',
						admin_url('/customize.php?autofocus[section]=social_accounts')
					),
					'</a>'
				),
				'setting' => [ 'transport' => 'postMessage' ],
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
				],

				'settings' => [
					'facebook' => [
						'label' => __( 'Facebook', 'blocksy' ),
					],

					'twitter' => [
						'label' => __( 'Twitter', 'blocksy' ),
					],

					'gplus' => [
						'label' => __( 'Google Plus', 'blocksy' ),
					],

					'instagram' => [
						'label' => __( 'Instagram', 'blocksy' ),
					],

					'pinterest' => [
						'label' => __( 'Pinterest', 'blocksy' ),
					],

					'dribbble' => [
						'label' => __( 'Dribbble', 'blocksy' ),
					],

					'linkedin' => [
						'label' => __( 'LinkedIn', 'blocksy' ),
					],

					'medium' => [
						'label' => __( 'Medium', 'blocksy' ),
					],

					'patreon' => [
						'label' => __( 'Patreon', 'blocksy' ),
					],

					'vk' => [
						'label' => __( 'VK', 'blocksy' ),
					],

					'youtube' => [
						'label' => __( 'YouTube', 'blocksy' ),
					],

					'vimeo' => [
						'label' => __( 'Vimeo', 'blocksy' ),
					],

					'rss' => [
						'label' => __( 'RSS', 'blocksy' ),
					],
				],
			],
		],
	],

];
