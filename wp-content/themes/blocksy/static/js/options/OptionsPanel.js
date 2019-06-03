import { createElement, Component, Fragment } from '@wordpress/element'
import GenericOptionType from './GenericOptionType'
import GenericContainerType from './GenericContainerType'
import { flattenOptions } from './helpers/get-value-from-input'

const OptionsPanel = ({
	options,
	value,
	onChange,

	// default | customizer
	purpose = 'default',
	hasRevertButton = true
}) => {
	options = flattenOptions(options)

	return (
		<Fragment>
			{[
				...(options.__CT_KEYS_ORDER__
					? Object.keys(options.__CT_KEYS_ORDER__)
							.map(orderKey => parseInt(orderKey, 10))
							.sort((a, b) => a - b)
							.map(
								orderKey => options.__CT_KEYS_ORDER__[orderKey]
							)
					: Object.keys(options))
			]
				.filter(id => id !== '__CT_KEYS_ORDER__')
				.map(id => ({
					...options[id],
					id
				}))
				.reduce((chunksHolder, currentOptionDescriptor, index) => {
					if (chunksHolder.length === 0) {
						return [[currentOptionDescriptor]]
					}

					let lastChunk = chunksHolder[chunksHolder.length - 1]

					if (
						((lastChunk[0].options &&
							lastChunk[0].type ===
								currentOptionDescriptor.type) ||
							(currentOptionDescriptor.type === 'ct-tab-group' ||
								currentOptionDescriptor.type ===
									'ct-tab-group-sync')) &&
						/**
						 * Do not group rendering chunks for boxes
						 */
						currentOptionDescriptor.type !== 'box' &&
						/**
						 * Do not group rendering chunks for ct-popup's
						 */
						currentOptionDescriptor.type !== 'ct-popup'
					) {
						return [
							...chunksHolder.slice(0, -1),
							[...lastChunk, currentOptionDescriptor]
						]
					}

					return [...chunksHolder, [currentOptionDescriptor]]
				}, [])
				.map(renderingChunk => {
					/**
					 * We are dealing with a container
					 */
					if (
						renderingChunk[0].options ||
						renderingChunk[0].type === 'ct-tab-group-sync'
					) {
						return (
							<GenericContainerType
								key={renderingChunk[0].id}
								value={value}
								renderingChunk={renderingChunk}
								onChange={v =>
									onChange(
										// TODO: a bit doubtful, maybe spread initial value here
										v
									)
								}
								purpose={purpose}
								hasRevertButton={hasRevertButton}
							/>
						)
					}

					/**
					 * We have a regular option type here
					 */
					return (
						<GenericOptionType
							hasRevertButton={hasRevertButton}
							purpose={purpose}
							key={renderingChunk[0].id}
							id={renderingChunk[0].id}
							value={value[renderingChunk[0].id]}
							values={value}
							option={renderingChunk[0]}
							onChange={newValue => {
								onChange({
									...value,
									[renderingChunk[0].id]: newValue
								})
							}}
						/>
					)
				})}
		</Fragment>
	)
}

export default OptionsPanel
