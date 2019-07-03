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
import DashboardContext from '../../../DashboardContext'
import { DemosContext } from '../../DemoInstall'

import { sprintf, __ } from 'ct-i18n'

const listener = e => {
	e.preventDefault()
	e.returnValue = ''
}

export const getStepsForDemoConfiguration = (
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

export const useInstaller = demoConfiguration => {
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
			query_string: `action=blocksy_demo_erase_content&wp_customize=on`,
			expected_signals: 6
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

	const [progressSignals, setProgressSignals] = useState(0)
	const [lastMessage, setLastMessage] = useState(null)

	let progressSignalsRef = useRef(progressSignals)
	let stepsDescriptorsRef = useRef(stepsDescriptors)

	useEffect(() => {
		progressSignalsRef.current = progressSignals
		stepsDescriptorsRef.current = stepsDescriptors
	})

	const getPercentageForStep = step => {
		if (step === 'content') {
			return stepsForConfiguration.length === 1 ? 100 : 50
		}

		return stepsForConfiguration.indexOf('content') > -1
			? 50 / (stepsForConfiguration.length - 1)
			: 100 / stepsForConfiguration.length
	}

	const progress =
		stepsForConfiguration.reduce((currentProgress, step, index) => {
			if (index >= currentStep) {
				return currentProgress
			}

			return currentProgress + getPercentageForStep(step)
		}, 0) +
		progressSignals *
			100 /
			stepsDescriptors[stepName].expected_signals *
			(getPercentageForStep(stepName) / 100)

	const fireOffNextStep = () => {
		const stepDescriptor = stepsDescriptors[stepName]

		var evtSource = new EventSource(
			`${ctDashboardLocalizations.ajax_url}?${
				stepDescriptor.query_string
			}`
		)

		evtSource.onmessage = e => {
			var data = JSON.parse(e.data)

			setProgressSignals(progressSignalsRef.current + 1)

			if (data.action === 'content_installer_progress') {
				const { kind } = data

				if (kind) {
					setLastMessage(data)

					setStepsDescriptors({
						...stepsDescriptorsRef.current,
						content: {
							...stepsDescriptorsRef.current.content,
							[`${kind}_count`]:
								stepsDescriptorsRef.current.content[
									`${kind}_count`
								] + 1
						}
					})
				}
			} else {
				setLastMessage(data)
			}

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
						preliminary_data: {
							...data.data,
							users_count: users.length
						},

						comment_count: 0,
						media_count: 0,
						post_count: 0,
						term_count: 0,
						users_count: 0,

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
					window.removeEventListener('beforeunload', listener)
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

	useEffect(
		() => {
			if (isCompleted) {
				return
			}

			setLastMessage(null)
			setProgressSignals(0)

			fireOffNextStep()
		},
		[stepName]
	)

	useEffect(() => {
		window.addEventListener('beforeunload', listener)

		return () => {
			window.removeEventListener('beforeunload', listener)
		}
	}, [])

	return {
		isCompleted,
		stepName,
		stepsDescriptors,
		lastMessage,
		progress
	}
}
