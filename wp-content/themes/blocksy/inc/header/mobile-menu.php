<?php

function blocksy_get_custom_logo_mobile_menu() {
	$custom_logo_id = null;

	$custom_logo_id = get_theme_mod( 'mobile_menu_logo' );

	if ( ! isset( $custom_logo_id['attachment_id'] ) ) {
		$custom_logo_id = null;
	}

	$custom_logo_id = $custom_logo_id['attachment_id'];

	if (! $custom_logo_id) return '';

	$custom_logo_attr = [
		'class'    => 'custom-logo',
		'itemprop' => 'logo',
	];

	/**
	 * If the logo alt attribute is empty, get the site title and explicitly
	 * pass it to the attributes used by wp_get_attachment_image().
	 */
	$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );

	if ( empty( $image_alt ) ) {
		$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
	}

	$image_output = '';

	add_filter(
		'wp_get_attachment_image_attributes',
		'blocksy_handle_retina_logo_mobile_menu',
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
		'blocksy_handle_retina_logo_mobile_menu',
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

function blocksy_output_mobile_menu_site_branding($is_mobile = false) {
	if (get_theme_mod('has_mobile_menu_logo', 'no') === 'no') {
		return;
	}

	?>

	<div
		class="site-branding"
		<?php blocksy_schema_org_definitions_e('logo') ?>>

		<?php
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * Function blocksy_get_custom_logo_mobile_menu() used here escapes the value properly.
			 */
			echo blocksy_get_custom_logo_mobile_menu();
		?>
	</div>

	<?php
}

function blocksy_handle_retina_logo_mobile_menu($attr, $attachment, $size) {
	$retina_logo_id = null;
	$custom_logo_id = null;

	$custom_logo_id = get_theme_mod( 'mobile_menu_logo' );

	if ( ! isset( $custom_logo_id['attachment_id'] ) ) {
		$custom_logo_id['attachment_id'] = null;
	}

	$custom_logo_id = $custom_logo_id['attachment_id'];

	if (get_theme_mod('has_mobile_menu_retina_logo', 'no') === 'yes') {
		$retina_logo_id = get_theme_mod('mobile_menu_retina_logo');

		if ( ! isset( $retina_logo_id['attachment_id'] ) ) {
			$retina_logo_id['attachment_id'] = null;
		}

		$retina_logo_id = $retina_logo_id['attachment_id'];
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

function blocksy_header_mobile_menu() {

	?>
	<nav id="site-navigation" class="main-navigation">
		<a href="#mobile-menu" class="mobile-menu-toggle">
			<span
				data-type="<?php echo esc_attr(get_theme_mod('mobile_menu_trigger_type', 'type-1')) ?>"
				class="lines-button"></span>
		</a>
	</nav>

	<?php
}

function blocksy_header_mobile_modal() {
	// offcanvas | modal
	$behavior = get_theme_mod('mobile_menu_modal_behavior', 'modal');

	$v_align = '';

	if ( $behavior === 'modal' ) {
		$v_align = 'data-align="middle"';
	}

	if ($behavior === 'offcanvas') {
		$behavior = 'offcanvas-menu';
	}

	?>

	<div id="mobile-menu" class="ct-<?php echo esc_attr($behavior) ?>">
		<?php

			ob_start();

			wp_nav_menu(
				[
					'theme_location' => 'primary',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'mobile-menu',
					'fallback_cb'    => 'blocksy_main_menu_fallback',
				]
			);

			$menu_output = ob_get_clean();
			$container_class = 'ct-bag-container';

			if ( strpos( $menu_output, 'sub-menu' ) ) {
				$container_class .= ' contains-sub-menus';
			}
		?>

		<div class="<?php echo esc_attr($container_class) ?>">
			<div class="ct-bag-actions">
				<div class="ct-bag-close">
					<span class="lines-button close"></span>
				</div>
			</div>

			<div class="ct-bag-content" <?php echo wp_kses_post($v_align) ?>>
				<?php blocksy_output_mobile_menu_site_branding(); ?>

				<?php
					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Variable $menu_output used here has the value escaped properly.
					 * It contains the default WordPress menu.
					 */
					echo $menu_output;
				?>
			</div>
		</div>
	</div>

	<?php
}

