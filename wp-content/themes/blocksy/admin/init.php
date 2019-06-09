<?php
/**
 * Admin
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */

require_once get_template_directory() . '/admin/dashboard/plugins/ct-plugin-manager.php';

if ( is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	require_once get_template_directory() . '/admin/dashboard/system-status/init.php';
	require_once get_template_directory() . '/admin/dashboard/api.php';
	require_once get_template_directory() . '/admin/dashboard/plugins/ct-plugin-manager.php';
	require_once get_template_directory() . '/admin/dashboard/plugins/plugins-api.php';
}

require get_template_directory() . '/admin/dashboard/core.php';

function blocksy_get_jed_locale_data( $domain ) {
	$translations = get_translations_for_domain( $domain );

	$locale = [
		'' => [
			'domain' => $domain,
			'lang'   => is_admin() ? get_user_locale() : get_locale(),
		],
	];

	if ( ! empty( $translations->headers['Plural-Forms'] ) ) {
		$locale['']['plural_forms'] = $translations->headers['Plural-Forms'];
	}

	foreach ( $translations->entries as $msgid => $entry ) {
		$locale[ $msgid ] = $entry->translations;
	}

	return $locale;
}

add_action(
	'admin_enqueue_scripts',
	function () {
		$theme = wp_get_theme();

		wp_enqueue_media();

		$deps = apply_filters('blocksy-options-scripts-dependencies', [
			'underscore',
			'wp-color-picker',
			'react',
			'react-dom',
			'wp-element',
            'wp-date',
			'wp-i18n',
			// 'wp-polyfill'
		]);

		global $wp_customize;

		if ( ! isset( $wp_customize ) ) {
			wp_enqueue_script(
				'ct-options-scripts',
				get_template_directory_uri() . '/static/bundle/options.js',
				$deps,
				$theme->get( 'Version' ),
				true
			);
		}

		$locale_data_ct = blocksy_get_jed_locale_data( 'blocksy' );

		wp_add_inline_script(
			'wp-i18n',
			'wp.i18n.setLocaleData( ' . wp_json_encode( $locale_data_ct ) . ', "blocksy" );'
		);

		wp_enqueue_style(
			'ct-options-styles',
			get_template_directory_uri() . '/static/bundle/options.css',
			['wp-color-picker'],
			$theme->get( 'Version' )
		);

		wp_localize_script(
			'ct-options-scripts',
			'ct_localizations',
			[
				'is_dev_mode' => !!(defined('BLOCKSY_DEVELOPMENT_MODE') && BLOCKSY_DEVELOPMENT_MODE),
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'ct-ajax-nonce' ),
				'public_url' => get_template_directory_uri() . '/static/bundle/',
				'rest_url' => get_rest_url(),
			]
		);
	}
);

add_action('admin_notices', function () {
	if (! current_user_can('activate_plugins') ) return;
	if (get_option('dismissed-blocksy_plugin_notice', false)) return;

	$manager = new Blocksy_Plugin_Manager();
	$status = $manager->get_plugin_status('blocksy-companion');

	if ($status === 'active') return;

	$url = admin_url('themes.php?page=ct-dashboard');
	$plugin_url = admin_url('admin.php?page=ct-dashboard');
	$plugin_link = 'http://creativethemes.com/downloads/blocksy-companion.zip';

	echo '<div class="notice notice-blocksy-plugin">';
	echo '<div class="notice-blocksy-plugin-root" data-url="' . esc_attr($url) . '" data-plugin-url="' . esc_attr($plugin_url) . '" data-plugin-status="' . esc_attr($status) . '" data-link="' . esc_attr($plugin_link) . '">';

	?>

	<h1><?php esc_html_e( 'Congratulations!', 'blocksy' ); ?></h1>
	<p class="about-description">
		<?php esc_html_e( 'Blocksy theme is now active and ready to use.', 'blocksy' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'To get full advantage of it, we strongly recommend to activate the', 'blocksy' ); ?>
		<b><?php esc_html_e( 'Blocksy Companion', 'blocksy' ); ?></b> Plugin.
		<?php esc_html_e( 'This way you will have access to custom extensions, demo templates and many other awesome features', 'blocksy' ); ?>.
	</p>

	<?php

	echo '</div>';
	echo '</div>';
});


add_action( 'wp_ajax_blocksy_dismissed_notice_handler', function () {
	update_option('dismissed-blocksy_plugin_notice', true);
	wp_die();
});

add_action( 'wp_ajax_blocksy_notice_button_click', function () {
	if (! current_user_can('activate_plugins') ) return;

	$manager = new Blocksy_Plugin_Manager();
	$status = $manager->get_plugin_status('blocksy-companion');

	if ($status === 'active') {
		wp_send_json_success([
			'status' => 'active'
		]);
	}

	if ($status === 'uninstalled') {
		$manager->download_and_install('blocksy-companion');
		$manager->plugin_activation('blocksy-companion');

		wp_send_json_success([
			'status' => 'active'
		]);
	}

	if ($status === 'installed') {
		$manager->plugin_activation('blocksy-companion');

		wp_send_json_success([
			'status' => 'active'
		]);
	}

	wp_die();
});

