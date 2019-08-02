export const getFormsVariablesFor = () => ({
	
	// general
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

	formInputHeight: {
		variable: 'formInputHeight',
		unit: 'px'
	},

	formTextAreaHeight: {
		selector: 'textarea',
		variable: 'formInputHeight',
		unit: 'px'
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

	formBorderSize: {
		selector: ':root',
		variable: 'formBorderSize',
		unit: 'px'
	},


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

})