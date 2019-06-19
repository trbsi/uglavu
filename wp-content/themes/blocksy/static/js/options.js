import './public-path.js'
import './frontend/ct-events.js'
import $ from 'jquery'
import { initAllPanels } from './options/initPanels'

if ($ && $.fn) {
	$(document).on('widget-added', () => initAllPanels())
}

document.addEventListener('DOMContentLoaded', () => {
	initAllPanels()
	;[...document.querySelectorAll('.notice-blocksy-plugin')].map(el =>
		import('./notification/main').then(({ mount }) => mount(el))
	)
})
