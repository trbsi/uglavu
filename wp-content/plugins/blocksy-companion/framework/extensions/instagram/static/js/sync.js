import { checkAndReplace, responsiveClassesFor } from './sync/helpers'

wp.customize('insta_block_visibility', val =>
	val.bind(to => {
		const block = document.querySelector('.ct-instagram-block')

		responsiveClassesFor('insta_block_visibility', block)
	})
)

wp.customize('insta_block_location', val =>
	val.bind(to => {
		const block = document.querySelector('.ct-instagram-block')
		block.dataset.location = wp.customize('insta_block_location')()
	})
)

checkAndReplace({
	id: 'insta_block_enabled',
	strategy: 'append',

	parent_selector: '.footer-inner',
	selector: '.ct-instagram-block',
	fragment_id: 'blocksy-instagram-section',

	watch: ['insta_block_count', 'insta_block_username'],

	whenInserted: () => {
		const block = document.querySelector('.ct-instagram-block')

		if (!block) return
		responsiveClassesFor('insta_block_visibility', block)

		block.dataset.location = wp.customize('insta_block_location')()

		const currentData = JSON.parse(block.firstElementChild.dataset.widget)
		;[
			...Array(
				currentData.limit -
					parseInt(wp.customize('insta_block_count')(), 10)
			)
		].map(() =>
			block.firstElementChild.removeChild(
				block.firstElementChild.firstElementChild
			)
		)

		const username = wp.customize('insta_block_username')()

		block.firstElementChild.dataset.widget = JSON.stringify({
			limit: parseInt(wp.customize('insta_block_count')(), 10),
			username
		})

		const link = block.querySelector('.ct-instagram-follow')
		link.href = `https://instagram.com/${username}`
		link.innerHTML = `@${username}`

		ctEvents.trigger('blocksy:instagram:init')
	}
})
