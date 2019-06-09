<?php

namespace Blocksy;

class Plugin {
	/**
	 * Blocksy instance.
	 *
	 * Holds the blocksy plugin instance.
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * Blocksy extensions manager.
	 *
	 * @var ExtensionsManager
	 */
	public $extensions = null;
	public $extensions_api = null;

	public $dashboard = null;
	public $theme_integration = null;

	// Features
	public $feat_google_analytics = null;
	public $demo = null;

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function init() {
		if (! $this->check_if_blocksy_is_activated()) {
			return;
		}

		add_action('widgets_init', [
			'BlocksyWidgetFactory',
			'register_all_widgets',
		]);

		$this->extensions_api = new ExtensionsManagerApi();
		$this->theme_integration = new ThemeIntegration();
		$this->demo = new DemoInstall();
	}

	/**
	 * Init components that need early access to the system.
	 *
	 * @access private
	 */
	public function early_init() {
		if (! $this->check_if_blocksy_is_activated()) {
			return;
		}

		$this->extensions = new ExtensionsManager();

		$this->dashboard = new Dashboard();

		$this->feat_google_analytics = new GoogleAnalytics();
	}

	/**
	 * Register autoloader.
	 *
	 * Blocksy autoloader loads all the classes needed to run the plugin.
	 *
	 * @access private
	 */
	private function register_autoloader() {
		require BLOCKSY_PATH . '/framework/autoload.php';

		Autoloader::run();
	}

	/**
	 * Plugin constructor.
	 *
	 * Initializing Blocksy plugin.
	 *
	 * @access private
	 */
	private function __construct() {
		$this->register_autoloader();
		$this->early_init();

		add_action( 'init', [ $this, 'init' ], 0 );
		add_action('admin_init', [$this, 'plugin_update']);
	}

	private function check_if_blocksy_is_activated() {
		return strpos(wp_get_theme()->get('Name'), 'Blocksy') !== false;
	}

	public function plugin_update() {
		$data = get_plugin_data(BLOCKSY__FILE__);

		new \EDD_SL_Plugin_Updater(
			'https://creativethemes.com/',
			BLOCKSY__FILE__,
			[
				'version' => $data['Version'],
				'license' => '123',
				'item_id' => 515,
				'author'  => 'CreativeThemes',
				'beta'    => false,
			]
		);
	}
}

Plugin::instance();

