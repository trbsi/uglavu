<?php

namespace Blocksy;

class DemoInstallOptionsExport {
	public function get_exported_options_keys() {
		return [
			'blocksy_ext_mailchimp_credentials',
			'blocksy_active_extensions'
		];
	}

	private $core_options = array(
		'blogname',
		'blogdescription',
		// 'show_on_front',
		// 'page_on_front',
		// 'page_for_posts',
	);

	public function export() {
		$theme = get_stylesheet();
		$template = get_template();
		$charset = get_option( 'blog_charset' );
		$mods = get_theme_mods();
		$data = array(
			'template' => $template,
			'mods' => $mods ? $mods : array(),
			'options' => array()
		);

		global $wp_customize;

		// Get options from the Customizer API.
		$settings = $wp_customize->settings();

		foreach ( $settings as $key => $setting ) {
			if ( 'option' == $setting->type ) {
				if ( 'widget_' === substr( strtolower( $key ), 0, 7 ) ) {
					continue;
				}

				if ( 'sidebars_' === substr( strtolower( $key ), 0, 9 ) ) {
					continue;
				}

				if ( in_array( $key, $this->core_options ) ) {
					continue;
				}

				$data['options'][ $key ] = $setting->value();
			}
		}

		$option_keys = $this->get_exported_options_keys();

		foreach ( $option_keys as $option_key ) {
			$data['options'][ $option_key ] = get_option( $option_key );
		}

		if ( function_exists( 'wp_get_custom_css_post' ) ) {
			$data['wp_css'] = wp_get_custom_css();
		}

		return $data;

		return serialize( $data );
	}


}


