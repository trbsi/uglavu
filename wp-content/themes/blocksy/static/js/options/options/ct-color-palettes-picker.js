import { createElement, Component, Fragment } from '@wordpress/element'
import OptionsPanel from '../OptionsPanel'
import { getValueFromInput } from '../helpers/get-value-from-input'
import { __ } from 'ct-i18n'
import cls from 'classnames'

const ColorPalettes = ({ option, value, onChange }) => {
	const properValue = {
		...option.value,
		...value
	}

	return (
		<div>
			<ul className="ct-color-palettes">
				{properValue.palettes.map((singlePalette, index) => (
					<li
						onMouseDown={e => {
							e.stopPropagation()
						}}
						onMouseUp={e => {
							e.stopPropagation()
						}}
						className={cls('ct-color-modal-wrapper', {
							active:
								singlePalette.id === properValue.current_palette
						})}
						onClick={() => {
							const { id, ...colors } = singlePalette

							onChange({
								...properValue,
								current_palette: singlePalette.id,
								...colors
							})
						}}
						key={singlePalette.id}>
						<label
							onClick={() => {
								const { id, ...colors } = singlePalette

								onChange({
									...properValue,
									current_palette: singlePalette.id,
									...colors
								})
							}}>
							<input
								checked={
									properValue.current_palette ===
									singlePalette.id
								}
								type="radio"
							/>
							Palette {index + 1}
						</label>

						<OptionsPanel
							hasRevertButton={false}
							onChange={newValue => {
								const { id, ...colors } = newValue.color
								onChange({
									...properValue,

									palettes: properValue.palettes.map(
										p =>
											p.id === singlePalette.id
												? {
														...p,
														...colors
													}
												: p
									),
									...(properValue.current_palette ===
									singlePalette.id
										? colors
										: {})
								})
							}}
							value={{ color: singlePalette }}
							options={{
								color: {
									type: 'ct-color-picker',
									predefined: true,
									design: 'none',
									label: false,
									value: option.value.palettes.find(
										({ id }) => id === singlePalette.id
									),

									pickers: [
										{
											title: __('Color 1', 'blocksy'),
											id: 'color1'
										},

										{
											title: __('Color 2', 'blocksy'),
											id: 'color2'
										},

										{
											title: __('Color 3', 'blocksy'),
											id: 'color3'
										},

										{
											title: __('Color 4', 'blocksy'),
											id: 'color4'
										},

										{
											title: __('Color 5', 'blocksy'),
											id: 'color5'
										}
									]
								}
							}}
						/>
					</li>
				))}
			</ul>
		</div>
	)
}

export default ColorPalettes
