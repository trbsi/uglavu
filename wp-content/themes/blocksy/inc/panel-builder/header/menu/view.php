<?php

if (empty($class)) {
	$class = 'header-menu-1';
}

$responsive_output = 'data-responsive';

$stretch_output = '';

if (blocksy_default_akg('stretch_menu', $atts, 'no') === 'yes') {
	$stretch_output = 'data-stretch';
}

$menu_type = blocksy_default_akg('header_menu_type', $atts, 'type-1');
$dropdown_animation = blocksy_default_akg('dropdown_animation', $atts, 'type-1');

?>

<nav
	class="<?php echo esc_attr($class) ?>"
	<?php echo blocksy_attr_to_html($attr) ?>
	data-type="<?php echo esc_attr($menu_type) ?>"
	data-dropdown-animation="<?php echo esc_attr($dropdown_animation) ?>"
	<?php echo $stretch_output ?>
	<?php echo wp_kses_post($responsive_output) ?>
	<?php blocksy_schema_org_definitions_e('navigation') ?>>

	<?php
		wp_nav_menu(
			[
				'menu' => blocksy_default_akg('menu', $atts, blocksy_get_default_menu()),
				'container'      => false,
				'menu_class'     => 'menu',
				'fallback_cb'    => 'blocksy_main_menu_fallback',
			]
		);
	?>

</nav>

<?php
