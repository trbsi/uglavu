<?php

add_filter('get_site_icon_url', function ($url) {
	if (empty($url)) {
		return blocksy_image_picker_url('favicon.png');
	}

	return $url;
});

function blocksy_output_site_branding($is_mobile = false) {
	$transparent_logo_output = '';

	if (blocksy_has_transparent_custom_logo()) {
		$transparent_logo_output = 'data-transparent-logo';
	}

	$tagline_class = 'site-description ' . blocksy_visibility_classes(
		get_theme_mod('tagline_search_visibility', [
			'desktop' => false,
			'tablet' => false,
			'mobile' => false,
		])
	);

	$tag = 'h1';

	if ($is_mobile) {
		$tag = 'h2';
	}

	?>

	<div
		class="site-branding"
		<?php blocksy_schema_org_definitions_e('logo') ?>
		<?php echo wp_kses_post($transparent_logo_output) ?>>

		<<?php echo $tag ?> class="site-title">
			<?php if ( ! blocksy_has_default_logo($is_mobile) ) { ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
					<?php bloginfo('name'); ?>
				</a>
			<?php } else { ?>
				<?php echo wp_kses_post(blocksy_get_custom_logo($is_mobile)); ?>
			<?php } ?>
		</<?php echo $tag ?>>

		<h2 class="<?php echo $tagline_class ?>">
			<?php bloginfo('description'); ?>
		</h2>
	</div>

	<?php
}


function blocksy_output_site_branding_mobile() {
	blocksy_output_site_branding(true);
}

function blocksy_has_default_logo($is_mobile = false) {
	if (get_theme_mod('logo_type', 'image') === 'text') {
		return false;
	}

	$custom_logo_id = get_theme_mod( 'custom_logo', '' );

	if ($is_mobile && get_theme_mod('has_mobile_logo', 'yes') === 'yes') {
		$mobile_logo_id = get_theme_mod( 'mobile_header_logo' );

		if ( ! isset( $mobile_logo_id['attachment_id'] ) ) {
			$mobile_logo_id['attachment_id'] = null;
		}

		if ($mobile_logo_id['attachment_id']) {
			$custom_logo_id = $mobile_logo_id['attachment_id'];
		}
	}

	return !!$custom_logo_id;
}

function blocksy_get_custom_logo($is_mobile = false) {
	$custom_logo_id = get_theme_mod( 'custom_logo', '' );

	if ($is_mobile && get_theme_mod('has_mobile_logo', 'yes') === 'yes') {
		$mobile_logo_id = get_theme_mod( 'mobile_header_logo' );

		if ( ! isset( $mobile_logo_id['attachment_id'] ) ) {
			$mobile_logo_id['attachment_id'] = null;
		}

		if ($mobile_logo_id['attachment_id']) {
			$custom_logo_id = $mobile_logo_id['attachment_id'];
		}
	}

	$transparent_logo_id = null;

	if (
		blocksy_has_transparent_header()
		&&
		get_theme_mod('has_transparent_different_logo', 'no') === 'yes'
	) {
		$transparent_custom_logo_id = get_theme_mod( 'transparent_header_logo' );

		if (! isset($transparent_custom_logo_id['attachment_id'])) {
			$transparent_custom_logo_id = null;
		}

		if ($transparent_custom_logo_id['attachment_id']) {
			$transparent_logo_id = $transparent_custom_logo_id['attachment_id'];
		}
	}

	if (! $custom_logo_id && !$transparent_logo_id) return '';

	$custom_logo_attr = [
		'class'    => 'custom-logo ct-default-logo',
		'itemprop' => 'logo',
	];

	$transparent_custom_logo_attr = [
		'class'    => 'custom-logo ct-transparent-logo',
		'itemprop' => 'logo',
	];

	/**
	 * If the logo alt attribute is empty, get the site title and explicitly
	 * pass it to the attributes used by wp_get_attachment_image().
	 */
	$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
	$transparent_image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );

	if ( empty( $image_alt ) ) {
		$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
	}

	if ( empty( $transparent_image_alt ) ) {
		$transparent_custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
	}

	$image_output = '';

	add_filter(
		'wp_get_attachment_image_attributes',
		'blocksy_handle_retina_logo',
		10, 3
	);

	$image_output .= wp_get_attachment_image(
		$custom_logo_id,
		'full',
		false,
		$custom_logo_attr
	);

	remove_filter(
		'wp_get_attachment_image_attributes',
		'blocksy_handle_retina_logo',
		10, 3
	);

	add_filter(
		'wp_get_attachment_image_attributes',
		'blocksy_handle_retina_logo_transparent',
		10, 3
	);

	$image_output .= wp_get_attachment_image(
		$transparent_logo_id,
		'full',
		false,
		$transparent_custom_logo_attr
	);

	remove_filter(
		'wp_get_attachment_image_attributes',
		'blocksy_handle_retina_logo_transparent',
		10, 3
	);

	/**
	 * If the alt attribute is not empty, there's no need to explicitly pass
	 * it because wp_get_attachment_image() already adds the alt attribute.
	 */
	$html = sprintf(
		'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
		esc_url( home_url( '/' ) ),
		$image_output
	);

	return $html;
}

