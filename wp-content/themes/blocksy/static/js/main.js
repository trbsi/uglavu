import './public-path.js'
import './frontend/polyfills'
import './frontend/ct-events.js'
import './frontend/lazy-load.js'
import './frontend/comments'
import './frontend/social-buttons'
import { maybeMountPerfLogger } from './frontend/perf-log'
import './frontend/choices'
import './frontend/woocommerce/add-to-cart-single'
import { watchLayoutContainerForReveal } from './frontend/animated-element'
import './frontend/parallax/register-listener'
import './frontend/woocommerce/single-product-gallery'

maybeMountPerfLogger()

const importAndInitLazyLoad = (layoutEl, msnry = null) =>
	import('./frontend/layouts/infinite-scroll').then(
		({ maybeInitInfiniteScroll }) =>
			maybeInitInfiniteScroll(layoutEl, msnry)
	)

document.addEventListener('DOMContentLoaded', () => {
	if (document.querySelector('.ct-quantity')) {
		import('./frontend/woocommerce/quantity-input').then(({ mount }) =>
			mount()
		)
	}

	if (document.querySelector('body.ct-ajax-add-to-cart')) {
		import('./frontend/woocommerce/add-to-cart-single').then(({ mount }) =>
			mount()
		)
	}

	ctEvents.on('ct:add-to-cart:update', () => {
		import('./frontend/woocommerce/add-to-cart-single').then(({ mount }) =>
			mount()
		)

		import('./frontend/woocommerce/quantity-input').then(({ mount }) =>
			mount()
		)
	})
	;[...document.querySelectorAll('.entries[data-layout]')].map(layoutEl => {
		importAndInitLazyLoad(layoutEl)
		watchLayoutContainerForReveal(layoutEl)
	})
})

document.addEventListener('DOMContentLoaded', () => {
	ctEvents.on('ct:footer-reveal:update', () => {
		import('./frontend/footer-reveal').then(({ mount }) => mount())
	})

	if (document.querySelector('[data-footer-reveal]')) {
		import('./frontend/footer-reveal').then(({ mount }) => mount())
	}

	if (document.querySelector('.ct-header-cart')) {
		import('./frontend/woocommerce/mini-cart').then(({ mount }) => mount())
	}

	if (document.querySelector('.ct-back-to-top')) {
		import('./frontend/back-to-top-link').then(({ mount }) => mount())
	}

	if (document.querySelector('.share-box[data-type="type-2"]')) {
		import('./frontend/share-box').then(({ mount }) => mount())
	}

	var pickclick =
		navigator.userAgent.match(/iPad/i) ||
		navigator.userAgent.match(/iPhone/)
			? 'touchend'
			: 'click'

	document
		.querySelector('#mobile-menu')
		.addEventListener(pickclick, event => {
			event.stopPropagation()
		})

	document
		.querySelector('.mobile-menu-toggle')
		.addEventListener(pickclick, event => {
			event.preventDefault()
			event.stopPropagation()

			document
				.querySelector('.mobile-menu-toggle')
				.firstElementChild.classList.toggle('close')

			if (document.querySelector('.ct-offcanvas-menu')) {
				import('./frontend/offcanvas').then(({ handleClick }) =>
					handleClick(event)
				)
				return
			}

			import('./frontend/search-overlay').then(({ handleClick }) =>
				handleClick(
					event,
					document.querySelector('.mobile-menu-toggle'),
					{
						modalTarget: document.querySelector(
							'.mobile-menu-toggle'
						).hash
					}
				)
			)
		})
})

ctEvents.on('ct:overlay:handle-click', ({ e, el, options = {} }) => {
	import('./frontend/search-overlay').then(({ handleClick }) =>
		handleClick(e, el, {
			modalTarget: el.hash,
			...options
		})
	)
})

document.addEventListener('DOMContentLoaded', () => {
	setTimeout(() => {
		document.body.classList.remove('ct-loading')
	}, 1500)
	;[
		...document.querySelectorAll([
			'.ct-sidebar .ct-widget .search-form:not(.woocommerce-product-search)'
		])
	].map(formEl =>
		import('./frontend/search-implementation.js').then(
			({ handleSingleSearchForm }) => handleSingleSearchForm(formEl)
		)
	)
	;[
		...document.querySelectorAll(
			'.ct-sidebar .ct-widget .woocommerce-product-search'
		)
	].map(formEl =>
		import('./frontend/search-implementation').then(
			({ handleSingleSearchForm }) =>
				handleSingleSearchForm(formEl, {
					postType: 'ct_forced_product'
				})
		)
	)
	;[
		...document.querySelectorAll([
			'[id="search-modal"][data-live-results] .search-form'
		])
	].map(formEl =>
		import('./frontend/search-implementation').then(
			({ handleSingleSearchForm }) =>
				handleSingleSearchForm(formEl, {
					mode: 'modal',
					perPage: 6
				})
		)
	)
})

const initMenu = () => {
	;[
		...document.querySelectorAll(
			'header.site-header [id="site-navigation"] > .primary-menu'
		)
	].map(
		menu =>
			getComputedStyle(
				document.querySelector('.mobile-menu-toggle'),
				':before'
			).content.indexOf('mobile') === -1 &&
			import('./frontend/menu').then(({ handleFirstLevelForMenu }) =>
				handleFirstLevelForMenu(menu)
			)
	)
	;[
		...document.querySelectorAll(
			'header.site-header [id="site-navigation"] > .primary-menu .menu-item-has-children > .sub-menu'
		),

		...document.querySelectorAll(
			'header.site-header [id="site-navigation"] > .primary-menu .page_item_has_children > .sub-menu'
		)
	].map(
		menu =>
			getComputedStyle(
				document.querySelector('.mobile-menu-toggle'),
				':before'
			).content.indexOf('mobile') === -1 &&
			import('./frontend/menu').then(({ handleUpdate }) =>
				handleUpdate(menu)
			)
	)
}

const initMobileMenu = () =>
	[...document.querySelectorAll('#mobile-menu .menu-arrow')].map(arrow =>
		import('./frontend/mobile-menu').then(({ handleArrow }) =>
			handleArrow(arrow)
		)
	)

const initSearch = () =>
	[
		...document.querySelectorAll([
			'.ct-modal-action',
			'header.site-header .search-button'
		])
	].map(singleAction =>
		import('./frontend/search-overlay').then(({ initSingleModal }) =>
			initSingleModal(singleAction)
		)
	)

document.addEventListener('DOMContentLoaded', () => {
	initMenu()
	initMobileMenu()
	initSearch()
})

ctEvents.on('ct:header:update', () => {
	initMenu()
	initMobileMenu()
	initSearch()
})
