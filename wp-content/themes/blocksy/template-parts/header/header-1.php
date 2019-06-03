<?php

if (! isset($for_preview)) {
	$for_preview = false;
}

$container_class = (
	get_theme_mod( 'header_container', 'fixed' ) === 'fixed'
) ? 'ct-container' : 'ct-container-fluid';

$menu_alignment = get_theme_mod('menu_alignment', 'right');

$class = 'search-button';

$search_visibility = get_theme_mod('header_search_visibility', [
	'desktop' => true,
	'tablet' => true,
	'mobile' => false,
]);

$class .= ' ' . blocksy_visibility_classes($search_visibility);

?>

<div class="header-desktop" data-type="type-1">
	<div class="<?php echo esc_attr($container_class) ?>" data-menu-alignment="<?php echo esc_attr($menu_alignment) ?>">

		<?php blocksy_output_site_branding(); ?>

		<?php blocksy_header_main_menu(); ?>

		<div class="header-group">
			<a href="#search-modal" class="<?php echo esc_attr($class) ?>">
				<svg width="12" height="12" viewBox="0 0 50 50">
					<path d="M48.6,48.6c-1.8,1.8-4.8,1.8-6.6,0l-8.3-8.3c-3.4,2.2-7.4,3.5-11.8,3.5C9.8,43.8,0,34,0,21.9S9.8,0,21.9,0
					C34,0,43.8,9.8,43.8,21.9c0,4.3-1.3,8.4-3.5,11.8l8.3,8.3C50.5,43.8,50.5,46.8,48.6,48.6z M21.9,6.3c-8.6,0-15.7,7-15.7,15.7
					s7,15.7,15.7,15.7c8.6,0,15.7-7,15.7-15.7C37.6,13.3,30.6,6.3,21.9,6.3z"/>
				</svg>
			</a>

			<?php
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_output_woo_mini_cart() used here escapes the value properly.
				 */
				echo blocksy_output_woo_mini_cart($for_preview);

				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_output_woo_mini_cart() used here escapes the value properly.
				 */
				echo blocksy_output_cta_header_button();
			?>
		</div>
	</div>
</div>
