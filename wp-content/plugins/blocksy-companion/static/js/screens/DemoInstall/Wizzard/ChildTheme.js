import {
	createElement,
	Component,
	useEffect,
	useState,
	useContext,
	createContext,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import { DemosContext } from '../../DemoInstall'
import DashboardContext from '../../../DashboardContext'
import Checkbox from '../../../helpers/Checkbox'

const ChildTheme = ({ demoConfiguration, setDemoConfiguration }) => {
	const { is_child_theme } = useContext(DashboardContext)

	return (
		<div className="ct-demo-child">
			<i className="ct-demo-icon">
				<svg width="40" height="40" viewBox="0 0 43 41.1">
					<path
						fill="#DBE7EE"
						d="M0,39.5c0,0.9,0.7,1.6,1.5,1.6h32.3c0.9,0,1.5-0.7,1.5-1.6V14H0V39.5z"
					/>
					<path
						fill="#BDC8D7"
						d="M18.2,41.1h15.6c0.9,0,1.5-0.7,1.5-1.6V14H7.6L8,32.4L18.2,41.1z"
					/>
					<path
						fill="#BDC8D7"
						d="M0,15.6V9.8c0-0.9,0.7-1.6,1.5-1.6h32.3c0.9,0,1.5,0.7,1.5,1.6v5.8H0z"
					/>
					<path
						fill="#3497D3"
						d="M7.6,31.3c0,0.9,0.7,1.6,1.5,1.6h32.4c0.9,0,1.5-0.7,1.5-1.6V5.8H7.6V31.3z"
					/>
					<path
						fill="#0C7AB3"
						d="M7.6,7.4V1.6C7.6,0.7,8.3,0,9.1,0h32.4C42.4,0,43,0.7,43,1.6v5.8H7.6z"
					/>
					<rect
						x="11.2"
						y="11"
						fill="#44ACDF"
						width="16.8"
						height="17.9"
					/>
					<rect
						x="31.5"
						y="11"
						fill="#44ACDF"
						width="7.9"
						height="17.9"
					/>
				</svg>
			</i>

			<h2>{__('Install Child Theme', 'blc')}</h2>

			{!is_child_theme && (
				<Fragment>
					<p>
						{__(
							'We strongly recommend to install the child theme, this way you will have freedom to make changes without breaking the parent theme.',
							'blc'
						)}
					</p>

					<Checkbox
						checked={demoConfiguration.child_theme}
						onChange={() =>
							setDemoConfiguration({
								...demoConfiguration,
								child_theme: !demoConfiguration.child_theme
							})
						}>
						{__('Install Child Theme', 'blc')}
					</Checkbox>
				</Fragment>
			)}

			{is_child_theme &&
				__(
					'You already have a child theme properly installed and activated. Move on.',
					'blc'
				)}

			<a href="https://codex.wordpress.org/child_themes" target="_blank">
				{__('Learn more about child themes', 'blc')}
			</a>
		</div>
	)
}

export default ChildTheme