import {
	createElement,
	Component,
	useEffect,
	useState,
	useRef,
	createContext,
	useContext,
	Fragment
} from '@wordpress/element'
import { sprintf, __ } from 'ct-i18n'
import classnames from 'classnames'
import { DemosContext } from '../DemoInstall'
import DashboardContext from '../../DashboardContext'
import { Transition } from 'react-spring/renderprops'

import InstallCompleted from './Installer/InstallCompleted'

import { getNameForPlugin } from './Wizzard/Plugins'

const listener = e => {
	e.preventDefault()
	e.returnValue = ''
}

const getMessageForAction = message => {
	const { action } = message
	if (action === 'complete') {
		return ''
	}

	if (action === 'import_install_child') {
		return __('copying child theme sources', 'blc')
	}

	if (action === 'import_activate_child') {
		return __('activating child theme', 'blc')
	}

	if (action === 'install_plugin') {
		return sprintf(
			__('installing plugin %s', 'blc'),
			getNameForPlugin(message.name) || message.name
		)
	}

	if (action === 'activate_plugin') {
		return sprintf(
			__('activating plugin %s', 'blc'),
			getNameForPlugin(message.name) || message.name
		)
	}

	return ''
}

const getStepsForDemoConfiguration = (
	demoConfiguration,
	pluginsStatus,
	is_child_theme
) => {
	let steps = []

	if (demoConfiguration.child_theme) {
		if (!is_child_theme) {
			steps.push('child_theme')
		}
	}

	if (
		demoConfiguration.plugins.filter(
			({ enabled, plugin }) => !!enabled && !pluginsStatus[plugin]
		).length > 0
	) {
		steps.push('plugins')
	}

	if (demoConfiguration.content.erase_content) {
		steps.push('erase_content')
	}

	if (demoConfiguration.content.options) {
		steps.push('options')
	}

	if (demoConfiguration.content.widgets) {
		steps.push('widgets')
	}

	if (demoConfiguration.content.content) {
		steps.push('content')
	}

	return steps
}

const getCompactSteps = (allSteps, stepName) => {
	return allSteps

	const isCompactStep = step =>
		step === 'options' || step === 'widgets' || step === 'content'

	const compactedSteps = allSteps.filter(isCompactStep)
	const otherSteps = allSteps.filter(step => !isCompactStep(step))

	return isCompactStep(stepName) && compactedSteps.includes(stepName)
		? [...otherSteps, stepName]
		: [
				...otherSteps,
				...(compactedSteps.length > 0 ? [compactedSteps[0]] : [])
			]
}

