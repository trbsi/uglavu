wp.customize('paginationDivider', val =>
	val.bind(to =>
		[...document.querySelectorAll('.ct-pagination')].map(el => {
			el.removeAttribute('data-divider')
			if (to.style === 'none') return
			el.dataset.divider = ''
		})
	)
)
