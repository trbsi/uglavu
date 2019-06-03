import { markImagesAsLoaded } from '../../frontend/lazy-load-helpers'
import { responsiveClassesFor } from './footer'
import ctEvents from 'ct-events'
import { getCache } from './helpers'
import { renderHeroSection, getPrefixFor } from './hero-section'

const pageStructureFor = page_structure_type => {
	if (page_structure_type === 'type-3') {
		return 'narrow'
	}

	if (page_structure_type === 'type-4') {
		return 'normal'
	}

	if (page_structure_type === 'type-5') {
		return 'normal'
	}

	if (page_structure_type === 'type-6') {
		return 'normal:enhanced'
	}

	if (page_structure_type === 'type-7') {
		return 'boundless'
	}

	return 'none'
}

const getSidebarTypeFor = page_structure_type => {
	if (page_structure_type === 'type-1') {
		return 'right'
	}

	if (page_structure_type === 'type-2') {
		return 'left'
	}

	return 'none'
}

const handleForVal = (val, args = {}) => {
	args = {
		bodyClass: 'single-post',
		class: 'post',
		...args
	}
	val.bind(to => {
		if (
			getCache().querySelector(
				'.ct-customizer-preview-cache [data-page-structure-custom]'
			)
		) {
			return
		}

		if (!document.body.classList.contains(args.bodyClass)) {
			return
		}

		if (pageStructureFor(to) !== 'none') {
			document.querySelector(
				`article.${args.class}`
			).dataset.pageStructure = pageStructureFor(to)
		} else {
			document
				.querySelector(`article.${args.class}`)
				.removeAttribute('data-page-structure')
		}

		const sidebarEl = document.querySelector(
			'.site-main > .content-area > [class*="ct-container"]'
		)

		sidebarEl.classList.remove('ct-container', 'ct-container-boundless')
		sidebarEl.classList.add(
			to === 'type-7' ? 'ct-container-boundless' : 'ct-container'
		)

		if (getSidebarTypeFor(to) === 'none') {
			if (sidebarEl.querySelector('aside')) {
				sidebarEl.removeChild(sidebarEl.querySelector('aside'))
			}

			sidebarEl.removeAttribute('data-sidebar')
			document.body.classList.remove('ct-has-sidebar')
		} else {
			document.body.classList.add('ct-has-sidebar')
			if (sidebarEl.querySelector('aside')) {
				sidebarEl.removeChild(sidebarEl.querySelector('aside'))
			}

			sidebarEl.dataset.sidebar = getSidebarTypeFor(to)

			const newHtml = getCache().querySelector(
				`.ct-customizer-preview-cache [data-id="sidebar"]`
			).innerHTML

			const e = document.createElement('div')
			e.innerHTML = newHtml

			while (e.firstElementChild) {
				sidebarEl.appendChild(e.firstElementChild)
			}
		}

		// markImagesAsLoaded(document.querySelector('.site-main'))
		window.ctEvents.trigger('ct:sidebar:update')
	})
}

