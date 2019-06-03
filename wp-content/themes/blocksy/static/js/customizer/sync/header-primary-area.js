import { getCache } from './helpers'
import { responsiveClassesFor, stackingClassesFor } from './footer'

const renderColumn = number => {
	const kind =
		wp.customize(`header_top_bar_section_${number}`)() ||
		(number === '1' ? 'header_menu' : 'social_icons')

	if (kind === 'disabled') {
		return
	}

	const newHtml = getCache().querySelector(
		`.ct-customizer-preview-cache [data-id="${
			{
				header_menu: 'header-top-bar-menu',
				custom_text: 'header-top-bar-text',
				social_icons: 'header-top-bar-socials'
			}[kind]
		}"]`
	).innerHTML

	const e = document.createElement('div')
	e.innerHTML = newHtml

	if (kind === 'custom_text') {
		e.querySelector('.ct-custom-text').innerHTML =
			wp.customize(`header_top_bar_section_${number}_text`)() ||
			'Sample text'
	}

	if (kind === 'social_icons') {
		const cache = document.createElement('div')
		cache.innerHTML = e.querySelector('.ct-social-box').innerHTML

		e.querySelector('.ct-social-box').innerHTML = ''

		wp
			.customize(`header_top_bar_socials_${number}`)()
			.map(({ id, enabled }) => {
				if (!enabled) return

				e
					.querySelector('.ct-social-box')
					.appendChild(cache.querySelector(`[data-network=${id}]`))
			})
	}

	while (e.firstElementChild) {
		document
			.querySelector('.site-header .header-top-bar .grid-columns')
			.appendChild(e.firstElementChild)
	}
}

const renderTopBar = () => {
	const cacheElement = getCache().querySelector(
		`.ct-customizer-preview-cache [data-id="header-top-bar"]`
	)

	if (!cacheElement) {
		return
	}

	const hasTopBar = (wp.customize('has_top_bar')() || 'yes') === 'yes'
	document.querySelector('.site-header').removeAttribute('data-top-bar-stack')

	if (document.querySelector('.site-header > .header-top-bar')) {
		;[...document.querySelectorAll('.site-header > .header-top-bar')].map(
			el => el.parentNode.removeChild(el)
		)
	}

	if (!hasTopBar) return

	const newHtml = cacheElement.innerHTML

	const e = document.createElement('div')
	e.innerHTML = newHtml

	const header = document.querySelector('.site-header')

	while (e.firstElementChild) {
		header.insertBefore(e.firstElementChild, header.firstElementChild)
	}

	const headerBar = document.querySelector('.site-header .header-top-bar')

	headerBar
		.querySelector('.grid-columns')
		.classList.remove(
			[...headerBar.querySelector('.grid-columns').classList].find(
				className => className.indexOf('ct-container') > -1
			)
		)

	headerBar
		.querySelector('.grid-columns')
		.classList.add(
			`ct-container${
				wp.customize('top_bar_container')() === 'fluid' ? '-fluid' : ''
			}`
		)

	headerBar.querySelector('.grid-columns').removeAttribute('data-columns')

	if (
		(wp.customize('header_top_bar_section_1')() || 'header_menu') !==
			'disabled' &&
		(wp.customize('header_top_bar_section_2')() || 'social_icons') !==
			'disabled'
	) {
		headerBar.querySelector('.grid-columns').dataset.columns = 2
	} else {
		if (
			(wp.customize('header_top_bar_section_1')() || 'header_menu') !==
				'disabled' ||
			(wp.customize('header_top_bar_section_2')() || 'social_icons') !==
				'disabled'
		) {
			headerBar.querySelector('.grid-columns').dataset.columns = 1
		}
	}

	headerBar.querySelector('.grid-columns').innerHTML = ''

	renderColumn('1')
	renderColumn('2')

	stackingClassesFor(
		'top_bar_stacking',
		document.querySelector('.site-header'),
		'topBarStack',

		(wp.customize('header_top_bar_section_1')() || 'header_menu') !==
			'disabled' &&
			(wp.customize('header_top_bar_section_2')() || 'social_icons') !==
				'disabled'
	)
}

wp.customize('has_top_bar', val => val.bind(to => renderTopBar()))
wp.customize('top_bar_container', val => val.bind(to => renderTopBar()))
wp.customize('header_top_bar_section_1', val => val.bind(to => renderTopBar()))
wp.customize('header_top_bar_section_2', val => val.bind(to => renderTopBar()))
wp.customize('header_top_bar_section_1_text', val =>
	val.bind(to => renderTopBar())
)
wp.customize('header_top_bar_section_2_text', val =>
	val.bind(to => renderTopBar())
)

wp.customize('header_top_bar_socials_1', val => val.bind(to => renderTopBar()))
wp.customize('header_top_bar_socials_2', val => val.bind(to => renderTopBar()))

wp.customize('top_bar_visibility', val =>
	val.bind(to =>
		responsiveClassesFor(
			'top_bar_visibility',
			document.querySelector('.site-header .header-top-bar')
		)
	)
)

wp.customize('top_bar_stacking', val =>
	val.bind(to =>
		stackingClassesFor(
			'top_bar_stacking',
			document.querySelector('.site-header'),
			'topBarStack',
			(wp.customize('header_top_bar_section_1')() || 'header_menu') !==
				'disabled' &&
				(wp.customize('header_top_bar_section_2')() ||
					'social_icons') !== 'disabled'
		)
	)
)
