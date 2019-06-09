import { createElement, Component } from '@wordpress/element'
import * as check from '@wordpress/element'

import { __ } from 'ct-i18n'

import Extensions from './screens/Extensions'
import DemoInstall from './screens/DemoInstall'
import SiteExport from './screens/SiteExport'
import DemoToInstall from './screens/DemoInstall/DemoToInstall'

ctEvents.on('ct:dashboard:routes', r => {
	r.push({
		Component: () => <Extensions />,
		path: '/extensions'
	})

	if (ct_localizations.is_dev_mode) {
		r.push({
			Component: props => <DemoInstall {...props} />,
			path: '/demos',
			children: <DemoToInstall path=":demoId" />
		})

		r.push({
			Component: () => <SiteExport />,
			path: '/site-export'
		})
	}
})

ctEvents.on('ct:dashboard:navigation-links', r => {
	r.push({
		text: __('Extensions', 'blc'),
		path: '/extensions'
	})

	if (ct_localizations.is_dev_mode) {
		r.push({
			text: __('Demo Install', 'blc'),
			path: 'demos',
			getProps: ({ isPartiallyCurrent, isCurrent }) =>
				isPartiallyCurrent
					? {
							'aria-current': 'page'
						}
					: {}
		})

		r.push({
			text: __('Export Site', 'blc'),
			path: '/site-export'
		})
	}
})
