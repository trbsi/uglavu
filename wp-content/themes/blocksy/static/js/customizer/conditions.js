import { normalizeCondition, matchValuesWithCondition } from 'match-conditions'

export const startListeningToValuesAndReact = () => {
	const checkSingleControl = controlWithCondition => {
		controlWithCondition.active.validate = () =>
			matchValuesWithCondition(
				normalizeCondition(controlWithCondition.params.condition),
				Object.keys(wp.customize._value).reduce(
					(finalValue, currentValue) => ({
						...finalValue,
						[currentValue]: wp.customize._value[currentValue]()
					}),

					{}
				)
			)

		controlWithCondition.active.validate()
			? controlWithCondition.activate()
			: controlWithCondition.deactivate()
	}

	const handleAllConditions = () =>
		Object.keys(wp.customize.control._value).map(
			singleControl =>
				wp.customize.control._value[singleControl].params.condition &&
				checkSingleControl(wp.customize.control._value[singleControl])
		)

	wp.customize.bind('change', () => handleAllConditions())
	wp.customize.bind('ready', () => handleAllConditions())
}
