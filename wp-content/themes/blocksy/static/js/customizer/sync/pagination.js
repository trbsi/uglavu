wp.customize('has_pagination_divider', val =>
	val.bind(to =>
		[...document.querySelectorAll('.ct-pagination')].map(el => {
			el.removeAttribute('data-divider')

			if (to === 'no') return

			el.dataset.divider = ''
		})
	)
)
