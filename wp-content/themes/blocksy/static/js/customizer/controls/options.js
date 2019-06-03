import {
	createElement,
	Component,
	createRef,
	createContext,
	createPortal
} from '@wordpress/element'
import classnames from 'classnames'

import OptionsPanel from '../../options/OptionsPanel'
import { getFirstLevelOptions } from '../../options/helpers/get-value-from-input'

export default class Options extends Component {
	static renderingConfig = {
		design: 'none'
	}

	render() {
		return (
			<div className="ct-options-wrapper">
				<OptionsPanel
					purpose="customizer"
					onChange={val => {
						Object.keys(
							getFirstLevelOptions(
								this.props.option['inner-options']
							)
						).map(
							id =>
								wp.customize(id) &&
								wp.customize(id).set(val[id])
						)

						this.forceUpdate()
					}}
					options={this.props.option['inner-options']}
					value={Object.keys(wp.customize._value).reduce(
						(finalValue, currentValue) => ({
							...finalValue,
							[currentValue]: wp.customize._value[currentValue]()
						}),

						{}
					)}
				/>
			</div>
		)
	}
}
