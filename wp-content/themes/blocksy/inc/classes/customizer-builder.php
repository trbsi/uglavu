<?php

require_once dirname( __FILE__ ) . '/builder/builder-renderer.php';

class Blocksy_Customizer_Builder {
	public function __construct() {
	}

	public function get_header_default_value() {
		return [
			'current_section' => 'type-1',
			'sections' => [
				$this->get_header_structure_for([
					'id' => 'type-1',
					'mode' => 'placements',
					'items' => [

						'desktop' => [
							'middle-row' => [
								'start' => ['logo'],
								'end' => ['menu', 'search']
							]
						],

						'mobile' => [
							'middle-row' => [
								'start' => ['logo'],
								'end' => ['trigger']
							],

							'offcanvas' => [
								'start' => [
									'mobile-menu',
									'button'
								]
							]
						]
					]
				]),

				$this->get_header_structure_for([
					'id' => 'type-2',
					'mode' => 'placements',
					'items' => [

						'desktop' => [
							'middle-row' => [
								'start' => ['logo'],
								'middle' => ['menu'],
								'end' => ['search', 'button']
							]
						],

						'mobile' => [
							'middle-row' => [
								'start' => ['search'],
								'middle' => ['logo'],
								'end' => ['trigger']
							],

							'offcanvas' => [
								'start' => [
									'mobile-menu',
									'button'
								]
							]
						]
					]
				]),

				$this->get_header_structure_for([
					'id' => 'type-3',
					'mode' => 'placements',
					'items' => [

						'desktop' => [
							'middle-row' => [
								'start' => ['search'],
								'middle' => ['logo'],
								'end' => ['socials']
							],

							'bottom-row' => [
								'middle' => ['menu'],
							],
						],

						'mobile' => [
							'middle-row' => [
								'start' => ['search'],
								'middle' => ['logo'],
								'end' => ['trigger']
							],

							'offcanvas' => [
								'start' => [
									'mobile-menu',
									'button'
								]
							]
						]
					]
				]),
			]
		];
	}

	public function patch_header_value_for($processed_terms) {
		$current_value = get_theme_mod(
			'header_placements',
			$this->get_header_default_value()
		);

		foreach ($current_value['sections'] as $index => $header) {
			if (! isset($header['items'])) {
				continue;
			}

			foreach ($header['items'] as $item_index => $item) {
				if (! isset($item['values'])) {
					continue;
				}

				if (! isset($item['values']['menu'])) {
					continue;
				}

				if (! isset($processed_terms[$item['values']['menu']])) {
					continue;
				}

				$current_value['sections'][$index][
					'items'
				][$item_index]['values']['menu'] = $processed_terms[$item['values']['menu']];
			}
		}

		set_theme_mod('header_placements', $current_value);
	}

	public function render($panel_type = 'header', $device = null) {
		$optionsMapping = [
			'header' => 'header_placements',
			'footer' => 'footer_placements'
		];

		if (! $device) {
			$device = wp_is_mobile() ? 'mobile' : 'desktop';
		}

		$renderer = new Blocksy_Customizer_Builder_Render_Placements(
			$device,
			$optionsMapping[$panel_type]
		);

		return $renderer->render();
	}

    public function render_offcanvas($device = 'mobile', $has_container = true) {
		$optionsMapping = [
			'header' => 'header_placements',
			'footer' => 'footer_placements'
		];

		$renderer = new Blocksy_Customizer_Builder_Render_Placements(
			$device,
			$optionsMapping['header']
		);

		return $renderer->render_offcanvas($has_container);
    }

	public function typography_keys($panel_type = 'header') {
		$render = new Blocksy_Customizer_Builder_Render_Placements();
		$section = $render->get_current_section();

		$result = [];

		foreach ($section['items'] as $item) {
			$nested_item = $render->get_item_config_for($item['id']);

			if (
				! isset($nested_item['config']['typography_keys'])
				||
				empty($nested_item['config']['typography_keys'])
			) {
				continue;
			}

			$data = $render->get_item_data_for($item['id']);

			foreach ($nested_item['config']['typography_keys'] as $key) {
				$result[] = blocksy_akg($key, $data, []);
			}
		}

		return $result;
	}

