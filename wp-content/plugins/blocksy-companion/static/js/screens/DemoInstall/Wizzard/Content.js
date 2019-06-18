import {
	createElement,
	Component,
	useEffect,
	useState,
	useContext,
	createContext,
	Fragment
} from '@wordpress/element'
import { __, sprintf } from 'ct-i18n'
import classnames from 'classnames'
import Checkbox from '../../../helpers/Checkbox'

const Content = ({ demoConfiguration, setDemoConfiguration, currentDemo }) => {
	return (
		<div>
			<i className="ct-demo-icon">
				<svg width="50" height="50" viewBox="0 0 40 40">
					<path
						fill="#ffffff"
						d="M8.2,35.8c0,0.7,0.5,1.3,1.2,1.3h25c0.7,0,1.2-0.6,1.2-1.3V16.1H8.2V35.8z"
					/>
					<path
						fill="#BDC9D7"
						d="M8.2,17.4v-4.5c0-0.7,0.5-1.3,1.2-1.3h25c0.7,0,1.2,0.6,1.2,1.3v4.5H8.2z"
					/>
					<path
						fill="#ADB8C4"
						d="M4.6,3L4.6,3C4.2,4.8,3.6,6.3,0.8,6.6v0.1c2.9,0.3,3.4,1.8,3.6,3.6h0.1c0.3-1.9,0.8-3.4,3.6-3.6v0C5.3,6.3,4.8,4.9,4.6,3z M2.7,16.5L2.7,16.5C2.4,17.8,2,18.9,0,19.1v0.1c2,0.2,2.4,1.3,2.6,2.6h0.1c0.2-1.3,0.6-2.4,2.6-2.6v-0.1C3.3,18.9,2.9,17.8,2.7,16.5z M18.2,3L18.2,3c-0.3,1.9-0.9,3.4-3.7,3.6v0.1c2.9,0.3,3.4,1.8,3.6,3.6h0.1c0.3-1.9,0.8-3.4,3.6-3.6v0C19,6.3,18.5,4.9,18.2,3z"
					/>
					<path
						fill="#0C7AB3"
						d="M39.5,25.9h-0.4c-0.3,0-0.5-0.3-0.5-0.5c0-0.2,0.1-0.3,0.2-0.4l0.2-0.2c0.2-0.2,0.2-0.6,0-0.8l-0.5-0.5c-0.1-0.1-0.3-0.2-0.4-0.2c-0.2,0-0.3,0.1-0.4,0.2l-0.2,0.2c-0.1,0.1-0.2,0.2-0.4,0.2c-0.3,0-0.6-0.2-0.6-0.5v-0.4c0-0.3-0.3-0.6-0.6-0.6h-0.7c-0.3,0-0.6,0.3-0.6,0.6v0.4c0,0.3-0.3,0.5-0.6,0.5c-0.2,0-0.3-0.1-0.4-0.2l-0.2-0.2c-0.1-0.1-0.3-0.2-0.4-0.2c-0.2,0-0.3,0.1-0.4,0.2l-0.5,0.5c-0.2,0.2-0.2,0.6,0,0.8l0.2,0.2c0.1,0.1,0.2,0.2,0.2,0.4c0,0.3-0.2,0.5-0.5,0.5h-0.4c-0.3,0-0.6,0.3-0.6,0.6v0.4v0.4c0,0.3,0.3,0.6,0.6,0.6h0.4c0.3,0,0.5,0.3,0.5,0.5c0,0.2-0.1,0.3-0.2,0.4l-0.2,0.2c-0.2,0.2-0.2,0.6,0,0.8l0.5,0.5c0.1,0.1,0.3,0.2,0.4,0.2c0.2,0,0.3-0.1,0.4-0.2l0.2-0.2c0.1-0.1,0.2-0.2,0.4-0.2c0.3,0,0.6,0.2,0.6,0.5v0.4c0,0.3,0.3,0.6,0.6,0.6h0.7c0.3,0,0.6-0.3,0.6-0.6v-0.4c0-0.3,0.3-0.5,0.6-0.5c0.2,0,0.3,0.1,0.4,0.2l0.2,0.2c0.1,0.1,0.3,0.2,0.4,0.2c0.2,0,0.3-0.1,0.4-0.2l0.5-0.5c0.2-0.2,0.2-0.6,0-0.8l-0.2-0.2c-0.1-0.1-0.2-0.2-0.2-0.4c0-0.3,0.2-0.5,0.5-0.5h0.4c0.3,0,0.5-0.3,0.5-0.6v-0.4v-0.4C40,26.2,39.8,25.9,39.5,25.9z M37.4,26.8L37.4,26.8c0,1-0.8,1.9-1.9,1.9c-1,0-1.9-0.8-1.9-1.9l0,0l0,0c0-1,0.8-1.9,1.9-1.9C36.6,25,37.4,25.8,37.4,26.8L37.4,26.8z"
					/>
					<path
						fill="#BDC9D7"
						d="M23.9,22.2H10.6c-0.2,0-0.4-0.2-0.4-0.4l0,0c0-0.2,0.2-0.4,0.4-0.4h13.3c0.2,0,0.4,0.2,0.4,0.4l0,0C24.3,22,24.1,22.2,23.9,22.2z"
					/>
					<path
						fill="#BDC9D7"
						d="M18.6,25.2h-8c-0.2,0-0.4-0.2-0.4-0.4l0,0c0-0.2,0.2-0.4,0.4-0.4h8c0.2,0,0.4,0.2,0.4,0.4l0,0C19,25,18.8,25.2,18.6,25.2z"
					/>
					<path
						fill="#BDC9D7"
						d="M29.2,25.2h-8c-0.2,0-0.4-0.2-0.4-0.4l0,0c0-0.2,0.2-0.4,0.4-0.4h8c0.2,0,0.4,0.2,0.4,0.4l0,0C29.6,25,29.4,25.2,29.2,25.2z"
					/>
					<path
						fill="#BDC9D7"
						d="M14.2,31.2h-3.7c-0.2,0-0.4-0.2-0.4-0.4v0c0-0.2,0.2-0.4,0.4-0.4h3.7c0.2,0,0.4,0.2,0.4,0.4v0C14.6,31,14.4,31.2,14.2,31.2z"
					/>
					<path
						fill="#BDC9D7"
						d="M25.3,31.2h-8.6c-0.2,0-0.4-0.2-0.4-0.4v0c0-0.2,0.2-0.4,0.4-0.4h8.6c0.2,0,0.4,0.2,0.4,0.4v0C25.8,31,25.6,31.2,25.3,31.2z"
					/>
					<path
						fill="#BDC9D7"
						d="M21.4,28.2H10.5c-0.2,0-0.4-0.2-0.4-0.4l0,0c0-0.2,0.2-0.4,0.4-0.4h10.9c0.2,0,0.4,0.2,0.4,0.4l0,0C21.8,28,21.6,28.2,21.4,28.2z"
					/>
					<path
						fill="#BDC9D7"
						d="M27.6,28.2H24c-0.2,0-0.4-0.2-0.4-0.4l0,0c0-0.2,0.2-0.4,0.4-0.4h3.6c0.2,0,0.4,0.2,0.4,0.4l0,0C28,28,27.8,28.2,27.6,28.2z"
					/>
				</svg>
			</i>

			<h2>{__('Import Content', 'blc')}</h2>
			<p>
				{__(
					'This will import posts, pages, comments, navigation menus, custom fields, terms and custom posts',
					'blc'
				)}
			</p>

			{['options', 'widgets', 'content'].map(option => (
				<Checkbox
					checked={demoConfiguration.content[option]}
					onChange={() =>
						setDemoConfiguration({
							...demoConfiguration,
							content: {
								...demoConfiguration.content,
								[option]: !demoConfiguration.content[option]
							}
						})
					}
					key={option}>
					{option
						.split('_')
						.map(w => w.replace(/^\w/, c => c.toUpperCase()))
						.join(' ')}
				</Checkbox>
			))}

			<div className="ct-demo-erase">
				<Checkbox
					checked={demoConfiguration.content.erase_content}
					onChange={() =>
						setDemoConfiguration({
							...demoConfiguration,
							content: {
								...demoConfiguration.content,
								erase_content: !demoConfiguration.content
									.erase_content
							}
						})
					}>
					<div>
						{__('Erase Content', 'blc')}
						<i>
							{__(
								'Check this option if you want to remove previous installed contend and perform a clean install.',
								'blc'
							)}
						</i>
					</div>
				</Checkbox>
			</div>
		</div>
	)
}

export default Content