const DemoInstaller = ({ demoConfiguration }) => {
	const {
		demos_list,
		currentDemo,
		setCurrentDemo,
		setInstallerBlockingReleased,
		pluginsStatus
	} = useContext(DemosContext)

	const { home_url, customizer_url, is_child_theme, Link } = useContext(
		DashboardContext
	)

	const [isCompleted, setIsCompleted] = useState(false)
	const [currentStep, setCurrentStep] = useState(0)

	const [properDemoName, _] = (currentDemo || '').split(':')

	const demoVariations = demos_list.filter(
		({ name }) => name === properDemoName
	)

	const pluginsToActivate = demoConfiguration.plugins
		.filter(({ enabled, plugin }) => enabled && !pluginsStatus[plugin])
		.map(({ plugin }) => plugin)

	const [stepsDescriptors, setStepsDescriptors] = useState({
		child_theme: {
			title: __('Child theme', 'blc'),
			query_string: `action=blocksy_demo_install_child_theme`,
			expected_signals: 3
		},

		plugins: {
			title: __('Required plugins', 'blc'),
			query_string: `action=blocksy_demo_activate_plugins&plugins=${pluginsToActivate.join(
				':'
			)}`,
			expected_signals: pluginsToActivate.length * 2 + 1
		},

		erase_content: {
			title: __('Erase content', 'blc'),
			query_string: `action=blocksy_demo_erase_content`,
			expected_signals: 1
		},
		options: {
			title: __('Import options', 'blc'),

			query_string: `action=blocksy_demo_install_options&wp_customize=on&demo_name=${currentDemo}:${demoConfiguration.builder ||
				demoVariations[0].builder}`,
			expected_signals: 5
		},
		widgets: {
			title: __('Import widgets', 'blc'),
			query_string: `action=blocksy_demo_install_widgets&wp_customize=on&demo_name=${currentDemo}:${demoConfiguration.builder ||
				demoVariations[0].builder}`,
			expected_signals: 3
		},
		content: {
			title: __('Import content', 'blc'),
			query_string: `action=blocksy_demo_install_content&wp_customize=on&demo_name=${currentDemo}:${demoConfiguration.builder ||
				demoVariations[0].builder}`,
			expected_signals: 50
		}
	})

	const stepsForConfiguration = getStepsForDemoConfiguration(
		demoConfiguration,
		pluginsStatus,
		is_child_theme
	)

	const stepName = stepsForConfiguration[currentStep]

	const compactSteps = getCompactSteps(stepsForConfiguration, stepName)

	const [progressSignals, setProgressSignals] = useState(0)
	const [lastMessage, setLastMessage] = useState(null)

	let progressSignalsRef = useRef(progressSignals)
	let stepsDescriptorsRef = useRef(stepsDescriptors)

	useEffect(() => {
		progressSignalsRef.current = progressSignals
		stepsDescriptorsRef.current = stepsDescriptors
	})

	const progress =
		currentStep * 100 / stepsForConfiguration.length +
		progressSignals *
			100 /
			stepsDescriptors[stepName].expected_signals /
			stepsForConfiguration.length

	console.log(progressSignals, progress)
	console.log('isCompleted', isCompleted)

	const testCreds = () => {
		const stepDescriptor = stepsDescriptors[stepName]

		var evtSource = new EventSource(
			`${ctDashboardLocalizations.ajax_url}?${
				stepDescriptor.query_string
			}`
		)

		evtSource.onmessage = e => {
			var data = JSON.parse(e.data)
			console.log('here', data)

			setProgressSignals(progressSignalsRef.current + 1)
			setLastMessage(data)

			if (data.action === 'get_content_preliminary_data') {
				const {
					comment_count,
					media_count,
					post_count,
					term_count,
					users
				} = data.data
				setStepsDescriptors({
					...stepsDescriptorsRef.current,
					content: {
						...stepsDescriptorsRef.current.content,
						expected_signals:
							comment_count +
							media_count +
							post_count +
							term_count +
							users.length +
							3
					}
				})
			}

			if (data.action === 'complete') {
				evtSource && evtSource.close && evtSource.close()

				if (currentStep === stepsForConfiguration.length - 1) {
					setIsCompleted(true)
					setInstallerBlockingReleased(true)
					return
				}

				setLastMessage(null)
				setProgressSignals(0)

				setCurrentStep(
					Math.min(stepsForConfiguration.length - 1, currentStep + 1)
				)
			}
		}
	}

	useEffect(() => {
		window.addEventListener('beforeunload', listener)

		return () => {
			window.removeEventListener('beforeunload', listener)
		}
	}, [])

	useEffect(
		() => {
			if (isCompleted) {
				return
			}

			setLastMessage(null)
			setProgressSignals(0)

			// if (stepName !== 'content') {
			console.log('start step', stepName)
			testCreds()
			// }

			console.log('new step name', stepName)
		},
		[stepName]
	)

	return (
		<div className="ct-demo-install">
			<Transition
				initial
				items={isCompleted}
				from={{ opacity: 0 }}
				enter={[{ opacity: 1 }]}
				leave={[{ opacity: 0 }]}
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
				{isCompleted => props => (
					<div style={props}>
						{isCompleted ? (
							<InstallCompleted />
						) : (
							<Fragment>
								<i className="ct-demo-icon">
									<svg
										width="40"
										height="40"
										viewBox="0 0 50 50">
										<path
											class="g1"
											d="M47,38.8c0.3-1,0.5-2,0.5-3.1c0-1.1-0.2-2.1-0.5-3.1l0.2-0.1l1.8-1.7l-1.8-3.1l-2.3,0.7l-0.2,0.1c-1.4-1.5-3.3-2.7-5.4-3.1V25l-0.6-2.4h-3.5L34.5,25v0.3c-2.1,0.5-4,1.6-5.4,3.1l-0.2-0.1l-2.3-0.7l-1.8,3.1l1.7,1.7l0.2,0.1c-0.3,1-0.5,2-0.5,3.1c0,1.1,0.2,2.1,0.5,3.1l-0.2,0.1l-1.8,1.7l1.8,3.1l2.3-0.7l0.2-0.1c1.4,1.5,3.3,2.7,5.4,3.1v0.3l0.6,2.4h3.5l0.6-2.4V46c2.1-0.5,4-1.6,5.4-3.1l0.2,0.1l2.3,0.7l1.8-3.1l-1.7-1.7L47,38.8z M36.9,41.5c-3.3,0-5.9-2.6-5.9-5.9s2.6-5.9,5.9-5.9s5.9,2.6,5.9,5.9S40.1,41.5,36.9,41.5z"
										/>
										<path
											class="g2"
											d="M21.2,32.2c0.2-0.8,0.4-1.7,0.4-2.5c0-0.9-0.1-1.7-0.4-2.5l0.3-0.2l1.7-1.7l-1.8-3.1L19.1,23l-0.3,0.2c-1.2-1.2-2.7-2.1-4.4-2.5v-0.3l-0.6-2.4h-3.5l-0.6,2.4v0.3c-1.7,0.4-3.2,1.3-4.4,2.5L5.1,23l-2.3-0.7L1,25.4L2.7,27L3,27.2c-0.2,0.8-0.4,1.7-0.4,2.5c0,0.9,0.1,1.7,0.4,2.5l-0.3,0.1L1,34.1l1.8,3.1l2.3-0.7l0.3-0.1c1.2,1.2,2.7,2.1,4.4,2.5v0.3l0.6,2.4h3.5l0.6-2.4v-0.3c1.7-0.4,3.2-1.3,4.4-2.5l0.3,0.1l2.3,0.7l1.8-3.1l-1.7-1.7L21.2,32.2z M12.1,34.4c-2.6,0-4.7-2.1-4.7-4.7S9.5,25,12.1,25s4.7,2.1,4.7,4.7S14.7,34.4,12.1,34.4z"
										/>
										<path
											class="g3"
											d="M37.7,15.7c0.2-0.8,0.4-1.7,0.4-2.5c0-0.9-0.1-1.7-0.4-2.5l0.3-0.2l1.7-1.7l-1.8-3.1l-2.3,0.7l-0.3,0.2c-1.2-1.2-2.7-2.1-4.4-2.5V3.8l-0.6-2.4h-3.5l-0.6,2.4v0.3c-1.7,0.4-3.2,1.3-4.4,2.5l-0.3-0.2l-2.3-0.7l-1.8,3.1l1.7,1.7l0.3,0.2c-0.2,0.8-0.4,1.7-0.4,2.5c0,0.9,0.1,1.7,0.4,2.5l-0.3,0.1l-1.7,1.7l1.8,3.1l2.3-0.7l0.3-0.1c1.2,1.2,2.7,2.1,4.4,2.5v0.3l0.6,2.4h3.5l0.6-2.4v-0.3c1.7-0.4,3.2-1.3,4.4-2.5l0.3,0.1l2.3,0.7l1.8-3.1L38,15.9L37.7,15.7z M28.6,17.9c-2.6,0-4.7-2.1-4.7-4.7s2.1-4.7,4.7-4.7s4.7,2.1,4.7,4.7S31.2,17.9,28.6,17.9z"
										/>
									</svg>
								</i>

								<h2>{__('Installing', 'blc')}...</h2>

								<p>
									{__(
										"Please be patient and don't refresh this page, the demo install process may take a while, this also depends on your server.",
										'blc'
									)}
								</p>

								<div className="ct-progress-info">
									{stepsDescriptors[stepName].title}
									{lastMessage &&
									getMessageForAction(lastMessage)
										? `: ${getMessageForAction(
												lastMessage
											)}`
										: ''}
									<span>{Math.round(progress)}%</span>
								</div>

								<div
									style={{
										'--progress': `${progress}%`
									}}
									className="ct-installer-progress">
									<div />
								</div>
							</Fragment>
						)}
					</div>
				)}
			</Transition>
		</div>
	)
}

export default DemoInstaller
