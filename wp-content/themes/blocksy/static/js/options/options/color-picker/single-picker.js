import {
	createElement,
	Component,
	createPortal,
	createRef
} from '@wordpress/element'
import PickerModal, { getNoColorPropFor } from './picker-modal.js'
import OutsideClickHandler from 'react-outside-click-handler'
import { Transition } from 'react-spring'
import bezierEasing from 'bezier-easing'
import classnames from 'classnames'

export default class SinglePicker extends Component {
	state = {
		isTransitioning: false,
		sameColorPickerInvolved: false
	}

	el = createRef()

	render() {
		if (this.props.option.inline_modal) {
			return (
				<div ref={this.el} className="ct-color-picker-single">
					{this.el &&
						this.el.current &&
						createPortal(
							<PickerModal
								option={this.props.option}
								onChange={this.props.onChange}
								value={this.props.value}
							/>,
							this.el.current.closest('.ct-color-modal-wrapper')
								? this.el.current.closest(
										'.ct-color-modal-wrapper'
									)
								: this.el.current
										.closest('.ct-control')
										.querySelector(
											'.ct-color-modal-wrapper'
										)
						)}
				</div>
			)
		}

		return (
			<div
				ref={this.el}
				className={classnames('ct-color-picker-single', {
					[`ct-no-color`]:
						(this.props.value || {}).color ===
						getNoColorPropFor(this.props.option)
				})}>
				<span tabIndex="0">
					<span
						tabIndex="0"
						onClick={e => {
							e.stopPropagation()
							this.props.onPickingChange()
						}}
						style={
							(this.props.value || {}).color !==
							getNoColorPropFor(this.props.option)
								? {
										background: (this.props.value || {})
											.color
									}
								: {}
						}>
						<i className="ct-tooltip-top">
							{this.props.picker.title}
						</i>
					</span>
				</span>

				{(this.props.isTransitioning === this.props.picker.id ||
					this.props.is_picking === this.props.picker.id) &&
					createPortal(
						<Transition
							items={this.props.is_picking}
							onRest={isOpen => this.props.stopTransitioning()}
							config={{
								duration: 100,
								easing: bezierEasing(0.25, 0.1, 0.25, 1.0)
							}}
							from={
								this.props.shouldAnimate
									? {
											transform: 'scale3d(0.95, 0.95, 1)',
											opacity: 0
										}
									: { opacity: 1 }
							}
							enter={
								this.props.shouldAnimate
									? {
											transform: 'scale3d(1, 1, 1)',
											opacity: 1
										}
									: {
											opacity: 1
										}
							}
							leave={
								this.props.shouldAnimate
									? {
											transform: 'scale3d(0.95, 0.95, 1)',
											opacity: 0
										}
									: {
											opacity: 1
										}
							}>
							{is_picking =>
								is_picking === this.props.picker.id &&
								(props => (
									<PickerModal
										style={props}
										option={this.props.option}
										onChange={this.props.onChange}
										value={this.props.value}
										el={this.el}
									/>
								))
							}
						</Transition>,
						this.el.current.closest('.ct-color-modal-wrapper')
							? this.el.current.closest('.ct-color-modal-wrapper')
							: this.el.current
									.closest('.ct-control')
									.querySelector('.ct-color-modal-wrapper')
					)}
			</div>
		)
	}
}
