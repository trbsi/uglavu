import './public-path'
import './ct-events'
import { onDocumentLoaded } from './helpers'

import ctEvents from 'ct-events'

onDocumentLoaded(() => {
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
