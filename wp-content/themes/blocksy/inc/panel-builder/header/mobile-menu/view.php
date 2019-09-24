<?php

$attr['data-type'] = blocksy_default_akg('mobile_menu_type', $atts, 'type-1');

ob_start();

wp_nav_menu(
	[
		'menu' => blocksy_default_akg(
			'menu',
			$atts,
			blocksy_get_default_menu()
		),
		'container' => false,
		'menu_class' => false,
		'fallback_cb' => 'blocksy_main_menu_fallback',
	]
);

$menu_output = ob_get_clean();

$class = 'mobile-menu';

if ( strpos( $menu_output, 'sub-menu' ) ) {
	$class .= ' has-submenu';
}

?>

<nav class="<?php echo $class ?>" <?php echo blocksy_attr_to_html($attr) ?>>
	<?php echo $menu_output ?>
</nav>
