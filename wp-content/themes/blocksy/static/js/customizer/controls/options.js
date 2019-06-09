import {
	createElement,
	Component,
	createRef,
	createContext,
	useEffect,
	useState,
	createPortal
} from '@wordpress/element'
import classnames from 'classnames'

import OptionsPanel from '../../options/OptionsPanel'
import { getFirstLevelOptions } from '../../options/helpers/get-value-from-input'

const Options = ({ option }) => {
	const [values, setValues] = useState(null)

	return (
		<div className="ct-options-wrapper">
			<OptionsPanel
				purpose="customizer"
				onChange={val => {
					setValues(val)

					Object.keys(
						getFirstLevelOptions(option['inner-options'])
					).map(
						id => wp.customize(id) && wp.customize(id).set(val[id])
					)

					// this.forceUpdate()
				}}
				options={option['inner-options']}
				value={
					values ||
					Object.keys(wp.customize._value).reduce(
						(finalValue, currentValue) => ({
							...finalValue,
							[currentValue]: wp.customize._value[currentValue]()
						}),

						{}
					)
				}
			/>
		</div>
	)
}

Options.renderingConfig = {
	design: 'none'
}

export default Options
