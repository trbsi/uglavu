import {
	createElement,
	Component,
	useEffect,
	useState,
	createContext,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import useExtensionReadme from '../helpers/useExtensionReadme'
import useActivationAction from '../helpers/useActivationAction'
import { Transition, animated } from 'react-spring/renderprops'
import DemosList from './DemoInstall/DemosList'

export const DemosContext = createContext({
	demos: []
})

import SubmitSupport from '../helpers/SubmitSupport'

const DemoToInstall = () => {
	return <div>demo</div>
}

let demos_cache = null

const DemoInstall = ({ children }) => {
	const [isLoading, setIsLoading] = useState(!demos_cache)
	const [demos_list, setDemosList] = useState(demos_cache || [])

	const syncDemos = async (verbose = false) => {
		if (verbose) {
			setIsLoading(true)
		}

		const body = new FormData()
		body.append('action', 'blocksy_demo_list')

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			if (response.status === 200) {
				const { success, data } = await response.json()

				if (success) {
					setDemosList(data.demos)
					demos_cache = data.demos
				}
			}
		} catch (e) {}

		setIsLoading(false)
	}

	useEffect(() => {
		syncDemos(!demos_cache)
	}, [])

	return (
		<div className="ct-demos-list-container">
			<Transition
				items={isLoading}
				from={{ opacity: 0 }}
				enter={[{ opacity: 1 }]}
				leave={[{ opacity: 0 }]}
				initial={null}
				config={(key, phase) => {
					return phase === 'leave'
						? {
								duration: 300
							}
						: {
								delay: 300,
								duration: 300
							}
				}}>
				{isLoading => {
					if (isLoading) {
						return props => (
							<animated.p
								style={props}
								className="ct-loading-text">
								<span />

								{__('Loading Demo Sites...', 'blc')}
							</animated.p>
						)
					}

					return props => (
						<animated.div style={props}>
							<Fragment>
								<DemosContext.Provider
									value={{
										demos_list
									}}>
									<DemosList />
									{children}
								</DemosContext.Provider>
								<SubmitSupport />
							</Fragment>
						</animated.div>
					)
				}}
			</Transition>
		</div>
	)
}

export default DemoInstall
