<?php
/**
 * Blocksy Theme Customizer
 *
 * @package Blocksy
 */

global $blocksy_wp_customize;
$blocksy_wp_customize = null;

require get_template_directory() . '/inc/validator.php';

function blocksy_get_options( $path, $pass_inside = [], $relative = true ) {
	if ($relative) {
		$path = get_template_directory() . '/inc/options/' . $path . '.php';
	}

	if ( ! file_exists( $path ) ) {
		return null;
	}

	return blocksy_akg(
		'options',
		blocksy_get_variables_from_file(
			$path,
			[ 'options' => [] ],
			$pass_inside
		)
	);
}

/**
 * Implement customizer controls
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blocksy_customize_register( $wp_customize ) {
	require get_template_directory() . '/inc/classes/class-ct-group-title.php';

	global $blocksy_wp_customize;

	$blocksy_wp_customize = $wp_customize;

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->remove_control('custom_logo');

	if (function_exists('is_shop')) {
		$wp_customize->remove_section( 'header_image' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'woocommerce_product_catalog' );

		$wp_customize->add_section(
			new Blocksy_Group_Title(
				$wp_customize,
				'plugin_integrations',
				[
					'title'       => esc_html__( 'Plugin Integrations', 'blocksy' ),
					'priority' => 3,
				]
			)
		);
	}

	$wp_customize->add_panel( 'woocommerce', array(
		'priority'       => 4,
		'capability'     => 'manage_woocommerce',
		'theme_supports' => '',
		'title'          => __( 'WooCommerce', 'blocksy' ),
	) );

	$wp_customize->add_section(
		new Blocksy_Group_Title(
			$wp_customize,
			'core',
			[
				'title'       => esc_html__( 'Core', 'blocksy' ),
				'priority' => 12,
			]
		)
	);

	blocksy_customizer_register_options( $wp_customize, blocksy_get_options( 'customizer' ) );

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			[
				'selector'        => '.site-title a',
				'render_callback' => function () {
					bloginfo( 'name' );
				},
			]
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			[
				'selector'        => '.site-description',
				'render_callback' => function () {
					bloginfo( 'description' );
				}
			]
		);
	}
}
add_action( 'customize_register', 'blocksy_customize_register' );

function blocksy_add_customizer_preview_cache( $maybe_content ) {
	add_action(
		'blocksy_customizer_preview_cache',
		function () use ( $maybe_content ) {
			if (is_callable($maybe_content)) {
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function call_user_func($maybe_content) used here escapes the value properly.
				 */
				echo call_user_func($maybe_content);
				return;
			}

			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * Variable $maybe_content used here has the value escaped properly.
			 */
			echo $maybe_content;
		}
	);
}

add_action(
	'wp_footer',
	function () {
		if ( ! is_customize_preview() ) {
			return;
		}

		ob_start();

		echo '<div class="ct-customizer-preview-cache">';
		do_action( 'blocksy_customizer_preview_cache' );
		echo '</div>';

		$html = ob_get_clean();

		// $html = str_replace(' ', '', $html);
		$search = array(
			'/\>[^\S ]+/s',     // strip whitespaces after tags, except space
			'/[^\S ]+\</s',     // strip whitespaces before tags, except space
			'/(\s)+/s',         // shorten multiple whitespace sequences
			'/<!--(.|\s)*?-->/', // Remove HTML comments
		);

		$replace = array(
			'>',
			'<',
			'\\1',
			'',
		);

		// $html = preg_replace($search, $replace, $html);
		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * The string used here escapes the value properly.
		 */
		echo '<input type="hidden" value="' . htmlspecialchars( $html ) . '" class="ct-customizer-preview-cache-container">';
	},
	3000,
	0
);

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
add_action(
	'customize_preview_init',
	function () {
		wp_enqueue_script(
			'ct-customizer',
			get_template_directory_uri() . '/static/bundle/sync.js',
			[ 'customize-preview', 'wp-date' ],
			'20151215',
			true
		);

		wp_enqueue_media();
	}
);

function blocksy_customizer_sync_data() {
	$location = null;

	if ( is_front_page() ) {
		$location = 'home';
	}

	if ( is_page() ) {
		$location = 'page';
	}

	if ( get_post_type() === 'post' && is_single() ) {
		$location = 'post';
	}

	if (
		function_exists('is_woocommerce')
		&&
		is_woocommerce()
	) {
		if (is_single()) {
			$location = 'product';
		}

		if (is_shop() || is_product_category()) {
			$location = 'product_archives';
		}
	}

	return [
		'future_location' => $location,
	];
}

