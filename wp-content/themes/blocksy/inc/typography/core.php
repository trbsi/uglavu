<?php

class Blocksy_Fonts_Manager {
	public function get_all_fonts() {
		return [
			'system' => [
				'type' => 'system',
				'families' => $this->get_system_fonts(),
			],
			'google' => [
				'type' => 'google',
				'families' => $this->get_googgle_fonts()
			]
		];
	}

	public function load_fonts() {
		$fonts_ids = [
			'rootTypography',
			'h1Typography',
			'h2Typography',
			'h3Typography',
			'h4Typography',
			'h5Typography',
			'h6Typography',
			'blockquote',
			'pre',
			'siteTitle',
			'primaryMenuFont',
			'primaryMenuDropdownFont',
			'mobileMenuFont',
			'sidebarWidgetsTitleFont',
			'sidebarWidgetsHeadingsFont',
			'singleProductTitleFont',
			'cardProductTitleFont',
			blocksy_get_posts_listing_source()['prefix'] . '_cardTitleFont',
		];

		$page_title_source = blocksy_get_page_title_source();

		if ($page_title_source) {
			$fonts_ids[] = blocksy_akg_or_customizer(
				'pageTitleFont',
				$page_title_source,
				blocksy_typography_default_values([
					'size' => [
						'desktop' => '32px',
						'tablet'  => '30px',
						'mobile'  => '25px'
					],
					'variation' => 'n7',
					'line-height' => '1.3',
				])
			);
		}

		$url = $this->get_google_fonts_url($fonts_ids);

		if ( ! empty($url) ) {
			wp_register_style( 'blocksy-fonts-font-source-google', $url );
			wp_enqueue_style( 'blocksy-fonts-font-source-google' );
		}
	}

	private function get_google_fonts_url($fonts_ids = []) {
		$all_fonts = $this->get_all_fonts();

		$google_fonts_families = [];

		foreach ($all_fonts['google']['families'] as $single_google_font) {
			$google_fonts_families[] = $single_google_font['family'];
		}

		$to_enqueue = [];

		foreach ($fonts_ids as $font_id) {
			if (is_array($font_id)) {
				$value = $font_id;
			} else {
				$value = get_theme_mod($font_id, null);
			}

			if (! $value) {
				continue;
			}

			if (isset($value['family'])) {
				if (in_array($value['family'], $google_fonts_families)) {
					if (! isset($to_enqueue[$value['family']])) {
						$to_enqueue[$value['family']] = [ $value['variation'] ];
					} else {
						$to_enqueue[$value['family']][] = $value['variation'];
					}
				}
			}
		}

		$url = 'https://fonts.googleapis.com/css?family=';

		$families = [];

		foreach ($to_enqueue as $family => $variations) {
			$to_push = $family . ':';

			$vars = [];

			foreach ($variations as $variation) {
				$var_to_push = intval($variation[1]) * 100;
				$var_to_push .= $variation[0] === 'i' ? 'i' : '';
				$vars[] = $var_to_push;
			}

			$to_push .= implode(',', $vars);

			$families[] = $to_push;
		}

		$families = implode('|', $families);

		if ( ! empty($families) ) {
			$subsets = [];

			foreach (get_theme_mod('font_subset', [
				'latin' => true,
				'latin-ext' => false,
				'cyrillic' => false,
				'cyrillic-ext' => false,
				'greek' => false,
				'greek-ext' => false,
				'vietnamese' => false,
			]) as $subset => $enabled) {
				if ($enabled && $subset !== 'latin') {
					$subsets[] = $subset;
				}
			}

			$url .= $families;
			$url .= '&display=swap';

			if (! empty($subsets)) {
				$url .= '&subset=' . implode(',', $subsets);
			}

			return $url;
		}

		return false;
	}

