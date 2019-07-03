<?php
/**
 * Blocksy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blocksy
 */

if ( version_compare( PHP_VERSION, '5.7.0', '<' ) ) {
	require get_template_directory() . '/inc/php-fallback.php';
	return;
}

require get_template_directory() . '/inc/init.php';
require get_template_directory() . '/custom-functions/scrape-og-tags.php';
require get_template_directory() . '/custom-functions/save-og-tags.php';
require get_template_directory() . '/custom-functions/custom-queries.php';
require get_template_directory() . '/custom-functions/custom-excerpt.php';

