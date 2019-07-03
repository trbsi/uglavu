<?php

namespace Blocksy;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Blocksy autoloader.
 */
class Autoloader {

	/**
	 * Classes map.
	 *
	 * Maps Elementor classes to file names.
     *
	 * @static
	 *
	 * @var array Classes used by blocksy.
	 */
	private static $classes_map = [
		'ExtensionsManager' => 'framework/extensions-manager.php',
		'ExtensionsManagerApi' => 'framework/extensions-manager-api.php',
		'Dashboard' => 'framework/dashboard.php',
		'ThemeIntegration' => 'framework/theme-integration.php',

		'GoogleAnalytics' => 'framework/features/google-analytics.php',

		'DemoInstall' => 'framework/features/demo-install.php',
		'DemoInstallContentExport' => 'framework/features/demo-install/content-export.php',
		'DemoInstallWidgetsExport' => 'framework/features/demo-install/widgets-export.php',
		'DemoInstallOptionsExport' => 'framework/features/demo-install/options-export.php',

		'DemoInstallChildThemeInstaller' => 'framework/features/demo-install/child-theme.php',
		'DemoInstallPluginsInstaller' => 'framework/features/demo-install/required-plugins.php',
		'DemoInstallContentInstaller' => 'framework/features/demo-install/content-installer.php',
		'DemoInstallOptionsInstaller' => 'framework/features/demo-install/options-import.php',
		'DemoInstallWidgetsInstaller' => 'framework/features/demo-install/widgets-import.php',
		'DemoInstallContentEraser' => 'framework/features/demo-install/content-eraser.php',

		/**
		 * No namespace
		 */
		'_BlocksyWidgetFactory' => 'framework/widgets-manager.php',
		'_Blocksy_WXR_Importer' => 'framework/features/demo-install/wxr-importer.php',

		// TODO: remove when getting rid of EDD
		'_EDD_SL_Plugin_Updater' => 'framework/EDD_SL_Plugin_Updater.php',
	];

	/**
	 * Run autoloader.
	 *
	 * Register a function as `__autoload()` implementation.
	 *
	 * @static
	 */
	public static function run() {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	/**
	 * Load class.
	 *
	 * For a given class name, require the class file.
	 *
	 * @static
	 *
	 * @param string $relative_class_name Class name.
	 */
	private static function load_class( $relative_class_name ) {
		if ( isset( self::$classes_map[ $relative_class_name ] ) ) {
			$filename = BLOCKSY_PATH . '/' . self::$classes_map[ $relative_class_name ];
		} else {
			$filename = strtolower(
				preg_replace(
					[ '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$relative_class_name
				)
			);

			$filename = BLOCKSY_PATH . $filename . '.php';
		}

		if ( is_readable( $filename ) ) {
			require $filename;
		}
	}

	/**
	 * Autoload.
	 *
	 * For a given class, check if it exist and load it.
	 *
	 * @static
	 *
	 * @param string $class Class name.
	 */
	private static function autoload( $class ) {
		if (
			0 !== strpos( $class, __NAMESPACE__ . '\\' )
			&&
			! isset( self::$classes_map[ '_' . $class ] )
		) {
			return;
		}

		$relative_class_name = preg_replace( '/^' . __NAMESPACE__ . '\\\/', '', $class );

		$final_class_name = __NAMESPACE__ . '\\' . $relative_class_name;

		if ( isset( self::$classes_map[ '_' . $relative_class_name ] ) ) {
			$final_class_name = $relative_class_name;
			$relative_class_name = '_' . $relative_class_name;
		}

		if ( ! class_exists( $final_class_name ) ) {
			self::load_class( $relative_class_name );
		}
	}
}
