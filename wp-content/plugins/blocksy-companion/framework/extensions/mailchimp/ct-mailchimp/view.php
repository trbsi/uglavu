<?php
/**
 * Mailchimp widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */


// Widget title
$title = blocksy_default_akg( 'title', $atts, __( 'Newsletter', 'blc' ) );


// Message
$message = blocksy_default_akg( 'mailchimp_text', $atts, __( 'Enter your email address below to subscribe to our newsletter', 'blc' ) );

// Button text
$button_text = blocksy_default_akg( 'mailchimp_button_text', $atts, __( 'Subscribe', 'blc' ) );

// Form name
$has_name = blocksy_default_akg( 'has_mailchimp_name', $atts, 'no' ) === 'yes';

$list_id = null;

if (blocksy_default_akg( 'mailchimp_list_id_source', $atts, 'default' ) === 'custom') {
	$list_id = blocksy_default_akg( 'mailchimp_list_id', $atts, '' );
}

$manager = new BlocksyMailchimpManager();

// Button value
$form_url = $manager->get_form_url_for($list_id);

if (! $form_url) {
	return;
}

// Content alignment
$alignment = blocksy_default_akg( 'mailchimp_alignment', $atts, 'center' );

$name_label = blocksy_default_akg('mailchimp_name_label', $atts, __( 'Your name', 'blc' ));
$email_label = blocksy_default_akg('mailchimp_mail_label', $atts, __( 'Your email', 'blc' ));

$data_alignment = '';

if ( $alignment !== 'left' ) {
	$data_alignment = 'data-alignment=' . $alignment;
}

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_widget;

echo '<div class="ct-widget-inner"' . $data_alignment . '>';

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_title . wp_kses_post( $title ) . $after_title;

?>


<form action="<?php echo esc_attr($form_url) ?>" method="post" class="ct-mailchimp-form">

	<?php if( !empty( $message ) ) { ?>
		<div class="ct-mailchimp-description">
			<?php echo wp_kses_post($message) ?>
		</div>
	<?php } ?>

	<div class="ct-fields">
		<?php if ( $has_name ) { ?>
			<input type="text" name="FNAME" placeholder="<?php esc_attr_e($name_label); ?>" />
		<?php } ?>

		<input type="email" name="EMAIL" placeholder="<?php esc_attr_e($email_label); ?> *" required />

		<button class="button">
			<?php echo esc_html($button_text) ?>
		</button>

		<?php
			if (function_exists('blocksy_ext_cookies_checkbox')) {
				echo blocksy_ext_cookies_checkbox('mailchimp');
			}
		?>
	</div>
</form>

</div>

<?php echo wp_kses_post( $after_widget ); ?>
