<?php
/**
 * Mailchimp widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */


// Widget title
$title = blocksy_default_akg( 'title', $atts, __( 'Contact Info', 'blc' ) );

// Text
$text = blocksy_default_akg( 'contact_text', $atts, '' );

// Icons size
$icons_size = blocksy_default_akg( 'contact_icons_size', $atts, 'medium' );

// Icons type
$icons_type = blocksy_default_akg( 'contact_icons_type', $atts, 'rounded' );

// Icons fill type
$fill_type = blocksy_default_akg( 'contact_icons_fill', $atts, 'outline' );

$fill_type_output = '';

if ( $icons_type !== 'simple' ) {
	$fill_type_output = '-' . $fill_type;
}

$contact_information = blocksy_default_akg(
	'contact_information',
	$atts,
	[
		[
			'id' => 'address',
			'enabled' => true,
			'title' => __('Address:', 'blc'),
			'content' => 'Street Name, NY 38954',
		],

		[
			'id' => 'phone',
			'enabled' => true,
			'title' => __('Phone:', 'blc'),
			'content' => '578-393-4937',
			'link' => 'tel:578-393-4937',
		],

		[
			'id' => 'mobile',
			'enabled' => true,
			'title' => __('Mobile:', 'blc'),
			'content' => '578-393-4937',
			'link' => 'tel:578-393-4937',
		],
	]
);

$svgs = [
	'address' => '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M10,0C6.1,0,3,3.1,3,7c0,4.5,6,11.8,6.2,12.1L10,20l0.8-0.9C11,18.8,17,11.5,17,7C17,3.1,13.9,0,10,0z M10,2c2.8,0,5,2.2,5,5c0,2.7-3.1,7.4-5,9.8C8.1,14.4,5,9.7,5,7C5,4.2,7.2,2,10,2zM10,4.5C8.6,4.5,7.5,5.6,7.5,7S8.6,9.5,10,9.5s2.5-1.1,2.5-2.5S11.4,4.5,10,4.5z"/></svg>',

	'phone' => '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M4.4,0C4,0,3.6,0.2,3.2,0.4l0,0l0,0L0.8,2.9l0,0C0,3.6-0.2,4.7,0.1,5.6c0,0,0,0,0,0c0.7,1.9,2.3,5.5,5.6,8.7c3.3,3.3,6.9,4.9,8.7,5.6h0c0.9,0.3,1.9,0.1,2.7-0.5l2.4-2.4c0.6-0.6,0.6-1.7,0-2.4l-3.1-3.1l0,0c-0.6-0.6-1.8-0.6-2.4,0l-1.5,1.5c-0.6-0.3-1.9-1-3.1-2.2C8,9.5,7.4,8.2,7.2,7.6l1.5-1.5c0.6-0.6,0.7-1.7,0-2.4l0,0L8.6,3.6L5.6,0.5l0,0l0,0C5.2,0.2,4.8,0,4.4,0zM4.4,1.5c0.1,0,0.1,0,0.2,0.1l3.1,3.1l0.1,0.1c0,0,0,0.1,0,0.2L5.7,6.9L5.3,7.3l0.2,0.5c0,0,0.9,2.4,2.7,4.1L8.4,12c1.8,1.6,3.9,2.5,3.9,2.5l0.5,0.2l2.3-2.3c0.1-0.1,0.1-0.1,0.2,0l3.1,3.1c0.1,0.1,0.1,0.1,0,0.2l-2.4,2.4c-0.4,0.3-0.7,0.4-1.2,0.2c-1.7-0.7-5.1-2.2-8.1-5.2c-3-3-4.6-6.5-5.2-8.2c-0.1-0.3,0-0.8,0.2-1l0,0l2.3-2.4C4.2,1.6,4.3,1.5,4.4,1.5z"/></svg>',

	'mobile' => '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M13.5,20H6.5c-1.6,0-2.9-1.3-2.9-2.9V2.9C3.5,1.3,4.8,0,6.5,0h7.1c1.6,0,2.9,1.3,2.9,2.9v14.1C16.5,18.7,15.2,20,13.5,20zM6.7,1.7C5.8,1.7,5,2.5,5,3.4v13.2c0,0.9,0.7,1.7,1.7,1.7h6.6c0.9,0,1.7-0.7,1.7-1.7V3.4c0-0.9-0.7-1.7-1.7-1.7H6.7z"/><path d="M11.2,4.4H8.8c-0.3,0-0.6-0.3-0.6-0.6s0.3-0.6,0.6-0.6h2.4c0.3,0,0.6,0.3,0.6,0.6S11.5,4.4,11.2,4.4z"/><circle cx="10" cy="15.7" r="1.2"/></svg>',

	'fax' => '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M17.5,5.8h-1.7v-4V0h-1.7H5.8H4.2v1.8v4H2.5C1.1,5.8,0,7,0,8.3v8.3h4.2V20h11.7v-3.3H20V8.3C20,7,18.9,5.8,17.5,5.8zM5.8,1.8h8.3v4H5.8V1.8zM14.2,18.3H5.8v-5h8.3V18.3zM18.3,15h-2.5v-3.3H4.2V15H1.7V8.3c0-0.5,0.4-0.8,0.8-0.8h15c0.5,0,0.8,0.4,0.8,0.8V15zM4.2,9.2c0,0.5-0.4,0.8-0.8,0.8S2.5,9.6,2.5,9.2s0.4-0.8,0.8-0.8S4.2,8.7,4.2,9.2z"/></svg>',

	'email' => '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M10,0C4.5,0,0,4.5,0,10s4.5,10,10,10h5v-2h-5c-4.4,0-8-3.6-8-8s3.6-8,8-8s8,3.6,8,8v1.5c0,0.8-0.7,1.5-1.5,1.5S15,12.3,15,11.5V10c0-2.7-2.3-5-5-5s-5,2.3-5,5s2.3,5,5,5c1.4,0,2.7-0.6,3.6-1.6c0.6,0.9,1.7,1.6,2.9,1.6c1.9,0,3.5-1.6,3.5-3.5V10C20,4.5,15.5,0,10,0zM10,7c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S8.3,7,10,7z"/></svg>',

	'website' => '<svg width="20" height="20" viewBox="0 0 20 20"><path d="M9.3,0C4.4,0,0.4,4,0.4,8.9s4,8.9,8.9,8.9c0.8,0,1.5-0.1,2.2-0.3v-3.9c-0.6,1.7-1.4,2.7-2.2,2.7c-0.9,0-2-1.5-2.5-3.7h4.8
	v-1.5h-5c-0.1-0.7-0.1-1.4-0.1-2.2c0-0.8,0.1-1.5,0.2-2.2h5.6c0.1,0.7,0.2,1.4,0.2,2.2c0,0.2,0,0.4,0,0.6c0.4-0.4,0.9-0.6,1.5-0.6c0-0.8,0-1.5-0.1-2.2h2.8c0.2,0.7,0.3,1.4,0.3,2.2c0,0.5-0.1,1-0.2,1.5l1.3,0.9c0.2-0.8,0.3-1.6,0.3-2.4C18.1,4,14.2,0,9.3,0zM9.3,1.5c0.9,0,2,1.5,2.5,3.7h-5C7.3,2.9,8.3,1.5,9.3,1.5zM6.3,2.1C5.9,2.9,5.5,4,5.2,5.2H2.8C3.6,3.8,4.9,2.7,6.3,2.1zM12.2,2.1c1.5,0.6,2.7,1.7,3.5,3.1h-2.3C13.1,4,12.7,2.9,12.2,2.1zM2.2,6.7h2.8C4.9,7.4,4.8,8.1,4.8,8.9c0,0.8,0.1,1.5,0.1,2.2H2.2C2,10.4,1.9,9.7,1.9,8.9C1.9,8.1,2,7.4,2.2,6.7z M13.7,10.4c-0.4,0-0.7,0.3-0.8,0.7c0,0,0,0.1,0,0.1v6.6c0,0.4,0.3,0.7,0.7,0.7c0.2,0,0.4-0.1,0.5-0.2l0,0l1.4-1.6l1.5,3c0.2,0.4,0.6,0.5,1,0.3c0.4-0.2,0.5-0.6,0.3-1l-1.5-3l2.2-0.4l0,0c0.3-0.1,0.5-0.4,0.5-0.7c0-0.3-0.1-0.5-0.3-0.6l0,0l-5.1-3.6C14.1,10.4,13.9,10.4,13.7,10.4zM2.9,12.6h2.3c0.3,1.2,0.7,2.3,1.1,3.1C4.9,15.1,3.7,14,2.9,12.6z"/></svg>',
];

