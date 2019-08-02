<?php

class Blocksy_Customizer_Builder {
	public function __construct() {
	}

	public function register_options_for_customizer($wp_customize) {
		return
		blocksy_customizer_register_options(
			$wp_customize
		);
	}

	public function get_data_for_customizer() {
		$result = [];

		$result['header'] = $this->get_registered_items_by('header');
		$result['footer'] = $this->get_registered_items_by('footer');

		$result['secondary_items'] = [
			'header' => $this->get_registered_items_by(
				'header', 'secondary', true
			),
			'footer' => $this->get_registered_items_by(
				'footer', 'secondary', true
			),
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
			'top-bar',
			'middle-bar',
			'bottom-bar',
			'offcanvas-bar'
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
					'path' => $single_item
				];

				if ($require_options) {
					$future_data['options'] = $this->get_options_for(
						$panel_type,
						$future_data
					);
				}

				$items[] = $future_data;
			}
		}

		return $items;
	}


	private function read_config_for( $file_path ) {
		$name = explode( '-', basename($file_path) );
		$name = array_map( 'ucfirst', $name );
		$name = implode( ' ', $name );

		return [
			'name' => $name
		];

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
				'description' => ''
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

	public function get_header_structure_for($id, $mode = 'placements') {
		$base = [
			'id' => $id,
			'mode' => $mode,
			'items' => []
		];

		if ($mode === 'placements') {
			$base['desktop'] = [
				$this->get_bar_structure_for('top-bar', $mode),
				$this->get_bar_structure_for('middle-bar', $mode),
				$this->get_bar_structure_for('bottom-bar', $mode),
			];

			$base['mobile'] = [
				$this->get_bar_structure_for('top-bar', $mode),
				$this->get_bar_structure_for('middle-bar', $mode),
				$this->get_bar_structure_for('bottom-bar', $mode),
				$this->get_bar_structure_for('offcanvas-bar', $mode, false),
			];
		}

		if ($mode === 'rows') {
			$base['desktop'] = [
				$this->get_bar_structure_for('top-bar', $mode),
				$this->get_bar_structure_for('middle-bar', $mode),
				$this->get_bar_structure_for('bottom-bar', $mode),
			];
		}

		return $base;
	}

	private function get_bar_structure_for(
		$id, $mode = 'placements', $has_secondary = true
	) {
		$placements = [
			['id' => 'start', 'items' => []]
		];

		if ($has_secondary) {
			$placements[] = ['id' => 'middle', 'items' => []];
			$placements[] = ['id' => 'end', 'items' => []];

			$placements[] = ['id' => 'start-middle', 'items' => []];
			$placements[] = ['id' => 'end-middle', 'items' => []];
		}

		return array_merge([
			'id' => $id,
		], (
			$mode === 'rows' ? [
				'row' => []
			] : ['placements' => $placements]
		));
	}
}

