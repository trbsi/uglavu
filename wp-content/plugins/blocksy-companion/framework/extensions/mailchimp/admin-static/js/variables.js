import { handleVariablesFor } from 'customizer-sync-helpers'

handleVariablesFor({
	// Mailchimp
	mailchimpContent: {
		variable: 'mailchimpContent',
		type: 'color'
	},

	mailchimpButton: [
		{
			selector: '.ct-mailchimp-block',
			variable: 'buttonInitialColor',
			type: 'color:default'
		},

		{
			selector: '.ct-mailchimp-block',
			variable: 'buttonHoverColor',
			type: 'color:hover'
		}
	],

	mailchimpBackground: {
		variable: 'mailchimpBackground',
		type: 'color'
	},

	mailchimpShadow: {
		variable: 'mailchimpShadow',
		type: 'color'
	},

	mailchimpSpacing: {
		variable: 'mailchimpSpacing',
		responsive: true,
		unit: ''
	}
})