export const replaceArticleAndRemoveParts = () => {
	if (
		!document.body.classList.contains('single') &&
		!document.body.classList.contains('page')
	) {
		return
	}

	document.querySelector(
		'.site-main .content-area article'
	).innerHTML = getCache().querySelector(
		'.ct-customizer-preview-cache .single-content-cache > article'
	).innerHTML

	if ((wp.customize('has_share_box')() || 'yes') === 'no') {
		const shareBox = document.querySelectorAll(
			'.site-main .content-area article .share-box'
		)
		;[...shareBox].map(el => el && el.parentNode.removeChild(el))
	} else {
		const shareBoxLocation = wp.customize('share_box_location')() || {
			top: false,
			bottom: true
		}

		if (!shareBoxLocation.top) {
			const header = document.querySelector(
				'.site-main .content-area article .share-box[data-location="top"]'
			)

			if (header) {
				header.parentNode.removeChild(header)
			}
		}

		if (!shareBoxLocation.bottom) {
			const content = document.querySelector(
				'.site-main .content-area article .share-box[data-location="bottom"]'
			)

			if (content) {
				content.parentNode.removeChild(content)
			}
		}

		if ((wp.customize('share_facebook')() || 'yes') === 'no') {
			;[
				...document.querySelectorAll(
					'.site-main .content-area article [data-share-network="facebook"]'
				)
			].map(el => el.parentNode.removeChild(el))
		}

		if ((wp.customize('share_twitter')() || 'yes') === 'no') {
			;[
				...document.querySelectorAll(
					'.site-main .content-area article [data-share-network="twitter"]'
				)
			].map(el => el.parentNode.removeChild(el))
		}

		if ((wp.customize('share_pinterest')() || 'yes') === 'no') {
			;[
				...document.querySelectorAll(
					'.site-main .content-area article [data-share-network="pinterest"]'
				)
			].map(el => el.parentNode.removeChild(el))
		}

		if ((wp.customize('share_gplus')() || 'yes') === 'no') {
			;[
				...document.querySelectorAll(
					'.site-main .content-area article [data-share-network="google_plus"]'
				)
			].map(el => el.parentNode.removeChild(el))
		}

		if ((wp.customize('share_linkedin')() || 'yes') === 'no') {
			;[
				...document.querySelectorAll(
					'.site-main .content-area article [data-share-network="linkedin"]'
				)
			].map(el => el.parentNode.removeChild(el))
		}

		;[
			...document.querySelectorAll(
				'.site-main .content-area article .share-box'
			)
		].map(el => {
			const count = el.firstElementChild.children.length

			if (count === 0) {
				el.parentNode.removeChild(el)
				return
			}

			el.firstElementChild.dataset.count = count
		})
	}

	if ((wp.customize('has_author_box')() || 'yes') === 'no') {
		const authorBox = document.querySelector(
			'.site-main .content-area article .author-box'
		)

		authorBox && authorBox.parentNode.removeChild(authorBox)
	} else {
		if ((wp.customize('single_author_box_social')() || 'yes') === 'no') {
			const authorBoxSocial = document.querySelector(
				'.site-main .content-area article .author-box .author-box-social'
			)

			authorBoxSocial &&
				authorBoxSocial.parentNode.removeChild(authorBoxSocial)
		}

		if (
			document.querySelector(
				'.site-main .content-area article .author-box'
			)
		) {
			responsiveClassesFor(
				'author_box_visibility',
				document.querySelector(
					'.site-main .content-area article .author-box'
				)
			)
		}
	}

	if ((wp.customize('has_post_tags')() || 'yes') === 'no') {
		const postTags = document.querySelector(
			'.site-main .content-area article .entry-tags'
		)

		postTags && postTags.parentNode.removeChild(postTags)
	}

	if ((wp.customize('has_post_nav')() || 'yes') === 'no') {
		const postNav = document.querySelector(
			'.site-main .content-area article .post-navigation'
		)

		postNav && postNav.parentNode.removeChild(postNav)
	} else {
		if ((wp.customize('has_post_nav_thumb')() || 'yes') === 'no') {
			;[
				...document.querySelectorAll(
					'.site-main .content-area article .post-navigation [class*="nav-item"] > figure'
				)
			].map(el => el.parentNode.removeChild(el))
		}

		if ((wp.customize('has_post_nav_title')() || 'yes') === 'no') {
			;[
				...document.querySelectorAll(
					'.site-main .content-area article .post-navigation [class*="nav-item"] .item-title'
				)
			].map(el => el.parentNode.removeChild(el))
		}

		if (
			document.querySelector(
				'.site-main .content-area article .post-navigation'
			)
		) {
			responsiveClassesFor(
				'post_nav_visibility',
				document.querySelector(
					'.site-main .content-area article .post-navigation'
				)
			)
		}
	}

	renderHeroSection(getPrefixFor())

	markImagesAsLoaded(document.querySelector('.site-main'))
}

wp.customize('single_page_hero_section', val =>
	val.bind(to => replaceArticleAndRemoveParts())
)

wp.customize('single_blog_post_hero_section', val =>
	val.bind(to => replaceArticleAndRemoveParts())
)

wp.customize('has_share_box', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)