	public function dynamic_css($panel_type = 'header', $args = []) {
		foreach ($this->get_registered_items_by($panel_type) as $item) {
			if (! file_exists($item['path'] . '/dynamic-styles.php')) {
				continue;
			}

			$render = new Blocksy_Customizer_Builder_Render_Placements();

			$args['atts'] = $render->get_item_data_for($item['id']);

			blocksy_get_variables_from_file(
				$item['path'] . '/dynamic-styles.php',
				array(),
				$args
			);
		/*
		blocksy_customizer_register_options(
			$wp_customize,
			$builder->get_options_for('header', $item),
			[
				'include_container_types' => false,
				'limit_level' => 5
			]
		);
		 */
		}
	}

	public function output_footer_templates() {
		if (wp_is_mobile()) {
			return '';
		}

		return $this->output_header_template('desktop') . (
			$this->output_header_template('mobile')
		);
	}

	public function output_header_template($type = 'desktop') {
		return blocksy_html_tag(
			'script',
			[
				'id' => 'ct-header-template-' . $type,
				'type' => 'text-template/' . $type
			],
			$this->render('header', $type)
		);
	}

	public function get_data_for_customizer() {
		$result = [];

		$result['header'] = $this->get_registered_items_by('header', 'all', true);
		$result['footer'] = $this->get_registered_items_by('footer', 'all', true);

		$result['secondary_items'] = [
			'header' => $this->get_registered_items_by('header', 'secondary'),
			'footer' => $this->get_registered_items_by('footer', 'secondary'),
		];

		return $result;
	}

	public function get_option_id_for($panel_type = 'header', $item) {
		return $panel_type . '_item_' . str_replace('-', '_', $item['id']);
	}

	public function get_registered_items_by(
		$panel_type = 'header',

		// all | primary | secondary
		$include = 'all',

		$require_options = false
	) {
		$paths_to_look_for_items = [
			get_template_directory() . '/inc/panel-builder/' . $panel_type
		];

		$items = [];

		$primary_items = [
			'top-row',
			'middle-row',
			'bottom-row',
			'offcanvas'
		];

		foreach ($paths_to_look_for_items as $single_path) {
			$all_items = glob(
				$single_path . '/*',
				GLOB_ONLYDIR
			);

			foreach ($all_items as $single_item) {
				$id = str_replace('_', '-', basename($single_item));

				if (in_array($id, $primary_items)) {
					if ($include === 'secondary') {
						continue;
					}
				} else {
					if ($include === 'primary') {
						continue;
					}
				}

				$future_data = [
					'id' => $id,
					'config' => $this->read_config_for($single_item),
					'path' => $single_item,
				];

				if ($require_options) {
					$future_data['options'] = $this->get_options_for(
						$panel_type,
						$future_data
					);
				}

				// if ($future_data['config']['enabled']) {
					$items[] = $future_data;
				// }
			}
		}

		return $items;
	}

	private function read_config_for( $file_path ) {
		$name = explode( '-', basename($file_path) );
		$name = array_map( 'ucfirst', $name );
		$name = implode( ' ', $name );

		$_extract_variables = [ 'config' => [] ];

		if (is_readable($file_path . '/config.php')) {
			require $file_path . '/config.php';

			foreach ( $_extract_variables as $variable_name => $default_value ) {
				if ( isset( $$variable_name ) ) {
					$_extract_variables[ $variable_name ] = $$variable_name;
				}
			}
		}

		$_extract_variables['config'] = array_merge(
			[
				'name' => $name,
				'description' => '',
				'typography_keys' => [],
				'devices' => ['desktop', 'mobile'],
				'selective_refresh' => [],
				'allowed_in' => [],
				'excluded_from' => [],

				// border | drop
				'shortcut_style' => 'drop',
				'enabled' => true
			],
			$_extract_variables['config']
		);

		return $_extract_variables['config'];
	}

