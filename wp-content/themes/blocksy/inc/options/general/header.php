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
	'header_general_section_options' => [
		'type' => 'ct-options',
		'setting' => [ 'transport' => 'postMessage' ],
		'customizer_section' => 'layout',
		'inner-options' => [
			// $header_opts,

            /*
			blocksy_rand_md5() => [
				'type' => 'ct-title',
				'label' => __( 'Header Elements', 'blocksy' ),
			],
             */

			'header_placements' => [
				'type' => 'ct-header-builder',
				'setting' => ['transport' => 'postMessage'],
				'value' => $b->get_header_default_value(),
				'selective_refresh' => [
					[
						'id' => 'header_placements_1',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '#main-container > header[data-device="desktop"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder();
							echo $b->render('header', 'desktop');
						}
					],

					[
						'id' => 'header_placements_2',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '#main-container > header[data-device="mobile"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder();
							echo $b->render('header', 'mobile');
						}
					],

					[
						'id' => 'header_placements_offcanvas',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '#offcanvas .content-container',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder();
							echo $b->render_offcanvas('mobile', false);
						}
					],

					[
						'id' => 'header_placements_item:menu',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => 'header[data-device] [data-id="menu"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder_Render_Placements();
							echo $b->render_single_item('menu');
						}
					],

					[
						'id' => 'header_placements_item:menu-secondary',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => 'header[data-device] [data-id="menu-secondary"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder_Render_Placements();
							echo $b->render_single_item('menu-secondary');
						}
					],

					[
						'id' => 'header_placements_item:mobile-menu',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '#offcanvas [data-id="mobile-menu"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder_Render_Placements();
							echo $b->render_single_item('mobile-menu');
						}
					],

					[
						'id' => 'header_placements_item:logo:desktop',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '[data-device="desktop"] [data-id="logo"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder_Render_Placements();
							echo $b->render_single_item('logo');
						}
					],

					[
						'id' => 'header_placements_item_mobile:logo:mobile',
						'fallback_refresh' => false,
						'container_inclusive' => true,
						'selector' => '[data-device="mobile"] [data-id="logo"]',
						'settings' => ['header_placements'],
						'render_callback' => function () {
							$b = new Blocksy_Customizer_Builder_Render_Placements(
								'mobile'
							);
							echo $b->render_single_item('logo');
						}
					]
				],
			],

			'footer_placements' => [
				'type' => 'hidden',
				'value' => [
					'current_section' => 'type-1',
					'sections' => [
					]
				]
			]
		]
	],
];

