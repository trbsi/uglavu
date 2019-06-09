import $ from 'jquery'
import { markImagesAsLoaded } from '../../../instagram/static/js/lazy-load-helpers'

const store = {}

const cachedFetch = url =>
	store[url]
		? new Promise(resolve => {
				resolve(store[url])
				store[url] = store[url].clone()
			})
		: new Promise(resolve =>
				fetch(url).then(response => {
					resolve(response)
					store[url] = response.clone()
				})
			)

const mount = () =>
	[...document.querySelectorAll('.ct-open-quick-view')].map(el => {
		if (el.hasQuickViewInit) return
		el.hasQuickViewInit = true

		el.addEventListener('click', e => {
			e.preventDefault()

			el.closest('.shop-entry-card').classList.add('ct-loading-view')

			if (document.querySelector(el.hash)) {
				el
					.closest('.shop-entry-card')
					.classList.remove('ct-loading-view')

				ctEvents.trigger('ct:overlay:handle-click', {
					e,
					el,
					options: {
						clickOutside: true
					}
				})
				return
			}

			cachedFetch(
				`${
					ct_localizations.ajax_url
				}?action=blocsky_get_woo_quick_view&product_id=${
					el.href.split('-')[el.href.split('-').length - 1]
				}`
			).then(r => {
				if (r.status === 200) {
					r.json().then(({ success, data }) => {
						if (!success) return

						const div = document.createElement('div')

						div.innerHTML = data.quickview

						if (div.querySelector('.ct-quick-add')) {
							div.querySelector(
								'.ct-quick-add'
							).innerHTML = div.querySelector(
								'.single_add_to_cart_button'
							).innerHTML
						}

						markImagesAsLoaded(div)

						document.body.appendChild(div.firstElementChild)

						el
							.closest('.shop-entry-card')
							.classList.remove('ct-loading-view')

						const wc_single_product_params = {
							i18n_required_rating_text: 'Please select a rating',
							review_rating_required: 'yes',
							flexslider: {
								rtl: false,
								animation: 'slide',
								smoothHeight: true,
								directionNav: false,
								controlNav: 'thumbnails',
								slideshow: false,
								animationSpeed: 500,
								animationLoop: false,
								allowOneSlide: false
							},
							zoom_enabled: '',
							zoom_options: [],
							photoswipe_enabled: '1',
							photoswipe_options: {
								shareEl: false,
								closeOnScroll: false,
								history: false,
								hideAnimationDuration: 0,
								showAnimationDuration: 0
							},
							flexslider_enabled: '1'
						}

						$(`${el.hash} .variations_form`).each(function() {
							$(this).wc_variation_form()
						})

						ctEvents.trigger('ct:custom-select:init')
						ctEvents.trigger('ct:custom-select-allow:init')

						ctEvents.trigger('ct:add-to-cart:update')
						ctEvents.trigger('ct:overlay:handle-click', {
							e,
							el,
							options: {
								clickOutside: true
							}
						})

						setTimeout(() => {
							ctEvents.trigger('ct:flexy:update')
						})
					})
				}
			})
		})
	})

document.addEventListener('DOMContentLoaded', () => {
	mount()
	ctEvents.on('ct:quick-view:update', () => mount())

	ctEvents.on('ct:modal:closed', modalContainer => {
		if (
			!modalContainer
				.closest('.ct-modal')
				.classList.contains('quick-view-modal')
		) {
			return
		}

		if (modalContainer.querySelector('.flexy-container')) {
			const flexyEl = modalContainer.querySelector('.flexy-container')
				.parentNode

			flexyEl.flexy.destroy()
		}

		setTimeout(() => {
			modalContainer.parentNode.parentNode.removeChild(
				modalContainer.parentNode
			)
		})
	})
})
