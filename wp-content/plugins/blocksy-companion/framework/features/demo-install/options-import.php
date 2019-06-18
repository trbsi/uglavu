<?php

namespace Blocksy;

class DemoInstallOptionsInstaller {
	public function import() {
		Plugin::instance()->demo->start_streaming();

		if (! current_user_can('edit_theme_options')) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => 'No permission.',
			]);

			exit;
		}

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

		Plugin::instance()->demo->emit_sse_message([
			'action' => 'download_demo_options',
			'error' => false,
		]);

		$demo_content = Plugin::instance()->demo->fetch_single_demo([
			'demo' => $demo,
			'builder' => $builder,
			'field' => 'options'
		]);

		if (! isset($demo_content['options'])) {
			Plugin::instance()->demo->emit_sse_message([
				'action' => 'complete',
				'error' => __('Downloaded demo is corrupted.'),
			]);

			exit;
		}

		Plugin::instance()->demo->emit_sse_message([
			'action' => 'import_mods_images',
			'error' => false,
		]);

		$options = $demo_content['options'];
		$options['mods'] = $this->import_images(
			$demo_content,
			$options['mods']
		);

		Plugin::instance()->demo->emit_sse_message([
			'action' => 'import_customizer_options',
			'error' => false,
		]);

		do_action('customize_save', $wp_customize);

		foreach ($options['mods'] as $key => $val) {
			if ($key === 'nav_menu_locations') continue;

			do_action('customize_save_' . $key, $wp_customize);
			set_theme_mod($key, $val);
		}

		do_action('customize_save_after', $wp_customize);

		foreach ($options['options'] as $key => $val) {
			if ($key === 'blocksy_active_extensions') {
				if ($val && is_array($val)) {
					Plugin::instance()->demo->emit_sse_message([
						'action' => 'activate_required_extensions',
						'error' => false,
					]);

					foreach ($val as $single_extension) {
						Plugin::instance()->extensions->activate_extension(
							$single_extension
						);
					}
				}
			} else {
				update_option($key, $val);
			}
		}

		if (
			function_exists('wp_update_custom_css_post')
			&&
			isset($options['wp_css'])
			&&
			$options['wp_css']
		) {
			wp_update_custom_css_post($options['wp_css']);
		}

		Plugin::instance()->demo->emit_sse_message([
			'action' => 'complete',
			'error' => false,
		]);

		exit;
	}

	private function import_images($demo_content, $mods) {
		foreach ( $mods as $key => $val ) {
			if ($this->is_image_url($val)) {
				$data = $this->sideload_image($val);

				if (! is_wp_error($data)) {
					$mods[$key] = $data->url;

					// Handle header image controls.
					if (isset($mods[$key . '_data'])) {
						$mods[$key . '_data'] = $data;

						update_post_meta(
							$data->attachment_id,
							'_wp_attachment_is_custom_header',
							get_stylesheet()
						);
					}
				}
			}

			if ($key === 'custom_logo' && $val) {
				$maybe_url = $this->sideload_image_for_url(
					$demo_content['url'],
					$val
				);

				if ($maybe_url) {
					$data = $this->sideload_image($maybe_url);
					$mods[$key] = $data->attachment_id;
				}
			}

			if (
				is_array($val)
				&&
				isset($val['attachment_id'])
				&&
				$val['attachment_id']
			) {
				$maybe_url = $this->sideload_image_for_url(
					$demo_content['url'],
					$val['attachment_id']
				);

				if ($maybe_url) {
					$data = $this->sideload_image($maybe_url);
					$mods[$key]['attachment_id'] = $data->attachment_id;
				}
			}
		}

		return $mods;
	}

	public function sideload_image_for_url($url, $id) {
		$url = rtrim($url,"/") . '/wp-json/wp/v2/media/' . $id;

		$request = wp_remote_get($url);

		if ( is_wp_error( $request ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $request );

		$body = json_decode($body, true);

		if (! $body) {
			return false;
		}

		if (! isset($body['source_url'])) {
			return false;
		}

		return $body['source_url'];
	}

	private function sideload_image($file) {
		$data = new stdClass();

		if (! function_exists('media_handle_sideload')) {
			require_once( ABSPATH . 'wp-admin/includes/media.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
		}

		if (empty($file)) {
			return $data;
		}

		// Set variables for storage, fix file filename for query strings.
		preg_match( '/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches );

		$file_array = array();
		$file_array['name'] = basename( $matches[0] );

		// Download file to temp location.
		$file_array['tmp_name'] = download_url( $file );

		// If error storing temporarily, return the error.
		if ( is_wp_error( $file_array['tmp_name'] ) ) {
			return $file_array['tmp_name'];
		}

		// Do the validation and storage stuff.
		$id = media_handle_sideload( $file_array, 0 );

		// If error storing permanently, unlink.
		if ( is_wp_error( $id ) ) {
			@unlink( $file_array['tmp_name'] );
			return $id;
		}

		// Build the object to return.
		$meta = wp_get_attachment_metadata( $id );
		$data->attachment_id = $id;
		$data->url = wp_get_attachment_url( $id );
		$data->thumbnail_url = wp_get_attachment_thumb_url( $id );
		$data->height = $meta['height'];
		$data->width = $meta['width'];

		return $data;
	}

	private function is_image_url( $string = '' ) {
		if (is_string($string)) {
			if (preg_match('/\.(jpg|jpeg|png|gif)/i', $string)) {
				return true;
			}
		}

		return false;
	}
}


