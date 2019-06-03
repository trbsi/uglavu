<?php

$options = [

	'general_visitor_eng_section_options' => [
		'type' => 'ct-options',
		'asd' => 'test',
		'setting' => [ 'transport' => 'postMessage' ],
		'inner-options' => [

			'enable_schema_org_markup' => [
				'label' => __( 'Schema Org Markup', 'blocksy' ),
				'type' => 'ct-switch',
				'value' => 'yes'
			],

		],
	],

];
