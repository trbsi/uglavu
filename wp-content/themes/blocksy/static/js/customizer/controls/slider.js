import {
	createElement,
	Component,
	createRef,
	Fragment
} from '@wordpress/element'
import classnames from 'classnames'
import linearScale from 'simple-linear-scale'

import OutsideClickHandler from 'react-outside-click-handler'

const clamp = (min, max, value) => Math.max(min, Math.min(max, value))

export const pixelsToPercentage = (el, pixels) =>
	Math.round(
		linearScale([0, el.getBoundingClientRect().width], [0, 100], true)(
			pixels
		)
	)

export default class Slider extends Component {
	state = {
		is_dragging: false,
		is_open: false
	}

	el = createRef()

	getCurrentUnit = () =>
		this.props.option.units
			? this.props.value.toString().replace(/[0-9]/g, '') ||
				this.props.option.units[0].unit
			: ''

	getMax = () =>
		this.props.option.units
			? this.props.option.units.find(
					({ unit }) => unit === this.getCurrentUnit()
				).max
			: this.props.option.max

	getMin = () =>
		this.props.option.units
			? this.props.option.units.find(
					({ unit }) => unit === this.getCurrentUnit()
				).min
			: this.props.option.min

	getNumericValue = () => parseInt(this.props.value, 10)

	computeAndSendNewValue({ pageX }) {
		let { top, left, width } = this.el.current.getBoundingClientRect()

		this.props.onChange(
			`${Math.round(
				linearScale(
					[0, width],
					[parseInt(this.getMin(), 10), parseInt(this.getMax(), 10)],
					true
				)(pageX - left - pageXOffset)
			)}${this.getCurrentUnit()}`
		)
	}

	handleMove = event => {
		if (!this.state.is_dragging) return
		this.computeAndSendNewValue(event)
	}

	handleUp = () => {
		this.setState({
			is_dragging: false
		})

		this.detachEvents()
	}

	attachEvents() {
		document.documentElement.addEventListener(
			'mousemove',
			this.handleMove,
			true
		)

		document.documentElement.addEventListener(
			'mouseup',
			this.handleUp,
			true
		)
	}

	detachEvents() {
		document.documentElement.removeEventListener(
			'mousemove',
			this.handleMove,
			true
		)

		document.documentElement.removeEventListener(
			'mouseup',
			this.handleUp,
			true
		)
	}

	render() {
		const leftValue = `${linearScale(
			[parseInt(this.getMin(), 10), parseInt(this.getMax(), 10)],
			[0, 100]
		)(
			clamp(
				parseInt(this.getMin(), 10),
				parseInt(this.getMax(), 10),
				parseInt(this.getNumericValue(), 10)
			)
		)}`

		return (
			<div className="ct-option-slider">
				{this.props.beforeOption && this.props.beforeOption()}

				<div
					onMouseDown={({ pageX, pageY }) => {
						this.attachEvents()
						this.setState({ is_dragging: true })
					}}
					onClick={e => this.computeAndSendNewValue(e)}
					ref={this.el}
					className="ct-slider">
					<div style={{ width: `${leftValue}%` }} />
					<span
						style={{
							left: `${leftValue}%`
						}}
					/>
				</div>

				<div
					className={classnames('ct-slider-input', {
						// ['ct-unit-changer']: !!this.props.option.units,
						['ct-value-changer']: true,
						'no-unit-list': !this.props.option.units,
						active: this.state.is_open
					})}>
					<input
						type="number"
						value={this.getNumericValue()}
						onBlur={() =>
							this.props.onChange(
								`${clamp(
									parseInt(this.getMin(), 10),
									parseInt(this.getMax(), 10),
									parseInt(this.getNumericValue(), 10)
								)}${this.getCurrentUnit()}`
							)
						}
						onChange={({ target: { value } }) =>
							this.props.onChange(
								`${value}${this.getCurrentUnit()}`
							)
						}
					/>

					{!this.props.option.units && (
						<span className="ct-current-value">
							{this.getCurrentUnit() ||
								(this.props.option.defaultUnit || 'px')}
						</span>
					)}

					{this.props.option.units && (
						<Fragment>
							<span
								onClick={() =>
									this.setState({
										is_open: !this.state.is_open
									})
								}
								className="ct-current-value">
								{this.getCurrentUnit()}
							</span>

							<OutsideClickHandler
								onOutsideClick={() => {
									if (!this.state.is_open) {
										return
									}

									this.setState({ is_open: false })
								}}>
								<ul className="ct-units-list">
									{this.props.option.units
										.filter(
											({ unit }) =>
												unit !== this.getCurrentUnit()
										)

										.reduce(
											(current, el, index) => [
												...current.slice(
													0,
													index % 2 === 0
														? undefined
														: -1
												),
												...(index % 2 === 0
													? [[el]]
													: [
															[
																current[
																	current.length -
																		1
																][0],
																el
															]
														])
											],
											[]
										)

										.map(group => (
											<li key={group[0].unit}>
												{group.map(({ unit }) => (
													<span
														key={unit}
														onClick={() => {
															this.props.onChange(
																`${clamp(
																	this.props.option.units.find(
																		({
																			unit: u
																		}) =>
																			u ===
																			unit
																	).min,
																	this.props.option.units.find(
																		({
																			unit: u
																		}) =>
																			u ===
																			unit
																	).max,
																	parseInt(
																		this.getNumericValue(),
																		10
																	)
																)}${unit}`
															)
															this.setState({
																is_open: false
															})
														}}>
														{unit}
													</span>
												))}
											</li>
										))}
								</ul>
							</OutsideClickHandler>
						</Fragment>
					)}
				</div>
			</div>
		)
	}
}
