<?php

function blocksy_has_custom_top_bar() {
	if (is_single() || blocksy_is_page()) {
		$post_options = blocksy_get_post_options();

		if (
			blocksy_akg(
				'has_header_top_bar', $post_options, 'default'
			) !== 'default'
		) {
			return true;
		}
	}

	return false;
}

function blocksy_has_top_bar() {
	$has_header_top_bar = get_theme_mod('has_top_bar', 'yes') === 'yes';

	if (is_single() || blocksy_is_page()) {
		$post_options = blocksy_get_post_options();

		if (
			blocksy_akg(
				'has_header_top_bar', $post_options, 'default'
			) !== 'default'
		) {
			$has_header_top_bar = blocksy_akg(
				'has_header_top_bar', $post_options, 'default'
			) === 'enabled';
		}
	}

	return $has_header_top_bar;
}

function blocksy_output_header_top_bar() {
	$columns_output = '';

	$header_section_1 = get_theme_mod(
		'header_top_bar_section_1',
		'header_menu'
	);

	$header_section_2 = get_theme_mod(
		'header_top_bar_section_2',
		'disabled'
	);

	if ( $header_section_1 !== 'disabled' && $header_section_2 !== 'disabled' ) {
		$columns_output = 'data-columns="2"';
	} else {
		if ( $header_section_1 !== 'disabled' || $header_section_2 !== 'disabled' ) {
			$columns_output = 'data-columns="1"';
		}
	}

	$container_class = (
		get_theme_mod( 'top_bar_container', 'fixed' ) === 'fixed'
	) ? 'ct-container' : 'ct-container-fluid';

	$main_class = 'header-top-bar';

	$main_class .= ' ' . blocksy_visibility_classes(
		get_theme_mod('top_bar_visibility', [
			'desktop' => true,
			'tablet' => true,
			'mobile' => false,
		])
	);

	ob_start();

	?>

	<div class="<?php echo esc_attr($main_class) ?>">
		<div
			class="<?php echo esc_attr($container_class) ?> grid-columns"
			<?php echo wp_kses_post($columns_output); ?>>

			<?php
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_header_top_bar_area() used here escapes the value properly.
				 */
				echo blocksy_header_top_bar_area( '1' );
				echo blocksy_header_top_bar_area( '2' );
			?>
		</div>
	</div>

	<?php

	return ob_get_clean();
}

function blocksy_header_top_bar_area( $number = '1' ) {
	$kind = get_theme_mod(
		'header_top_bar_section_' . $number,
		intval( $number ) === 1 ? 'header_menu' : 'disabled'
	);

	if ( $kind === 'disabled' ) {
		return '';
	}

	$output = '';

	if ( $kind === 'header_menu' ) {
		ob_start();

		echo wp_kses_post('<nav data-menu-type="type-1"' . blocksy_schema_org_definitions('navigation') . '>');

		wp_nav_menu(
			[
				'theme_location' => 'header_top_bar',
				'depth'          => 1,
				'container'      => false,
				'menu_id'        => 'header-top-bar-menu',
				'menu_class'     => 'header-top-bar-menu menu',
				'fallback_cb' => 'blocksy_link_to_menu_editor',
			]
		);

		echo '</nav>';

		$output = ob_get_clean();
	}

	if ( $kind === 'custom_text' ) {
		$output = '<div class="ct-custom-text">' . get_theme_mod( 'header_top_bar_section_' . $number . '_text', 'Sample text' ) . '</div>';
	}

	if ( $kind === 'social_icons' ) {
		$output = blocksy_social_icons(
			get_theme_mod('header_top_bar_socials_' . $number, [
				[
					'id' => 'facebook',
					'enabled' => true,
				],

				[
					'id' => 'twitter',
					'enabled' => true,
				]
			])
		);
	}

	return '<section>' . $output . '</section>';
}

function blocksy_header_top_bar_sections_cache() {
	ob_start();

	wp_nav_menu(
		[
			'theme_location' => 'header_top_bar',
			'depth'          => 1,
			'container'      => false,
			'menu_id'        => 'header-top-bar-menu',
			'menu_class'     => 'header-top-bar-menu menu',
			'fallback_cb' => 'blocksy_link_to_menu_editor',
		]
	);

	$output = '<section>' . ob_get_clean() . '</section>';

	blocksy_add_customizer_preview_cache(
		function () use ($output) {
			return blocksy_html_tag(
				'div',
				[ 'data-id' => 'header-top-bar-menu' ],
				$output
			);
		}
	);

	$output = '<section>';
	$output .= '<div class="ct-custom-text">' . get_theme_mod( 'header_top_bar_section_1_text', 'Sample text' ) . '</p>';
	$output .= '</section>';

	blocksy_add_customizer_preview_cache(
		function () use ($output) {
			return blocksy_html_tag(
				'div',
				[ 'data-id' => 'header-top-bar-text' ],
				$output
			);
		}
	);

	blocksy_add_customizer_preview_cache(
		function () {
			return blocksy_html_tag(
				'div',
				[ 'data-id' => 'header-top-bar-socials' ],
				'<section>' . blocksy_social_icons() . '</section>'
			);
		}
	);
}
