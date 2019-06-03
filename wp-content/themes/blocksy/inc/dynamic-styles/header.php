<?php

$transparent_header_source = blocksy_get_transparent_header_source();


// default state
$headerBackground = blocksy_get_colors( get_theme_mod(
	'headerBackground',
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--headerBackground: {$headerBackground['default']}"
);


// transparent state
$transparentHeaderBackground = blocksy_get_colors( blocksy_akg_or_customizer(
	'transparentHeaderBackground',
	$transparent_header_source,
	[ 'default' => [ 'color' => 'rgba(255, 255, 255, 0.1)' ] ]
));

$css->put(
	':root',
	"--transparentHeaderBackground: {$transparentHeaderBackground['default']}"
);



$mobileHeaderBackground = blocksy_get_colors( get_theme_mod(
	'mobileHeaderBackground',
	[ 'default' => [ 'color' => 'var(--paletteColor5)' ] ]
));

$css->put(
	':root',
	"--mobileHeaderBackground: {$mobileHeaderBackground['default']}"
);



// Logo
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'logoMaxHeight',
	'value' => get_theme_mod('logoMaxHeight', [
		'mobile' => 50,
		'tablet' => 50,
		'desktop' => 50,
	])
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'transparentLogoMaxHeight',
	'value' => get_theme_mod('transparentLogoMaxHeight', [
		'mobile' => 50,
		'tablet' => 50,
		'desktop' => 50,
	])
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'headerLogoContainerHeight',
	'unit' => '',
	'value' => get_theme_mod('headerLogoContainerHeight', [
		'mobile' => '35px',
		'tablet' => '35px',
		'desktop' => '110px',
	]),
]);

// Header

$headerShadow = blocksy_get_colors( get_theme_mod(
	'headerShadow',
	[ 'default' => [ 'color' => 'rgba(210, 213, 218, 0.15)' ] ]
));

$css->put(
	':root',
	"--headerShadow: {$headerShadow['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'headerHeight',
	'value' => get_theme_mod('headerHeight', [
		'mobile' => '35px',
		'tablet' => '35px',
		'desktop' => '120px',
	]),
	'unit' => ''
]);