	public function get_system_fonts() {
		$system = [
			'System Default',
			'Arial', 'Verdana', 'Trebuchet', 'Georgia', 'Times New Roman',
			'Tahoma', 'Palatino', 'Helvetica', 'Calibri', 'Myriad Pro',
			'Lucida', 'Arial Black', 'Gill Sans', 'Geneva', 'Impact', 'Serif', 'monospace'
		];

		$result = [];

		foreach ($system as $font) {
			$result[] = [
				'source' => 'system',
				'family' => $font,
				'variations' => [],
				'all_variations' => $this->get_standard_variations_descriptors()
			];
		}

		return $result;
	}


	public function get_standard_variations_descriptors() {
		return [
			'n1', 'i1', 'n2', 'i2', 'n3', 'i3', 'n4', 'i4', 'n5', 'i5', 'n6',
			'i6', 'n7', 'i7', 'n8', 'i8', 'n9', 'i9'
		];
	}

	public function all_google_fonts() {
		$saved_data = get_option( 'blocksy_google_fonts', false );
		$ttl = 7 * DAY_IN_SECONDS;

		if (
			false === $saved_data
			||
			($saved_data['last_update'] + $ttl < time())
		) {
			$response = wp_remote_get(
				'https://google-webfonts-cache.unyson.io/v1/webfonts'
			);

			$body = wp_remote_retrieve_body( $response );

			if (
				200 === wp_remote_retrieve_response_code( $response )
				&&
				! is_wp_error( $body ) && ! empty( $body )
			) {
				update_option('blocksy_google_fonts', array(
					'last_update' => time(),
					'fonts' => $body
				), false);

				return $body;
			} else {
				if ( empty( $saved_data['fonts'] ) ) {
					$saved_data['fonts'] = json_encode( array( 'items' => array() ) );
				}

				update_option(
					'blocksy_google_fonts',
					array(
						'last_update' => time() - $ttl + MINUTE_IN_SECONDS,
						'fonts' => $saved_data['fonts']
					),
					false
				);
			}
		}

		return $saved_data['fonts'];
	}

	public function get_googgle_fonts() {
		$response = $this->all_google_fonts();
		$response = json_decode( $response, true );

		if (! isset( $response['items'] ) ) {
			return false;
		}

		if (!is_array( $response['items'] ) || !count( $response['items'] )) {
			return false;
		}

		foreach ($response['items'] as $key => $row ) {
			$response['items'][ $key ] = $this->prepare_font_data($row);
		}

		return $response['items'];
	}

	private function prepare_font_data( $font ) {
		$font['source'] = 'google';

		$font['variations'] = [];

		if ( isset( $font['variants'] ) ) {
			$font['all_variations'] = $this->change_variations_structure( $font['variants'] );
		}

		unset( $font['variants'] );
		return $font;
	}

	private function change_variations_structure( $structure ) {
		$result = [];

		foreach($structure as $weight) {
			$result[] = $this->get_weight_and_style_key($weight);
		}

		return $result;
	}

	private function get_weight_and_style_key( $code ) {
		$prefix = 'n'; // Font style: italic = `i`, regular = n.
		$sufix = '4';  // Font weight: 1 -> 9.

		$value = strtolower( trim( $code ) );
		$value = str_replace( ' ', '', $value );

		# Only number.
		if ( is_numeric( $value ) && isset( $value[0] ) ) {
			$sufix = $value[0];
			$prefix = 'n';
		}

		// Italic.
		if ( preg_match("#italic#", $value) ) {
			if( 'italic' === $value ) {
				$sufix = 4;
				$prefix = 'i';
			} else {
				$value = trim( str_replace('italic', '', $value) );
				if( is_numeric( $value ) && isset( $value[0] ) ) {
					$sufix = $value[0];
					$prefix = 'i';
				}
			}
		}

		// Regular.
		if ( preg_match("#regular|normal#", $value) ) {
			if( 'regular' === $value ) {
				$sufix = 4;
				$prefix = 'n';
			} else {
				$value = trim( str_replace( array('regular', 'normal') , '', $value) );
				if( is_numeric( $value ) && isset( $value[0] ) ) {
					$sufix = $value[0];
					$prefix = 'n';
				}
			}
		}

		return "{$prefix}{$sufix}";
	}

}

