import { markImagesAsLoaded } from '../../frontend/lazy-load-helpers'
import { getCache } from './helpers'
import { typographyOption } from './variables/typography'

const enabledKeysForPrefix = {
	blog: 'blog_page_title_enabled',
	single_blog_post: 'single_blog_post_title_enabled',
	single_page: 'single_page_title_enabled',
	search: 'search_page_title_enabled',
	categories: 'categories_has_page_title',
	woo_categories: 'woo_categories_has_page_title'
}

export const getPrefixFor = () => {
	if (
		document.body.classList.contains('blog') &&
		document.body.classList.contains('home')
	) {
		return 'blog'
	}

	if (document.body.classList.contains('single')) {
		return 'single_blog_post'
	}

	if (
		document.body.classList.contains('woocommerce-archive')
		// document.body.classList.contains('woocommerce-cart') ||
		// document.body.classList.contains('woocommerce-checkout') ||
		// document.body.classList.contains('woocommerce-account') ||
		// document.body.classList.contains('post-type-archive-product')
	) {
		return 'woo_categories'
	}

	if (
		document.body.classList.contains('page') ||
		document.body.classList.contains('blog') ||
		document.body.classList.contains('post-type-archive-product')
	) {
		return 'single_page'
	}

	if (document.body.classList.contains('search')) {
		return 'search'
	}

	if (
		document.body.classList.contains('archive') &&
		!document.body.classList.contains('author')
	) {
		return 'categories'
	}

	return false
}

const getEnabledKey = () => {
	if (
		document.body.classList.contains('blog') &&
		document.body.classList.contains('home')
	) {
		return 'blog_page_title_enabled'
	}

	if (document.body.classList.contains('single')) {
		return 'single_blog_post_title_enabled'
	}

	if (
		document.body.classList.contains('woocommerce-archive')
		// document.body.classList.contains('woocommerce-cart') ||
		// document.body.classList.contains('woocommerce-checkout') ||
		// document.body.classList.contains('woocommerce-account') ||
		// document.body.classList.contains('post-type-archive-product')
	) {
		return 'woo_categories_has_page_title'
	}

	if (
		document.body.classList.contains('page') ||
		document.body.classList.contains('blog') ||
		document.body.classList.contains('post-type-archive-product')
	) {
		return 'single_page_title_enabled'
	}

	if (document.body.classList.contains('search')) {
		return 'search_page_title_enabled'
	}

	if (
		document.body.classList.contains('archive') &&
		!document.body.classList.contains('author')
	) {
		return 'categories_has_page_title'
	}

	return false
}

export const getOptionFor = (key, prefix = '') =>
	wp.customize(`${prefix}${prefix.length > 0 ? '_' : ''}${key}`)()

export const renderHeroSection = prefix => {
	if (prefix !== getPrefixFor()) {
		return
	}

	const cache = getCache()

	const isCustom = cache.querySelector(
		'.ct-customizer-preview-cache [data-hero-section-custom]'
	)

	if (isCustom) {
		return
	}

	;[...document.querySelectorAll('.hero-section')].map(el =>
		el.parentNode.removeChild(el)
	)

	if (getOptionFor(getEnabledKey()) === 'no') {
		return
	}

	const type = getOptionFor('hero_section', prefix)

	const newHtml = cache.querySelector(
		`.ct-customizer-preview-cache .ct-hero-section-cache[data-type="${type}"]`
	).innerHTML

	const e = document.createElement('div')
	e.innerHTML = newHtml

	while (e.firstElementChild) {
		let type1Selector =
			prefix === 'single_blog_post' ||
			(prefix === 'single_page' &&
				!document.body.classList.contains('blog'))
				? document.body.classList.contains('single-product')
					? '.woocommerce .summary .price'
					: 'article .entry-content'
				: document.body.classList.contains('woocommerce-archive')
					? 'article .entry-content'
					: '.entries'

		if (document.body.classList.contains('post-type-archive-product')) {
			type1Selector = '.woo-listing-top'
		}

		if (prefix === 'single_blog_post') {
			if (
				document
					.querySelector('article .entry-content')
					.parentNode.firstElementChild.classList.contains(
						'share-box'
					)
			) {
				type1Selector = 'article .share-box:first-child'
			}
		}

		let entries = document.querySelector(
			type === 'type-1' ? type1Selector : '#primary.content-area'
		)

		entries.parentNode.insertBefore(e.firstElementChild, entries)
	}

	if (
		getOptionFor('page_title_bg_type', prefix) === 'color' &&
		document.querySelector('.hero-section figure')
	) {
		document
			.querySelector('.hero-section figure')
			.parentNode.removeChild(
				document.querySelector('.hero-section figure')
			)
	}

	if (
		type === 'type-2' &&
		getOptionFor('page_title_bg_type', prefix) === 'custom_image'
	) {
		if (!getOptionFor('custom_hero_background', prefix).attachment_id) {
			if (document.querySelector('.hero-section figure')) {
				document
					.querySelector('.hero-section figure')
					.parentNode.removeChild(
						document.querySelector('.hero-section figure')
					)
			}
		} else {
			wp.media
				.attachment(
					getOptionFor('custom_hero_background', prefix).attachment_id
				)
				.fetch()
				.then(() => {
					if (document.querySelector('.hero-section figure img')) {
						document
							.querySelector('.hero-section figure img')
							.removeAttribute('srcset')

						document
							.querySelector('.hero-section figure img')
							.removeAttribute('src')

						document
							.querySelector('.hero-section figure img')
							.removeAttribute('sizes')

						document.querySelector(
							'.hero-section figure img'
						).src = wp.media
							.attachment(
								getOptionFor('custom_hero_background', prefix)
									.attachment_id
							)
							.get('url')
					}
				})
		}
	}

	document.querySelector('.hero-section').removeAttribute('data-parallax')
	document.querySelector('.hero-section').dataset.alignment = getOptionFor(
		type === 'type-1' ? 'hero_alignment1' : 'hero_alignment2',
		prefix
	)

	if (
		type === 'type-2' &&
		(getOptionFor('page_title_bg_type', prefix) === 'custom_image' ||
			getOptionFor('page_title_bg_type', prefix) === 'featured_image') &&
		getOptionFor('enable_parallax', prefix) === 'yes'
	) {
		if (document.querySelector('.hero-section figure')) {
			document.querySelector('.hero-section').dataset.parallax = ''

			window.ctEvents.trigger('blocksy:parallax:init')
		}
	}

	renderHeroSectionTexts(prefix)
	markImagesAsLoaded(document.querySelector('.site-main'))
}

