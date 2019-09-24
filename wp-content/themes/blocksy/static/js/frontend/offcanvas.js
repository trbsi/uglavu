import { enable, disable } from './no-bounce'

const showOffcanvas = settings => {
	const sidePanel = document.querySelector('.side-panel')

	document.body.classList.add(
		sidePanel.dataset.position === 'left'
			? 'left-panel-active'
			: 'right-panel-active'
	)

	window.addEventListener(
		'click',
		() => {
			if (
				document.body.classList.contains('right-panel-active') ||
				document.body.classList.contains('left-panel-active')
			) {
				hideOffcanvas(settings)
			}
		},
		{ once: true }
	)

	sidePanel.querySelector('.ct-bag-close').addEventListener(
		'click',
		event => {
			event.preventDefault()
			event.stopPropagation()

			hideOffcanvas(settings)
		},
		{ once: true }
	)

	enable()
}

const hideOffcanvas = () => {
	if (
		!(
			document.body.classList.contains('right-panel-active') ||
			document.body.classList.contains('left-panel-active')
		)
	) {
		return
	}

	document.body.classList.remove('right-panel-active', 'left-panel-active')
	document.body.classList.add('panel-hiding')

	setTimeout(() => document.body.classList.remove('panel-hiding'), 250)

	document
		.querySelector('[data-id="trigger"] > a')
		.firstElementChild.classList.remove('close')

	disable()
}

export const handleClick = (e, settings) => {
	settings = {
		onClose: () => {},
		...settings
	}

	if (
		document.body.classList.contains('right-panel-active') ||
		document.body.classList.contains('left-panel-active')
	) {
		hideOffcanvas()
	} else {
		showOffcanvas(settings)
	}
}

ctEvents.on('ct:offcanvas:force-close', () => {
	hideOffcanvas()
})
