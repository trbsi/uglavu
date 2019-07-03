wp.customize('paginationDivider', val =>
	val.bind(to =>
		[...document.querySelectorAll('.ct-pagination')].map(el => {
			el.removeAttribute('data-divider')
			if (to.style === 'none') return
			el.dataset.divider = ''
		})
	)
)

wp.customize('background_pattern', val =>
	val.bind(to =>
		[...document.querySelectorAll('.ct-site-pattern')].map(el => {
			el.querySelector('svg > rect').setAttribute('fill', `url(#${to})`)
		})
	)
)
