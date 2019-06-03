import './variables'

import { renderWithStrategy } from '../../../instagram/static/js/sync/helpers'

const maybeAnimateCookiesConsent = cb => {
	if (document.querySelector('.cookie-notification')) return

	renderWithStrategy({
		fragment_id: 'blocksy-cookies-consent-section',
		selector: '.cookie-notification',
		parent_selector: '#main-container'
	})

	return true
}

const render = () => {
	const didInsert = maybeAnimateCookiesConsent()

	const notification = document.querySelector('.cookie-notification')

	if (!notification) {
		return
	}

	notification.querySelector('p').innerHTML = wp.customize(
		'cookie_consent_content'
	)()

	notification.querySelector('button.ct-accept').innerHTML = wp.customize(
		'cookie_consent_button_text'
	)()

	const type = wp.customize('cookie_consent_type')()

	notification.dataset.type = type

	notification.firstElementChild.classList.remove('ct-container', 'container')
	notification.firstElementChild.classList.add(
		type === 'type-1' ? 'container' : 'ct-container'
	)

	if (didInsert) {
		setTimeout(() => window.ctEvents.trigger('blocksy:cookies:init'))
	}
}

wp.customize('cookie_consent_content', val =>
	val.bind(to => {
		render()
	})
)
wp.customize('cookie_consent_button_text', val => val.bind(to => render()))
wp.customize('cookie_consent_type', val => val.bind(to => render()))