$has_enabled_layer = false;

foreach ($contact_information as $single_layer) {
	if ($single_layer['enabled']) {
		$has_enabled_layer = true;
		break;
	}
}

// Link target
$target = blocksy_default_akg( 'contact_link_target', $atts, 'no' );

$data_target = '';

if ( $target !== 'no' ) {
	$data_target = 'target="_blank"';
}


// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_widget;

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_title . wp_kses_post( $title ) . $after_title;

?>

<?php if( !empty( $text ) ) { ?>
	<div class="ct-contact-info-text">
		<?php echo wp_kses_post($text) ?>
	</div>
<?php } ?>

<?php if ($has_enabled_layer) { ?>

	<ul data-icons="<?php echo $icons_size . '-' . $icons_type . $fill_type_output ?>">
		<?php foreach ($contact_information as $single_layer) { ?>
			<li>
				<i>
					<?php echo $svgs[$single_layer['id']] ?>
				</i>

				<div class="contact-info">
					<?php if (! empty(blocksy_akg('title', $single_layer, ''))) { ?>
						<span class="contact-title">
							<?php echo esc_html(blocksy_akg('title', $single_layer, '')) ?>
						</span>
					<?php } ?>

					<?php if (! empty(blocksy_akg('content', $single_layer, ''))) { ?>
						<span class="contact-text">
							<?php if (! empty(blocksy_akg('link', $single_layer, ''))) { ?>
								<a href="<?php echo blocksy_akg('link', $single_layer, '') ?>" <?php echo $data_target ?>>
							<?php } ?>

							<?php echo esc_html(blocksy_akg('content', $single_layer, '')) ?>

							<?php if (! empty(blocksy_akg('link', $single_layer, ''))) { ?>
								</a>
							<?php } ?>
						</span>
					<?php } ?>
				</div>
			</li>

		<?php } ?>
	</ul>

<?php } ?>

<?php echo wp_kses_post( $after_widget ); ?>
