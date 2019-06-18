<?php

namespace Blocksy;

class ThemeIntegration {
	public function __construct() {
		add_filter(
			'blocksy_add_menu_page',
			function ($res, $options) {
				add_menu_page(
					$options['title'],
					$options['menu-title'],
					$options['permision'],
					$options['top-level-handle'],
					$options['callback'],
					$options['icon-url'],
					2
				);

				return true;
			},
			10, 2
		);

		add_action('rest_api_init', function () {
			return;

			register_rest_field('post', 'images', [
				'get_callback' => function () {
					return wp_prepare_attachment_for_js($object->id);
				},
				'update_callback' => null,
				'schema' => null,
			]);
		});

		add_filter('upload_mimes', function ($mimes) {
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		});

		add_action(
			'elementor/element/section/section_layout/before_section_end',
			function ($element, $args) {

				$element->add_control('fix_columns_alignment', [
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label' => esc_html__( 'Columns Alignment Fix', 'blc' ),
					// 'description' => esc_html__( 'It will remove the "weird" columns gap added by Elementor on the left and right side of each section (when `Columns Gap` is active). This helps you to have consistent content width without having to manually readjust it everytime you create sections with `Columns Gap`', 'blc' ),
					'return_value' => 'fix',
					'default' => '',
					'separator' => 'before',
					'prefix_class' => 'ct-columns-alignment-',
				]);

			},
			10, 2
		);

		add_action('elementor/editor/after_enqueue_styles', function () {
			$data = get_plugin_data(BLOCKSY__FILE__);

			wp_enqueue_style(
				'blocksy-elementor-styles',
				BLOCKSY_URL . 'static/bundle/elementor.css',
				[],
				$data['Version']
			);
		});

		add_filter('blocksy_changelogs_list', function ($changelogs) {
			$changelog = null;
			$access_type = get_filesystem_method();

			if ($access_type === 'direct') {
				$creds = request_filesystem_credentials(
					site_url() . '/wp-admin/',
					'', false, false,
					[]
				);

				if ( WP_Filesystem($creds) ) {
					global $wp_filesystem;

					$readme = $wp_filesystem->get_contents(
						BLOCKSY_PATH . '/readme.txt'
					);

					if ($readme) {
						$readme = explode('== Changelog ==', $readme);

						if (isset($readme[1])) {
							$changelog = trim($readme[1]);
						}
					}
				}
			}

			$changelogs[] = [
				'title' => __('Companion', 'blc'),
				'changelog' => $changelog
			];

			return $changelogs;
		});
	}
}
