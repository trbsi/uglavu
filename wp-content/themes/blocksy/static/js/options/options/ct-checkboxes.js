import {
	createElement,
	Component,
	createContext,
	Fragment
} from '@wordpress/element'
import { maybeTransformUnorderedChoices } from '../helpers/parse-choices.js'

import _ from 'underscore'

const Checkboxes = ({ option, value, onChange }) => {
	const orderedChoices = maybeTransformUnorderedChoices(option.choices)

	const { inline = false } = option

	return (
		<div
			className="ct-option-checkbox"
			{...(inline ? { ['data-inline']: '' } : {})}
			{...option.attr || {}}>
			{orderedChoices.map(({ key, value: choiceValue }) => (
				<label key={key}>
					<input
						type="checkbox"
						checked={
							typeof value[key] === 'boolean'
								? value[key]
								: value[key] === 'true'
						}
						data-id={key}
						onChange={({ target: { checked } }) =>
							(checked ||
								Object.values(value).filter(v => !!v).length >
									1) &&
							onChange({ ...value, [key]: checked })
						}
					/>

					{choiceValue}
				</label>
			))}
		</div>
	)
}

export default Checkboxes