/**
 * Enqueue JavaScripts & CSS
 */
add_action(
	'customize_controls_enqueue_scripts',
	function () {
		$theme = wp_get_theme();

		wp_enqueue_style(
			'ct-customizer-controls-styles',
			get_template_directory_uri() . '/static/bundle/customizer-controls.css',
			array(),
			$theme->get( 'Version' )
		);

		$deps = apply_filters('blocksy-options-scripts-dependencies', [
			'underscore',
			'wp-color-picker',
			'react',
			'react-dom',
			'wp-element',
			'wp-components',
			'wp-date',
			'wp-i18n',
			'customize-controls',
		]);

		wp_enqueue_script(
			'ct-customizer-controls',
			get_template_directory_uri() . '/static/bundle/customizer-controls.js',
			$deps,
			$theme->get( 'Version' ),
			true
		);

		wp_localize_script(
			'ct-customizer-controls',
			'ct_customizer_localizations',
			[
				'customizer_reset_none' => wp_create_nonce( 'ct-customizer-reset' ),
			]
		);

	}
);

add_action(
	'wp_ajax_ct_customizer_reset',
	function () {
		global $blocksy_wp_customize;

		if ( ! $blocksy_wp_customize ) {
			return;
		}

		if ( ! $blocksy_wp_customize->is_preview() ) {
			wp_send_json_error();
		}

		if ( ! check_ajax_referer( 'ct-customizer-reset', 'nonce', false ) ) {
			wp_send_json_error( 'nonce' );
		}

		$settings = $blocksy_wp_customize->settings();

		foreach ( $settings as $single_setting ) {
			if ( 'theme_mod' !== $single_setting->type ) {
				continue;
			}
			remove_theme_mod( $single_setting->id );
		}

		wp_send_json_success();
	}
);

/**
 * Register customizer options recursively
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @param array                $options All the theme options.
 * @param array                $parent_data recursive data.
 */
