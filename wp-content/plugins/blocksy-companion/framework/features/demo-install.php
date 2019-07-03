<?php

namespace Blocksy;

class DemoInstall {
	protected $ajax_actions = [
		'blocksy_demo_export',
		'blocksy_demo_list',
		'blocksy_demo_install_child_theme',
		'blocksy_demo_activate_plugins',
		'blocksy_demo_erase_content',
		'blocksy_demo_install_widgets',
		'blocksy_demo_install_options',
		'blocksy_demo_install_content',

		// 'blocksy_extension_activate',
		// 'blocksy_extension_deactivate',
	];

	public function has_mock() {
		return true;
	}

	public function __construct() {
		$this->attach_ajax_actions();

		add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );
		// add_filter( 'woocommerce_show_admin_notice', '__return_false' );
		add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_false' );
	}

	public function blocksy_demo_install_child_theme() {
		$m = new DemoInstallChildThemeInstaller();
		$m->import();
	}

	public function blocksy_demo_erase_content() {
		$plugins = new DemoInstallContentEraser();
		$plugins->import();
	}

	public function blocksy_demo_install_widgets() {
		$plugins = new DemoInstallWidgetsInstaller();
		$plugins->import();
	}

	public function blocksy_demo_install_options() {
		$plugins = new DemoInstallOptionsInstaller();
		$plugins->import();
	}

	public function blocksy_demo_install_content() {
		$plugins = new DemoInstallContentInstaller();
		$plugins->import();
	}

	public function blocksy_demo_activate_plugins() {
		$plugins = new DemoInstallPluginsInstaller();
		$plugins->import();
	}

	public function fetch_single_demo($args = []) {
		$args = wp_parse_args(
			$args,
			[
				'demo' => $demo,
				'builder' => '',
				'field' => ''
			]
		);

		$request = wp_remote_get('https://demo.creativethemes.com/?' . http_build_query([
			'route' => 'get_single',
			'demo' => $args['demo'] . ':' . $args['builder'],
			'field' => $args['field']
		]));

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

		$plugins = [
			'coblocks' => false,
			'contact-form-7' => false,
			'woocommerce' => false,
			'brizy' => false,
			'elementor' => false,
		];

		foreach ($plugins as $plugin_name => $status) {
			$plugins_manager = $this->get_plugins_manager();

			$path = $plugins_manager->is_plugin_installed( $plugin_name );

			if ($path) {
				if ($plugins_manager->is_plugin_active($path)) {
					$plugins[$plugin_name] = true;
				}
			}
		}

		wp_send_json_success([
			'demos' => $demos,
			'active_plugins' => $plugins
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

		$widgets_data = new DemoInstallWidgetsExport();
		$widgets_data = $widgets_data->export();

		$content_data = new DemoInstallContentExport();
		$content_data = $content_data->export();

		wp_send_json_success([
			'demo' => [
				'name' => $name,
				'options' => $options_data->export(),
				'widgets' => $widgets_data,
				'content' => $content_data,

				'pages_ids_options' => $options_data->export_pages_ids_options(),

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

	public function get_plugins_manager() {
		if (! class_exists('Blocksy_Plugin_Manager')) {
			require_once get_template_directory() . '/admin/dashboard/plugins/ct-plugin-manager.php';
		}

		return new \Blocksy_Plugin_Manager();
	}

	public function start_streaming() {
		// Turn off PHP output compression
		$previous = error_reporting( error_reporting() ^ E_WARNING );
		ini_set( 'output_buffering', 'off' );
		ini_set( 'zlib.output_compression', false );
		error_reporting( $previous );

		if ($GLOBALS['is_nginx']) {
			// Setting this header instructs Nginx to disable fastcgi_buffering
			// and disable gzip for this request.
			header( 'X-Accel-Buffering: no' );
			header( 'Content-Encoding: none' );
		}

		// Start the event stream.
		header( 'Content-Type: text/event-stream' );

		flush();

		// 2KB padding for IE
		echo ':' . str_repeat( ' ', 2048 ) . "\n\n";
		// Time to run the import!
		set_time_limit( 0 );
		// Ensure we're not buffered.
		wp_ob_end_flush_all();
	}

	public function emit_sse_message( $data ) {
		echo "event: message\n";
		echo 'data: ' . wp_json_encode( $data ) . "\n\n";
		// Extra padding.
		echo ':' . str_repeat( ' ', 2048 ) . "\n\n";
		flush();
	}
}
