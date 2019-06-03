<?php

add_filter(
	'nav_menu_item_title',
	function ( $item_output, $item, $depth, $args ) {
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join(' ', array_filter($classes));

		if ( strpos( $class_names, 'has-childre' ) !== false ) {
			return $item_output . '<span class="menu-arrow"><svg width="8" height="8" viewBox="0 0 15 15"><path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/></svg></span>';
		}

		return $item_output;
	},
	10,
	4
);

