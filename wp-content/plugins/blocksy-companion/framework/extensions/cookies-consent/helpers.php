<?php

function blc_ext_cookies_consent_cache() {
	if (! is_customize_preview()) return;

	blocksy_add_customizer_preview_cache(
		blocksy_html_tag(
			'div',
			[ 'data-id' => 'blocksy-cookies-consent-section' ],
			blocksy_ext_cookies_consent_output(true)
		)
	);
}

function blocksy_ext_cookies_consent_output($forced = false) {
	if (! $forced) {
		blc_ext_cookies_consent_cache();
	}

	if (! BlocksyExtensionCookiesConsent::should_display_notification()) {
		if (! $forced) {
			return;
		}
	}

	$content = get_theme_mod(
		'cookie_consent_content',
		__('We use cookies to ensure that we give you the best experience on our website.', 'blc')
	);

	$button_text = get_theme_mod('cookie_consent_button_text', __('Accept', 'blc'));
	$period = get_theme_mod('cookie_consent_period', 'onemonth');
	$type = get_theme_mod('cookie_consent_type', 'type-1');

	$class = 'container';

	if ( $type === 'type-2' ) {
		$class = 'ct-container';
	}

	ob_start();

	?>


	<div class="cookie-notification ct-fade-in-start" data-period="<?php esc_attr_e($period) ?>" data-type="<?php esc_attr_e($type) ?>">

		<div class="<?php esc_attr_e($class) ?>">

			<?php if (!empty($content)) { ?>
				<p><?php echo wp_kses_post($content) ?></p>
			<?php } ?>

			<button class="ct-accept"><?php echo esc_html($button_text) ?></button>

			<?php if ($type === 'type-1' || is_customize_preview()) { ?>
				<button class="ct-close">×</button>
			<?php } ?>

		</div>
	</div>
	<?php

	return ob_get_clean();
}

function blocksy_ext_cookies_checkbox() {
	ob_start();

	$message = sprintf(
		__('I accept the %s', 'blc'),
		sprintf(
			'<a href="' . site_url('/privacy-policy') . '">%s</a>',
			__('Privacy Policy', 'blc')
		)
	);

	?>

	<div class="gdpr-confirm-policy">
		<input id="gdprconfirm" name="gdprconfirm" type="checkbox" required />
		<label for="gdprconfirm"><?php echo $message ?></label>
	</div>

	<?php

	return ob_get_clean();
}
