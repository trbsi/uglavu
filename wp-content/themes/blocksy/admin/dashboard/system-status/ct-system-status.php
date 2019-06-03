<?php
/**
 * System status
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

class Blocksy_System_Status {

	protected $path;

	protected $result = array();

	public function __construct() {
		$this->path = dirname( __FILE__ ) . '/';
		$this->validation = $this->validation_instance();

		$this->collect_theme_info();
		$this->wordpress_environment();
		$this->collect_plugin_information();
		$this->collect_php_info();
		$this->collect_php_extensions();
		$this->collect_server_environment();
	}

	public function validation_instance() {
		return new Blocksy_Config_Validation();
	}

	public function output() {
		return $this->result;
	}

	protected function collect_php_info() {
		$version_validation = $this->validation->version(
			'php-version',
			PHP_VERSION
		);

		$post_max_size = $this->validation->compare(
			'php-post-max-size',
			// @codingStandardsIgnoreLine
			ini_get( 'post_max_size' )
		);

		$max_execution_time = $this->validation->compare(
			'php-max-execution-time',
			// @codingStandardsIgnoreLine
			ini_get( 'max_execution_time' )
		);

		$max_input_vars = $this->validation->compare(
			'php-max-input-vars',
			// @codingStandardsIgnoreLine
			ini_get( 'max_input_vars' )
		);

		$safe_mode = $this->validation->is(
			'php-safe-mode',
			// @codingStandardsIgnoreLine
			ini_get( 'safe_mode' )
		);

		$memory_limit = $this->validation->compare(
			'php-memory-limit',
			ini_get( 'memory_limit' )
		);

		$upload_max_filesize = $this->validation->compare(
			'php-upload-max-filesize',
			ini_get( 'upload_max_filesize' )
		);

		$allow_url_fopen = $this->validation->is(
			'php-allow-url-fopen',
			ini_get( 'allow_url_fopen' )
		);

		$this->result['php'] = array(
			'title' => __( 'PHP Configuration', 'blocksy' ),
			'desc'  => __( 'Information about PHP configuration.', 'blocksy' ),
			'options' => array(
				'version' => array(
					'title' => __( 'PHP Version', 'blocksy' ),
					'desc'  => __( 'The current PHP version.', 'blocksy' ),
					'value' => PHP_VERSION,
					'success' => $version_validation['response'],
					'message' => $version_validation['error'],
					'doc'   => 'http://php.net/',
					'text'  => 'Update',
				),

				'post_max_size' => array(
					'title' => __( 'PHP Post Max Size', 'blocksy' ),
					'desc'  => __( 'The upload module limits the size of a single attachment to be less than either post_max_size, or upload_max_filesize, whichever is smaller.', 'blocksy' ),
					'value' => ini_get( 'post_max_size' ),
					'success' => $post_max_size['response'],
					'message' => $post_max_size['error'],
					'doc'   => 'http://php.net/manual/en/ini.core.php',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'max_execution_time' => array(
					'title' => __( 'PHP Time Limit', 'blocksy' ),
					'desc'  => __( 'This sets the maximum time in seconds a script is allowed to run before it is terminated by the parser. This helps prevent poorly written scripts from tying up the server.', 'blocksy' ),
					'value' => ini_get( 'max_execution_time' ),
					'success' => $max_execution_time['response'],
					'message' => $max_execution_time['error'],
					'doc'   => 'http://php.net/manual/en/ini.core.php',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'max_input_vars' => array(
					'title' => __( 'PHP Max Input Vars', 'blocksy' ),
					'desc'  => __( 'How many input variables may be accepted (limit is applied to $_GET, $_POST and $_COOKIE superglobal separately).', 'blocksy' ),
					// @codingStandardsIgnoreLine
					'value' => ini_get( 'max_input_vars' ),
					'success' => $max_input_vars['response'],
					'message' => $max_input_vars['error'],
					'doc'   => 'http://php.net/manual/en/ini.core.php',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'safe_mode' => array(
					'title' => __( 'PHP Safe Mode', 'blocksy' ),
					'desc'  => __( 'The PHP safe mode is an attempt to solve the shared-server security problem.', 'blocksy' ),
					// @codingStandardsIgnoreLine
					'value' => ini_get( 'safe_mode' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => $safe_mode['response'],
					'message' => $safe_mode['error'],
					'doc'   => 'https://www.godaddy.com/help/turning-off-php-safe-mode-on-your-plesk-server-119',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'memory_limit' => array(
					'title' => __( 'PHP Memory Limit', 'blocksy' ),
					'desc'  => __( 'This sets the maximum amount of memory in bytes that a script is allowed to allocate.', 'blocksy' ),
					'value' => ini_get( 'memory_limit' ),
					'success' => $memory_limit['response'],
					'message' => $memory_limit['error'],
					'doc'   => 'http://php.net/manual/en/ini.core.php',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'upload_max_filesize' => array(
					'title' => __( 'PHP Upload Max Size', 'blocksy' ),
					'desc'  => __( 'The maximum size of an uploaded file.', 'blocksy' ),
					'value' => ini_get( 'upload_max_filesize' ),
					'success' => $upload_max_filesize['response'],
					'message' => $upload_max_filesize['error'],
					'doc'   => 'http://php.net/manual/en/ini.core.php',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'allow_url_fopen' => array(
					'title' => __( 'PHP Allow URL File Open', 'blocksy' ),
					'desc'  => __( 'This option enables the URL-aware fopen wrappers that enable accessing URL object like files.', 'blocksy' ),
					'value' => ini_get( 'allow_url_fopen' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => $allow_url_fopen['response'],
					'message' => $allow_url_fopen['error'],
					'doc'   => 'http://php.net/manual/en/ini.core.php',
					'text'  => __( 'Read More', 'blocksy' ),
				),
			),
		);
	}

	protected function wordpress_environment() {
		global $wpdb;

		$wp_version = $this->validation->version(
			'wp-version',
			get_bloginfo( 'version' )
		);

		$wp_debug = $this->validation->is(
			'wp-debug',
			defined( 'WP_DEBUG' ) ? WP_DEBUG : null
		);

		$wp_memory_limit = $this->validation->compare(
			'wp-memory-limit',
			WP_MEMORY_LIMIT
		);

		$wp_fs_method = $this->validation->is(
			'wp-fs-method',
			defined( 'FS_METHOD' ) ? ( 'direct' === WP_DEBUG ) ? true : false : true
		);

		$wp_is_plugins_writable = $this->validation->is(
			'wp-is-plugins-writable',
			is_writable( WP_PLUGIN_DIR )
		);

		$this->result['wordpress_environment'] = array(
			'title' => __( 'WordPress Environment', 'blocksy' ),
			'desc'  => __( 'Information about WordPress', 'blocksy' ),
			'options' => array(
				'home_url' => array(
					'title' => __( 'Home URL', 'blocksy' ),
					'desc'  => __( 'Home URL link', 'blocksy' ),
					'value' => home_url(),
					'success' => true,
				),

				'site_url' => array(
					'title' => __( 'Site URL', 'blocksy' ),
					'desc'  => __( 'Site URL link', 'blocksy' ),
					'value' => site_url(),
					'success' => true,
				),

				'wp_version' => array(
					'title' => __( 'WP Version', 'blocksy' ),
					'desc'  => __( 'Compare the current WordPress version with required version.', 'blocksy' ),
					'value' => get_bloginfo( 'version' ),
					'success' => $wp_version['response'],
					'message' => $wp_version['error'],
					'doc'   => admin_url( 'update-core.php' ),
					'text'  => 'update to ' . $this->validation->value( 'wp-version' ),
				),

				'wp_is_plugins_writable' => array(
					'title' => __( 'Write Access to Plugins', 'blocksy' ),
					'desc'  => __( 'WordPress may need access to write to files in your plugins directory to enable certain functions.', 'blocksy' ),
					'value' => is_writable( WP_PLUGIN_DIR ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => $wp_is_plugins_writable['response'],
					'message' => $wp_is_plugins_writable['error'],
					'doc'   => 'https://codex.wordpress.org/Changing_File_Permissions',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'wp_debug' => array(
					'title' => __( 'WP_DEBUG', 'blocksy' ),
					'desc'  => __( 'WP_DEBUG is a PHP constant (a permanent global variable) that can be used to trigger the "debug" mode throughout WordPress. It is assumed to be false by default and is usually set to true in the wp-config.php file on development copies of WordPress.', 'blocksy' ),
					'value' => defined( 'WP_DEBUG' ) ? WP_DEBUG ? __( 'Enabled', 'blocksy' ) : __( 'Disabled', 'blocksy' ) : __( 'Not set', 'blocksy' ),
					'success' => $wp_debug['response'],
					'message' => $wp_debug['error'],
					'doc'   => 'https://codex.wordpress.org/Debugging_in_WordPress',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'wp_fs_method' => array(
					'title' => __( 'Filesystem Method', 'blocksy' ),
					'desc'  => __( 'FS_METHOD forces the filesystem method. It should only be "direct", "ssh2", "ftpext", or "ftpsockets".', 'blocksy' ),
					'value' => defined( 'FS_METHOD' ) ? FS_METHOD : __( 'Not set', 'blocksy' ),
					'success' => $wp_fs_method['response'],
					'message' => $wp_fs_method['error'],
					'doc'   => 'https://codex.wordpress.org/Editing_wp-config.php#Override_of_default_file_permissions',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'wp_lang' => array(
					'title' => __( 'WP Language', 'blocksy' ),
					'desc'  => __( 'Change the language in the admin settings screen. Settings > General > Site Language.', 'blocksy' ),
					'value' => ( defined( 'WPLANG' ) && WPLANG ? WPLANG : 'en_US' ),
					'success' => true,
				),

				'multisite' => array(
					'title' => __( 'Multisite', 'blocksy' ),
					'desc'  => __( 'Multisite is a WordPress feature which allows users to create a network of sites on a single WordPress installation.', 'blocksy' ),
					'value' => is_multisite() ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => true,
				),

				'wp_memory_limit' => array(
					'title' => __( 'WP Memory Limit', 'blocksy' ),
					'desc'  => __( 'Administration tasks require much memory than usual operation. When in the administration area, the memory can be increased or decreased from the WP_MEMORY_LIMIT', 'blocksy' ),
					'value' => WP_MEMORY_LIMIT,
					'success' => $wp_memory_limit['response'],
					'message' => $wp_memory_limit['error'],
					'doc'   => 'https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP',
					'text'  => __( 'Read More', 'blocksy' ),
				),

				'table_prefix' => array(
					'title' => __( 'WP Table Prefix', 'blocksy' ),
					'desc'  => __( 'By default the WordPress database table prefix is wp_, you can change this prefix in the wp-config.php.', 'blocksy' ),
					'value' => $wpdb->prefix,
					'success' => true,
				),

				'wp_timezone' => array(
					'title' => __( 'WP Timezone', 'blocksy' ),
					'desc'  => __( 'Time zones and time offsets. A time zone is a geographical region in which residents observe the same standard time.', 'blocksy' ),
					'value' => get_option( 'timezone_string' ) . ', GMT: ' . get_option( 'gmt_offset' ),
					'success' => true,
				),

				'permalink' => array(
					'title' => __( 'Permalink Structure', 'blocksy' ),
					'desc'  => __( 'Permalinks are the permanent URLs to your individual weblog posts, as well as categories and other lists of weblog postings.', 'blocksy' ),
					'value' => get_option( 'permalink_structure' ),
					'success' => true,
				),
			),
		);
	}

	protected function collect_theme_info() {
		$active_theme = wp_get_theme();
		if ( is_child_theme() ) {
			$parent_theme = wp_get_theme( $active_theme->get( 'Template' ) );
		} else {
			$parent_theme = $active_theme;
		}

		$options = array(
			'theme_name' => array(
				'title' => __( 'Theme Name', 'blocksy' ),
				'desc'  => __( 'The current theme name.', 'blocksy' ),
				'value' => $active_theme->get( 'Name' ),
				'success' => true,
			),

			'theme_version' => array(
				'title' => __( 'Theme Version', 'blocksy' ),
				'desc'  => __( 'The current theme version.', 'blocksy' ),
				'value' => $active_theme->get( 'Version' ),
				'success' => true,
			),

			'theme_author' => array(
				'title' => __( 'Theme Author', 'blocksy' ),
				'desc'  => __( 'The current theme author.', 'blocksy' ),
				'value' => $active_theme->get( 'Author' ),
				'success' => true,
			),

			'author_uri' => array(
				'title' => __( 'Theme Author URI', 'blocksy' ),
				'desc'  => __( 'The current theme author website.', 'blocksy' ),
				'value' => $active_theme->get( 'AuthorURI' ),
				'success' => true,
			),

			'child_theme' => array(
				'title' => __( 'Is Child Theme', 'blocksy' ),
				'desc'  => __( 'Whether a child theme is in use.', 'blocksy' ),
				'value' => is_child_theme() ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
				'success' => true,
			),
		);

		if ( is_child_theme() ) {
			$options = array_merge(
				$options,
				array(
					'parent_theme' => array(
						'title' => __( 'Parent Theme', 'blocksy' ),
						'desc'  => __( 'Parent theme name.', 'blocksy' ),
						'value' => $parent_theme->get( 'Name' ),
						'success' => true,
					),

					'parent_theme_version' => array(
						'title' => __( 'Parent Theme Version', 'blocksy' ),
						'desc'  => __( 'Current parent theme version.', 'blocksy' ),
						'value' => $parent_theme->get( 'Version' ),
						'success' => true,
					),

					'parent_theme_uri' => array(
						'title' => __( 'Parent Theme URI', 'blocksy' ),
						'desc'  => __( 'Current parent theme website.', 'blocksy' ),
						'value' => $parent_theme->get( 'ThemeURI' ),
						'success' => true,
					),
				)
			);
		}

		$this->result['theme_info'] = array(
			'title' => __( 'Theme Information', 'blocksy' ),
			'desc'  => __( 'Information about your theme', 'blocksy' ),
			'options' => $options,
		);
	}

	protected function collect_plugin_information() {
		$list_of_active_plugins = array();
		$list_of_inactive_plugins = array();

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );

		foreach ( $plugins as $plugin_path => $plugin ) {
			if ( in_array( $plugin_path, $active_plugins, true ) ) {
				$list_of_active_plugins[] = "{$plugin['Name']} (v{$plugin['Version']})";
			} else {
				$list_of_inactive_plugins[] = "{$plugin['Name']} (v{$plugin['Version']})";
			}
		}

		$this->result['plugin_info'] = array(
			'title' => __( 'Plugins Information', 'blocksy' ),
			'desc'  => __( 'List of installed plugins', 'blocksy' ),
			'options' => array(
				'active_plugins' => array(
					'title' => __( 'Active Plugins', 'blocksy' ),
					'desc'  => __( 'List of all active plugins.', 'blocksy' ),
					'value' => implode( ', ', $list_of_active_plugins ),
					'success' => true,
				),

				'inactive_plugins' => array(
					'title' => __( 'Inactive Plugins', 'blocksy' ),
					'desc'  => __( 'List of all inactive plugins.', 'blocksy' ),
					'value' => implode( ', ', $list_of_inactive_plugins ),
					'success' => true,
				),
			),
		);
	}

	protected function collect_php_extensions() {
		$php_display_errors = $this->validation->is(
			'php-display-errors',
			ini_get( 'display_errors' )
		);

		$php_ziparchive = $this->validation->is(
			'php-ziparchive',
			class_exists( 'ZipArchive' )
		);

		$this->result['php_extensions'] = array(
			'title' => __( 'PHP Extensions', 'blocksy' ),
			'desc' => __( 'List of PHP extensions', 'blocksy' ),
			'options' => array(
				'php_display_errors' => array(
					'title' => __( 'Display Errors', 'blocksy' ),
					'desc' => __( 'This determines whether errors should be printed to the screen as part of the output or if they should be hidden from the user.', 'blocksy' ),
					'value' => ini_get( 'display_errors' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => $php_display_errors['response'],
					'message' => $php_display_errors['error'],
				),

				'php_ziparchive' => array(
					'title' => __( 'ZipArchive', 'blocksy' ),
					'desc' => __( 'The ZipArchive extension allows you to read ZIP files.', 'blocksy' ),
					'value' => class_exists( 'ZipArchive' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => $php_ziparchive['response'],
					'message' => $php_ziparchive['error'],
				),

				'php_fsockopen' => array(
					'title' => __( 'FSOCKOPEN', 'blocksy' ),
					'desc' => __( 'Fsockopen lets you open an Internet or Unix domain socket connection for connecting to a resource via socket connection.', 'blocksy' ),
					'value' => function_exists( 'fsockopen' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => true,
				),

				'php_curl' => array(
					'title' => __( 'cURL', 'blocksy' ),
					'desc' => __( 'CURL is an easy to use command line tool to send and receive files, and it supports almost all major protocols', 'blocksy' ),
					'value' => function_exists( 'curl_init' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => true,
				),

				'php_soap' => array(
					'title' => __( 'SOAP Client', 'blocksy' ),
					'desc' => __( 'The SOAP extension can be used to write SOAP Servers and Clients.', 'blocksy' ),
					'value' => class_exists( 'SoapClient' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => true,
				),

				'php_suhosin' => array(
					'title' => __( 'SUHOSIN', 'blocksy' ),
					'desc' => __( 'Suhosin is an advanced protection system for PHP installations.', 'blocksy' ),
					'value' => extension_loaded( 'suhosin' ) ? __( 'Yes', 'blocksy' ) : __( 'No', 'blocksy' ),
					'success' => true,
				),
			),
		);
	}

	protected function collect_server_environment() {
		global $wpdb;

		if ( $wpdb->use_mysqli ) {
			// @codingStandardsIgnoreLine
			$mysql_ver = @mysqli_get_server_info( $wpdb->dbh );
		} else {
			// @codingStandardsIgnoreLine
			$mysql_ver = @mysql_get_server_info();
		}

		$mysql_version = $this->validation->version(
			'mysql-version',
			$mysql_ver
		);

		$this->result['server_environment'] = array(
			'title' => __( 'Server Environment', 'blocksy' ),
			'desc' => __( 'Information about server environment', 'blocksy' ),
			'options' => array(
				'server_info' => array(
					'title' => __( 'Server Info', 'blocksy' ),
					'desc' => __( 'Server Identification from header.', 'blocksy' ),
					// @codingStandardsIgnoreLine
					'value' => $_SERVER['SERVER_SOFTWARE'],
					'success' => true,
				),

				'default_timezone' => array(
					'title' => __( 'Default Timezone', 'blocksy' ),
					'desc' => __( 'default timezone used by all date/time functions in a script', 'blocksy' ),
					'value' => date_default_timezone_get(),
					'success' => true,
				),

				'mysql_version' => array(
					'title' => __( 'MySQL Version', 'blocksy' ),
					'desc' => __( 'Compare the current MySQL version with required version.', 'blocksy' ),
					'value' => $mysql_ver,
					'success' => $mysql_version['response'],
					'message' => $mysql_version['error'],
				),
			),
		);
	}
}

