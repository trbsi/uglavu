<?php

require_once dirname( __FILE__ ) . '/helpers.php';

class BlocksyExtensionReadProgress {
	public function __construct() {
		add_action('wp_enqueue_scripts', function () {
			if (! function_exists('get_plugin_data')){
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			$data = get_plugin_data(BLOCKSY__FILE__);

			if (is_admin()) return;

			if (! BlocksyExtensionReadProgress::should_enable_progress_bar()) {
				return;
			}

			wp_enqueue_style(
				'blocksy-ext-read-progress-bar-styles',
				BLOCKSY_URL . 'framework/extensions/read-progress/static/bundle/main.css',
				['ct-main-styles'],
				$data['Version']
			);

			wp_enqueue_script(
				'blocksy-ext-read-progress-bar-scripts',
				BLOCKSY_URL . 'framework/extensions/read-progress/static/bundle/main.js',
				[],
				$data['Version'],
				true
			);

			$data = [
				'public_url' => BLOCKSY_URL . 'framework/extensions/read-progress/static/bundle/',
			];

			wp_localize_script(
				'blocksy-ext-read-progress-bar-scripts',
				'blocksy_ext_read_progress_localization',
				$data
			);
		});

		add_filter('blocksy_extensions_metabox_post_bottom', function ($opts) {
			$opts['read_progress_bar'] = [
					'label' => __( 'Read progress bar', 'blocksy' ),
					'type' => 'ct-switch',
					'value' => 'yes',
			];

			return $opts;
		});
	}

	public static function should_enable_progress_bar() {
		if (!is_single()) {
			return false;
		}

		if (is_single() && get_post_type() !== 'post') {
			return false;
		}

		return blocksy_default_akg(
			'read_progress_bar',
			blocksy_get_post_options(),
			'yes'
		) === 'yes';
	}
}
