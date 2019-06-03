import { handleVariablesFor } from 'customizer-sync-helpers'

handleVariablesFor({
	// Cookie
	cookieContentColor: {
		variable: 'cookieContentColor',
		type: 'color'
	},

	cookieBackground: {
		variable: 'cookieBackground',
		type: 'color'
	},

	cookieButtonBackground: [
		{
			selector: '.cookie-notification',
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: '.cookie-notification',
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	cookieMaxWidth: {
		variable: 'cookieMaxWidth',
		unit: 'px'
	}
})
