<?php

blocksy_theme_get_dynamic_styles('typography', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

blocksy_theme_get_dynamic_styles('page-title', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

blocksy_theme_get_dynamic_styles('posts-listing', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

blocksy_theme_get_dynamic_styles('site-background', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

blocksy_theme_get_dynamic_styles('woocommerce', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

blocksy_theme_get_dynamic_styles('header', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

// Color palette
$colorPalette = blocksy_get_colors( get_theme_mod( 'colorPalette',
	[
		'color1' => [ 'color' => '#3eaf7c' ],
		'color2' => [ 'color' => '#33a370' ],
		'color3' => [ 'color' => 'rgba(44, 62, 80, 0.9)' ],
		'color4' => [ 'color' => 'rgba(44, 62, 80, 1)' ],
		'color5' => [ 'color' => '#ffffff' ],
	]
));


$css->put(
	':root',
	"--paletteColor1: {$colorPalette['color1']}"
);

$css->put(
	':root',
	"--paletteColor2: {$colorPalette['color2']}"
);

$css->put(
	':root',
	"--paletteColor3: {$colorPalette['color3']}"
);

$css->put(
	':root',
	"--paletteColor4: {$colorPalette['color4']}"
);

$css->put(
	':root',
	"--paletteColor5: {$colorPalette['color5']}"
);

// Colors
$font_color = blocksy_get_colors( get_theme_mod( 'fontColor',
	[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
));

$css->put(
	':root',
	"--fontColor: {$font_color['default']}"
);

// Headings
$h1Color = blocksy_get_colors( get_theme_mod( 'h1Color',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'h1',
	"--fontColor: {$h1Color['default']}"
);

$h2Color = blocksy_get_colors( get_theme_mod( 'h2Color',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'h2',
	"--fontColor: {$h2Color['default']}"
);

$h3Color = blocksy_get_colors( get_theme_mod( 'h3Color',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'h3',
	"--fontColor: {$h3Color['default']}"
);

$h4Color = blocksy_get_colors( get_theme_mod( 'h4Color',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'h4',
	"--fontColor: {$h4Color['default']}"
);

$h5Color = blocksy_get_colors( get_theme_mod( 'h5Color',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'h5',
	"--fontColor: {$h5Color['default']}"
);

$h6Color = blocksy_get_colors( get_theme_mod( 'h6Color',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'h6',
	"--fontColor: {$h6Color['default']}"
);



$link_color = blocksy_get_colors( get_theme_mod( 'linkColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	':root',
	"--linkInitialColor: {$link_color['default']}"
);

$css->put(
	':root',
	"--linkHoverColor: {$link_color['hover']}"
);


$button_color = blocksy_get_colors( get_theme_mod( 'buttonColor',
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
));

$css->put(
	':root',
	"--buttonInitialColor: {$button_color['default']}"
);

$css->put(
	':root',
	"--buttonHoverColor: {$button_color['hover']}"
);

$site_background = blocksy_get_colors( get_theme_mod( 'siteBackground',
	[ 'default' => [ 'color' => '#f8f9fb' ] ]
));

$css->put(
	':root',
	"--siteBackground: {$site_background['default']}"
);


// Layout
$max_site_width = get_theme_mod( 'maxSiteWidth', 1290 );
$css->put( ':root', '--maxSiteWidth: ' . $max_site_width . 'px' );

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'contentAreaSpacing',
	'unit' => '',
	'value' => get_theme_mod('contentAreaSpacing', [
		'mobile' => '50px',
		'tablet' => '60px',
		'desktop' => '80px',
	])
]);

$narrowContainerWidth = get_theme_mod( 'narrowContainerWidth', 60 );
$css->put( ':root', '--narrowContainerWidth: ' . $narrowContainerWidth . '%' );

$wideOffset = get_theme_mod( 'wideOffset', 130 );
$css->put( ':root', '--wideOffset: ' . $wideOffset . 'px' );


// Sidebar
$sidebar_width = get_theme_mod( 'sidebarWidth', '27' );
$css->put( ':root', '--sidebarWidth: ' . $sidebar_width . '%' );

$css->put( ':root', '--sidebarWidthNoUnit: ' . intval($sidebar_width) );


$sidebarGap = blocksy_get_with_percentage( 'sidebarGap', '4%' );
$css->put( ':root', '--sidebarGap: ' . $sidebarGap );

$sidebarOffset = get_theme_mod( 'sidebarOffset', '50' );
$css->put( ':root', '--sidebarOffset: ' . $sidebarOffset . 'px' );


$sidebar_widgets_title_color = blocksy_get_colors( get_theme_mod(
	'sidebarWidgetsTitleColor',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'.ct-sidebar',
	"--widgetsTitleColor: {$sidebar_widgets_title_color['default']}"
);

$sidebar_widgets_font_color = blocksy_get_colors( get_theme_mod(
	'sidebarWidgetsFontColor',
	[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
));

$css->put(
	'.ct-sidebar',
	"--widgetsFontColor: {$sidebar_widgets_font_color['default']}"
);

$sidebar_widgets_link = blocksy_get_colors( get_theme_mod(
	'sidebarWidgetsLink',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.ct-sidebar',
	"--linkInitialColor: {$sidebar_widgets_link['default']}"
);

$css->put(
	'.ct-sidebar',
	"--linkHoverColor: {$sidebar_widgets_link['hover']}"
);


$sidebar_background_color = blocksy_get_colors( get_theme_mod(
	'sidebarBackgroundColor',
	[ 'default' => [ 'color' => 'var(--paletteColor5)' ] ]
));

$css->put(
	':root',
	"--sidebarBackgroundColor: {$sidebar_background_color['default']}"
);

$sidebarBorderColor = blocksy_get_colors( get_theme_mod(
	'sidebarBorderColor',
	[ 'default' => [ 'color' => 'rgba(224, 229, 235, 0.8)' ] ]
));

$css->put(
	':root',
	"--sidebarBorderColor: {$sidebarBorderColor['default']}"
);

$sidebarBorderSize = get_theme_mod( 'sidebarBorderSize', 0 );
$css->put( ':root', '--sidebarBorderSize: ' . $sidebarBorderSize . 'px' );


$sidebarDividerColor = blocksy_get_colors( get_theme_mod(
	'sidebarDividerColor',
	[ 'default' => [ 'color' => 'rgba(224, 229, 235, 0.8)' ] ]
));

$css->put(
	':root',
	"--sidebarDividerColor: {$sidebarDividerColor['default']}"
);

$sidebarDividerSize = get_theme_mod( 'sidebarDividerSize', 1 );
$css->put( ':root', '--sidebarDividerSize: ' . $sidebarDividerSize . 'px' );


blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'sidebarWidgetsSpacing',
	'value' => get_theme_mod('sidebarWidgetsSpacing', [
		'mobile' => 30,
		'tablet' => 40,
		'desktop' => 60,
	])
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ":root",
	'variableName' => 'sidebarInnerSpacing',
	'value' => get_theme_mod('sidebarInnerSpacing', [
		'mobile' => 35,
		'tablet' => 35,
		'desktop' => 35,
	])
]);


// Pagination
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'paginationSpacing',
	'value' => get_theme_mod('paginationSpacing', [
		'mobile' => 50,
		'tablet' => 60,
		'desktop' => 80,
	])
]);

$paginationFontColor = blocksy_get_colors( get_theme_mod(
	'paginationFontColor',
	[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
));

$css->put(
	':root',
	"--paginationFontColor: {$paginationFontColor['default']}"
);


$paginationAccentColor = blocksy_get_colors( get_theme_mod(
	'paginationAccentColor',
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
));

$css->put(
	':root',
	"--paginationAccentInitialColor: {$paginationAccentColor['default']}"
);

$css->put(
	':root',
	"--paginationAccentHoverColor: {$paginationAccentColor['hover']}"
);


blocksy_output_border([
	'css' => $css,
	'selector' => ':root',
	'variableName' => 'paginationDivider',
	'value' => get_theme_mod('paginationDivider', [
		'width' => 1,
		'style' => 'none',
		'color' => [
			'color' => 'rgba(224, 229, 235, 0.5)',
		],
	])
]);

// Related Posts
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ":root",
	'variableName' => 'relatedPostsContainerSpacing',
	'value' => get_theme_mod('relatedPostsContainerSpacing', [
		'mobile' => '30px',
		'tablet' => '50px',
		'desktop' => '70px',
	]),
	'unit' => ''
]);

$related_posts_label_color = blocksy_get_colors( get_theme_mod(
	'relatedPostsLabelColor',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	':root',
	"--relatedPostsLabelColor: {$related_posts_label_color['default']}"
);


$related_posts_link_color = blocksy_get_colors( get_theme_mod(
	'relatedPostsLinkColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.ct-related-posts',
	"--linkInitialColor: {$related_posts_link_color['default']}"
);

$css->put(
	'.ct-related-posts',
	"--linkHoverColor: {$related_posts_link_color['hover']}"
);


$related_posts_meta_color = blocksy_get_colors( get_theme_mod(
	'relatedPostsMetaColor',
	[ 'default' => [ 'color' => '#667380' ] ]
));

$css->put(
	':root',
	"--relatedPostsMetaColor: {$related_posts_meta_color['default']}"
);


$related_posts_container_color = blocksy_get_colors( get_theme_mod(
	'relatedPostsContainerColor',
	[ 'default' => [ 'color' => '#eff1f5' ] ]
));

$css->put(
	':root',
	"--relatedPostsContainerColor: {$related_posts_container_color['default']}"
);


// Comments
$postCommentsBackground = blocksy_get_colors( get_theme_mod(
	'postCommentsBackground',
	[ 'default' => [ 'color' => '#f8f9fb' ] ]
));

$css->put(
	':root',
	"--commentsBackground: {$postCommentsBackground['default']}"
);


// Posts Navigation
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'postNavSpacing',
	'value' => get_theme_mod('postNavSpacing', [
		'mobile' => '40px',
		'tablet' => '60px',
		'desktop' => '80px',
	]),
	'unit' => ''
]);

// Share Box
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'topShareBoxSpacing',
	'value' => get_theme_mod('topShareBoxSpacing', [
		'mobile' => '30px',
		'tablet' => '50px',
		'desktop' => '70px',
	]),
	'unit' => ''
]);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'bottomShareBoxSpacing',
	'value' => get_theme_mod('bottomShareBoxSpacing', [
		'mobile' => '30px',
		'tablet' => '50px',
		'desktop' => '70px',
	]),
	'unit' => ''
]);


$shareItemsIconColor = blocksy_get_colors( get_theme_mod( 'shareItemsIconColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.share-box[data-type="type-1"]',
	"--shareItemsIconInitial: {$shareItemsIconColor['default']}"
);

$css->put(
	'.share-box[data-type="type-1"]',
	"--shareItemsIconHover: {$shareItemsIconColor['hover']}"
);

$shareItemsBorder = blocksy_get_colors( get_theme_mod(
	'shareItemsBorder',
	[ 'default' => [ 'color' => '#e0e5eb' ] ]
));

$css->put(
	':root',
	"--shareItemsBorder: {$shareItemsBorder['default']}"
);



$shareItemsIcon = blocksy_get_colors( get_theme_mod(
	'shareItemsIcon',
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--shareItemsIcon: {$shareItemsIcon['default']}"
);


$shareItemsBackground = blocksy_get_colors( get_theme_mod( 'shareItemsBackground',
	[
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	]
));

$css->put(
	'.share-box[data-type="type-2"]',
	"--shareBoxBackgroundInitial: {$shareItemsBackground['default']}"
);

$css->put(
	'.share-box[data-type="type-2"]',
	"--shareBoxBackgroundHover: {$shareItemsBackground['hover']}"
);


// Post
$postBackground = blocksy_get_colors( get_theme_mod(
	'postBackground',
	[ 'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ] ]
));

$css->put(
	'.single .site-main',
	"--siteBackground: {$postBackground['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'singleContentBoxedSpacing',
	'value' => get_theme_mod('singleContentBoxedSpacing', [
		'mobile' => '40px',
		'tablet' => '40px',
		'desktop' => '40px',
	]),
	'unit' => ''
]);

$singleContentBackground = blocksy_get_colors( get_theme_mod(
	'singleContentBackground',
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--singleContentBackground: {$singleContentBackground['default']}"
);


// Page
$pageBackground = blocksy_get_colors( get_theme_mod(
	'pageBackground',
	[ 'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ] ]
));

$css->put(
	'.page .site-main',
	"--siteBackground: {$pageBackground['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'pageContentBoxedSpacing',
	'value' => get_theme_mod('pageContentBoxedSpacing', [
		'mobile' => '40px',
		'tablet' => '40px',
		'desktop' => '40px',
	]),
	'unit' => ''
]);

$pageContentBackground = blocksy_get_colors( get_theme_mod(
	'pageContentBackground',
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--pageContentBackground: {$pageContentBackground['default']}"
);


// Author Box
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'singleAuthorBoxSpacing',
	'value' => get_theme_mod('singleAuthorBoxSpacing', [
		'mobile' => '40px',
		'tablet' => '40px',
		'desktop' => '40px',
	]),
	'unit' => ''
]);

$singleAuthorBoxBackground = blocksy_get_colors( get_theme_mod(
	'singleAuthorBoxBackground',
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--singleAuthorBoxBackground: {$singleAuthorBoxBackground['default']}"
);

$singleAuthorBoxBorder = blocksy_get_colors( get_theme_mod(
	'singleAuthorBoxBorder',
	[ 'default' => [ 'color' => '#e8ebf0' ] ]
));

$css->put(
	':root',
	"--singleAuthorBoxBorder: {$singleAuthorBoxBorder['default']}"
);

$singleAuthorBoxShadow = blocksy_get_colors( get_theme_mod(
	'singleAuthorBoxShadow',
	[ 'default' => [ 'color' => 'rgba(210, 213, 218, 0.4)' ] ]
));

$css->put(
	':root',
	"--singleAuthorBoxShadow: {$singleAuthorBoxShadow['default']}"
);



// Footer
$footer_widgets_title_color = blocksy_get_colors( get_theme_mod(
	'footerWidgetsTitleColor',
	[ 'default' => [ 'color' => 'var(--paletteColor4)' ] ]
));

$css->put(
	'.footer-widgets',
	"--widgetsTitleColor: {$footer_widgets_title_color['default']}"
);

$footer_widgets_font_color = blocksy_get_colors( get_theme_mod(
	'footerWidgetsFontColor',
	[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
));

$css->put(
	'.footer-widgets',
	"--widgetsFontColor: {$footer_widgets_font_color['default']}"
);


$footer_widgets_link = blocksy_get_colors( get_theme_mod(
	'footerWidgetsLink',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.footer-widgets',
	"--linkInitialColor: {$footer_widgets_link['default']}"
);

$css->put(
	'.footer-widgets',
	"--linkHoverColor: {$footer_widgets_link['hover']}"
);


$widgets_area_background = blocksy_get_colors( get_theme_mod(
	'widgetsAreaBackground',
	[ 'default' => [ 'color' => '#f4f5f8' ] ]
));

$css->put(
	':root',
	"--widgetsAreaBackground: {$widgets_area_background['default']}"
);

blocksy_output_border([
	'css' => $css,
	'selector' => ':root',
	'variableName' => 'widgetsAreaDivider',
	'value' => get_theme_mod('widgetsAreaDivider', [
		'width' => 1,
		'style' => 'dashed',
		'color' => [
			'color' => '#dddddd',
		],
	])
]);


blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'widgetAreaSpacing',
	'value' => get_theme_mod('widgetAreaSpacing', [
		'mobile' => '40px',
		'tablet' => '50px',
		'desktop' => '70px',
	]),
	'unit' => ''
]);


// Footer Primary Bar
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.footer-menu',
	'variableName' => 'menuItemsSpacing',
	'value' => get_theme_mod('footerMenuItemsSpacing', [
		'mobile' => 20,
		'tablet' => 20,
		'desktop' => 20,
	])
]);


$footerPrimaryColor = blocksy_get_colors( get_theme_mod(
	'footerPrimaryColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	'.footer-primary-area',
	"--linkInitialColor: {$footerPrimaryColor['default']}"
);

$css->put(
	'.footer-primary-area',
	"--linkHoverColor: {$footerPrimaryColor['hover']}"
);


$footer_primary_background = blocksy_get_colors( get_theme_mod(
	'footerPrimaryBackground',
	[ 'default' => [ 'color' => '#eef0f4' ] ]
));

$css->put(
	':root',
	"--footerPrimaryBackground: {$footer_primary_background['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'footerPrimarySpacing',
	'value' => get_theme_mod('footerPrimarySpacing', [
		'mobile' => '30px',
		'tablet' => '30px',
		'desktop' => '30px',
	]),
	'unit' => ''
]);


// Copyright
$copyright_text = blocksy_get_colors( get_theme_mod(
	'copyrightText',
	[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
));

$css->put(
	':root',
	"--copyrightText: {$copyright_text['default']}"
);


$copyright_backgroundn = blocksy_get_colors( get_theme_mod(
	'copyrightBackground',
	[ 'default' => [ 'color' => '#eef0f4' ] ]
));

$css->put(
	':root',
	"--copyrightBackground: {$copyright_backgroundn['default']}"
);

blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'copyrightSpacing',
	'value' => get_theme_mod('copyrightSpacing', [
		'mobile' => '15px',
		'tablet' => '25px',
		'desktop' => '25px',
	]),
	'unit' => ''
]);


// To top button
$topButtonIconColor = blocksy_get_colors( get_theme_mod(
	'topButtonIconColor',
	[
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	]
));

$css->put(
	'.ct-back-to-top',
	"--linkInitialColor: {$topButtonIconColor['default']}"
);

$css->put(
	'.ct-back-to-top',
	"--linkHoverColor: {$topButtonIconColor['hover']}"
);


$topButtonShapeBackground = blocksy_get_colors( get_theme_mod(
	'topButtonShapeBackground',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor4)' ],
	]
));

$css->put(
	'.ct-back-to-top',
	"--buttonInitialColor: {$topButtonShapeBackground['default']}"
);

$css->put(
	'.ct-back-to-top',
	"--buttonHoverColor: {$topButtonShapeBackground['hover']}"
);


// Forms
$formLabelColor = blocksy_get_colors( get_theme_mod(
	'formLabelColor',
	[ 'default' => [ 'color' => 'var(--paletteColor3)' ] ]
));

$css->put(
	':root',
	"--formLabelColor: {$formLabelColor['default']}"
);

$formBorderColor = blocksy_get_colors( get_theme_mod(
	'formBorderColor',
	[
		'default' => [ 'color' => 'rgba(232, 235, 240, 1)' ],
		'focus' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	':root',
	"--formBorderInitialColor: {$formBorderColor['default']}"
);

$css->put(
	':root',
	"--formBorderFocusColor: {$formBorderColor['focus']}"
);


$formBackgroundColor = blocksy_get_colors( get_theme_mod(
	'formBackgroundColor',
	[
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
		'focus' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword() ],
	]
));

$css->put(
	':root',
	"--formBackgroundInitialColor: {$formBackgroundColor['default']}"
);

$css->put(
	':root',
	"--formBackgroundFocusColor: {$formBackgroundColor['focus']}"
);


$formTextColor = blocksy_get_colors( get_theme_mod(
	'formTextColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'focus' => [ 'color' => 'var(--paletteColor3)' ],
	]
));

$css->put(
	':root',
	"--formTextInitialColor: {$formTextColor['default']}"
);

$css->put(
	':root',
	"--formTextFocusColor: {$formTextColor['focus']}"
);

$formFontSize = get_theme_mod( 'formFontSize', 15 );
$css->put( ':root', '--formFontSize: ' . $formFontSize . 'px' );


$formBorderSize = get_theme_mod( 'formBorderSize', 1 );
$css->put( ':root', '--formBorderSize: ' . $formBorderSize . 'px' );


$formInputHeight = get_theme_mod( 'formInputHeight', 45 );
$css->put( ':root', '--formInputHeight: ' . $formInputHeight . 'px' );


$formTextAreaHeight = get_theme_mod( 'formTextAreaHeight', 170 );
$css->put( ':root', '--formTextAreaHeight: ' . $formTextAreaHeight . 'px' );


// radio & checkbox
$radioCheckboxColor = blocksy_get_colors( get_theme_mod(
	'radioCheckboxColor',
	[
		'default' => [ 'color' => '#e8ebf0' ],
		'accent' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	':root',
	"--radioCheckboxInitialColor: {$radioCheckboxColor['default']}"
);

$css->put(
	':root',
	"--radioCheckboxAccentColor: {$radioCheckboxColor['accent']}"
);


// select box
$selectDropdownTextColor = blocksy_get_colors( get_theme_mod(
	'selectDropdownTextColor',
	[
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor3)' ],
		'active' => [ 'color' => '#ffffff' ],
	]
));

$css->put(
	':root',
	"--selectDropdownTextInitialColor: {$selectDropdownTextColor['default']}"
);

$css->put(
	':root',
	"--selectDropdownTextHoverColor: {$selectDropdownTextColor['hover']}"
);

$css->put(
	':root',
	"--selectDropdownTextActiveColor: {$selectDropdownTextColor['active']}"
);


$selectDropdownItemColor = blocksy_get_colors( get_theme_mod(
	'selectDropdownItemColor',
	[
		'hover' => [ 'color' => 'rgba(232, 235, 240, 0.4)' ],
		'active' => [ 'color' => 'var(--paletteColor1)' ],
	]
));

$css->put(
	':root',
	"--selectDropdownItemHoverColor: {$selectDropdownItemColor['hover']}"
);

$css->put(
	':root',
	"--selectDropdownItemActiveColor: {$selectDropdownItemColor['active']}"
);

$selectDropdownBackground = blocksy_get_colors( get_theme_mod(
	'selectDropdownBackground',
	[ 'default' => [ 'color' => '#ffffff' ] ]
));

$css->put(
	':root',
	"--selectDropdownBackground: {$selectDropdownBackground['default']}"
);


// Passepartout
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => ':root',
	'variableName' => 'passepartoutSize',
	'value' => get_theme_mod('passepartoutSize', [
		'mobile' => 0,
		'tablet' => 10,
		'desktop' => 10,
	])
]);

$passepartoutColor = blocksy_get_colors( get_theme_mod(
	'passepartoutColor',
	[ 'default' => [ 'color' => 'var(--paletteColor1)' ] ]
));

$css->put(
	':root',
	"--passepartoutColor: {$passepartoutColor['default']}"
);

