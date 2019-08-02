import { getCache } from './helpers'

import { responsiveClassesFor, stackingClassesFor } from './footer'

const renderCtaButton = () =>
	[...document.querySelectorAll('.ct-header-button')].map(button => {
		button.innerHTML = wp.customize('header_button_text')()
		button.href = wp.customize('header_button_link')()

		button.removeAttribute('target')

		button.dataset.size = wp.customize('header_button_size')()
		button.dataset.type = wp.customize('header_button_type')()

		if (wp.customize('header_button_target')() === 'yes') {
			button.target = '_blank'
		}

		responsiveClassesFor('header_button_visibility', button)
	})

const updateHeader = () => {
	const header = document.querySelector('header.site-header')
	const to = wp.customize('header_type')() || 'type-1'

	document.body.classList.remove('header-type-1')
	document.body.classList.remove('header-type-2')

	document.body.classList.add(`header-${to}`)

	header.removeAttribute('data-border')

	if (wp.customize('headerBottomBorder')().style !== 'none') {
		header.dataset.border =
			wp.customize('headerBottomBorderContainer')() === 'yes'
				? 'full-width'
				: 'contained'
	}

	const newHtml = getCache().querySelector(
		`.ct-customizer-preview-cache [data-id="header"] [data-type="${to}"]`
	).innerHTML

	const oldTitle = document.querySelector('.site-title').innerHTML

	const e = document.createElement('div')
	e.innerHTML = newHtml
	;[...e.querySelectorAll('.site-title')].map(el => (el.innerHTML = oldTitle))

	if (header.querySelector('.header-desktop')) {
		header.removeChild(header.querySelector('.header-desktop'))
	}

	while (e.firstElementChild) {
		header.insertBefore(
			e.firstElementChild,
			header.querySelector('.header-mobile')
		)
	}

	;[...document.querySelectorAll('.site-header .search-button')].map(el =>
		responsiveClassesFor('header_search_visibility', el)
	)

	if (to === 'type-1') {
		document.querySelector(
			'[data-type="type-1"] [data-menu-alignment]'
		).dataset.menuAlignment = wp.customize('menu_alignment')()
	}

	if (to === 'type-2') {
		const navigationRow = header.querySelector('.navigation-row')
		navigationRow.removeAttribute('data-border')

		if (wp.customize('headerTopBorder')().style !== 'none') {
			navigationRow.dataset.border =
				wp.customize('headerTopBorderFull')() === 'yes'
					? 'full-width'
					: 'contained'
		}
	}

	;[...document.querySelectorAll('.site-header .ct-header-cart')].map(el =>
		responsiveClassesFor('header_cart_visibility', el)
	)
	;[...document.querySelectorAll('.site-description')].map(el => {
		el.innerHTML = wp.customize('blogdescription')()
		responsiveClassesFor('tagline_search_visibility', el)
	})
	;[...document.querySelectorAll('.site-title a')].map(el => {
		if (wp.customize('logo_type')() === 'text') {
			el.innerHTML = wp.customize('blogname')()
		}
	})

	if (wp.customize('has_cart_badge')) {
		if (wp.customize('has_cart_badge')() === 'yes') {
			document
				.querySelector('.site-header .ct-header-cart')
				.removeAttribute('data-skip-badge')
		} else {
			document.querySelector(
				'.site-header .ct-header-cart'
			).dataset.skipBadge =
				''
		}
	}

	const miniCartHtml = wp.customize('mini_cart_type')
		? getCache().querySelector(
				`.ct-customizer-preview-cache [data-header-cart="${wp.customize(
					'mini_cart_type'
				)()}"]`
			).innerHTML
		: ''
	;[...document.querySelectorAll('.site-header .ct-cart-icon')].map(
		el => (el.innerHTML = miniCartHtml)
	)

	renderCtaButton()
	;[...document.querySelectorAll('.header-desktop nav.main-navigation')].map(
		el => {
			el.removeAttribute('data-menu-divider')

			if (wp.customize('menu_items_divider')() !== 'default') {
				el.dataset.menuDivider = wp.customize('menu_items_divider')()
			}

			el.dataset.menuType = wp.customize('header_menu_type')()
			el.dataset.dropdownAnimation = wp.customize('dropdown_animation')()
		}
	)

	ctEvents.trigger('ct:header:update')
}

