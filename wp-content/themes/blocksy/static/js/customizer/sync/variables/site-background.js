export const getSiteBackgroundVariables = () => ({
	site_background_image: [
		{
			variable: 'siteBackgroundImage',
			extractValue: ({ url }) => `url(${url})`
		},

		{
			variable: 'siteBackgroundPosition',
			extractValue: ({ x, y }) =>
				`${Math.round(parseFloat(x) * 100)}% ${Math.round(
					parseFloat(y) * 100
				)}%`
		}
	],

	site_background_size: {
		variable: 'siteBackgroundSize'
	},

	site_background_attachment: {
		variable: 'siteBackgroundAttachment'
	},

	site_background_repeat: {
		variable: 'siteBackgroundRepeat'
	},

	// pattern
	patternColor: {
		variable: 'patternColor',
		type: 'color'
	},
})
