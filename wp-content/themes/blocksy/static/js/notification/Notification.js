import {
	createElement,
	Component,
	createRef,
	useState,
	useEffect,
	useRef
} from '@wordpress/element'
import { __, sprintf } from 'ct-i18n'

const Notification = ({ initialStatus, url, pluginUrl, pluginLink }) => {
	const [pluginStatus, setPluginStatus] = useState('installed')

	const [isLoading, setIsLoading] = useState(false)

	const containerEl = useRef(null)

	useEffect(() => {
		setPluginStatus(initialStatus)
	}, [])

	return (
		<div ref={containerEl}>
			<button
				onClick={() => {
					containerEl.current
						.closest('.notice-blocksy-plugin')
						.parentNode.removeChild(
							containerEl.current.closest(
								'.notice-blocksy-plugin'
							)
						)

					$.ajax(ajaxurl, {
						type: 'POST',
						data: {
							action: 'blocksy_dismissed_notice_handler'
						}
					})
				}}
				type="button"
				className="notice-dismiss">
				<span className="screen-reader-text">
					{__('Dismiss this notice.')}
				</span>
			</button>

			<h1>{__('Congratulations!')}</h1>

			<p className="about-description">
				{__('Blocksy theme is now active and ready to use.')}
			</p>

			<p
				dangerouslySetInnerHTML={{
					__html: __(
						'To get full advantage of it, we strongly recommend to activate the <b>Blocksy Companion</b> Plugin. This way you will have access to custom extensions, demo templates and many other awesome features.'
					)
				}}
			/>

			<div className="notice-actions">
				{pluginStatus === 'uninstalled' && (
					<a
						className="button button-primary"
						href={pluginLink}
						target="_blank">
						{__('Download Blocksy Companion')}
					</a>
				)}

				{pluginStatus !== 'uninstalled' && (
					<button
						disabled={isLoading || pluginStatus === 'active'}
						onClick={() => {
							setIsLoading(true)

							setTimeout(() => {})
							$.ajax(ajaxurl, {
								type: 'POST',
								data: {
									action: 'blocksy_notice_button_click'
								}
							}).then(({ success, data }) => {
								if (success) {
									setPluginStatus(data.status)

									if (data.status === 'active') {
										location.assign(pluginUrl)
									}
								}

								setIsLoading(false)
							})
						}}
						className="button button-primary">
						{isLoading && (
							<i className="dashicons dashicons-update" />
						)}
						{isLoading
							? __('Activating...')
							: pluginStatus === 'uninstalled'
								? __('Install Blocksy Companion')
								: pluginStatus === 'installed'
									? __('Activate Blocksy Companion')
									: __('Blocksy Companion active!')}
					</button>
				)}

				<a href={url} className="button">
					{__('Theme Dashboard')}
				</a>
			</div>
		</div>
	)
}

export default Notification
