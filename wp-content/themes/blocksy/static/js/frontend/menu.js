import Popper from 'popper.js'

export const handleFirstLevelForMenu = menu => {
	if (menu.hasFirstLevelPoppers) {
		return
	}

	menu.hasFirstLevelPoppers = true
	;[...menu.children]
		.filter(
			el =>
				el.classList.contains('menu-item-has-children') ||
				el.classList.contains('page_item_has_children')
		)
		.map(el => el.querySelector('.sub-menu'))
		.map(menu => {
			;[...menu.querySelectorAll('[data-submenu]')].map(el => {
				el.removeAttribute('data-submenu')
			})

			setTimeout(
				() =>
					(menu._popper = new Popper(menu.parentNode, menu, {
						modifiers: {
							applyStyle: { enabled: false },

							preventOverflow: {
								enabled: false
							},

							hide: {
								enabled: false
							},

							flip: {
								// enabled: false,
								behavior: ['right', 'left']
							},

							setCustomStyle: {
								enabled: true,
								order: 100000000,
								fn: ({
									flipped,
									instance,
									instance: { reference },
									popper,
									popper: { left },
									placement,
									styles
								}) =>
									(reference.dataset.submenu =
										placement === 'left' ? 'left' : 'right')
							}
						},
						placement: 'right'
					}))
			)
		})
}

export const handleUpdate = menu => {
	if (menu.hasPoppers) {
		return
	}

	menu.hasPoppers = true

	menu.parentNode.addEventListener('mouseenter', () => {
		if (menu._timeout_id) {
			clearTimeout(menu._timeout_id)
		}

		;[...menu.children]
			.filter(
				el =>
					el.classList.contains('menu-item-has-children') ||
					el.classList.contains('page_item_has_children')
			)
			.map(el => el.querySelector('.sub-menu'))
			.map(menu => {
				;[...menu.querySelectorAll('[data-submenu]')].map(el => {
					el.removeAttribute('data-submenu')
				})

				setTimeout(
					() =>
						(menu._popper = new Popper(menu.parentNode, menu, {
							modifiers: {
								applyStyle: { enabled: false },

								preventOverflow: {
									enabled: false
								},

								hide: {
									enabled: false
								},

								flip: {
									// enabled: false,
									behavior: ['right', 'left']
								},

								setCustomStyle: {
									enabled: true,
									order: 100000000,
									fn: ({
										flipped,
										instance,
										instance: { reference },
										popper,
										popper: { left },
										placement,
										styles
									}) =>
										(reference.dataset.submenu =
											placement === 'left'
												? 'left'
												: 'right')
								}
							},
							placement: 'right'
						}))
				)
			})

		menu.parentNode.addEventListener(
			'mouseleave',
			() => {
				;[...menu.children]
					.filter(
						el =>
							el.classList.contains('menu-item-has-children') ||
							el.classList.contains('page_item_has_children')
					)
					.map(el => el.querySelector('.sub-menu'))
					.map(menu => {
						if (!menu._popper) return

						menu._popper.destroy()
						menu._popper = null
					})

				menu._timeout_id = setTimeout(() => {
					menu._timeout_id = null
					;[...menu.children]
						.filter(
							el =>
								el.classList.contains(
									'menu-item-has-children'
								) ||
								el.classList.contains('page_item_has_children')
						)
						.map(el => el.removeAttribute('data-submenu'))
				}, 200)
			},
			{ once: true }
		)
	})
}
