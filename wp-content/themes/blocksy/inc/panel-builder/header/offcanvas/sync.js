import { handleBackgroundOptionFor } from '../../../../static/js/customizer/sync/variables/background'
import ctEvents from 'ct-events'
import { updateAndSaveEl } from '../../../../static/js/frontend/header/render-loop'

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	variableDescriptors => {
		variableDescriptors['offcanvas'] = {
			...handleBackgroundOptionFor({
				id: 'offcanvasBackground',
				selector: '#offcanvas'
			})
		}
	}
)

ctEvents.on(
	'ct:header:sync:item:offcanvas',
	({ optionId, optionValue, values }) => {
		const selector = '#offcanvas'

		if (optionId === 'offcanvasContentAlignment') {
			document.querySelector(
				'#offcanvas .ct-bag-content'
			).dataset.align = optionValue
		}

		if (
			optionId === 'offcanvas_behavior' ||
			optionId === 'side_panel_position'
		) {
			const el = document.querySelector('#offcanvas')

			ctEvents.trigger('ct:offcanvas:force-close', {
				$el: document.querySelector('#offcanvas'),
				settings: {
					onClose: () => {
						document.querySelector('.mobile-menu-toggle') &&
							document
								.querySelector('.mobile-menu-toggle')
								.firstElementChild.classList.remove('close')
					}
				}
			})

			setTimeout(() => {
				el.removeAttribute('data-position')
				el.classList.remove('ct-modal', 'side-panel')

				el.classList.add(
					values.offcanvas_behavior === 'modal'
						? 'ct-modal'
						: 'side-panel'
				)

				if (values.side_panel_position !== 'modal') {
					el.dataset.position = values.side_panel_position
				}
			}, 1000)
		}
	}
)
