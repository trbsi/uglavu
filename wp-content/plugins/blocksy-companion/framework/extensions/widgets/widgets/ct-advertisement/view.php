<?php
/**
 * Advertisement widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */


// Widget title
$title = blocksy_default_akg( 'title', $atts, __( 'Advertisement', 'blc' ) );

// Ad source
$source = blocksy_default_akg( 'ad_source', $atts, 'code' );

// Button text
$ad_code = blocksy_default_akg( 'ad_code', $atts, '' );

// Ad link
$ad_link = blocksy_default_akg( 'ad_link', $atts, '' );

// Ad link target
$ad_link_target = blocksy_default_akg( 'ad_link_target', $atts, 'yes' );

$image_output = blocksy_image([
	'attachment_id' => blocksy_default_akg( 'ad_image/attachment_id', $atts, null ),
	'ratio' => 'original',
	'tag_name' => 'a',
	'size' => 'large',
	'html_atts' => array_merge([
		'href' => esc_url( $ad_link ),
	], $ad_link_target !== 'yes' ? [] : [
		'target' => '_blank'
	]),
]);


// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_widget;

// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
echo $before_title . wp_kses_post( $title ) . $after_title;

?>

<div class="ct-advertisement">
	<?php if ( $source === 'code' ) {
		echo $ad_code;
	} else {
		echo $image_output;
	} ?>
</div>

<?php echo wp_kses_post( $after_widget ); ?>