wp.customize('has_post_nav_title', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('has_post_nav_thumb', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)

wp.customize('share_box_location', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('share_facebook', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('share_twitter', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('share_pinterest', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('share_gplus', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('share_linkedin', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('has_author_box', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)

wp.customize('single_author_box_social', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)

wp.customize('author_box_visibility', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)
wp.customize('has_post_nav', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)

wp.customize('post_nav_visibility', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)

wp.customize('has_post_tags', val =>
	val.bind(() => replaceArticleAndRemoveParts())
)

wp.customize('has_post_comments', val =>
	val.bind(to => {
		const comments = document.querySelector(
			'.site-main .ct-comments-container'
		)
		if (comments) {
			comments.parentNode.removeChild(comments)
		}

		if (to === 'yes') {
			const newWrapper = document.createElement('div')
			newWrapper.innerHTML = getCache().querySelector(
				'.ct-customizer-preview-cache [data-part="comments"]'
			).innerHTML

			if (newWrapper.firstElementChild) {
				document
					.querySelector('.site-main')
					.appendChild(newWrapper.firstElementChild)

				if (
					!document.querySelector('.site-main .ct-related-posts') ||
					wp.customize('related_location')() === 'before'
				) {
					document
						.querySelector('.site-main')
						.appendChild(newWrapper.firstElementChild)
				} else {
					document
						.querySelector('.site-main .ct-related-posts')
						.parentNode.insertBefore(
							newWrapper.firstElementChild,
							document.querySelector(
								'.site-main .ct-related-posts'
							)
						)
				}
			}

			markImagesAsLoaded(document.querySelector('.site-main'))
		}
	})
)

const refreshRelatedPosts = (shouldInsert = true) => {
	if (!document.body.classList.contains('single')) {
		return
	}

	const relatedPosts = document.querySelector('.site-main .ct-related-posts')

	if (relatedPosts) {
		relatedPosts.parentNode.removeChild(relatedPosts)
	}

	if (!shouldInsert) return

	const newWrapper = document.createElement('div')
	newWrapper.innerHTML = getCache().querySelector(
		'.ct-customizer-preview-cache [data-part="related-posts"]'
	).innerHTML

	if (newWrapper.firstElementChild) {
		if (
			!document.querySelector('.site-main .ct-comments-container') ||
			wp.customize('related_location')() === 'after'
		) {
			document
				.querySelector('.site-main')
				.appendChild(newWrapper.firstElementChild)
		} else {
			document
				.querySelector('.site-main .ct-comments-container')
				.parentNode.insertBefore(
					newWrapper.firstElementChild,
					document.querySelector('.site-main .ct-comments-container')
				)
		}
	}

	Array.from(
		new Array(8 - parseInt(wp.customize('related_posts_count')() || 8, 10))
	).map(() =>
		document
			.querySelector('.site-main .ct-related-posts ul')
			.removeChild(
				document.querySelector('.site-main .ct-related-posts ul')
					.lastElementChild
			)
	)

	document.querySelector('.site-main .ct-related-posts ul').dataset.columns =
		wp.customize('related_posts_columns')() || 3

	document.querySelector(
		'.site-main .ct-related-posts .ct-related-posts-label'
	).innerHTML = wp.customize('related_label')()

	responsiveClassesFor(
		'related_visibility',
		document.querySelector('.site-main .ct-related-posts')
	)

	markImagesAsLoaded(document.querySelector('.site-main'))
}

wp.customize('has_related_posts', val =>
	val.bind(to => refreshRelatedPosts(to === 'yes'))
)

wp.customize('related_location', val => val.bind(to => refreshRelatedPosts()))

wp.customize('single_author_box_type', val => {
	val.bind(to => {
		if (document.querySelector('.site-main .author-box')) {
			document.querySelector('.site-main .author-box').dataset.type = to
		}
	})
})

wp.customize('related_posts_columns', val => {
	val.bind(to => {
		if (document.querySelector('.site-main .ct-related-posts ul')) {
			document.querySelector(
				'.site-main .ct-related-posts ul'
			).dataset.columns = to
		}
	})
})

wp.customize('related_posts_count', val =>
	val.bind(() => refreshRelatedPosts())
)
wp.customize('related_visibility', val => val.bind(() => refreshRelatedPosts()))

wp.customize('related_label', val => val.bind(() => refreshRelatedPosts()))

wp.customize('single_page_structure', val =>
	handleForVal(val, { bodyClass: 'page', class: 'page' })
)
wp.customize('single_blog_post_structure', val => handleForVal(val))