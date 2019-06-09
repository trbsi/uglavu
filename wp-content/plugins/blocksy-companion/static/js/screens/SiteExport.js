import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import useExtensionReadme from '../helpers/useExtensionReadme'
import useActivationAction from '../helpers/useActivationAction'
import { Transition, animated } from 'react-spring/renderprops'
import fileSaver from 'file-saver'

const SiteExport = () => {
	const [isLoading, setIsLoading] = useState(false)

	const [name, setName] = useState('')
	const [builder, setBuilder] = useState('')
	const [plugins, setPlugins] = useState('coblocks,elementor,contact-form-7')
	const [url, setUrl] = useState('')
	const [isPro, setIsPro] = useState(false)

	const downloadExport = async () => {
		setIsLoading(true)

		const body = new FormData()

		body.append('action', 'blocksy_demo_export')
		body.append('name', name)
		body.append('is_pro', isPro)
		body.append('url', url)
		body.append('builder', builder)
		body.append('plugins', plugins)
		body.append('wp_customize', 'on')

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			if (response.status === 200) {
				const { success, data } = await response.json()

				if (success) {
					var blob = new Blob([JSON.stringify(data.demo)], {
						type: 'text/plain;charset=utf-8'
					})

					fileSaver.saveAs(blob, `${name}.json`)
				}
			}
		} catch (e) {}

		setIsLoading(false)
	}

	return (
		<div className="ct-site-export">
			<label>
				{__('Name', 'blc')}

				<input
					placeholder={__('Name', 'blc')}
					value={name}
					onChange={({ target: { value } }) => setName(value)}
				/>
			</label>

			<label>
				{__('Preview URL', 'blc')}
				<input
					placeholder={__('Preview URL', 'blc')}
					value={url}
					onChange={({ target: { value } }) => setUrl(value)}
				/>
			</label>

			<label>
				{__('PRO', 'blc')}
				<input
					type="checkbox"
					value={isPro}
					onChange={({ target: { value } }) => setIsPro(!isPro)}
				/>
			</label>

			<label>
				{__('Builder', 'blc')}
				<input
					placeholder={__('Builder', 'blc')}
					value={builder}
					onChange={({ target: { value } }) => setBuilder(value)}
				/>
			</label>

			<label>
				{__('Plugins', 'blc')}
				<input
					placeholder={__('Plugins', 'blc')}
					value={plugins}
					onChange={({ target: { value } }) => setPlugins(value)}
				/>
			</label>

			<button disabled={isLoading} onClick={() => downloadExport()}>
				{isLoading ? __('Loading...', 'blc') : __('Export site', 'blc')}
			</button>
		</div>
	)
}

export default SiteExport