	public function get_options_for($panel_type = 'header', $item) {
		if (!is_array($item)) {
			return [];
		}

		if (! isset($item['path'])) {
			return [];
		}

		return blocksy_get_options($item['path'] . '/options.php', [
			'prefix' => $this->get_option_id_for($panel_type, $item) . '_'
		], false);
	}

	public function get_header_structure_for($args = []) {
		$args = wp_parse_args($args, [
			'id' => null,
			'mode' => 'placements',
			'items' => []
		]);

		$args['items'] = wp_parse_args($args['items'], [
			'desktop' => [],
			'mobile' => []
		]);

		$args['items']['desktop'] = wp_parse_args($args['items']['desktop'], [
			'top-row' => [],
			'middle-row' => [],
			'bottom-row' => [],
		]);

		$args['items']['mobile'] = wp_parse_args($args['items']['mobile'], [
			'top-row' => [],
			'middle-row' => [],
			'bottom-row' => [],
			'offcanvas' => [],
		]);

		$base = [
			'id' => $args['id'],
			'mode' => $args['mode'],
			'items' => []
		];

		if ($args['mode'] === 'placements') {
			$base['desktop'] = [
				$this->get_bar_structure_for([
					'id' => 'top-row',
					'mode' => $args['mode'],
					'items' => $args['items']['desktop']['top-row']
				]),
				$this->get_bar_structure_for([
					'id' => 'middle-row',
					'mode' => $args['mode'],
					'items' => $args['items']['desktop']['middle-row']
				]),
				$this->get_bar_structure_for([
					'id' => 'bottom-row',
					'mode' => $args['mode'],
					'items' => $args['items']['desktop']['bottom-row']
				]),
			];

			$base['mobile'] = [
				$this->get_bar_structure_for([
					'id' => 'top-row',
					'mode' => $args['mode'],
					'items' => $args['items']['mobile']['top-row']
				]),
				$this->get_bar_structure_for([
					'id' => 'middle-row',
					'mode' => $args['mode'],
					'items' => $args['items']['mobile']['middle-row']
				]),
				$this->get_bar_structure_for([
					'id' => 'bottom-row',
					'mode' => $args['mode'],
					'items' => $args['items']['mobile']['bottom-row']
				]),
				$this->get_bar_structure_for([
					'id' => 'offcanvas',
					'mode' => $args['mode'],
					'has_secondary' => false,
					'items' => $args['items']['mobile']['offcanvas']
				]),
			];
		}

		if ($args['mode'] === 'rows') {
			$base['desktop'] = [
				$this->get_bar_structure_for([
					'id' => 'top-row',
					'mode' => $args['mode']
				]),
				$this->get_bar_structure_for([
					'id' => 'middle-row',
					'mode' => $args['mode']
				]),
				$this->get_bar_structure_for([
					'id' => 'bottom-row',
					'mode' => $args['mode']
				]),
			];
		}

		return $base;
	}

	private function get_bar_structure_for($args = []) {
		$args = wp_parse_args($args, [
			'id' => null,
			'mode' => 'placements',
			'has_secondary' => true,
			'items' => []
		]);

		$args['items'] = wp_parse_args($args['items'], [
			'start' => [],
			'middle' => [],
			'end' => [],
			'start-middle' => [],
			'end-middle' => [],
		]);

		$placements = [
			['id' => 'start', 'items' => $args['items']['start']]
		];

		if ($args['has_secondary']) {
			$placements[] = ['id' => 'middle', 'items' => $args['items']['middle']];
			$placements[] = ['id' => 'end', 'items' => $args['items']['end']];

			$placements[] = ['id' => 'start-middle', 'items' => $args['items']['start-middle']];
			$placements[] = ['id' => 'end-middle', 'items' => $args['items']['end-middle']];
		}

		return array_merge([
			'id' => $args['id'],
		], (
			$args['mode'] === 'rows' ? [
				'row' => []
			] : ['placements' => $placements]
		));
	}
}

