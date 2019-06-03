import './public-path'
import ctEvents from 'ct-events'

document.addEventListener('DOMContentLoaded', () => {
	;[...document.querySelectorAll('.ct-instagram-widget')].map(el =>
		import('./instagram-widget').then(({ initInstagramWidget }) => {
			initInstagramWidget(el)
		})
	)

	ctEvents.on('blocksy:instagram:init', () => {
		;[...document.querySelectorAll('.ct-instagram-widget')].map(el =>
			import('./instagram-widget').then(({ initInstagramWidget }) => {
				initInstagramWidget(el)
			})
		)
	})
})
