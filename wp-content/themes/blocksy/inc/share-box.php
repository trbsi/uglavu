<?php
/**
 * Share box related helpers.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

/**
 * Get social share box.
 */
function blocksy_get_social_share_box( $check_for_preview = false, $args = [] ) {
	$home_url = blocksy_encode_uri_component( home_url( add_query_arg( null, null ) ) );

	$args = wp_parse_args(
		$args,
		[ 'html_atts' => [] ]
	);

	$old_args = $args['html_atts'];

	$args['html_atts'] = [
		'class' => 'share-box',
	];

	$args['html_atts'] = wp_parse_args(
		$old_args,
		$args['html_atts']
	);

	$social_urls = [
		'facebook' => str_replace(
			'{url}',
			$home_url,
			'https://www.facebook.com/sharer/sharer.php?u={url}'
		),
		'twitter' => str_replace(
			'{url}',
			$home_url,
			'https://twitter.com/share?url={url}'
		),
		'google_plus' => str_replace(
			'{url}',
			$home_url,
			'https://plus.google.com/share?url={url}'
		),
		'pinterest' => str_replace(
			'{url}',
			$home_url,
			'#'
		),
		'linkedin' => str_replace(
			'{url}',
			$home_url,
			'https://www.linkedin.com/shareArticle?url={url}'
		),
		'reddit' => str_replace(
			'{url}',
			$home_url,
			'http://www.reddit.com/submit?url={url}'
		),
		'vk' => str_replace(
			'{url}',
			$home_url,
			'http://vk.com/share.php?url={url}'
		),
		'ok' => str_replace(
			'{url}',
			$home_url,
			'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl={url}'
		),

		'telegram' => str_replace(
			'{url}',
			$home_url,
			'https://t.me/share/url?url={url}'
		),
	];

	$all_links = [];

	$share_box_networks = [
		[
			'for' => 'facebook',
			'enabled' => get_theme_mod( 'share_facebook', 'yes' ) === 'yes' || $check_for_preview,

			'name' => __( 'Facebook', 'blocksy' ),
			'icon' => '
				<svg
				width="15px"
				height="15px"
				viewBox="0 0 20 20">
					<path d="M11.7,6.7v-2c0-0.9,0.2-1.3,1.6-1.3H15V0h-2.9C8.5,0,7.3,1.6,7.3,4.4v2.2H5V10h2.3v10h4.3V10h2.9L15,6.7H11.7z"/>
				</svg>
			',
		],

		[
			'for' => 'twitter',
			'enabled' => get_theme_mod( 'share_twitter', 'yes' ) === 'yes' || $check_for_preview,

			'name' => __( 'Twitter', 'blocksy' ),
			'icon' => '
				<svg
				width="16px"
				height="16px"
				viewBox="0 0 20 20">
					<path d="M20,3.8c-0.7,0.3-1.5,0.5-2.4,0.6c0.8-0.5,1.5-1.3,1.8-2.3c-0.8,0.5-1.7,0.8-2.6,1c-0.7-0.8-1.8-1.3-3-1.3c-2.3,0-4.1,1.8-4.1,4.1c0,0.3,0,0.6,0.1,0.9C6.4,6.7,3.4,5.1,1.4,2.6C1,3.2,0.8,3.9,0.8,4.7c0,1.4,0.7,2.7,1.8,3.4C2,8.1,1.4,7.9,0.8,7.6c0,0,0,0,0,0.1c0,2,1.4,3.6,3.3,4c-0.3,0.1-0.7,0.1-1.1,0.1c-0.3,0-0.5,0-0.8-0.1c0.5,1.6,2,2.8,3.8,2.8c-1.4,1.1-3.2,1.8-5.1,1.8c-0.3,0-0.7,0-1-0.1c1.8,1.2,4,1.8,6.3,1.8c7.5,0,11.7-6.3,11.7-11.7c0-0.2,0-0.4,0-0.5C18.8,5.3,19.4,4.6,20,3.8z"/>
				</svg>
			',
		],

		[
			'enabled' => get_theme_mod( 'share_pinterest', 'yes' ) === 'yes' || $check_for_preview,
			'for' => 'pinterest',

			'name' => __( 'Pinterest', 'blocksy' ),
			'icon' => '
				<svg
				width="15px"
				height="15px"
				viewBox="0 0 20 20">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,4.1,2.5,7.6,6,9.2c0-0.7,0-1.5,0.2-2.3c0.2-0.8,1.3-5.4,1.3-5.4s-0.3-0.6-0.3-1.6c0-1.5,0.9-2.6,1.9-2.6c0.9,0,1.3,0.7,1.3,1.5c0,0.9-0.6,2.3-0.9,3.5c-0.3,1.1,0.5,1.9,1.6,1.9c1.9,0,3.2-2.4,3.2-5.3c0-2.2-1.5-3.8-4.2-3.8c-3,0-4.9,2.3-4.9,4.8c0,0.9,0.3,1.5,0.7,2C6,12,6.1,12.1,6,12.4c0,0.2-0.2,0.6-0.2,0.8c-0.1,0.3-0.3,0.3-0.5,0.3c-1.4-0.6-2-2.1-2-3.8c0-2.8,2.4-6.2,7.1-6.2c3.8,0,6.3,2.8,6.3,5.7c0,3.9-2.2,6.9-5.4,6.9c-1.1,0-2.1-0.6-2.4-1.2c0,0-0.6,2.3-0.7,2.7c-0.2,0.8-0.6,1.5-1,2.1C8.1,19.9,9,20,10,20c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0z"/>
				</svg>
			',
		],

		[
			'enabled' => get_theme_mod( 'share_gplus', 'yes' ) === 'yes' || $check_for_preview,
			'for' => 'google_plus',

			'name' => __( 'Google Plus', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M6.4,9.1c0,0.7,0,1.4,0,2.2c1.2,0,2.4,0,3.6,0c-0.5,2.7-4.2,3.6-6.1,1.8C1.9,11.6,2,8.2,4,6.8C5.5,5.6,7.5,5.9,9,6.9
						c0.6-0.5,1.1-1.1,1.6-1.7c-1.2-1-2.7-1.6-4.2-1.6C3.1,3.5,0.1,6.4,0,9.7c-0.2,2.7,1.5,5.3,4,6.2c2.5,1,5.6,0.3,7.2-1.9
						c1-1.4,1.3-3.2,1.1-4.9C10.4,9.1,8.4,9.1,6.4,9.1z"/>
					<path d="M18.2,9.1c0-0.6,0-1.2,0-1.8c-0.6,0-1.2,0-1.8,0c0,0.6,0,1.2,0,1.8c-0.6,0-1.2,0-1.8,0c0,0.6,0,1.2,0,1.8c0.6,0,1.2,0,1.8,0
						c0,0.6,0,1.2,0,1.8c0.6,0,1.2,0,1.8,0c0-0.6,0-1.2,0-1.8c0.6,0,1.2,0,1.8,0c0-0.6,0-1.2,0-1.8C19.4,9.1,18.8,9.1,18.2,9.1z"/>
				</svg>
			',
		],

		[
			'enabled' => get_theme_mod( 'share_linkedin', 'yes' ) === 'yes' || $check_for_preview,
			'for' => 'linkedin',

			'name' => __( 'LinkedIn', 'blocksy' ),
			'icon' => '
				<svg
				width="15px"
				height="15px"
				viewBox="0 0 20 20">

					<path id="linkedin" d="M16,19.5v-7.9c0,0-0.4-1.6-2-1.6s-2.1,0.3-2.8,1.2v8.2h-4V7h4v1.8c0,0,1.3-2.5,4-2.4c2.5,0.2,4.3,1.7,4.7,5H20v8H16z M2.4,5.4C1.1,5.4,0,4.3,0,3c0-1.3,1.1-2.4,2.4-2.4S4.8,1.6,4.8,3C4.8,4.3,3.7,5.4,2.4,5.4z M4.4,19.5h-4V7h4V19.5z"/>
				</svg>
			',
		],

		[
			'enabled' => false,
			'for' => 'reddit',

			'name' => __( 'Reddit', 'blocksy' ),
			'icon' => '
				<svg
				width="17px"
				height="17px"
				viewBox="0 0 20 20">

					<path d="M10,7.1c1.2,0,2.4-0.8,2.9-1.8c1.8,0.8,3,2.4,3.5,4.2c0.1,0.3,0.4,0.7,0.8,0.7h0.2c0.4-0.1,0.8-0.6,0.6-1c-0.7-2.5-2.4-4.5-4.8-5.5c0-1.8-1.4-3.2-3.2-3.2S6.7,1.9,6.7,3.8S8.2,7.1,10,7.1z M10,2.1c0.9,0,1.7,0.8,1.7,1.7S10.9,5.4,10,5.4S8.3,4.7,8.3,3.8S9.1,2.1,10,2.1zM3.3,11.2c0-1.9,0.8-3.8,2.2-5c0.2-0.2,0.3-0.3,0.3-0.6c0.1-0.3,0-0.4-0.2-0.6C5.3,4.8,4.8,4.8,4.5,5c-1.8,1.6-2.8,3.8-2.8,6.2v0.4c-1,0.6-1.7,1.7-1.7,2.9c0,1.8,1.5,3.3,3.3,3.3s3.3-1.5,3.3-3.3S5.2,11.2,3.3,11.2z M1.7,14.6c0-0.9,0.8-1.7,1.7-1.7S5,13.7,5,14.6s-0.8,1.7-1.7,1.7S1.7,15.5,1.7,14.6z M16.7,11.2c-1.8,0-3.3,1.5-3.3,3.3c0,0.8,0.2,1.4,0.7,2c-1.8,1.4-4.3,1.8-6.5,0.9c-0.4-0.2-0.9,0-1.1,0.4c-0.1,0.2-0.1,0.4,0,0.7c0.1,0.2,0.3,0.3,0.4,0.4c1,0.4,2.1,0.6,3.2,0.6c1.9,0,3.8-0.7,5.3-1.9c0.4,0.2,0.8,0.2,1.3,0.2c1.8,0,3.3-1.5,3.3-3.3S18.5,11.2,16.7,11.2z M16.7,16.2c-0.9,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7c0.9,0,1.7,0.7,1.7,1.7S17.6,16.2,16.7,16.2z"/>
				</svg>
			',
		],

		[
			'enabled' => get_theme_mod( 'share_vk', 'no' ) === 'yes' || $check_for_preview,
			'for' => 'vk',

			'name' => __( 'VK', 'blocksy' ),
			'icon' => '
				<svg
				width="19px"
				height="19px"
				viewBox="0 0 20 20">

					<path d="M19.2,4.8H16c-0.3,0-0.5,0.1-0.6,0.4c0,0-1.3,2.4-1.7,3.2c-1.1,2.2-1.8,1.5-1.8,0.5V5.4c0-0.6-0.5-1.1-1.1-1.1H8.2C7.6,4.3,6.9,4.6,6.5,5.1c0,0,1.2-0.2,1.2,1.5c0,0.4,0,1.6,0,2.6c0,0.4-0.3,0.7-0.7,0.7c-0.2,0-0.4-0.1-0.6-0.2c-1-1.4-1.8-2.9-2.5-4.5C4,5,3.7,4.8,3.5,4.8c-0.7,0-2.1,0-2.9,0C0.2,4.8,0,5,0,5.3c0,0.1,0,0.1,0,0.2C0.9,8,4.8,15.7,9.2,15.7H11c0.4,0,0.7-0.3,0.7-0.7v-1.1c0-0.4,0.3-0.7,0.7-0.7c0.2,0,0.4,0.1,0.5,0.2l2.2,2.1c0.2,0.2,0.5,0.3,0.7,0.3h2.9c1.4,0,1.4-1,0.6-1.7c-0.5-0.5-2.5-2.6-2.5-2.6c-0.3-0.4-0.4-0.9-0.1-1.3c0.6-0.8,1.7-2.2,2.1-2.8C19.6,6.5,20.7,4.8,19.2,4.8z"/>
				</svg>
			',
		],

		[
			'enabled' => get_theme_mod( 'share_ok', 'no' ) === 'yes' || $check_for_preview,
			'for' => 'ok',

			'name' => __( 'Odnoklassniki', 'blocksy' ),
			'icon' => '
				<svg
				width="17px"
				height="17px"
				viewBox="0 0 20 20">

					<path d="M10,3c1.2,0,2.1,1,2.1,2.1c0,1.2-1,2.1-2.1,2.1c-1.2,0-2.1-1-2.1-2.1C7.9,4,8.8,3,10,3L10,3L10,3z M10,10.3c2.8,0,5.2-2.3,5.2-5.2C15.2,2.3,12.8,0,10,0C7.2,0,4.8,2.3,4.8,5.2C4.8,8,7.2,10.3,10,10.3L10,10.3zM12.1,14.5c1.1-0.2,2.1-0.7,3-1.2c0.7-0.4,0.9-1.4,0.5-2.1c-0.4-0.7-1.4-0.9-2.1-0.5c-2.1,1.3-4.8,1.3-6.9,0c-0.7-0.4-1.6-0.2-2.1,0.5c-0.4,0.7-0.2,1.6,0.5,2.1c0.9,0.6,1.9,1,3,1.2L5,17.4C4.4,18,4.4,19,5,19.6C5.3,19.9,5.7,20,6.1,20c0.4,0,0.8-0.1,1.1-0.4l2.8-2.8l2.8,2.8c0.6,0.6,1.5,0.6,2.1,0c0.6-0.6,0.6-1.5,0-2.1L12.1,14.5L12.1,14.5z"/>
				</svg>
			',
		],

		[
			'enabled' => get_theme_mod( 'share_telegram', 'no' ) === 'yes' || $check_for_preview,
			'for' => 'telegram',

			'name' => __( 'Telegram', 'blocksy' ),
			'icon' => '
				<svg
				width="16px"
				height="16px"
				viewBox="0 0 20 20">

					<path d="M19.9,3.1l-3,14.2c-0.2,1-0.8,1.3-1.7,0.8l-4.6-3.4l-2.2,2.1c-0.2,0.2-0.5,0.5-0.9,0.5l0.3-4.7L16.4,5c0.4-0.3-0.1-0.5-0.6-0.2L5.3,11.4L0.7,10c-1-0.3-1-1,0.2-1.5l17.7-6.8C19.5,1.4,20.2,1.9,19.9,3.1z"/>
				</svg>
			',
		],
	];

	if ( ! is_array( $share_box_networks ) ) {
		return '';
	}

	if ( count( $share_box_networks ) === 0 ) {
		return '';
	}

	$has_enabled_network = 0;

	foreach ( $share_box_networks as $share_network ) {
		if ( $share_network['enabled'] ) {
			$has_enabled_network++;
		}
	}

	if ( ! $has_enabled_network ) {
		return '';
	}

	ob_start();

	?>

	<div <?php echo wp_kses_post(blocksy_attr_to_html( $args['html_atts'] )); ?>>
		<ul data-count="<?php echo esc_attr( $has_enabled_network ); ?>">

			<?php
				echo wp_kses_post(implode( '', $all_links ));
			?>

			<?php foreach ( $share_box_networks as $share_network ) { ?>
				<?php

				if ( ! $share_network['enabled'] ) {
					continue;}
				?>

				<li data-share-network="<?php echo esc_attr( $share_network['for'] ); ?>">
					<a href="<?php echo esc_attr( $social_urls[ $share_network['for'] ] ); ?>">
						<?php
							/**
							 * Note to code reviewers: This line doesn't need to be escaped.
							 * The variable used here escapes the value properly.
							 * It contains an inline SVG, which is perfectly safe.
							 */
							echo $share_network['icon'];
						?>

						<span>
							<?php
								echo wp_kses_post($share_network['name']);
							?>
						</span>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>

	<?php
	$output = ob_get_clean();

	return $output;
}

/**
 * Encore a string to be safely included in the URL.
 *
 * @param string $str String to encode for URL.
 */
function blocksy_encode_uri_component( $str ) {
	$revert = [
		'%21' => '!',
		'%2A' => '*',
		'%27' => "'",
		'%28' => '(',
		'%29' => ')',
	];

	return strtr( rawurlencode( $str ), $revert );
}
