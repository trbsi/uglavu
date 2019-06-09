<?php

namespace Blocksy;

class DemoInstall {
	protected $ajax_actions = [
		'blocksy_demo_export',
		'blocksy_demo_list'
		// 'blocksy_extension_activate',
		// 'blocksy_extension_deactivate',
	];

	public function __construct() {
		$this->attach_ajax_actions();

		add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );
		// add_filter( 'woocommerce_show_admin_notice', '__return_false' );
		add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_false' );
	}

	public function fetch_all_demos() {
		$request = wp_remote_get('https://demo.creativethemes.com/?route=get_all');

		if ( is_wp_error( $request ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $request );

		$body = json_decode($body, true);

		if (! $body) {
			return false;
		}

		return $body;
	}

	public function blocksy_demo_list() {
		$demos = $this->fetch_all_demos();

		if (! $demos) {
			wp_send_json_error();
		}

		wp_send_json_success([
			'demos' => $demos
		]);
	}

	public function blocksy_demo_export() {
		if ( !current_user_can( 'edit_theme_options' ) ) {
			wp_send_json_error();
		}

		global $wp_customize;

		$name = sanitize_text_field($_REQUEST['name']);
		$builder = sanitize_text_field($_REQUEST['builder']);
		$plugins = sanitize_text_field($_REQUEST['plugins']);
		$url = sanitize_text_field($_REQUEST['url']);
		$is_pro = sanitize_text_field($_REQUEST['is_pro']) === 'true';

		$plugins = explode(',', preg_replace('/\s+/', '', $plugins));

		$options_data = new DemoInstallOptionsExport();
		$options_data = $options_data->export();

		$widgets_data = new DemoInstallWidgetsExport();
		$widgets_data = $widgets_data->export();

		$content_data = new DemoInstallContentExport();
		$content_data = $content_data->export();

		wp_send_json_success([
			'demo' => [
				'name' => $name,
				'options' => $options_data,
				'widgets' => $widgets_data,
				'content' => $content_data,

				'url' => $url,
				'is_pro' => !!$is_pro,

				'builder' => $builder,

				'plugins' => $plugins
			]
		]);
	}

	public function attach_ajax_actions() {
		foreach ( $this->ajax_actions as $action ) {
			add_action(
				'wp_ajax_' . $action,
				[ $this, $action ]
			);
		}
	}
}
