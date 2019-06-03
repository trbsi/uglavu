<?php

require_once dirname( __FILE__ ) . '/helpers.php';

class BlocksyExtensionInstagram {
	public function __construct() {
		add_filter(
			'blocksy_extensions_customizer_options',
			[$this, 'add_options_panel']
		);

		add_filter('blocksy_widgets_paths', function ($all_widgets) {
			$all_widgets[] = dirname(__FILE__) . '/ct-instagram';
			return $all_widgets;
		});

		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			wp_enqueue_style(
				'blocksy-ext-instagram-styles',
				BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);

			wp_enqueue_script(
				'blocksy-ext-instagram-scripts',
				BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/main.js',
				['ct-scripts'],
				$data['Version'],
				true
			);

			$data = [
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'public_url' => BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/',
			];

			wp_localize_script(
				'blocksy-ext-instagram-scripts',
				'blocksy_ext_instagram_localization',
				$data
			);
		});

		add_action(
			'customize_preview_init',
			function () {
				if (! function_exists('get_plugin_data')){
					require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				$data = get_plugin_data(BLOCKSY__FILE__);

				wp_enqueue_script(
					'blocksy-instagram-customizer-sync',
					BLOCKSY_URL . 'framework/extensions/instagram/static/bundle/sync.js',
					[ 'customize-preview' ],
					$data['Version'],
					true
				);
			}
		);
	}

	public function add_options_panel($options) {
		$options['instagram_ext'] = blocksy_get_options(
			dirname( __FILE__ ) . '/customizer.php',
			[], false
		);

		return $options;
	}
}
