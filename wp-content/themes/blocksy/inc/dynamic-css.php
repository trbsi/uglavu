<?php
/**
 * Dynamic CSS helpers
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

add_action('admin_print_styles', function () {
	global $wp_customize;

	$css = new Blocksy_Css_Injector();

	blocksy_theme_get_dynamic_styles('admin-global', [
		'css' => $css,
	]);

	/**
	 * Note to code reviewers: This line doesn't need to be escaped.
	 * The variable used here has the value escaped properly.
	 */
	echo '<style id="ct-main-styles-inline-css" type="text/css">';
	echo trim($css->build_css_structure());
	echo "</style>\n";
});

add_action(
	'wp_print_styles',
	function () {
		$css = new Blocksy_Css_Injector();
		$mobile_css = new Blocksy_Css_Injector();
		$tablet_css = new Blocksy_Css_Injector();

		blocksy_theme_get_dynamic_styles('global', [
			'css' => $css,
			'mobile_css' => $mobile_css,
			'tablet_css' => $tablet_css,
		]);

		do_action(
			'blocksy:global-dynamic-css:enqueue',
			$css,
			$tablet_css,
			$mobile_css
		);

		/**
		 * Note to code reviewers: This line doesn't need to be escaped.
		 * The variable used here has the value escaped properly.
		 */
		echo '<style id="ct-main-styles-inline-css" type="text/css">';
		echo trim( $css->build_css_structure() );
		echo "</style>\n";

		$tablet_css = trim( $tablet_css->build_css_structure() );
		$mobile_css = trim( $mobile_css->build_css_structure() );

		if ( ! empty( trim( $tablet_css ) ) ) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-tablet-inline-css" type="text/css" media="(max-width: 1000px) and (min-width: 690px)">';
			echo $tablet_css;
			echo "</style>\n";
		}

		if ( ! empty( trim( $mobile_css ) ) ) {
			/**
			 * Note to code reviewers: This line doesn't need to be escaped.
			 * The variable used here has the value escaped properly.
			 */
			echo '<style id="ct-main-styles-mobile-inline-css" type="text/css" media="(max-width: 690px)">';
			echo $mobile_css;
			echo "</style>\n";
		}
	}
);


/**
 * Evaluate a file with dynamic styles.
 *
 * @param string $name Name of dynamic CSS file.
 * @param array $variables list of data to pass in file.
 * @throws Error When $css not provided.
 */
function blocksy_theme_get_dynamic_styles( $name, $variables = array() ) {
	if ( ! isset( $variables['css'] ) ) {
		throw new Error( '$css instance not provided. This is required!' );
	}

	$dynamic_style = get_template_directory() . '/inc/dynamic-styles/' . $name . '.php';

	if (! $dynamic_style) {
		return;
	}

	blocksy_get_variables_from_file( $dynamic_style, array(), $variables );
}

