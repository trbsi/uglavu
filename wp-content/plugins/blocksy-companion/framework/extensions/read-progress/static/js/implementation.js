const render = () => {
	if (!document.querySelector('.entry-content')) {
		return
	}

	const entryContent = document
		.querySelector('.entry-content')
		.getBoundingClientRect()

	document
		.querySelector('.ct-read-progress-bar')
		.style.setProperty(
			'--scroll',
			`${Math.max(
				0,
				Math.min(
					100,
					100 *
						pageYOffset /
						(entryContent.top +
							entryContent.height +
							pageYOffset -
							innerHeight)
				)
			)}%`
		)
}

export const mount = () => {
	render()
	document.addEventListener('scroll', () => render())
}
