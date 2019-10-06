import {
	createElement,
	Component,
	createPortal,
	useRef,
	createRef
} from '@wordpress/element'
import PickerModal, { getNoColorPropFor } from './picker-modal'
import { Transition } from 'react-spring'
import bezierEasing from 'bezier-easing'
import classnames from 'classnames'

const SinglePicker = ({
	option,
	value,
	onChange,
	picker,

	onPickingChange,
	stopTransitioning,

	isTransitioning,
	isPicking
}) => {
	const el = useRef()
	if (option.inline_modal) {
		return (
			<div ref={el} className="ct-color-picker-single">
				{el &&
					el.current &&
					createPortal(
						<PickerModal
							option={option}
							onChange={onChange}
							value={value}
						/>,
						el.current.closest('.ct-single-palette')
							? el.current
									.closest('.ct-single-palette')
									.querySelector('.ct-color-modal-wrapper')
							: el.current.closest('.ct-color-modal-wrapper')
							? el.current.closest('.ct-color-modal-wrapper')
							: el.current
									.closest('.ct-control')
									.querySelector('.ct-color-modal-wrapper')
					)}
			</div>
		)
	}

	return (
		<div
			ref={el}
			className={classnames('ct-color-picker-single', {
				[`ct-no-color`]:
					(value || {}).color === getNoColorPropFor(option)
			})}>
			<span tabIndex="0">
				<span
					tabIndex="0"
					onMouseDownCapture={e => {
						e.nativeEvent.stopImmediatePropagation()
						e.nativeEvent.stopPropagation()
					}}
					onMouseUpCapture={e => {
						e.nativeEvent.stopImmediatePropagation()
						e.nativeEvent.stopPropagation()
					}}
					onClick={e => {
						e.stopPropagation()

						let futureIsPicking = isPicking
							? isPicking.split(':')[0] === picker.id
								? null
								: `${picker.id}:${isPicking.split(':')[0]}`
							: picker.id

						onPickingChange(futureIsPicking)
					}}
					style={
						(value || {}).color !== getNoColorPropFor(option)
							? {
									background: (value || {}).color
							  }
							: {}
					}>
					<i className="ct-tooltip-top">{picker.title}</i>
				</span>
			</span>

			{(isTransitioning === picker.id ||
				(isPicking || '').split(':')[0] === picker.id) &&
				createPortal(
					<Transition
						items={isPicking}
						onRest={isOpen => stopTransitioning()}
						config={{
							duration: 100,
							easing: bezierEasing(0.25, 0.1, 0.25, 1.0)
						}}
						from={
							(isPicking || '').indexOf(':') === -1
								? {
										transform: 'scale3d(0.95, 0.95, 1)',
										opacity: 0
								  }
								: { opacity: 1 }
						}
						enter={
							(isPicking || '').indexOf(':') === -1
								? {
										transform: 'scale3d(1, 1, 1)',
										opacity: 1
								  }
								: {
										opacity: 1
								  }
						}
						leave={
							(isPicking || '').indexOf(':') === -1
								? {
										transform: 'scale3d(0.95, 0.95, 1)',
										opacity: 0
								  }
								: {
										opacity: 1
								  }
						}>
						{isPicking =>
							(isPicking || '').split(':')[0] === picker.id &&
							(props => (
								<PickerModal
									style={props}
									option={option}
									onChange={onChange}
									value={value}
									el={el}
								/>
							))
						}
					</Transition>,
					el.current.closest('.ct-single-palette')
						? el.current
								.closest('.ct-single-palette')
								.querySelector('.ct-color-modal-wrapper')
						: el.current.closest('.ct-color-modal-wrapper')
						? el.current.closest('.ct-color-modal-wrapper')
						: el.current
								.closest('.ct-control')
								.querySelector('.ct-color-modal-wrapper')
				)}
		</div>
	)
}

export default SinglePicker