function blocksy_handle_retina_logo_transparent($attr, $attachment, $size) {
	return blocksy_handle_retina_logo($attr, $attachment, $size, true);
}

function blocksy_handle_retina_logo(
	$attr, $attachment, $size, $is_transparent = false
) {
	$retina_logo_id = null;
	$custom_logo_id = null;

	if (! $is_transparent) {
		$custom_logo_id = get_theme_mod( 'custom_logo', '' );

		if (get_theme_mod('has_retina_logo', 'no') === 'yes') {
			$retina_logo_id = get_theme_mod('retina_header_logo');

			if ( ! isset( $retina_logo_id['attachment_id'] ) ) {
				$retina_logo_id['attachment_id'] = null;
			}

			$retina_logo_id = $retina_logo_id['attachment_id'];
		}
	}

	if (
		$is_transparent
		&&
		blocksy_has_transparent_header()
		&&
		get_theme_mod('has_transparent_different_logo', 'no') === 'yes'
	) {
		$transparent_custom_logo_id = get_theme_mod( 'transparent_header_logo' );

		if (! isset( $transparent_custom_logo_id['attachment_id'] ) ) {
			$transparent_custom_logo_id = null;
		}

		if ($transparent_custom_logo_id['attachment_id']) {
			$custom_logo_id = $transparent_custom_logo_id['attachment_id'];
		}

		$retina_logo_id = null;

		if (get_theme_mod('has_transparent_retina_logo', 'no') === 'yes') {
			$transparent_retina_logo_id = get_theme_mod(
				'transparent_retina_header_logo'
			);

			if ( ! isset( $transparent_retina_logo_id['attachment_id'] ) ) {
				$transparent_retina_logo_id['attachment_id'] = null;
			}

			$retina_logo_id = $transparent_retina_logo_id['attachment_id'];
		}
	}

	if (!$retina_logo_id || !$custom_logo_id) {
		return $attr;
	}

	$attr['srcset'] = '';

	$cutom_logo_src = wp_get_attachment_image_src( $custom_logo_id , 'full' );
	$cutom_logo_url = $cutom_logo_src[0];

	$retina_logo_src = wp_get_attachment_image_src( $retina_logo_id , 'full' );
	$retina_logo_url = $retina_logo_src[0];

	$attr['srcset'] = $retina_logo_url . ' 1x, ' . $retina_logo_url . ' 2x';

	unset( $attr['sizes'] );

	return $attr;
}

function blocksy_header_main_menu() {
	$divider_output = '';

	$items_divider = get_theme_mod('menu_items_divider', 'default');

	if ($items_divider !== 'default') {
		$divider_output = 'data-menu-divider="' . esc_attr($items_divider) . '"';
	}

	?>

	<nav
		id="site-navigation"
		class="main-navigation"
		data-menu-type="<?php echo esc_attr(get_theme_mod('header_menu_type', 'type-1')) ?>"
		data-dropdown-animation="<?php echo esc_attr(get_theme_mod('dropdown_animation', 'type-1')) ?>"
		<?php echo wp_kses_post($divider_output) ?>
		<?php blocksy_schema_org_definitions_e('navigation') ?>>

		<?php
			wp_nav_menu(
				[
					'theme_location' => 'primary',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'primary-menu menu',
					'fallback_cb'    => 'blocksy_main_menu_fallback',
				]
			);
		?>

	</nav>

	<?php
}

function blocksy_get_transparent_header_source() {
	static $result = null;

	if (! is_null($result)) {
		if (! is_customize_preview()) {
			return $result;
		}
	}

	if (blocksy_is_page() || is_single()) {
		$post_options = blocksy_get_post_options();

		$mode = blocksy_akg('has_transparent_header', $post_options, 'default');

		if ($mode === 'default') {
			$result = [
				'strategy' => 'customizer',
				'prefix' => ''
			];

			return $result;
		}

		$result = [
			'strategy' => $post_options
		];

		return $result;
	}

	$result = [
		'strategy' => 'customizer',
		'prefix' => ''
	];

	return $result;
}

function blocksy_output_cta_header_button() {
	return blocksy_html_tag(
		'a',

		array_merge(
			[
				'class' => 'ct-header-button ' . blocksy_visibility_classes(
					get_theme_mod('header_button_visibility', [
						'desktop' => false,
						'tablet' => false,
						'mobile' => false,
					])
				),

				'data-type' => esc_attr(
					get_theme_mod('header_button_type', 'type-1')
				),

				'data-size' => esc_attr(
					get_theme_mod('header_button_size', 'medium')
				)
			],

			(
				get_theme_mod('header_button_target', 'no') === 'yes' ? [
					'target' => '_blank'
				] : []
			),

			(
				!empty(get_theme_mod('header_button_link', '')) ? [
					'href' => esc_attr(get_theme_mod('header_button_link', '')),
				] : []
			)
		),

		esc_html(get_theme_mod('header_button_text', __('Download', 'blocksy')))
	);
}

