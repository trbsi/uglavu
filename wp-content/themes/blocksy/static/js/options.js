import './public-path.js'
import './frontend/ct-events.js'
import { getValueFromInput } from './options/helpers/get-value-from-input'
import { createElement, render } from '@wordpress/element'
import OptionsRoot from './options/OptionsRoot.js'
import $ from 'jquery'

const initAllPanels = () =>
	[...document.querySelectorAll('.ct-options-panel')].map(singleTarget => {
		if (singleTarget.closest('[id="available-widgets"]')) {
			return
		}

		if (singleTarget.ctHasOptions) return
		singleTarget.ctHasOptions = true

		$(singleTarget).on('remove', () => setTimeout(() => initAllPanels()))
		$(singleTarget).on('remove', () => () => initAllPanels())

		render(
			<OptionsRoot
				options={JSON.parse(
					singleTarget.firstElementChild.dataset.ctOptions
				)}
				value={getValueFromInput(
					JSON.parse(
						singleTarget.firstElementChild.dataset.ctOptions
					),
					JSON.parse(singleTarget.firstElementChild.value)
				)}
				input_id={singleTarget.firstElementChild.id}
				input_name={singleTarget.firstElementChild.name}
				hasRevertButton={
					Object.keys(singleTarget.dataset).indexOf(
						'disableReverseButton'
					) === -1
				}
			/>,
			singleTarget
		)
	})

if ($ && $.fn) {
	$(document).on('widget-added', () => initAllPanels())
}

document.addEventListener('DOMContentLoaded', () => {
	initAllPanels()
	;[...document.querySelectorAll('.notice-blocksy-plugin')].map(el =>
		import('./notification/main').then(({ mount }) => mount(el))
	)
})
