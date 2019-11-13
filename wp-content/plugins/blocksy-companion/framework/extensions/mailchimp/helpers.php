<?php

function blc_output_mailchimp_subscribe_form_cache() {
	if (! is_customize_preview()) return;

	blocksy_add_customizer_preview_cache(
		blocksy_html_tag(
			'div',
			[ 'data-id' => 'blocksy-mailchimp-subscribe' ],
			blc_ext_mailchimp_subscribe_form(true)
		)
	);
}

function blc_ext_mailchimp_subscribe_form($forced = false) {
	if (! $forced) {
		blc_output_mailchimp_subscribe_form_cache();
	}

	if (get_theme_mod('mailchimp_single_post_enabled', 'yes') !== 'yes') {
		if (! $forced) {
			return '';
		}
	}

	$title = get_theme_mod('mailchimp_title', __(
		'Newsletter Updates', 'blc'
	));

	$description = get_theme_mod('mailchimp_text', __(
		'Enter your email address below to subscribe to our newsletter',
		'blc'
	));

	$button_text = get_theme_mod('mailchimp_button_text', __(
		'Subscribe', 'blc'
	));

	$has_name = get_theme_mod( 'has_mailchimp_name', 'no' ) === 'yes';

    $name_label = get_theme_mod('mailchimp_name_label', __( 'Your name', 'blc' ));
    $email_label = get_theme_mod('mailchimp_mail_label', __( 'Your email', 'blc' ));

	if ($forced) {
		$has_name = true;
	}

	$list_id = null;

	if (get_theme_mod( 'mailchimp_list_id_source', 'default' ) === 'custom') {
		$list_id = get_theme_mod( 'mailchimp_list_id', '' );
	}

	$manager = new BlocksyMailchimpManager();

	$form_url = $manager->get_form_url_for($list_id);

	if (! $form_url) {
		return '';
	}

	$class = 'ct-mailchimp-block';

	$class .= ' ' . blocksy_visibility_classes(
		get_theme_mod('mailchimp_subscribe_visibility', [
			'desktop' => true,
			'tablet' => true,
			'mobile' => false,
		])
	);

	ob_start();

	?>

	<div class="<?php esc_attr_e($class) ?>">
		<h4>
			<?php echo esc_html($title) ?>
		</h4>



		<form action="<?php echo esc_attr($form_url) ?>" method="post" class="ct-mailchimp-form">
			<p class="ct-mailchimp-description">
				<?php echo esc_html($description) ?>
			</p>
			
			<div class="block-inner">
				<?php if ( $has_name ) { ?>
					<input type="text" name="FNAME" placeholder="<?php esc_attr_e($name_label); ?>" title="<?php echo __('Name', 'blocksy') ?>" />
				<?php } ?>

				<input type="email" name="EMAIL" placeholder="<?php esc_attr_e($email_label); ?> *" title="<?php echo __('Email', 'blocksy') ?>" required />

				<button class="button">
					<?php echo esc_html($button_text) ?>
				</button>
			</div>

			<div class="ct-mailchimp-message"></div>

			<?php
				if (function_exists('blocksy_ext_cookies_checkbox')) {
					echo blocksy_ext_cookies_checkbox('subscribe');
				}
			?>

		</form>

	</div>

	<?php

	return ob_get_clean();
}
