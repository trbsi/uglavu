import ctEvents from 'ct-events'
import { updateAndSaveEl } from '../../../../static/js/frontend/header/render-loop'

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	variableDescriptors => {
		variableDescriptors['trigger'] = {
			triggerIconColor: [
				{
					selector: '.ct-header-trigger',
					variable: 'linkInitialColor',
					type: 'color:default'
				},

				{
					selector: '.ct-header-trigger',
					variable: 'linkHoverColor',
					type: 'color:hover'
				}
			]
		}
	}
)

ctEvents.on('ct:header:sync:item:trigger', ({ optionId, optionValue }) => {
	const selector = '[data-id="trigger"]'

	if (optionId === 'mobile_menu_trigger_type') {
		updateAndSaveEl(
			selector,
			el => (el.querySelector('.lines-button').dataset.type = optionValue)
		)
	}
})
