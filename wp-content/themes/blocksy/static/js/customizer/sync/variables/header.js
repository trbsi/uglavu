export const getHeaderVariables = () => ({

	transparentHeaderBackground: {
		variable: 'transparentHeaderBackground',
		type: 'color'
	},

	// Logo
	logoMaxHeight: {
		variable: 'logoMaxHeight',
		responsive: true,
		unit: 'px'
	},

	headerLogoContainerHeight: {
		variable: 'headerLogoContainerHeight',
		responsive: true,
		unit: ''
	},

	// Header
	headerShadow: {
		variable: 'headerShadow',
		type: 'color'
	},

	headerHeight: {
		variable: 'headerHeight',
		responsive: true,
		unit: ''
	},

	// site title & tagline
	siteTitleColor: [
		{
			selector: '.site-title',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.site-title',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	siteTaglineColor: {
		selector: '.site-description',
		variable: 'fontColor',
		type: 'color'
	},


	// main menu
	menuFontColor: [
		{
			selector: '.site-header',
			variable: 'menuInitialColor',
			type: 'color:default'
		},

		{
			selector: '.site-header',
			variable: 'menuActiveColor',
			type: 'color:active'
		},

		{
			selector: '.site-header',
			variable: 'menuHoverColor',
			type: 'color:hover'
		}
	],

	dropdownFontColor: [
		{
			selector: '.primary-menu .sub-menu',
			variable: 'menuInitialColor',
			type: 'color:default'
		},

		{
			selector: '.primary-menu .sub-menu',
			variable: 'menuHoverColor',
			type: 'color:hover'
		}
	],

	dropDownDivider: {
		variable: 'dropDownDivider',
		type: 'border'
	},

	headerMenuItemsSpacing: {
		selector: '.header-desktop',
		variable: 'menuItemsSpacing',
		unit: 'px'
	},

	navSectionHeight: {
		variable: 'navSectionHeight',
		responsive: true,
		unit: ''
	},

	navSectionBackground: {
		variable: 'navSectionBackground',
		type: 'color'
	},

	dropdownTopOffset: {
		variable: 'dropdownTopOffset',
		unit: 'px'
	},

	dropdownMenuWidth: {
		variable: 'dropdownMenuWidth',
		unit: 'px'
	},

	dropDownBackground: {
		variable: 'dropDownBackground',
		type: 'color'
	},

	// Top bar
	topBarFontColor: [
		{
			selector: '.header-top-bar',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.header-top-bar',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	topBarBackground: {
		variable: 'topBarBackground',
		type: 'color'
	},

	topBarMenuItemsSpacing: {
		selector: '.header-top-bar-menu',
		variable: 'menuItemsSpacing',
		responsive: true,
		unit: 'px'
	},

	topBarHeight: {
		variable: 'topBarHeight',
		responsive: true,
		unit: 'px',
		respect_visibility: 'top_bar_visibility',
		enabled: 'has_top_bar'
	},

	// Mobile header
	mobileHeaderHeight: {
		variable: 'mobileHeaderHeight',
		responsive: true,
		unit: ''
	},

	mobileMenuIconColor: [
		{
			selector: '.mobile-menu-toggle',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.mobile-menu-toggle',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	mobileMenuLinkColor: [
		{
			selector: '#mobile-menu',
			variable: 'menuInitialColor',
			type: 'color:default'
		},

		{
			selector: '#mobile-menu',
			variable: 'menuHoverColor',
			type: 'color:hover'
		}
	],

	mobileMenuBackground: {
		selector: '#mobile-menu',
		variable: 'modalBackground',
		type: 'color'
	},

	mobileMenulogoMaxHeight: {
		selector: '#mobile-menu .custom-logo',
		variable: 'logoMaxHeight',
		unit: 'px'
	},

	// Off-Canvas
	offCanvasWidth: {
		variable: 'offCanvasWidth',
		responsive: true,
		unit: ''
	},

	// Header Search Modal
	searchHeaderIconColor: [
		{
			selector: '.search-button',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.search-button',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	searchHeaderLinkColor: [
		{
			selector: '#search-modal',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '#search-modal',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	searchHeaderBackground: {
		selector: '#search-modal',
		variable: 'modalBackground',
		type: 'color'
	},

	// Header Cart
	cartHeaderIconColor: [
		{
			selector: '.ct-cart-icon',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-cart-icon',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	cartBadgeColor: [
		{
			selector: '.ct-header-cart',
			variable: 'cartBadgeBackground',
			type: 'color:background'
		},

		{
			selector: '.ct-header-cart',
			variable: 'cartBadgeText',
			type: 'color:text'
		}
	],

	cartFontColor: [
		{
			selector: '.ct-cart-content',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-cart-content',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	cartDropDownBackground: {
		selector: '.ct-cart-content',
		variable: 'cartDropDownBackground',
		type: 'color'
	},

	// Header CTA button
	headerButtonFont: [
		{
			selector: '.ct-header-button',
			variable: 'linkInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-header-button',
			variable: 'linkHoverColor',
			type: 'color:hover'
		}
	],

	headerButtonBackground: [
		{
			selector: '.ct-header-button',
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-header-button',
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	headerButtonRadius: {
		variable: 'headerButtonRadius',
		unit: 'px'
	},

	// Transparent header
	transparentHeaderFontColor: [
		{
			variable: 'transparentHeaderInitialFontColor',
			type: 'color:default'
		},

		{
			variable: 'transparentHeaderHoverFontColor',
			type: 'color:hover'
		}
	],

	transparentLogoMaxHeight: {
		variable: 'transparentLogoMaxHeight',
		responsive: true,
		unit: 'px'
	},

	// Header border
	headerTopBorder: {
		variable: 'headerTopBorder',
		type: 'border'
	},

	headerBottomBorder: {
		variable: 'headerBottomBorder',
		type: 'border'
	}
})
