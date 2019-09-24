<?php

function blocksy_output_footer_widgets() {
	$max_footer_columns_number = 4;
	$columns_structure = get_theme_mod( 'footer_widgets_structure', '3' );

	$footer_columns_number = strpos( $columns_structure, '-' ) ? 3 : intval(
		$columns_structure
	);

	$footer_widgets_output = '';
	$preview_cache_widgets_output = '';

	for ( $i = 1; $i <= $max_footer_columns_number; $i++ ) {
		ob_start();
		dynamic_sidebar( 'ct-footer-sidebar-' . $i );

		$single_widget_column = ob_get_clean();

		if ( empty( trim( $single_widget_column ) ) ) {
			continue;
		}

		if ( $i <= $footer_columns_number ) {
			$footer_widgets_output .= '<div class="ct-footer-column">' . $single_widget_column . '</div>';
		}

		$preview_cache_widgets_output .= '<div class="ct-footer-column">' . $single_widget_column . '</div>';
	}

	blocksy_add_customizer_preview_cache(
		function () use ($preview_cache_widgets_output) {
			return blocksy_html_tag(
				'div',
				[ 'data-id' => 'footer-columns' ],
				blocksy_footer_widgets_structure(
					$preview_cache_widgets_output
				)
			);
		}
	);

	if (
		get_theme_mod('has_widget_area', 'yes') === 'yes'
		&&
		!empty(trim($footer_widgets_output))
	) {
		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * Function blocksy_footer_widgets_structure() used here escapes the value properly.
		 */
		echo blocksy_footer_widgets_structure($footer_widgets_output);
	}
}

