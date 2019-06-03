import {
	createElement,
	Component,
	createRef,
	Fragment
} from '@wordpress/element'
import ColorPickerIris from './color-picker-iris.js'
import classnames from 'classnames'

export const getNoColorPropFor = option =>
	option.noColorTransparent ? 'transparent' : `CT_CSS_SKIP_RULE`

const getLeftForEl = (arrow, el) => {
	if (!arrow) return
	if (!el) return

	const wrapper = arrow.closest('.ct-control').getBoundingClientRect()
	const modal = arrow.nextElementSibling.getBoundingClientRect()
	el = el.getBoundingClientRect()
	arrow = arrow.getBoundingClientRect()

	return {
		left: el.left + el.width / 2 - wrapper.left - arrow.width / 2
		// top: modal.top - wrapper.top - arrow.height / 2
	}
}

export default class PickerModal extends Component {
	arrow = createRef()

	render() {
		return (
			<Fragment>
				<span
					className="ct-arrow"
					ref={this.arrow}
					style={{
						...getLeftForEl(
							this.arrow.current,
							this.props.el.current
						),

						...(this.props.style
							? { opacity: this.props.style.opacity }
							: {})
					}}
				/>

				<div
					tabIndex="0"
					className={`ct-color-picker-modal`}
					{...{
						...(this.props.style ? { style: this.props.style } : {})
					}}
					onMouseDown={e => e.nativeEvent.stopImmediatePropagation()}>
					{!this.props.option.predefined && (
						<div className="ct-color-picker-top">
							<ul className="ct-color-picker-skins">
								{[
									'paletteColor1',
									'paletteColor2',
									'paletteColor3',
									'paletteColor4',
									'paletteColor5'
								].map(color => (
									<li
										key={color}
										style={{
											background: getComputedStyle(
												document.documentElement
											)
												.getPropertyValue(`--${color}`)
												.trim()
										}}
										className={classnames({
											active:
												this.props.value.color ===
												`var(--${color})`
										})}
										onClick={() =>
											this.props.onChange({
												...this.props.value,
												color: `var(--${color})`
											})
										}>
										<div className="ct-tooltip-top">
											{
												{
													paletteColor1: 'Color 1',
													paletteColor2: 'Color 2',
													paletteColor3: 'Color 3',
													paletteColor4: 'Color 4',
													paletteColor5: 'Color 5'
												}[color]
											}
										</div>
									</li>
								))}
							</ul>

							<span
								onClick={() =>
									this.props.onChange({
										...this.props.value,
										color: getNoColorPropFor(
											this.props.option
										)
									})
								}
								className={classnames('ct-no-color-pill', {
									active:
										this.props.value.color ===
										getNoColorPropFor(this.props.option)
								})}>
								<i className="ct-tooltip-top">No Color</i>
							</span>
						</div>
					)}

					<ColorPickerIris
						onChange={v => this.props.onChange(v)}
						value={{
							...this.props.value,
							color:
								this.props.value.color ===
								getNoColorPropFor(this.props.option)
									? ''
									: this.props.value.color.indexOf('var') > -1
										? getComputedStyle(
												document.documentElement
											)
												.getPropertyValue(
													this.props.value.color
														.replace(/var\(/, '')
														.replace(/\)/, '')
												)
												.trim()
												.replace(/\s/g, '')
										: this.props.value.color
						}}
					/>
				</div>
			</Fragment>
		)
	}
}
