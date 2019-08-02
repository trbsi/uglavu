<?php

$b = new Blocksy_Customizer_Builder();

$options = [];

$header_opts = [];

foreach ($b->get_registered_items_by('header', 'primary') as $single_item) {
	$option_id = $b->get_option_id_for('header', $single_item);

	$header_opts[$option_id . '_panel'] = [
		'label' => $single_item['config']['name'],
		'container' => [ 'priority' => 1 ],
		'setting' => [ 'transport' => 'postMessage' ],
		'type' => 'ct-panel',
		'switch' => false,
		'inner-options' => $b->get_options_for('header', $single_item)
	];

	/*
		$option_id . '_panel_options' => [
			'type' => 'ct-options',
			'setting' => [ 'transport' => 'postMessage' ],
			'inner-options' => $b->get_options_for('header', $single_item)
		]
	 */
}

$options = [
	'new_header_general_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'customizer_section' => 'layout',
		'inner-options' => [
			$header_opts,

			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Builder Elements', 'blocksy' ),
			],

			'header_items_check' => [
				'type' => 'ct-panels-builder-items',
				'panelType' => 'header',
				'value' => ''
			],

			'header_placements' => [
				'type' => 'hidden',
				'value' => [
					'current_section' => 'type-1',
					'sections' => [
						$b->get_header_structure_for('type-1'),
						$b->get_header_structure_for('type-2')
					]
				]
			],

			'footer_placements' => [
				'type' => 'hidden',
				'value' => [
					'current_section' => 'type-1',
					'sections' => [
						$b->get_header_structure_for('type-1', 'rows'),
						$b->get_header_structure_for('type-2', 'rows')
					]
				]
			]
		]
	],
];