wp.customize('headerTopBorder', val => val.bind(to => updateHeader()))
wp.customize('menu_items_divider', val => val.bind(to => updateHeader()))
wp.customize('header_menu_type', val => val.bind(to => updateHeader()))
wp.customize('dropdown_animation', val => val.bind(to => updateHeader()))
wp.customize('headerTopBorderFull', val => val.bind(to => updateHeader()))
wp.customize('headerBottomBorder', val => val.bind(to => updateHeader()))
wp.customize('headerBottomBorderContainer', val =>
	val.bind(to => updateHeader())
)
wp.customize('header_type', val => val.bind(to => updateHeader()))
wp.customize('search_icon_panel', val => val.bind(to => updateHeader()))
wp.customize('menu_alignment', val => val.bind(to => updateHeader()))
wp.customize('header_search_visibility', val => val.bind(to => updateHeader()))
wp.customize('header_cart_visibility', val => val.bind(to => updateHeader()))
wp.customize('has_cart_badge', val => val.bind(to => updateHeader()))
wp.customize('tagline_search_visibility', val => val.bind(to => updateHeader()))
wp.customize('mini_cart_type', val => val.bind(to => updateHeader()))
wp.customize('header_container', val =>
	val.bind(to => {
		const headerBar = document.querySelector(
			'.header-desktop[data-type="type-1"]'
		)

		if (!headerBar) return

		headerBar.firstElementChild.classList.remove(
			[...headerBar.firstElementChild.classList].find(
				className => className.indexOf('ct-container') > -1
			)
		)

		headerBar.firstElementChild.classList.add(
			`ct-container${to === 'fluid' ? '-fluid' : ''}`
		)
	})
)

wp.customize('nav_container', val =>
	val.bind(to => {
		const headerBar = document.querySelector(
			'.header-desktop[data-type="type-2"]'
		)

		if (!headerBar) return

		headerBar.lastElementChild.firstElementChild.classList.remove(
			[...headerBar.lastElementChild.firstElementChild.classList].find(
				className => className.indexOf('ct-container') > -1
			)
		)

		headerBar.lastElementChild.firstElementChild.classList.add(
			`ct-container${to === 'fluid' ? '-fluid' : ''}`
		)
	})
)

wp.customize('mobile_header_type', val =>
	val.bind(to => (document.querySelector('.header-mobile').dataset.type = to))
)

wp.customize('mobile_menu_modal_behavior', val =>
	val.bind(to => {
		const modal = document.querySelector('#mobile-menu')

		document.body.classList.remove('ct-offcanvas')
		modal.classList.remove('ct-offcanvas-menu', 'ct-modal')

		if (to === 'offcanvas') {
			document.body.classList.add('ct-offcanvas')
		}

		modal.classList.add(`ct-${to === 'offcanvas' ? 'offcanvas-menu' : to}`)
	})
)

wp.customize('header_button_type', val => val.bind(to => renderCtaButton()))
wp.customize('header_button_size', val => val.bind(to => renderCtaButton()))
wp.customize('header_button_text', val => val.bind(to => renderCtaButton()))
wp.customize('header_button_link', val => val.bind(to => renderCtaButton()))
wp.customize('header_button_target', val => val.bind(to => renderCtaButton()))
wp.customize('header_button_target', val => val.bind(to => renderCtaButton()))
wp.customize('header_button_visibility', val =>
	val.bind(to => renderCtaButton())
)

wp.customize('mobile_menu_trigger_type', val =>
	val.bind(to =>
		[...document.querySelectorAll('.mobile-menu-toggle > span')].map(
			el => (el.dataset.type = to)
		)
	)
)
