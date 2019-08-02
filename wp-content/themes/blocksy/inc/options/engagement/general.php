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
				'value' => 'yes',
				'desc' => __( 'If you use an SEO plugin, you can disable this option and let the plugin take care of it.', 'blocksy' ),
			],

		],
	],

];
