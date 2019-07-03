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

		echo wp_kses_post('<nav data-menu-type="type-1"' . blocksy_schema_org_definitions('navigation') . '>');

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

				[
					'id' => 'gplus',
					'enabled' => true,
				],
			])
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
				'<section>' . blocksy_social_icons(null) . '</section>'
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

function blocksy_site_pattern() {
	$background_type = get_theme_mod('site_background_type', 'color');

	if ($background_type !== 'pattern') {
		if (! is_customize_preview()) {
			return '';
		}
	}

	$pattern_type  = get_theme_mod('background_pattern', 'type-1');

	ob_start();

	?>

		<figure class="ct-site-pattern">
			<svg width="100%" height="100%">
				<?php if ($pattern_type === 'type-1' || is_customize_preview()) { ?>
					<pattern id="type-1" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M0 38.59l2.83-2.83 1.41 1.41L1.41 40H0v-1.41zM0 1.4l2.83 2.83 1.41-1.41L1.41 0H0v1.41zM38.59 40l-2.83-2.83 1.41-1.41L40 38.59V40h-1.41zM40 1.41l-2.83 2.83-1.41-1.41L38.59 0H40v1.41zM20 18.6l2.83-2.83 1.41 1.41L21.41 20l2.83 2.83-1.41 1.41L20 21.41l-2.83 2.83-1.41-1.41L18.59 20l-2.83-2.83 1.41-1.41L20 18.59z"/>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-2' || is_customize_preview()) { ?>
					<pattern id="type-2" x="0" y="0" width="36" height="72" patternUnits="userSpaceOnUse" >

						<path fill="var(--patternColor)" d="M2 6h12L8 18 2 6zm18 36h12l-6 12-6-12z"/>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-3' || is_customize_preview()) { ?>
					<pattern id="type-3" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M11,18 C14.8659932,18 18,14.8659932 18,11 C18,7.13400675 14.8659932,4 11,4 C7.13400675,4 4,7.13400675 4,11 C4,14.8659932 7.13400675,18 11,18 Z M59,43 C62.8659932,43 66,39.8659932 66,36 C66,32.1340068 62.8659932,29 59,29 C55.1340068,29 52,32.1340068 52,36 C52,39.8659932 55.1340068,43 59,43 Z M16,36 C17.6568542,36 19,34.6568542 19,33 C19,31.3431458 17.6568542,30 16,30 C14.3431458,30 13,31.3431458 13,33 C13,34.6568542 14.3431458,36 16,36 Z M79,67 C80.6568542,67 82,65.6568542 82,64 C82,62.3431458 80.6568542,61 79,61 C77.3431458,61 76,62.3431458 76,64 C76,65.6568542 77.3431458,67 79,67 Z M34,90 C35.6568542,90 37,88.6568542 37,87 C37,85.3431458 35.6568542,84 34,84 C32.3431458,84 31,85.3431458 31,87 C31,88.6568542 32.3431458,90 34,90 Z M90,14 C91.6568542,14 93,12.6568542 93,11 C93,9.34314575 91.6568542,8 90,8 C88.3431458,8 87,9.34314575 87,11 C87,12.6568542 88.3431458,14 90,14 Z M12,86 C14.209139,86 16,84.209139 16,82 C16,79.790861 14.209139,78 12,78 C9.790861,78 8,79.790861 8,82 C8,84.209139 9.790861,86 12,86 Z M40,21 C42.209139,21 44,19.209139 44,17 C44,14.790861 42.209139,13 40,13 C37.790861,13 36,14.790861 36,17 C36,19.209139 37.790861,21 40,21 Z M63,10 C65.7614237,10 68,7.76142375 68,5 C68,2.23857625 65.7614237,0 63,0 C60.2385763,0 58,2.23857625 58,5 C58,7.76142375 60.2385763,10 63,10 Z M57,70 C59.209139,70 61,68.209139 61,66 C61,63.790861 59.209139,62 57,62 C54.790861,62 53,63.790861 53,66 C53,68.209139 54.790861,70 57,70 Z M86,92 C88.7614237,92 91,89.7614237 91,87 C91,84.2385763 88.7614237,82 86,82 C83.2385763,82 81,84.2385763 81,87 C81,89.7614237 83.2385763,92 86,92 Z M32,63 C34.7614237,63 37,60.7614237 37,58 C37,55.2385763 34.7614237,53 32,53 C29.2385763,53 27,55.2385763 27,58 C27,60.7614237 29.2385763,63 32,63 Z M89,50 C91.7614237,50 94,47.7614237 94,45 C94,42.2385763 91.7614237,40 89,40 C86.2385763,40 84,42.2385763 84,45 C84,47.7614237 86.2385763,50 89,50 Z M80,29 C81.1045695,29 82,28.1045695 82,27 C82,25.8954305 81.1045695,25 80,25 C78.8954305,25 78,25.8954305 78,27 C78,28.1045695 78.8954305,29 80,29 Z M60,91 C61.1045695,91 62,90.1045695 62,89 C62,87.8954305 61.1045695,87 60,87 C58.8954305,87 58,87.8954305 58,89 C58,90.1045695 58.8954305,91 60,91 Z M35,41 C36.1045695,41 37,40.1045695 37,39 C37,37.8954305 36.1045695,37 35,37 C33.8954305,37 33,37.8954305 33,39 C33,40.1045695 33.8954305,41 35,41 Z M12,60 C13.1045695,60 14,59.1045695 14,58 C14,56.8954305 13.1045695,56 12,56 C10.8954305,56 10,56.8954305 10,58 C10,59.1045695 10.8954305,60 12,60 Z"></path>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-4' || is_customize_preview()) { ?>
					<pattern id="type-4" x="0" y="0" width="52" height="26" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z" />
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-5' || is_customize_preview()) { ?>
					<pattern id="type-5" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse" >
						<g fill="var(--patternColor)">
							<circle id="Oval-377-Copy-9" cx="3" cy="3" r="3"></circle>
							<circle id="Oval-377-Copy-14" cx="13" cy="13" r="3"></circle>
						</g>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-6' || is_customize_preview()) { ?>
					<pattern id="type-6" x="0" y="0" width="80" height="80" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10zm10 8c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40 40c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z" />
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-7' || is_customize_preview()) { ?>
					<pattern id="type-7" x="0" y="0" width="4" height="4" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M1 3h1v1H1V3zm2-2h1v1H3V1z"></path>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-8' || is_customize_preview()) { ?>
					<pattern id="type-8" x="0" y="0" width="6" height="6" patternUnits="userSpaceOnUse" >
						<g fill="var(--patternColor)">
							<polygon id="Rectangle-9" points="5 0 6 0 0 6 0 5"></polygon>
							<polygon id="Rectangle-9-Copy" points="6 5 6 6 5 6"></polygon>
						</g>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-9' || is_customize_preview()) { ?>
					<pattern id="type-9" x="0" y="0" width="12" height="16" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M4,0.990777969 C4,0.443586406 4.44386482,0 5,0 C5.55228475,0 6,0.45097518 6,0.990777969 L6,5.00922203 C6,5.55641359 5.55613518,6 5,6 C4.44771525,6 4,5.54902482 4,5.00922203 L4,0.990777969 Z M10,8.99077797 C10,8.44358641 10.4438648,8 11,8 C11.5522847,8 12,8.45097518 12,8.99077797 L12,13.009222 C12,13.5564136 11.5561352,14 11,14 C10.4477153,14 10,13.5490248 10,13.009222 L10,8.99077797 Z"></path>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-10' || is_customize_preview()) { ?>
					<pattern id="type-10" x="0" y="0" width="40" height="1" patternUnits="userSpaceOnUse" >
						<rect fill="var(--patternColor)" x="0" y="0" width="20" height="1"></rect>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-11' || is_customize_preview()) { ?>
					<pattern id="type-11" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse" >
						<g fill="var(--patternColor)">
							<polygon id="Path-2" points="0 40 40 0 20 0 0 20"></polygon>
							<polygon id="Path-2-Copy" points="40 40 40 20 20 40"></polygon>
						</g>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-12' || is_customize_preview()) { ?>
					<pattern id="type-12" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M15,0 C6.71572875,0 0,6.71572875 0,15 C8.28427125,15 15,8.28427125 15,0 Z M0,15 C0,23.2842712 6.71572875,30 15,30 C15,21.7157288 8.28427125,15 0,15 Z M30,15 C30,6.71572875 23.2842712,0 15,0 C15,8.28427125 21.7157288,15 30,15 Z M30,15 C30,23.2842712 23.2842712,30 15,30 C15,21.7157288 21.7157288,15 30,15 Z"></path>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-13' || is_customize_preview()) { ?>
					<pattern id="type-13" x="0" y="0" width="100" height="20" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M21.1841339,20 C21.5411448,19.869748 21.9037256,19.7358773 22.272392,19.5983261 C22.6346445,19.4631679 23.8705367,18.9999982 24.0399055,18.9366758 C33.6397477,15.3475548 39.6469349,14 50,14 C60.2711361,14 65.3618399,15.2217689 74.6286093,18.9284767 C75.584355,19.310775 76.4978747,19.6675274 77.3787841,20 L83.604005,20 C81.0931362,19.2694473 78.4649665,18.3089537 75.3713907,17.0715233 C65.8881601,13.2782311 60.5621972,12 50,12 C39.3741437,12 33.144814,13.3973866 23.3395101,17.0633242 C23.1688625,17.1271247 21.9338538,17.5899633 21.5732596,17.7245028 C19.0984715,18.6478581 16.912678,19.3994574 14.8494171,20 L21.1841339,20 L21.1841339,20 Z M21.1841339,0 C13.2575214,2.89194861 8.07672845,4 7.87150385e-14,4 L7.81597009e-14,4 L0,2 C5.74391753,2 9.9514017,1.4256397 14.8494171,1.40165657e-15 L21.1841339,6.9388939e-17 L21.1841339,0 Z M77.3787841,2.21705987e-12 C85.238555,2.9664329 90.5022896,4 100,4 L100,2 C93.1577329,2 88.6144135,1.4578092 83.604005,1.04805054e-13 L77.3787841,0 L77.3787841,2.21705987e-12 Z M7.87150385e-14,14 C8.44050043,14 13.7183277,12.7898887 22.272392,9.59832609 C22.6346445,9.46316794 23.8705367,8.99999822 24.0399055,8.9366758 C33.6397477,5.34755477 39.6469349,4 50,4 C60.2711361,4 65.3618399,5.2217689 74.6286093,8.92847669 C84.1118399,12.7217689 89.4378028,14 100,14 L100,12 C89.7288639,12 84.6381601,10.7782311 75.3713907,7.07152331 C65.8881601,3.2782311 60.5621972,2 50,2 C39.3741437,2 33.144814,3.39738661 23.3395101,7.0633242 C23.1688625,7.12712472 21.9338538,7.58996334 21.5732596,7.72450279 C13.2235239,10.8398294 8.16350991,12 0,12 L7.81597009e-14,14 L7.87150385e-14,14 L7.87150385e-14,14 Z"></path>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-14' || is_customize_preview()) { ?>
					<pattern id="type-14" x="0" y="0" width="40" height="12" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M2.84217094e-14,6.17157288 L6.17157288,0 L11.8284271,0 L0,11.8284271 L2.84217094e-14,6.17157288 L2.84217094e-14,6.17157288 Z M40,11.8284271 L28.1715729,0 L33.8284271,3.55271368e-15 L40,6.17157288 L40,11.8284271 L40,11.8284271 Z M6.17157288,12 L18.1715729,0 L21.8284271,0 L33.8284271,12 L28.1715729,12 L20,3.82842712 L11.8284271,12 L6.17157288,12 L6.17157288,12 Z M18.1715729,12 L20,10.1715729 L21.8284271,12 L18.1715729,12 L18.1715729,12 Z"></path>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-15' || is_customize_preview()) { ?>
					<pattern id="type-15" x="0" y="0" width="56" height="28" patternUnits="userSpaceOnUse" >
						<path fill="var(--patternColor)" d="M56 26v2h-7.75c2.3-1.27 4.94-2 7.75-2zm-26 2a2 2 0 1 0-4 0h-4.09A25.98 25.98 0 0 0 0 16v-2c.67 0 1.34.02 2 .07V14a2 2 0 0 0-2-2v-2a4 4 0 0 1 3.98 3.6 28.09 28.09 0 0 1 2.8-3.86A8 8 0 0 0 0 6V4a9.99 9.99 0 0 1 8.17 4.23c.94-.95 1.96-1.83 3.03-2.63A13.98 13.98 0 0 0 0 0h7.75c2 1.1 3.73 2.63 5.1 4.45 1.12-.72 2.3-1.37 3.53-1.93A20.1 20.1 0 0 0 14.28 0h2.7c.45.56.88 1.14 1.29 1.74 1.3-.48 2.63-.87 4-1.15-.11-.2-.23-.4-.36-.59H26v.07a28.4 28.4 0 0 1 4 0V0h4.09l-.37.59c1.38.28 2.72.67 4.01 1.15.4-.6.84-1.18 1.3-1.74h2.69a20.1 20.1 0 0 0-2.1 2.52c1.23.56 2.41 1.2 3.54 1.93A16.08 16.08 0 0 1 48.25 0H56c-4.58 0-8.65 2.2-11.2 5.6 1.07.8 2.09 1.68 3.03 2.63A9.99 9.99 0 0 1 56 4v2a8 8 0 0 0-6.77 3.74c1.03 1.2 1.97 2.5 2.79 3.86A4 4 0 0 1 56 10v2a2 2 0 0 0-2 2.07 28.4 28.4 0 0 1 2-.07v2c-9.2 0-17.3 4.78-21.91 12H30zM7.75 28H0v-2c2.81 0 5.46.73 7.75 2zM56 20v2c-5.6 0-10.65 2.3-14.28 6h-2.7c4.04-4.89 10.15-8 16.98-8zm-39.03 8h-2.69C10.65 24.3 5.6 22 0 22v-2c6.83 0 12.94 3.11 16.97 8zm15.01-.4a28.09 28.09 0 0 1 2.8-3.86 8 8 0 0 0-13.55 0c1.03 1.2 1.97 2.5 2.79 3.86a4 4 0 0 1 7.96 0zm14.29-11.86c1.3-.48 2.63-.87 4-1.15a25.99 25.99 0 0 0-44.55 0c1.38.28 2.72.67 4.01 1.15a21.98 21.98 0 0 1 36.54 0zm-5.43 2.71c1.13-.72 2.3-1.37 3.54-1.93a19.98 19.98 0 0 0-32.76 0c1.23.56 2.41 1.2 3.54 1.93a15.98 15.98 0 0 1 25.68 0zm-4.67 3.78c.94-.95 1.96-1.83 3.03-2.63a13.98 13.98 0 0 0-22.4 0c1.07.8 2.09 1.68 3.03 2.63a9.99 9.99 0 0 1 16.34 0z"></path>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-16' || is_customize_preview()) { ?>
					<pattern id="type-16" x="0" y="0" width="56" height="100" patternUnits="userSpaceOnUse" >
						<path d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='var(--patternColor)' stroke-width='2'/>
						<path d='M28 0L28 34L0 50L0 84L28 100L56 84L56 50L28 34' fill='none' stroke='var(--patternColor)' stroke-width='2' style="opacity: 0.6"/>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-17' || is_customize_preview()) { ?>
					<pattern id="type-17" x="0" y="0" width="8" height="8" patternUnits="userSpaceOnUse" >
						<path d='M0 0L8 8ZM8 0L0 8Z' stroke-width='1' stroke='var(--patternColor)'/>
					</pattern>
				<?php } ?>

				<?php if ($pattern_type === 'type-18' || is_customize_preview()) { ?>
					<pattern id="type-18" x="0" y="0" width="88" height="24" patternUnits="userSpaceOnUse">
						<path fill="var(--patternColor)" d="M10 0l30 15 2 1V2.18A10 10 0 0 0 41.76 0H39.7a8 8 0 0 1 .3 2.18v10.58L14.47 0H10zm31.76 24a10 10 0 0 0-5.29-6.76L4 1 2 0v13.82a10 10 0 0 0 5.53 8.94L10 24h4.47l-6.05-3.02A8 8 0 0 1 4 13.82V3.24l31.58 15.78A8 8 0 0 1 39.7 24h2.06zM78 24l2.47-1.24A10 10 0 0 0 86 13.82V0l-2 1-32.47 16.24A10 10 0 0 0 46.24 24h2.06a8 8 0 0 1 4.12-4.98L84 3.24v10.58a8 8 0 0 1-4.42 7.16L73.53 24H78zm0-24L48 15l-2 1V2.18A10 10 0 0 1 46.24 0h2.06a8 8 0 0 0-.3 2.18v10.58L73.53 0H78z"/>
					</pattern>
				<?php } ?>

				<rect x="0" y="0" width="100%" height="100%" fill="url(#<?php echo esc_attr($pattern_type) ?>)" />
			</svg>
		</figure>

	<?php

	return ob_get_clean();
}
