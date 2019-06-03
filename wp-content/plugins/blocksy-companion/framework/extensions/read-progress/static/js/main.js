import './public-path'

document.addEventListener('DOMContentLoaded', () => {
	if (!document.querySelector('.ct-read-progress-bar')) {
		return
	}

	import('./implementation').then(({ mount }) => mount())
})
