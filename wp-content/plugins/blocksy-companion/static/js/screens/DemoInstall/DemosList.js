import {
	createElement,
	Component,
	useEffect,
	useState,
	createContext,
	useContext,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import { DemosContext } from '../DemoInstall'
import DashboardContext from '../../DashboardContext'

const DemosList = () => {
	const { demos_list } = useContext(DemosContext)
	const { Link } = useContext(DashboardContext)

	return (
		<div className="ct-demos-list">
			{demos_list
				.filter(
					(v, i, a) =>
						demos_list.map(({ name }) => name).indexOf(v.name) === i
				)
				.map(demo => (
					<div
						key={demo.name}
						className={classnames('ct-single-demo', {
							'ct-is-pro': demo.is_pro
						})}>
						<img src={demo.screenshot} />
						{demo.name}
						<a target="_blank" href={demo.url}>
							{__('Preview', 'blc')}
						</a>
						<Link to="/demos/123">{__('Install', 'blc')}</Link>
					</div>
				))}
		</div>
	)
}

export default DemosList
