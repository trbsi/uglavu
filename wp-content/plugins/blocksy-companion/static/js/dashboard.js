import { createElement, Component } from '@wordpress/element'
import * as check from '@wordpress/element'

import { __ } from 'ct-i18n'
import Extensions from './screens/Extensions'

ctEvents.on('ct:dashboard:routes', r =>
	r.push({
		Component: () => <Extensions />,
		path: '/extensions'
	})
)
ctEvents.on('ct:dashboard:navigation-links', r =>
	r.push({
		text: __('Extensions', 'blc'),
		path: '/extensions'
	})
)