function blocksy_customizer_register_options(
	$wp_customize,
	$options,
	$parent_data = [],
	$has_controls = true
) {
	$collected = [];

	blocksy_collect_options(
		$collected,
		$options,
		[
			'limit_option_types' => false,
			'limit_level' => 1,
			'info_wrapper' => true,
		]
	);


	if ( empty( $collected ) ) {
		return;
	}

	foreach ( $collected as &$opt ) {

		if (
			isset( $opt['option']['type'] )
			&&
			'ct-group-title' === $opt['option']['type']
		) {
			$wp_customize->add_section(
				new Blocksy_Group_Title( $wp_customize, $opt['id'], $opt['option'] )
			);

			continue;
		}

		if ( 'container' === $opt['group'] ) {
			// Check if has container options.
			$_collected = [];

			blocksy_collect_options(
				$_collected,
				$opt['option']['options'],
				[
					'limit_option_types' => [],
					'limit_level' => 1,
					'info_wrapper' => false,
				]
			);


			$has_containers = ! empty( $_collected );
			unset( $_collected );

			$children_data = [
				'group' => 'container',
				'id' => $opt['id'],
			];

			$args = [
				'title' => empty( $opt['option']['title'] )
				? blocksy_id_to_title( $opt['id'] )
				: $opt['option']['title'],
				'description' => empty( $opt['option']['desc'] )
				? ''
				: $opt['option']['desc'],
			];

			if ( isset( $opt['option']['container'] ) && is_array( $opt['option']['container'] ) ) {
				$args = array_merge( $opt['option']['container'], $args );
			}

			if ( $has_containers ) {
				if ( $parent_data ) {
					// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
					trigger_error(
						esc_html( $opt['id'] ) . ' panel can\'t have a parent (' . esc_html( $parent_data['id'] ) . ')',
						E_USER_WARNING
					);
					break;
				}

				if (! isset($opt['option']['only_if_exists'])) {
					$wp_customize->add_panel( $opt['id'], $args );
				}

				$children_data['customizer_type'] = 'panel';
			} else {
				if ( $parent_data ) {
					if ( 'panel' === $parent_data['customizer_type'] ) {
						$args['panel'] = $parent_data['id'];
					} else {
						// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
						trigger_error(
							esc_html( $opt['id'] ) . ' section can have only panel parent (' . esc_html( $parent_data['id'] ) . ')',
							E_USER_WARNING
						);
						break;
					}
				}

				$wp_customize->add_section( $opt['id'], $args );
				$children_data['customizer_type'] = 'section';
			}

			blocksy_customizer_register_options(
				$wp_customize,
				$opt['option']['options'],
				$children_data
			);

			unset( $children_data );
			continue;
		}

		if ( 'option' === $opt['group'] ) {
			if (
				(
					$opt['option']['type'] === 'ct-panel'
					||
					$opt['option']['type'] === 'ct-options'
				)
				&&
				isset( $opt['option']['inner-options'] )
			) {
				$options_to_send = null;

				blocksy_collect_options(
					$options_to_send,
					$opt['option']['inner-options'],
					[
						'include_container_types' => false,
					]
				);

				/*
				$options_to_send = json_decode(
					wp_json_encode( $options_to_send ),
					true
				);
				 */

				blocksy_customizer_register_options(
					$wp_customize,
					$options_to_send,
					[],
					false
				);
			}

			$args_control = array(
				'label' => empty( $opt['option']['label'] )
				? blocksy_id_to_title( $opt['id'] )
				: $opt['option']['label'],
				'description' => empty( $opt['option']['desc'] )
				? ''
				: $opt['option']['desc'],
				'settings' => $opt['id'],
				'type' => $opt['option']['type'],
			);

			if ( isset( $opt['option']['control'] ) && is_array( $opt['option']['control'] ) ) {
				$args_control = array_merge( $opt['option']['control'], $args_control );
			}

			$args_control = array_merge( $opt['option'], $args_control );

			if ( $parent_data ) {
				if ( 'section' === $parent_data['customizer_type'] ) {
					$args_control['section'] = $parent_data['id'];
				} else {
					// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
					trigger_error(
						'Invalid control parent: ' . esc_html( $parent_data['customizer_type'] ),
						E_USER_WARNING
					);

					break;
				}
			} else {
				// the option is not placed in a section, create a section automatically.
				$args_control['section'] = 'fw_option_auto_section_' . $opt['id'];

				$wp_customize->add_section(
					$args_control['section'],
					array(
						'title' => empty( $opt['option']['label'] )
						? blocksy_id_to_title( $opt['id'] )
						: $opt['option']['label'],
					)
				);
			}

			$args_setting = array(
				'default' => isset( $opt['option']['value'] ) ? $opt['option']['value'] : ' ',
			);

			$opt['option'] = blocksy_include_sanitizer($opt['option']);

			if ( isset( $opt['option']['setting'] ) && is_array( $opt['option']['setting'] ) ) {
				$args_setting = array_merge(
					$opt['option']['setting'],
					$args_setting
				);
			}

			// blocksy_print($opt['option']);

			$is_allowed = true;

			$options_that_are_not_allowed = apply_filters(
				'blocksy-options-without-controls',
				['ct-divider', 'ct-title', 'ct-notification']
			);

			if (in_array($opt['option']['type'], $options_that_are_not_allowed)) {
				$is_allowed = false;
			}

			if (
				$opt['option']['type'] === 'ct-panel'
				&&
				!isset($opt['option']['switch'])
			) {
				$is_allowed = false;
			}

			if ($is_allowed) {
				$wp_customize->add_setting($opt['id'], array_merge([
					// This is only a default function.
					// Real check comes from blocksy_include_sanitizer()
					// above.
					'sanitize_callback' => function ($input, $setting) {
						return $input;
					}
				], $args_setting));
			}

			unset( $args_setting );

			if (
				isset( $opt['option']['selective_refresh'] )
				&&
				isset( $opt['option']['selective_refresh']['selector'] )
			) {
				$wp_customize->selective_refresh->add_partial(
					$opt['id'],
					$opt['option']['selective_refresh']
				);
			}

			if ( $has_controls ) {
				$our_control = new WP_Customize_Control(
					$wp_customize,
					$opt['id'],
					$args_control
				);

				if ( isset( $opt['option']['choices'] ) ) {
					$our_control->json['choices'] = $opt['option']['choices'];
				}

				if ( isset( $opt['option']['condition'] ) ) {
					$our_control->json['condition'] = $opt['option']['condition'];
				}

				$our_control->json['option'] = $opt['option'];

				$wp_customize->add_control( $our_control );
			}

			continue;
		}

		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
		trigger_error(
			'Unknown group: ' . esc_html( $opt['group'] ),
			E_USER_WARNING
		);
	}
}