function blocksy_output_font_css($args = []) {
	$args = wp_parse_args(
		$args,
		[
			'css' => null,
			'tablet_css' => null,
			'mobile_css' => null,
			'font_value' => null,
			'selector' => ':root'
		]
	);

	if (! $args['css']) {
		throw new Error('css missing in args!');
	}

	if (! $args['tablet_css']) {
		throw new Error('tablet_css missing in args!');
	}

	if (! $args['mobile_css']) {
		throw new Error('mobile_css missing in args!');
	}

	if ($args['font_value']['family'] === 'System Default') {
		$args['font_value']['family'] = "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'";
	}

	if ($args['font_value']['family'] === 'Default') {
		$args['font_value']['family'] = 'CT_CSS_SKIP_RULE';
	}

	$args['css']->put(
		$args['selector'],
		"--fontFamily: {$args['font_value']['family']}"
	);

	$weight_and_style = blocksy_get_css_for_variation(
		$args['font_value']['variation']
	);

	$args['css']->put(
		$args['selector'],
		"--fontWeight: {$weight_and_style['weight']}"
	);

	$args['css']->put(
		$args['selector'],
		"--fontStyle: {$weight_and_style['style']}"
	);

	$args['css']->put(
		$args['selector'],
		"--textTransform: {$args['font_value']['text-transform']}"
	);

	$args['css']->put(
		$args['selector'],
		"--textDecoration: {$args['font_value']['text-decoration']}"
	);

	blocksy_output_responsive([
		'css' => $args['css'],
		'tablet_css' => $args['tablet_css'],
		'mobile_css' => $args['mobile_css'],
		'selector' => $args['selector'],
		'variableName' => 'fontSize',
		'unit' => '',
		'value' => $args['font_value']['size']
	]);

	blocksy_output_responsive([
		'css' => $args['css'],
		'tablet_css' => $args['tablet_css'],
		'mobile_css' => $args['mobile_css'],
		'selector' => $args['selector'],
		'variableName' => 'lineHeight',
		'unit' => '',
		'value' => $args['font_value']['line-height']
	]);

	blocksy_output_responsive([
		'css' => $args['css'],
		'tablet_css' => $args['tablet_css'],
		'mobile_css' => $args['mobile_css'],
		'selector' => $args['selector'],
		'variableName' => 'letterSpacing',
		'unit' => '',
		'value' => $args['font_value']['letter-spacing']
	]);
}

function blocksy_get_css_for_variation($variation, $should_output_normals = true) {
	$weight_and_style = [
		'style' => '',
		'weight' => '',
	];

	if ($variation === 'Default') {
		return [
			'style' => 'CT_CSS_SKIP_RULE',
			'weight' => 'CT_CSS_SKIP_RULE'
		];
	}

	if ( preg_match(
		"#(n|i)(\d+?)$#",
		$variation,
		$matches
	)) {
		if ( 'i' === $matches[1] ) {
			$weight_and_style['style'] = 'italic';
		} else {
			$weight_and_style['style'] = 'normal';
		}

		$weight_and_style['weight'] = (int) $matches[2] . '00';
	}


	return $weight_and_style;
}

function blocksy_typography_default_values($values = []) {
	return array_merge([
		'family' => 'Default',
		'variation' => 'Default',
		'size' => '17px',
		'line-height' => '1.65',
		'letter-spacing' => '0em',
		'text-transform' => 'none',
		'text-decoration' => 'none',
	], $values);
}

add_action( 'wp_ajax_blocksy_get_fonts_list', function () {
	if (! current_user_can('edit_theme_options')) {
		wp_send_json_error();
	}

	$m = new Blocksy_Fonts_Manager();

	wp_send_json_success([
		'fonts' => $m->get_all_fonts()
	]);
});