// main menu
$menuFontColor = blocksy_get_colors( get_theme_mod(
	'menuFontColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'active' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.site-header',
	"--menuInitialColor: {$menuFontColor['default']}"
);

$css->put(
	'.site-header',
	"--menuActiveColor: {$menuFontColor['active']}"
);

$css->put(
	'.site-header',
	"--menuHoverColor: {$menuFontColor['hover']}"
);


$transparentHeaderFontColor = blocksy_get_colors( blocksy_akg_or_customizer(
	'transparentHeaderFontColor',
	$transparent_header_source,
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	':root',
	"--transparentHeaderInitialFontColor: {$transparentHeaderFontColor['default']}"
);

$css->put(
	':root',
	"--transparentHeaderHoverFontColor: {$transparentHeaderFontColor['hover']}"
);



$headerMenuItemsSpacing = get_theme_mod( 'headerMenuItemsSpacing', 25 );
$css->put(
	'.header-desktop',
	'--menuItemsSpacing: ' . $headerMenuItemsSpacing . 'px'
);


$navSectionBackground = blocksy_get_colors( get_theme_mod(
	'navSectionBackground',
	[ 'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ] ]
));

$css->put(
	':root',
	"--navSectionBackground: {$navSectionBackground['default']}"
);

$dropdownFontColor = blocksy_get_colors( get_theme_mod(
	'dropdownFontColor',
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.primary-menu .sub-menu',
	"--menuInitialColor: {$dropdownFontColor['default']}"
);

$css->put(
	'.primary-menu .sub-menu',
	"--menuHoverColor: {$dropdownFontColor['hover']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'navSectionHeight',
	'unit' => '',
	'value' => get_theme_mod('navSectionHeight', [
		'mobile' => '15px',
		'tablet' => '15px',
		'desktop' => '60px',
	]),
]);

$dropdownTopOffset = get_theme_mod( 'dropdownTopOffset', 15 );
$css->put(
	':root',
	'--dropdownTopOffset: ' . $dropdownTopOffset . 'px'
);

$dropdownMenuWidth = get_theme_mod( 'dropdownMenuWidth', 200 );
$css->put(
	':root',
	'--dropdownMenuWidth: ' . $dropdownMenuWidth . 'px'
);

blocksy_output_border([
	'css' => $css,
	'selector' => ':root',
	'variableName' => 'dropDownDivider',
	'value' => get_theme_mod('dropDownDivider', [
		'width' => 1,
		'style' => 'dashed',
		'color' => [
			'color' => 'rgba(255, 255, 255, 0.1)',
		],
	])
]);

$dropDownBackground = blocksy_get_colors( get_theme_mod(
	'dropDownBackground',
	[ 'default' => [ 'color' => '#29333C' ] ]
));

$css->put(
	':root',
	"--dropDownBackground: {$dropDownBackground['default']}"
);


// Top bar
$topBarFontColor = blocksy_get_colors( get_theme_mod(
	'topBarFontColor',
	[
		'default' => [ 'color' => 'rgba(255, 255, 255, 0.8)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.header-top-bar',
	"--linkInitialColor: {$topBarFontColor['default']}"
);

$css->put(
	'.header-top-bar',
	"--linkHoverColor: {$topBarFontColor['hover']}"
);

$topBarBackground = blocksy_get_colors( get_theme_mod(
	'topBarBackground',
	[ 'default' => [ 'color' => '#29333d' ] ]
));

$css->put(
	':root',
	"--topBarBackground: {$topBarBackground['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.header-top-bar-menu',
	'variableName' => 'menuItemsSpacing',
	'value' => get_theme_mod('topBarMenuItemsSpacing', [
		'mobile' => 20,
		'tablet' => 20,
		'desktop' => 20,
	])
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'topBarHeight',
	'value' => get_theme_mod( 'topBarHeight', 40 ),
	'respect_visibility' => get_theme_mod('top_bar_visibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	]),
	'enabled' => blocksy_has_top_bar() ? 'yes' : 'no'
]);

// Mobile header
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'mobileHeaderHeight',
	'value' => get_theme_mod('mobileHeaderHeight', [
		'mobile' => '70px',
		'tablet' => '70px',
		'desktop' => '70px',
	]),
	'unit' => ''
]);


$mobileMenuIconColor = blocksy_get_colors( get_theme_mod(
	'mobileMenuIconColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.mobile-menu-toggle',
	"--linkInitialColor: {$mobileMenuIconColor['default']}"
);

$css->put(
	'.mobile-menu-toggle',
	"--linkHoverColor: {$mobileMenuIconColor['hover']}"
);


$mobileMenuLinkColor = blocksy_get_colors( get_theme_mod(
	'mobileMenuLinkColor',
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'#mobile-menu',
	"--menuInitialColor: {$mobileMenuLinkColor['default']}"
);

$css->put(
	'#mobile-menu',
	"--menuHoverColor: {$mobileMenuLinkColor['hover']}"
);

$mobileMenuBackground = blocksy_get_colors( get_theme_mod(
	'mobileMenuBackground',
	[ 'default' => [ 'color' => 'rgba(18, 21, 25, 0.98)' ] ]
));

$css->put(
	'#mobile-menu',
	"--modalBackground: {$mobileMenuBackground['default']}"
);

$mobileMenulogoMaxHeight = get_theme_mod( 'mobileMenulogoMaxHeight', 50 );
$css->put(
	'#mobile-menu .custom-logo',
	'--logoMaxHeight: ' . $mobileMenulogoMaxHeight . 'px'
);

// Off-Canvas
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'offCanvasWidth',
	'value' => get_theme_mod('offCanvasWidth', [
		'mobile' => '250px',
		'tablet' => '280px',
		'desktop' => '280px',
	]),
	'unit' => ''
]);

// Header Search Modal
$searchHeaderIconColor = blocksy_get_colors( get_theme_mod(
	'searchHeaderIconColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.search-button',
	"--linkInitialColor: {$searchHeaderIconColor['default']}"
);

$css->put(
	'.search-button',
	"--linkHoverColor: {$searchHeaderIconColor['hover']}"
);


$searchHeaderBackground = blocksy_get_colors( get_theme_mod(
	'searchHeaderBackground',
	[ 'default' => [ 'color' => 'rgba(18, 21, 25, 0.98)' ] ]
));

$css->put(
	'#search-modal',
	"--modalBackground: {$searchHeaderBackground['default']}"
);

$searchHeaderLinkColor = blocksy_get_colors( get_theme_mod(
	'searchHeaderLinkColor',
	[
		'default' => [ 'color' => 'var(--paletteColor5)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'#search-modal',
	"--linkInitialColor: {$searchHeaderLinkColor['default']}"
);

$css->put(
	'#search-modal',
	"--linkHoverColor: {$searchHeaderLinkColor['hover']}"
);


// Header Cart
$cartHeaderIconColor = blocksy_get_colors( get_theme_mod(
	'cartHeaderIconColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.ct-cart-icon',
	"--linkInitialColor: {$cartHeaderIconColor['default']}"
);

$css->put(
	'.ct-cart-icon',
	"--linkHoverColor: {$cartHeaderIconColor['hover']}"
);


$cartBadgeColor = blocksy_get_colors( get_theme_mod(
	'cartBadgeColor',
	[
		'background' => [ 'color' => 'var(--paletteColor1)' ],
		'text' => [ 'color' => '#ffffff' ],
	]
));

$css->put(
	'.ct-header-cart',
	"--cartBadgeBackground: {$cartBadgeColor['background']}"
);

$css->put(
	'.ct-header-cart',
	"--cartBadgeText: {$cartBadgeColor['text']}"
);


$cartFontColor = blocksy_get_colors( get_theme_mod(
	'cartFontColor',
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.ct-cart-content',
	"--linkInitialColor: {$cartFontColor['default']}"
);

$css->put(
	'.ct-cart-content',
	"--linkHoverColor: {$cartFontColor['hover']}"
);

$cartDropDownBackground = blocksy_get_colors( get_theme_mod(
	'cartDropDownBackground',
	[ 'default' => [ 'color' => '#29333C' ] ]
));

$css->put(
	'.ct-cart-content',
	"--cartDropDownBackground: {$cartDropDownBackground['default']}"
);


// CTA button
$headerButtonFont = blocksy_get_colors( get_theme_mod(
	'headerButtonFont',
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	]
));

$css->put(
	'.ct-header-button',
	"--linkInitialColor: {$headerButtonFont['default']}"
);

$css->put(
	'.ct-header-button',
	"--linkHoverColor: {$headerButtonFont['hover']}"
);

$headerButtonBackground = blocksy_get_colors( get_theme_mod(
	'headerButtonBackground',
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
));

$css->put(
	'.ct-header-button',
	"--buttonInitialColor: {$headerButtonBackground['default']}"
);

$css->put(
	'.ct-header-button',
	"--buttonHoverColor: {$headerButtonBackground['hover']}"
);

$headerButtonRadius = get_theme_mod( 'headerButtonRadius', 5 );
$css->put( ':root', '--headerButtonRadius: ' . $headerButtonRadius . 'px' );



// Header border
blocksy_output_border([
	'css' => $css,
	'selector' => ':root',
	'variableName' => 'headerTopBorder',
	'value' => get_theme_mod('headerTopBorder', [
		'width' => 1,
		'style' => 'dashed',
		'color' => [
			'color' => 'rgba(44,62,80,0.2)',
		],
	])
]);

blocksy_output_border([
	'css' => $css,
	'selector' => ':root',
	'variableName' => 'headerBottomBorder',
	'value' => get_theme_mod('headerBottomBorder', [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(44,62,80,0.2)',
		],
	])
]);


