import { enable, disable } from './no-bounce'

const showOffcanvas = () => {
	document.body.classList.add('ct-offcanvas-active')
	document.body.classList.remove('ct-offcanvas')

	var pickclick =
		navigator.userAgent.match(/iPad/i) ||
		navigator.userAgent.match(/iPhone/)
			? 'touchend'
			: 'click'

	window.addEventListener(
		pickclick,
		() => {
			if (document.body.classList.contains('ct-offcanvas-active')) {
				hideOffcanvas()
			}
		},
		{ once: true }
	)

	document.querySelector('.ct-offcanvas-menu .ct-bag-close').addEventListener(
		'click',
		event => {
			event.preventDefault()
			event.stopPropagation()

			hideOffcanvas()
		},
		{ once: true }
	)

	enable()
}

const hideOffcanvas = () => {
	document.body.classList.remove('ct-offcanvas-active')
	document.body.classList.add('ct-offcanvas')
	document.body.classList.add('ct-offcanvas-hiding')

	setTimeout(() => {
		document.body.classList.remove('ct-offcanvas-hiding')
	}, 250)

	document
		.querySelector('.mobile-menu-toggle')
		.firstElementChild.classList.remove('close')

	disable()
}

export const handleClick = e => {
	if (document.body.classList.contains('ct-offcanvas-active')) {
		hideOffcanvas()
	} else {
		showOffcanvas()
	}
}
