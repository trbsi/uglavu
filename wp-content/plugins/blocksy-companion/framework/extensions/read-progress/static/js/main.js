import './public-path'
import { onDocumentLoaded } from '../../../instagram/static/js/helpers'

onDocumentLoaded(() => {
	if (!document.querySelector('.ct-read-progress-bar')) {
		return
	}

	import('./implementation').then(({ mount }) => mount())
})
