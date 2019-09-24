import { createElement, render } from '@wordpress/element'
import Notification from './Notification'

export const mount = el => {
	if (el.querySelector('.notice-blocksy-plugin-root')) {
		render(
			<Notification
				initialStatus={
					el.querySelector('.notice-blocksy-plugin-root').dataset
						.pluginStatus
				}
				url={
					el.querySelector('.notice-blocksy-plugin-root').dataset.url
				}
				pluginUrl={
					el.querySelector('.notice-blocksy-plugin-root').dataset
						.pluginUrl
				}
				pluginLink={
					el.querySelector('.notice-blocksy-plugin-root').dataset.link
				}
			/>,
			el.querySelector('.notice-blocksy-plugin-root')
		)
	}
}
