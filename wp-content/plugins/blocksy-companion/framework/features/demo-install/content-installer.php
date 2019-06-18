<?php

namespace Blocksy;

class DemoInstallContentInstaller {
	public function import() {
		Plugin::instance()->demo->start_streaming();

		// Are we allowed to create users?
		add_filter( 'wxr_importer.pre_process.user', '__return_null' );

		add_action(
			'wxr_importer.processed.post',
			array( $this, 'send_update' ),
			10, 2
		);

		add_action(
			'wxr_importer.process_failed.post',
			array( $this, 'send_update' ),
			10, 2
		);

		add_action(
			'wxr_importer.process_already_imported.post',
			array( $this, 'send_update' ),
			10, 2
		);

		add_action(
			'wxr_importer.process_skipped.post',
			array( $this, 'send_update' ),
			10, 2
		);

		add_action(
			'wxr_importer.processed.comment',
			array( $this, 'send_update' )
		);

		add_action(
			'wxr_importer.process_already_imported.comment',
			array( $this, 'send_update' )
		);

		add_action(
			'wxr_importer.processed.term',
			array( $this, 'send_update' )
		);

		add_action(
			'wxr_importer.process_failed.term',
			array( $this, 'send_update' )
		);

		add_action(
			'wxr_importer.process_already_imported.term',
			array( $this, 'send_update' )
		);

		add_action(
			'wxr_importer.processed.user',
			array( $this, 'send_update' )
		);

		add_action(
			'wxr_importer.process_failed.user',
			array( $this, 'send_update' )
		);

		if (! isset($_REQUEST['demo_name']) || !$_REQUEST['demo_name']) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => 'No demo name passed.',
			]);
			exit;
		}

		$demo_name = explode(':', $_REQUEST['demo_name']);

		if (! isset($demo_name[1])) {
			$demo_name[1] = '';
		}

		$demo = $demo_name[0];
		$builder = $demo_name[1];

		$importer = new \Blocksy_WXR_Importer([
			'fetch_attachments' => true,
			'default_author'    => get_current_user_id(),
		]);

		$logger   = new \Blocksy_WP_Importer_Logger_ServerSentEvents();

		$importer->set_logger( $logger );

		$url = 'https://demo.creativethemes.com/?' . http_build_query([
			'route' => 'get_single_xml',
			'demo' => $demo . ':' . $builder
		]);

		$data = $importer->get_preliminary_information($url);

		Plugin::instance()->demo->emit_sse_message([
			'action' => 'get_content_preliminary_data',
			'data' => $data,
			'error' => false,
		]);

		$response = $importer->import($url);

		$this->assign_menu_locations();
		$this->clean_plugins_cache();
		$this->assign_pages_ids($demo, $builder);

		$completion_response = [
			'action' => 'complete',
			'error' => false
		];

		if (is_wp_error($response)) {
			$completion_response['error'] = $response->get_error_message();
		}

		Plugin::instance()->demo->emit_sse_message($completion_response);

		exit;
	}

	public function send_update() {
		Plugin::instance()->demo->emit_sse_message([
			'action' => 'content_installer_progress',
			'error' => false,
		]);
	}

	public function assign_menu_locations() {
		Plugin::instance()->demo->emit_sse_message([
			'action' => 'assign_menus_locations',
			'error' => false,
		]);

		$locations = get_theme_mod('nav_menu_locations');
		$menus = wp_get_nav_menus();

		if ($menus) {
			foreach ($menus as $menu) {
				if (strpos(strtolower($menu->name), 'main') !== false) {
					$locations['primary'] = $menu->term_id;
				}

				if (strpos(strtolower($menu->name), 'footer') !== false) {
					$locations['footer'] = $menu->term_id;
				}

				if (strpos(strtolower($menu->name), 'top bar') !== false) {
					$locations['header_top_bar'] = $menu->term_id;
				}
			}
		}

		set_theme_mod( 'nav_menu_locations', $locations );
	}

	public function clean_plugins_cache() {
		Plugin::instance()->demo->emit_sse_message([
			'action' => 'cleanup_plugins_cache',
			'error' => false,
		]);

		if ( class_exists( '\Elementor\Plugin' ) ) {
			\Elementor\Plugin::$instance->posts_css_manager->clear_cache();
		}

		if ( is_callable( 'FLBuilderModel::delete_asset_cache_for_all_posts' ) ) {
			FLBuilderModel::delete_asset_cache_for_all_posts();
		}
	}

	public function assign_pages_ids($demo, $builder) {
		Plugin::instance()->demo->emit_sse_message([
			'action' => 'cleanup_plugins_cache',
			'error' => false,
		]);

		$demo_content = Plugin::instance()->demo->fetch_single_demo([
			'demo' => $demo,
			'builder' => $builder,
			'field' => 'content'
		]);

		if (! isset($demo_content['pages_ids_options'])) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => __('Downloaded demo is corrupted.'),
			]);

			exit;
		}

		foreach ($demo_content['pages_ids_options'] as $option_id => $page_title) {
			if (strpos($option_id, 'woocommerce') !== false) {
				if (! class_exists('WooCommerce')) {
					continue;
				}
			}

			$page = get_page_by_title($page_title);

			if (isset($page) && $page->ID) {
				update_option($option_id, $page->ID);
			}
		}
	}
}