function blocksy_footer_widgets_structure( $output ) {
	$columns_structure = get_theme_mod( 'footer_widgets_structure', '3' );

	$divider_output = '';

	if (
		blocksy_akg(
			'style',
			get_theme_mod( 'widgetsAreaDivider', [
				'width' => 1,
				'style' => 'dashed',
				'color' => [
					'color' => '#dddddd',
				],
			])
		) !== 'none'
	) {
		$divider_output = 'data-divider';
	}

	$class = 'footer-widgets-area';

	$container_class = 'ct-container';

	if (get_theme_mod('footer_widgets_container', 'fixed') !== 'fixed') {
		$container_class = 'ct-container-fluid';
	}

	$class .= ' ' . blocksy_visibility_classes(get_theme_mod('footer_widgets_visibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	]));

	ob_start();

	?>
		<section class="<?php echo esc_attr($class); ?>">
			<div class="<?php echo esc_attr($container_class) ?>">
				<div class="footer-widgets grid-columns" data-columns="<?php echo( esc_attr($columns_structure) ); ?>" <?php echo wp_kses_post($divider_output); ?>>
					<?php
					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Variable $output used here has the value escaped properly.
					 * Its contents is the actual footer widgets output.
					 */
					echo $output;
				?>
				</div>
			</div>
		</section>

	<?php

	return ob_get_clean();
}

function blocksy_footer_main_area_section( $number = '1' ) {
	$kind = get_theme_mod(
		'footer_section_' . $number,
		intval( $number ) === 1 ? 'footer_menu' : 'disabled'
	);

	if ( $kind === 'disabled' ) {
		return '';
	}

	$output = '';

	if ( $kind === 'footer_menu' ) {
		ob_start();

		echo '<nav data-type="type-1"' . blocksy_schema_org_definitions('navigation') . '>';

		wp_nav_menu(
			[
				'theme_location' => 'footer',
				'depth'          => 1,
				'container'      => false,
				'menu_id'        => 'footer-menu',
				'menu_class'     => 'footer-menu menu',
				'fallback_cb' => 'blocksy_link_to_menu_editor',
			]
		);

		echo '</nav>';

		$output = ob_get_clean();
	}

	if ( $kind === 'custom_text' ) {
		$output = '<div class="ct-custom-text">' . get_theme_mod( 'section_' . $number . '_text', 'Sample text' ) . '</div>';
	}

	if ( $kind === 'social_icons' ) {
		$output = blocksy_social_icons(
			get_theme_mod('footer_socials_' . $number, [
				[
					'id' => 'facebook',
					'enabled' => true,
				],

				[
					'id' => 'twitter',
					'enabled' => true,
				],
			]),

			[
				'type' => 'simple-small'
			]
		);
	}

	return '<section>' . $output . '</section>';
}

function blocksy_footer_main_area_sections_cache() {
	ob_start();

	wp_nav_menu(
		[
			'theme_location' => 'footer',
			'depth'          => 1,
			'container'      => false,
			'menu_id'        => 'footer-menu',
			'menu_class'     => 'footer-menu menu',
			'fallback_cb' => 'blocksy_link_to_menu_editor',
		]
	);

	$output = '<section>' . ob_get_clean() . '</section>';

	blocksy_add_customizer_preview_cache(
		function () use ($output) {
			return blocksy_html_tag(
				'div',
				[ 'data-id' => 'footer-main-area-menu' ],
				$output
			);
		}
	);

	$output = '<section>';
	$output .= '<div class="ct-custom-text">' . get_theme_mod( 'section_1_text', 'Sample text' ) . '</p>';
	$output .= '</section>';

	blocksy_add_customizer_preview_cache(
		function () use ($output) {
			return blocksy_html_tag(
				'div',
				[ 'data-id' => 'footer-main-area-text' ],
				$output
			);
		}
	);

	blocksy_add_customizer_preview_cache(
		function () {
			return blocksy_html_tag(
				'div',
				[ 'data-id' => 'footer-main-area-socials' ],
				'<section>' . blocksy_social_icons(null, [
					'type' => 'simple-small'
				]) . '</section>'
			);
		}
	);
}


function blocksy_output_back_to_top_link($for_preview = false) {
	$type = get_theme_mod('top_button_type', 'type-1');
	$shape = get_theme_mod('top_button_shape', 'square');
	$alignment = get_theme_mod('top_button_alignment', 'right');

	$svgs = [
		'type-1' => '<svg width="12" height="12" viewBox="0 0 20 20"><path d="M10,0L9.4,0.6L0.8,9.1l1.2,1.2l7.1-7.1V20h1.7V3.3l7.1,7.1l1.2-1.2l-8.5-8.5L10,0z"/></svg>',

		'type-2' => '<svg width="12" height="12" viewBox="0 0 20 20"><path d="M18.1,9.4c-0.2,0.4-0.5,0.6-0.9,0.6h-3.7c0,0-0.6,8.7-0.9,9.1C12.2,19.6,11.1,20,10,20c-1,0-2.3-0.3-2.7-0.9C7,18.7,6.5,10,6.5,10H2.8c-0.4,0-0.7-0.2-1-0.6C1.7,9,1.7,8.6,1.9,8.3c2.8-4.1,7.2-8,7.4-8.1C9.5,0.1,9.8,0,10,0s0.5,0.1,0.6,0.2c0.2,0.1,4.6,3.9,7.4,8.1C18.2,8.7,18.3,9.1,18.1,9.4z"/></svg>',

		'type-3' => '<svg width="15" height="15" viewBox="0 0 20 20"><path d="M10,0c0,0-4.4,3-4.4,9.6c0,0.1,0,0.2,0,0.4c-0.8,0.6-2.2,1.9-2.2,3c0,1.3,1.3,4,1.3,4L7.1,14l0.7,1.6h4.4l0.7-1.6l2.4,3.1c0,0,1.3-2.7,1.3-4c0-1.1-1.5-2.4-2.2-3c0-0.1,0-0.2,0-0.4C14.4,3,10,0,10,0zM10,5.2c0.8,0,1.5,0.7,1.5,1.5S10.8,8.1,10,8.1S8.5,7.5,8.5,6.7S9.2,5.2,10,5.2z M8.1,16.3c-0.2,0.2-0.3,0.5-0.3,0.8C7.8,18.5,10,20,10,20s2.2-1.4,2.2-2.9c0-0.3-0.1-0.6-0.3-0.8h-0.6c0,0.1,0,0.1,0,0.2c0,1-1.3,1.5-1.3,1.5s-1.3-0.5-1.3-1.5c0-0.1,0-0.1,0-0.2H8.1z"/></svg>',
	];

	$class = 'ct-back-to-top';

	$class .= ' ' . blocksy_visibility_classes(get_theme_mod('back_top_visibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	]));

	?>

	<a href="#" class="<?php echo esc_attr($class) ?>"
		data-shape="<?php echo esc_attr($shape) ?>"
		data-alignment="<?php echo esc_attr($alignment) ?>"
		title="<?php echo esc_html__('Go to top', 'blocksy') ?>">

		<?php
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * It can't be escaped with wp_kses_post() because it contains an SVG and is perfectly safe.
			 */
			echo $svgs[$type]
		?>

		<?php

			if ($for_preview) {
				foreach ($svgs as $key => $value) {
					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Function blocksy_html_tag() used here escapes the value properly.
					 * It's mainly not escaped with wp_kses_post() because it contains an SVG.
					 */
					echo blocksy_html_tag(
						'div',
						['data-top' => $key],
						$value
					);
				}
			}

		?>

	</a>

	<?php
}