export const renderHeroSectionTexts = prefix => {
	if (prefix !== getPrefixFor()) {
		return
	}

	const cache = getCache()

	const isCustom = cache.querySelector(
		'.ct-customizer-preview-cache [data-hero-section-custom]'
	)

	if (isCustom) {
		return
	}

	if (prefix === 'blog') {
		if (getOptionFor('custom_title', prefix).trim().length > 0) {
			if (document.querySelector('.entry-header .page-title')) {
				document.querySelector(
					'.entry-header .page-title'
				).innerHTML = getOptionFor('custom_title', prefix)
			} else {
				const header = document.createElement('h1')
				header.classList.add('page-title')
				header.innerHTML = getOptionFor('custom_title', prefix)
				document.querySelector('.entry-header').appendChild(header)
			}
		} else {
			if (document.querySelector('.entry-header .page-title')) {
				document
					.querySelector('.entry-header .page-title')
					.parentNode.removeChild(
						document.querySelector('.entry-header .page-title')
					)
			}
		}
	}

	if (prefix === 'blog') {
		if (getOptionFor('custom_description', prefix).trim().length > 0) {
			if (document.querySelector('.entry-header .page-description')) {
				document.querySelector(
					'.entry-header .page-description'
				).innerHTML = getOptionFor('custom_description', prefix)
			} else {
				const header = document.createElement('div')
				header.classList.add('page-description')
				header.innerHTML = getOptionFor('custom_description', prefix)
				document.querySelector('.entry-header').appendChild(header)
			}
		} else {
			if (document.querySelector('.entry-header .page-description')) {
				document
					.querySelector('.entry-header .page-description')
					.parentNode.removeChild(
						document.querySelector(
							'.entry-header .page-description'
						)
					)
			}
		}
	}
}

const getVariablesForPrefix = prefix => ({
	[`${prefix}_hero_height`]: {
		variable: 'pageTitleMinHeight',
		responsive: true,
		unit: ''
	},

	...typographyOption({
		id: `${prefix}_pageTitleFont`,
		selector: '.entry-header .page-title'
	}),

	[`${prefix}_pageTitleFontColor`]: [
		{
			selector: ':root',
			variable: 'pageTitleFontInitialColor',
			type: 'color:default'
		},

		{
			selector: ':root',
			variable: 'pageTitleFontHoverColor',
			type: 'color:hover'
		}
	],

	[`${prefix}_pageTitleOverlay`]: {
		selector: ':root',
		variable: 'pageTitleOverlay',
		type: 'color'
	},

	[`${prefix}_pageTitleBackground`]: {
		selector: ':root',
		variable: 'pageTitleBackground',
		type: 'color'
	}
})

export const getHeroVariables = () => getVariablesForPrefix(getPrefixFor())

const watchOptionsFor = prefix => {
	;[
		enabledKeysForPrefix[prefix],
		`${prefix}_hero_alignment`,
		`${prefix}_hero_section`,
		`${prefix}_has_meta`,
		// `${prefix}_custom_title`,
		// `${prefix}_custom_description`,

		`${prefix}_page_title_bg_type`,
		`${prefix}_custom_hero_background`,
		`${prefix}_enable_parallax`
	].map(id =>
		wp.customize(id, val => val.bind(to => renderHeroSection(prefix)))
	)
	;[`${prefix}_custom_title`, `${prefix}_custom_description`].map(id =>
		wp.customize(id, val => val.bind(to => renderHeroSectionTexts(prefix)))
	)
}

Object.keys(enabledKeysForPrefix).map(prefix => watchOptionsFor(prefix))
