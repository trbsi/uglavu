import { getHeroVariables } from './hero-section'
import { getPostListingVariables } from './template-parts/content-loop'
import { getHeaderVariables } from './variables/header'
import { getTypographyVariablesFor } from './variables/typography'
import { getSiteBackgroundVariables } from './variables/site-background'

import { handleVariablesFor } from 'customizer-sync-helpers'

handleVariablesFor({
	colorPalette: [
		{
			variable: 'paletteColor1',
			type: 'color:color1'
		},

		{
			variable: 'paletteColor2',
			type: 'color:color2'
		},

		{
			variable: 'paletteColor3',
			type: 'color:color3'
		},

		{
			variable: 'paletteColor4',
			type: 'color:color4'
		},

		{
			variable: 'paletteColor5',
			type: 'color:color5'
		}
	],

	background_pattern: [
		{
			variable: 'backgroundPattern'
		}
	],

	// Page Hero
	...getHeroVariables(),
	...getPostListingVariables(),

	...getSiteBackgroundVariables(),

	...getHeaderVariables(),
	...getTypographyVariablesFor(),

	// Colors
	fontColor: {
		variable: 'fontColor',
		type: 'color'
	},

	h1Color: {
		variable: 'fontColor',
		type: 'color',
		selector: 'h1'
	},

	h2Color: {
		variable: 'fontColor',
		type: 'color',
		selector: 'h2'
	},

	h3Color: {
		variable: 'fontColor',
		type: 'color',
		selector: 'h3'
	},

	h4Color: {
		variable: 'fontColor',
		type: 'color',
		selector: 'h4'
	},

	h5Color: {
		variable: 'fontColor',
		type: 'color',
		selector: 'h5'
	},

	h6Color: {
		variable: 'fontColor',
		type: 'color',
		selector: 'h6'
	},

	linkColor: [
		{
			selector: ':root',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	buttonColor: [
		{
			selector: ':root',
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	siteBackground: {
		variable: 'siteBackground',
		type: 'color'
	},

	// Layout
	maxSiteWidth: {
		variable: 'maxSiteWidth',
		unit: 'px'
	},

	contentAreaSpacing: {
		variable: 'contentAreaSpacing',
		responsive: true,
		unit: ''
	},

	narrowContainerWidth: {
		variable: 'narrowContainerWidth',
		unit: '%'
	},

	wideOffset: {
		variable: 'wideOffset',
		unit: 'px'
	},

	// Sidebar
	sidebarWidth: [
		{
			variable: 'sidebarWidth',
			unit: '%'
		},
		{
			variable: 'sidebarWidthNoUnit',
			unit: ''
		}
	],

	sidebarGap: {
		variable: 'sidebarGap',
		unit: ''
	},

	sidebarOffset: {
		variable: 'sidebarOffset',
		unit: 'px'
	},

	sidebarWidgetsTitleColor: {
		selector: '.ct-sidebar',
		variable: 'widgetsTitleColor',
		type: 'color'
	},

	sidebarWidgetsFontColor: {
		selector: '.ct-sidebar',
		variable: 'widgetsFontColor',
		type: 'color'
	},

	sidebarWidgetsLink: [
		{
			selector: '.ct-sidebar',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-sidebar',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	sidebarBackgroundColor: {
		variable: 'sidebarBackgroundColor',
		type: 'color'
	},

	sidebarBorderColor: {
		variable: 'sidebarBorderColor',
		type: 'color'
	},

	sidebarBorderSize: {
		variable: 'sidebarBorderSize',
		unit: 'px'
	},

	sidebarDividerColor: {
		variable: 'sidebarDividerColor',
		type: 'color'
	},

	sidebarDividerSize: {
		variable: 'sidebarDividerSize',
		unit: 'px'
	},

	sidebarWidgetsSpacing: {
		variable: 'sidebarWidgetsSpacing',
		responsive: true,
		unit: 'px'
	},

	sidebarInnerSpacing: {
		variable: 'sidebarInnerSpacing',
		responsive: true,
		unit: 'px'
	},

	// Related Posts
	relatedPostsContainerSpacing: {
		variable: 'relatedPostsContainerSpacing',
		responsive: true,
		unit: ''
	},

	relatedPostsLabelColor: {
		variable: 'relatedPostsLabelColor',
		type: 'color'
	},

	relatedPostsLinkColor: [
		{
			selector: '.ct-related-posts',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-related-posts',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	relatedPostsMetaColor: {
		variable: 'relatedPostsMetaColor',
		type: 'color'
	},

	relatedPostsContainerColor: {
		variable: 'relatedPostsContainerColor',
		type: 'color'
	},

	// Comments
	postCommentsBackground: {
		variable: 'commentsBackground',
		type: 'color'
	},

	// Pagination
	paginationSpacing: {
		variable: 'paginationSpacing',
		responsive: true,
		unit: 'px'
	},

	// Posts Navigation
	postNavSpacing: {
		variable: 'postNavSpacing',
		responsive: true,
		unit: ''
	},

	paginationFontColor: {
		variable: 'paginationFontColor',
		type: 'color'
	},

	paginationAccentColor: [
		{
			selector: ':root',
			variable: 'paginationAccentInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'paginationAccentHoverColor',
			type: 'color:hover'
		}
	],

	paginationDivider: {
		variable: 'paginationDivider',
		type: 'border'
	},

	// Share Box
	topShareBoxSpacing: {
		variable: 'topShareBoxSpacing',
		responsive: true,
		unit: ''
	},

	bottomShareBoxSpacing: {
		variable: 'bottomShareBoxSpacing',
		responsive: true,
		unit: ''
	},

	shareItemsIconColor: [
		{
			selector: '.share-box[data-type="type-1"]',
			variable: 'shareItemsIconInitial',
			type: 'color:default'
		},

		{
			selector: '.share-box[data-type="type-1"]',
			variable: 'shareItemsIconHover',
			type: 'color:hover'
		}
	],

	shareItemsBorder: {
		variable: 'shareItemsBorder',
		type: 'color'
	},

	shareItemsIcon: {
		variable: 'shareItemsIcon',
		type: 'color'
	},

	shareItemsBackground: [
		{
			selector: '.share-box[data-type="type-2"]',
			variable: 'shareBoxBackgroundInitial',
			type: 'color:default'
		},

		{
			selector: '.share-box[data-type="type-2"]',
			variable: 'shareBoxBackgroundHover',
			type: 'color:hover'
		}
	],


	// Post
	postBackground: {
		selector: '.single .site-main',
		variable: 'siteBackground',
		type: 'color'
	},

	singleContentBoxedSpacing: {
		variable: 'singleContentBoxedSpacing',
		responsive: true,
		unit: ''
	},

	singleContentBackground: {
		variable: 'singleContentBackground',
		type: 'color'
	},


	// Page
	pageBackground: {
		selector: '.page .site-main',
		variable: 'siteBackground',
		type: 'color'
	},

	pageContentBoxedSpacing: {
		variable: 'pageContentBoxedSpacing',
		responsive: true,
		unit: ''
	},

	pageContentBackground: {
		variable: 'pageContentBackground',
		type: 'color'
	},


	// Autor Box
	singleAuthorBoxSpacing: {
		variable: 'singleAuthorBoxSpacing',
		responsive: true,
		unit: ''
	},

	singleAuthorBoxBackground: {
		variable: 'singleAuthorBoxBackground',
		type: 'color'
	},

	singleAuthorBoxBorder: {
		variable: 'singleAuthorBoxBorder',
		type: 'color'
	},

	singleAuthorBoxShadow: {
		variable: 'singleAuthorBoxShadow',
		type: 'color'
	},

	// Footer
	footerWidgetsTitleColor: {
		selector: '.footer-widgets',
		variable: 'widgetsTitleColor',
		type: 'color'
	},

	footerWidgetsFontColor: {
		selector: '.footer-widgets',
		variable: 'widgetsFontColor',
		type: 'color'
	},

	footerWidgetsLink: [
		{
			selector: '.footer-widgets',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.footer-widgets',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	widgetsAreaBackground: {
		variable: 'widgetsAreaBackground',
		type: 'color'
	},

	widgetsAreaDivider: {
		variable: 'widgetsAreaDivider',
		type: 'border'
	},

	widgetAreaSpacing: {
		variable: 'widgetAreaSpacing',
		responsive: true,
		unit: ''
	},

	// Footer Primary bar
	footerMenuItemsSpacing: {
		selector: '.footer-menu',
		variable: 'menuItemsSpacing',
		responsive: true,
		unit: 'px'
	},

	footerPrimaryColor: [
		{
			selector: '.footer-primary-area',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.footer-primary-area',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	footerPrimaryBackground: {
		variable: 'footerPrimaryBackground',
		type: 'color'
	},

	footerPrimarySpacing: {
		variable: 'footerPrimarySpacing',
		responsive: true,
		unit: ''
	},

	// Copyright
	copyrightText: {
		variable: 'copyrightText',
		type: 'color'
	},

	copyrightBackground: {
		variable: 'copyrightBackground',
		type: 'color'
	},

	copyrightSpacing: {
		variable: 'copyrightSpacing',
		responsive: true,
		unit: ''
	},

	// Woocommerce archive
	productGalleryWidth: {
		variable: 'productGalleryWidth',
		unit: '%'
	},

	cardProductTitleColor: [
		{
			selector: '.shop-entry-card',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.shop-entry-card',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	cardProductCategoriesColor: [
		{
			selector: '.product-categories',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.product-categories',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	cardProductPriceColor: {
		selector: '.shop-entry-card .price',
		variable: 'fontColor',
		type: 'color'
	},

	cardStarRatingColor: {
		selector: '.shop-entry-card',
		variable: 'starRatingColor',
		type: 'color'
	},

	saleBadgeColor: [
		{
			selector: '.shop-entry-card',
			variable: 'saleBadgeTextColor',
			type: 'color:text'
		},

		{
			selector: '.shop-entry-card',
			variable: 'saleBadgeBackgroundColor',
			type: 'color:background'
		}
	],

	cardProductImageOverlay: {
		selector: '.shop-entry-card',
		variable: 'imageOverlay',
		type: 'color'
	},

	cardProductAction1Color: [
		{
			selector: '.woo-card-actions',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.woo-card-actions',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	cardProductAction2Color: [
		{
			selector: '.woo-card-actions',
			variable: 'wooButtonInitialColor',
			type: 'color:default'
		},

		{
			selector: '.woo-card-actions',
			variable: 'wooButtonHoverColor',
			type: 'color:hover'
		}
	],

	// Woocommerce single
	singleProductPriceColor: {
		selector: '.entry-summary .price',
		variable: 'fontColor',
		type: 'color'
	},

	singleSaleBadgeColor: [
		{
			selector: '.product > span.onsale',
			variable: 'saleBadgeTextColor',
			type: 'color:text'
		},

		{
			selector: '.product > span.onsale',
			variable: 'saleBadgeBackgroundColor',
			type: 'color:background'
		}
	],

	singleStarRatingColor: {
		selector: '.entry-summary,.woocommerce-tabs',
		variable: 'starRatingColor',
		type: 'color'
	},

	// To top button
	topButtonIconColor: [
		{
			selector: '.ct-back-to-top',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-back-to-top',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	topButtonShapeBackground: [
		{
			selector: '.ct-back-to-top',
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-back-to-top',
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	// Forms
	formLabelColor: {
		selector: ':root',
		variable: 'formLabelColor',
		type: 'color'
	},

	formBorderColor: [
		{
			selector: ':root',
			variable: 'formBorderInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'formBorderFocusColor',
			type: 'color:focus'
		}
	],

	formBackgroundColor: [
		{
			selector: ':root',
			variable: 'formBackgroundInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'formBackgroundFocusColor',
			type: 'color:focus'
		}
	],

	formTextColor: [
		{
			selector: ':root',
			variable: 'formTextInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'formTextFocusColor',
			type: 'color:focus'
		}
	],

	formFontSize: {
		variable: 'formFontSize',
		unit: 'px'
	},

	formBorderSize: {
		variable: 'formBorderSize',
		unit: 'px'
	},

	formInputHeight: {
		variable: 'formInputHeight',
		unit: 'px'
	},

	formTextAreaHeight: {
		variable: 'formTextAreaHeight',
		unit: 'px'
	},

	// radio & checkbox
	radioCheckboxColor: [
		{
			selector: ':root',
			variable: 'radioCheckboxInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'radioCheckboxAccentColor',
			type: 'color:accent'
		}
	],

	// select box
	selectDropdownTextColor: [
		{
			selector: ':root',
			variable: 'selectDropdownTextInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'selectDropdownTextHoverColor',
			type: 'color:hover'
		},

		{
			selector: ':root',
			variable: 'selectDropdownTextActiveColor',
			type: 'color:active'
		}
	],

	selectDropdownItemColor: [
		{
			selector: ':root',
			variable: 'selectDropdownItemHoverColor',
			type: 'color:hover'
		},

		{
			selector: ':root',
			variable: 'selectDropdownItemActiveColor',
			type: 'color:active'
		}
	],

	selectDropdownBackground: {
		selector: ':root',
		variable: 'selectDropdownBackground',
		type: 'color'
	},

	// Passepartout
	passepartoutSize: {
		variable: 'passepartoutSize',
		responsive: true,
		unit: 'px'
	},

	passepartoutColor: {
		variable: 'passepartoutColor',
		type: 'color'
	}
})
