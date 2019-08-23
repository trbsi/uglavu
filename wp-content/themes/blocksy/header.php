<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blocksy
 */

$header_type = get_theme_mod( 'header_type', 'type-1' );

$template = 'template-parts/header/' . (
	str_replace('type', 'header', $header_type)
);

ob_start();

if ( is_customize_preview() ) {
	$for_preview = true;
	include locate_template( 'template-parts/header/header-1.php' );
	$for_preview = false;
}

$type_1_output = ob_get_clean();

ob_start();

if ( is_customize_preview() ) {
	$for_preview = true;
	include locate_template( 'template-parts/header/header-2.php' );
	$for_preview = false;
}

$type_2_output = ob_get_clean();

blocksy_add_customizer_preview_cache(
	function () use ($type_1_output, $type_2_output) {
		return blocksy_html_tag(
			'div',
			[ 'data-id' => 'header' ],
			blocksy_html_tag( 'div', [ 'data-type' => 'type-1' ], $type_1_output ) .
			blocksy_html_tag( 'div', [ 'data-type' => 'type-2' ], $type_2_output )
		);
	}
);

blocksy_add_customizer_preview_cache(
	function () {
		if (blocksy_has_custom_top_bar()) {
			return '';
		}

		return blocksy_html_tag(
			'div',
			[ 'data-id' => 'header-top-bar' ],
			blocksy_output_header_top_bar()
		);
	}
);

blocksy_header_top_bar_sections_cache();

$transparent_border_output = '';

$header_bottom_border = get_theme_mod('headerBottomBorder', [
	'width' => 1,
	'style' => 'none',
	'color' => [
		'color' => 'rgba(18, 21, 25, 0.98)',
	],
]);

if (blocksy_akg('style', $header_bottom_border) !== 'none') {
	$transparent_border_output = 'data-border="' . (
		get_theme_mod('headerBottomBorderContainer', 'no') === 'yes' ? 'full-width' : 'contained'
	) . '"';
}

$stacking_output = '';

if (blocksy_has_top_bar()) {
	if (
		get_theme_mod(
			'header_top_bar_section_1',
			'header_menu'
		) !== 'disabled' && get_theme_mod(
			'header_top_bar_section_2',
			'disabled'
		) !== 'disabled'
	) {
		$stacking_output = blocksy_stacking(
			get_theme_mod('top_bar_stacking', [
				'tablet' => false,
				'mobile' => true,
			]),
			'data-top-bar-stack'
		);
	}
}


$transparent_output = '';

if (blocksy_has_transparent_header()) {
	$transparent_output = blocksy_stacking(
		get_theme_mod('transparent_header_visibility', [
			'desktop' => true,
			'tablet' => true,
			'mobile' => false,
		]),
		'data-transparent-header'
	);
}

if (is_customize_preview()) {
	if (blocksy_header_has_custom_transparency()) {
		blocksy_add_customizer_preview_cache(
			blocksy_html_tag(
				'div',
				['data-transparent-header-custom' => blocksy_header_get_transparency()],
				''
			)
		);
	}

	if (!blocksy_has_transparent_header(true)) {
		blocksy_add_customizer_preview_cache(
			blocksy_html_tag(
				'div',
				['data-transparent-forced-by-checkboxes' => ''],
				''
			)
		);
	}
}

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php echo wp_kses_post($transparent_output) ?>>

<?php
	if (function_exists('wp_body_open')) {
		wp_body_open();
	}
?>

<a class="skip-link screen-reader-text" href="#primary">
<?php _e( 'Skip to content', 'blocksy' ); ?></a>

<div id="main-container">

	<header
		class="site-header"
		<?php blocksy_schema_org_definitions_e('header') ?>
		<?php echo wp_kses_post($stacking_output) ?>
		<?php echo wp_kses_post($transparent_border_output) ?>>
		<?php
			if (
				blocksy_has_top_bar() || (
					isset( $for_preview ) && $for_preview
				)
			) {
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blocksy_output_header_top_bar() used here escapes the value properly.
				 */
				echo blocksy_output_header_top_bar();
			}
		?>

		<?php get_template_part( $template ); ?>
		<?php get_template_part( 'template-parts/header/mobile' ); ?>
	</header>

	<main id="main" class="site-main">

		<?php if (function_exists('blc_output_read_progress_bar')) { ?>
			<?php
				/**
				 * Note to code reviewers: This line doesn't need to be escaped.
				 * Function blc_output_read_progress_bar() used here escapes the value properly.
				 */
				echo blc_output_read_progress_bar()
			?>
		<?php } ?>
