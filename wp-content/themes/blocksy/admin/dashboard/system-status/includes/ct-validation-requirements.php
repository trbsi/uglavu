<?php
/**
 * Validation requirements
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

return array(
	'php-version' => array(
		'value' => '5.6.0',
		'error' => __( 'You have an old PHP version, required PHP version is :required+', 'blocksy' ),
	),

	'php-post-max-size' => array(
		'value' => '32M',
		'error' => __( 'Required max post size is :required', 'blocksy' ),
	),

	'php-max-execution-time' => array(
		'value' => 45,
		'error' => __( 'Required max execution time is :requireds.', 'blocksy' ),
	),

	'php-safe-mode' => array(
		'value' => false,
		'error' => __( 'Safe Mode must be enabled.', 'blocksy' ),
	),

	'php-memory-limit' => array(
		'value' => '100M',
		'error' => __( 'Required memory limit is :required', 'blocksy' ),
	),

	'wp-version' => array(
		'value' => '4.6.2',
		'error' => __( 'You have an old WordPress version, ', 'blocksy' ),
	),

	'wp-debug' => array(
		'value' => false,
		'error' => __( 'Displays whether or not WordPress is in Debug Mode.', 'blocksy' ),
	),

	'wp-memory-limit' => array(
		'value' => '64M',
		'error' => __( 'Recommended Memory Limit is :required', 'blocksy' ),
	),

	'wp-fs-method' => array(
		'value' => true,
		'error' => __( 'Recommended Filesystem Method (FS_METHOD) is `direct`', 'blocksy' ),
	),

	'wp-is-plugins-writable' => array(
		'value' => true,
		'error' => __( 'Write access to plugins folder is required', 'blocksy' ),
	),

	'php-display-errors' => array(
		'value' => false,
		'error' => __( 'We recommend you to display php errors only in test mode.', 'blocksy' ),
	),

	'php-ziparchive' => array(
		'value' => true,
		'error' => __( 'ZipArchive is required for importing demos. They are used to import and export zip files specifically for sliders.', 'blocksy' ),
	),

	'mysql-version' => array(
		'value' => '5.5.0',
		'error' => __( 'You have an old MySQL version, required version is :required+', 'blocksy' ),
	),
);

