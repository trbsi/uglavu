<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blocksy
 */

$columns_output = '';

$footer_section_1 = get_theme_mod(
	'footer_section_1',
	'footer_menu'
);

$footer_section_2 = get_theme_mod(
	'footer_section_2',
	'disabled'
);

if ( $footer_section_1 !== 'disabled' && $footer_section_2 !== 'disabled' ) {
	$columns_output = 'data-columns="2"';
} else {
	if ( $footer_section_1 !== 'disabled' || $footer_section_2 !== 'disabled' ) {
		$columns_output = 'data-columns="1"';
	}
}

blocksy_footer_main_area_sections_cache();

$primary_area_class = 'footer-primary-area';

$primary_area_class .= ' ' . blocksy_visibility_classes(
	get_theme_mod('footer_primary_area_visibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	])
);

$container_class = 'ct-container';

if (get_theme_mod('footer_main_area_container', 'fixed') !== 'fixed') {
	$container_class = 'ct-container-fluid';
}

$main_area_stacking_output = blocksy_stacking(
	get_theme_mod('footer_main_area_stacking', [
		'tablet' => true,
		'mobile' => true,
	])
);

$reveal_output = '';

if (get_theme_mod('footer_reveal', 'no') === 'yes') {
	$reveal_output = 'data-footer-reveal="no"';
}

?>

	</main>

	<footer
		class="site-footer"
		<?php echo wp_kses_post($reveal_output) ?>
		<?php blocksy_schema_org_definitions_e('footer') ?>>

		<div
			class="footer-inner"
			data-type="<?php echo esc_attr(get_theme_mod( 'footer_base', 'type-2' )); ?>">

			<?php blocksy_output_footer_widgets(); ?>

			<?php ob_start(); ?>

			<section class="<?php echo esc_attr($primary_area_class); ?>">
				<div class="<?php echo esc_attr($container_class) ?>">
					<div
						class="grid-columns"
						<?php echo wp_kses_post($columns_output); ?>
						<?php echo wp_kses_post($main_area_stacking_output); ?>>
						<?php

							/**
							 * Note to code reviewers: This lines doesn't need to be escaped.
							 * Function blocksy_footer_main_area_section() used
							 * here escapes the value properly.
							 */
							echo blocksy_footer_main_area_section( '1' );
							echo blocksy_footer_main_area_section( '2' );
						?>
					</div>
				</div>
			</section>

			<?php
				$main_area_output = ob_get_clean();

				if ( get_theme_mod( 'has_primary_area', 'yes' ) === 'yes' ) {
					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * $main_area_output var used here  is already escaped properly.
					 */
					echo $main_area_output;
				}

				blocksy_add_customizer_preview_cache(
					function () use ($main_area_output) {
						return blocksy_html_tag(
							'div',
							[ 'data-id' => 'footer-main-area-wrapper' ],
							$main_area_output
						);
					}
				);
				?>

			<?php
				ob_start();

				$class = 'footer-copyright';

				$class .= ' ' . blocksy_visibility_classes(get_theme_mod('copyright_visibility', [
					'desktop' => true,
					'tablet' => true,
					'mobile' => true,
				]));

				?>

			<section class="<?php echo esc_attr($class) ?>">
				<div class="ct-container">
					<?php echo wp_kses_post(get_theme_mod( 'copyright_text', '© Blocksy 2019. All Rights Reserved.' )); ?>
				</div>
			</section>

			<?php
				$site_info_output = ob_get_clean();

				if ( get_theme_mod( 'has_copyright', 'no' ) === 'yes' ) {
					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Var $site_info_output used here has the value escaped properly.
					 */
					echo $site_info_output;
				}

				blocksy_add_customizer_preview_cache(
					blocksy_html_tag(
						'div',
						[ 'data-id' => 'footer-copyright' ],
						$site_info_output
					)
				);
			?>

			<?php if (function_exists('blc_output_instagram_section')) { ?>
				<?php
					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Function blc_output_instagram_section() used here escapes the value properly.
					 */
					echo blc_output_instagram_section();
				?>
			<?php } ?>
		</div>
	</footer>

</div>

<?php
	if (get_theme_mod('has_back_top', 'no') === 'yes') {
		blocksy_output_back_to_top_link();
	}

	blocksy_add_customizer_preview_cache(function () {
		return blocksy_html_tag(
			'div',
			['data-id' => 'back-to-top-link'],
			blocksy_collect_and_return(function () {
				blocksy_output_back_to_top_link(true);
			})
		);
	});

?>

<div id="search-modal" class="ct-modal">
	<div class="ct-bag-container">
		<div class="ct-bag-actions">
			<div class="ct-bag-close">
				<span class="lines-button close"></span>
			</div>
		</div>

		<div class="ct-bag-content" data-align="middle">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>

<a class="skip-link screen-reader-text" href="#primary">
<?php _e( 'Skip to content', 'blocksy' ); ?></a>

<?php if (function_exists('blocksy_ext_cookies_consent_output')) { ?>
	<?php
		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * Function blocksy_ext_cookies_consent_output() used here escapes the value properly.
		 */
		echo blocksy_ext_cookies_consent_output();
	?>
<?php } ?>

<?php

$b = new Blocksy_Customizer_Builder();
echo $b->render_offcanvas();

?>

<?php wp_footer(); ?>

</body>
</html>
