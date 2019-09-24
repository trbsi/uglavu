<?php

$b = new Blocksy_Customizer_Builder();

$b->dynamic_css('header', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

blocksy_theme_get_dynamic_styles('typography', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

blocksy_theme_get_dynamic_styles('background', [
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

if (class_exists('WooCommerce')) {
	blocksy_theme_get_dynamic_styles('woocommerce', [
		'css' => $css,
		'mobile_css' => $mobile_css,
		'tablet_css' => $tablet_css
	]);
}

blocksy_theme_get_dynamic_styles('forms', [
	'css' => $css,
	'mobile_css' => $mobile_css,
	'tablet_css' => $tablet_css
]);

// Color palette
blocksy_output_colors([
	'value' => get_theme_mod('colorPalette'),
	'default' => [
		'color1' => [ 'color' => '#3eaf7c' ],
		'color2' => [ 'color' => '#33a370' ],
		'color3' => [ 'color' => 'rgba(44, 62, 80, 0.9)' ],
		'color4' => [ 'color' => 'rgba(44, 62, 80, 1)' ],
		'color5' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'color1' => ['variable' => 'paletteColor1'],
		'color2' => ['variable' => 'paletteColor2'],
		'color3' => ['variable' => 'paletteColor3'],
		'color4' => ['variable' => 'paletteColor4'],
		'color5' => ['variable' => 'paletteColor5'],
	],
]);

// Colors
blocksy_output_colors([
	'value' => get_theme_mod('fontColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'fontColor'],
	],
]);

// Headings
blocksy_output_colors([
	'value' => get_theme_mod('h1Color'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => 'h1',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('h2Color'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => 'h2',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('h3Color'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => 'h3',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('h4Color'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => 'h4',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('h5Color'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => 'h5',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('h6Color'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => 'h6',
			'variable' => 'fontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('linkColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'linkInitialColor'],
		'hover' => ['variable' => 'linkHoverColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('buttonColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'buttonInitialColor'],
		'hover' => ['variable' => 'buttonHoverColor'],
	],
]);

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

$css->put( ':root', '--narrowContainerWidthNoUnit: ' . intval($narrowContainerWidth) );

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

blocksy_output_colors([
	'value' => get_theme_mod('sidebarWidgetsTitleColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-sidebar',
			'variable' => 'widgetsTitleColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('sidebarWidgetsFontColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-sidebar',
			'variable' => 'widgetsFontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('sidebarWidgetsLink'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-sidebar',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.ct-sidebar',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('sidebarBackgroundColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor5)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'sidebarBackgroundColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('sidebarBorderColor'),
	'default' => [
		'default' => [ 'color' => 'rgba(224, 229, 235, 0.8)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'sidebarBorderColor'],
	],
]);

$sidebarBorderSize = get_theme_mod( 'sidebarBorderSize', 0 );
$css->put( ':root', '--sidebarBorderSize: ' . $sidebarBorderSize . 'px' );

blocksy_output_colors([
	'value' => get_theme_mod('sidebarDividerColor'),
	'default' => [
		'default' => [ 'color' => 'rgba(224, 229, 235, 0.8)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'sidebarDividerColor'],
	],
]);

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

blocksy_output_colors([
	'value' => get_theme_mod('paginationFontColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'paginationFontInitialColor'],
		'hover' => ['variable' => 'paginationFontHoverColor']
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('paginationAccentColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'paginationAccentInitialColor'],
		'hover' => ['variable' => 'paginationAccentHoverColor']
	],
]);

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

blocksy_output_colors([
	'value' => get_theme_mod('relatedPostsLabelColor'),
	'default' => [
		'default' => ['color' => 'var(--paletteColor4)'],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'relatedPostsLabelColor'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('relatedPostsLinkColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-related-posts',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.ct-related-posts',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('relatedPostsMetaColor'),
	'default' => [
		'default' => [ 'color' => '#667380' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'relatedPostsMetaColor'],
	],
]);

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

blocksy_output_colors([
	'value' => get_theme_mod('shareItemsIconColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.share-box[data-type="type-1"]',
			'variable' => 'shareItemsIconInitial'
		],

		'hover' => [
			'selector' => '.share-box[data-type="type-1"]',
			'variable' => 'shareItemsIconHover'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('shareItemsBorder'),
	'default' => [
		'default' => [ 'color' => '#e0e5eb' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'shareItemsBorder'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('shareItemsIcon'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'shareItemsIcon'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('shareItemsBackground'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
		'hover' => [ 'color' => 'var(--paletteColor2)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.share-box[data-type="type-2"]',
			'variable' => 'shareBoxBackgroundInitial'
		],

		'hover' => [
			'selector' => '.share-box[data-type="type-2"]',
			'variable' => 'shareBoxBackgroundHover'
		]
	],
]);

// Post
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

// Page
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

blocksy_output_colors([
	'value' => get_theme_mod('singleAuthorBoxBackground'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'variable' => 'singleAuthorBoxBackground'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('singleAuthorBoxBorder'),
	'default' => [
		'default' => [ 'color' => '#e8ebf0' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'variable' => 'singleAuthorBoxBorder'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('singleAuthorBoxShadow'),
	'default' => [
		'default' => [ 'color' => 'rgba(210, 213, 218, 0.4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'variable' => 'singleAuthorBoxShadow'
		],
	],
]);


// Footer
blocksy_output_colors([
	'value' => get_theme_mod('footerWidgetsTitleColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.footer-widgets',
			'variable' => 'widgetsTitleColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('footerWidgetsFontColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.footer-widgets',
			'variable' => 'widgetsFontColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('footerWidgetsLink'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.footer-widgets',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.footer-widgets',
			'variable' => 'linkHoverColor'
		],
	],
]);

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


blocksy_output_colors([
	'value' => get_theme_mod('footerPrimaryColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.footer-primary-area',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.footer-primary-area',
			'variable' => 'linkHoverColor'
		],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('footerPrimaryBackground'),
	'default' => [
		'default' => [ 'color' => '#eef0f4' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'footerPrimaryBackground'],
	],
]);

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
blocksy_output_colors([
	'value' => get_theme_mod('copyrightText'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'copyrightText'],
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('copyrightBackground'),
	'default' => [
		'default' => [ 'color' => '#eef0f4' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'copyrightBackground'],
	],
]);

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
blocksy_output_colors([
	'value' => get_theme_mod('topButtonIconColor'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
		'hover' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'linkHoverColor'
		]
	],
]);

blocksy_output_colors([
	'value' => get_theme_mod('topButtonShapeBackground'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor3)' ],
		'hover' => [ 'color' => 'var(--paletteColor4)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'buttonInitialColor'
		],

		'hover' => [
			'selector' => '.ct-back-to-top',
			'variable' => 'buttonHoverColor'
		]
	],
]);


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

blocksy_output_colors([
	'value' => get_theme_mod('passepartoutColor'),
	'default' => [
		'default' => [ 'color' => 'var(--paletteColor1)' ],
	],
	'css' => $css,
	'variables' => [
		'default' => ['variable' => 'passepartoutColor'],
	],
]);

