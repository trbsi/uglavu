<?php

defined( 'ABSPATH' ) || die( "Don't run this file directly!" );

add_filter(
	'excerpt_length',
	function ( $length ) {
		return 100;
	}
);

/**
 * @param number $length Number of words allowed in excerpt.
 */
function blocksy_trim_excerpt( $excerpt, $length ) {
	//CUSTOM START
	$excerpt = explode(' ', $excerpt, $length);

	if (count($excerpt) >= $length) {
		array_pop($excerpt);
		$excerpt = implode(" ", $excerpt).'...';
	} else {
		$excerpt = implode(" ", $excerpt);
	}

	$excerpt = preg_replace('`[[^]]*]`', '', $excerpt);
	
	echo wp_kses_post($excerpt);
	//CUSTOM END
}

add_filter(
	'excerpt_more',
	function () {
		return '…';
	}
);

