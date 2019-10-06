import { createElement, Component, Fragment } from '@wordpress/element'
import cls from 'classnames'

const DISPLAY = {
	BLOCK: 'block',
	FLEX: 'flex',
	INLINE_BLOCK: 'inline-block'
}

const defaultProps = {
	disabled: false,

	// `useCapture` is set to true by default so that a `stopPropagation` in the
	// children will not prevent all outside click handlers from firing - maja
	useCapture: true,
	display: DISPLAY.BLOCK
}

export default class OutsideClickHandler extends Component {
	constructor(...args) {
		super(...args)

		this.onMouseDown = this.onMouseDown.bind(this)
		this.onMouseUp = this.onMouseUp.bind(this)
		this.setChildNodeRef = this.setChildNodeRef.bind(this)
	}

	componentDidMount() {
		const { disabled, useCapture } = this.props

		if (!disabled) this.addMouseDownEventListener(useCapture)
	}

	componentWillReceiveProps({ disabled, useCapture }) {
		const { disabled: prevDisabled } = this.props

		if (prevDisabled !== disabled) {
			if (disabled) {
				this.removeEventListeners()
			} else {
				this.addMouseDownEventListener(useCapture)
			}
		}
	}

	componentWillUnmount() {
		this.removeEventListeners()
	}

	// Use mousedown/mouseup to enforce that clicks remain outside the root's
	// descendant tree, even when dragged. This should also get triggered on
	// touch devices.
	onMouseDown(e) {
		const { useCapture } = this.props

		const isDescendantOfRoot =
			this.childNode && this.childNode.contains(e.target)

		if (!isDescendantOfRoot) {
			if (this.removeMouseUp) {
				this.removeMouseUp()
				this.removeMouseUp = null
			}

			document.addEventListener('mouseup', this.onMouseUp, useCapture)

			this.removeMouseUp = () => {
				document.removeEventListener(
					'mouseup',
					this.onMouseUp,
					useCapture
				)
			}
		}
	}

	// Use mousedown/mouseup to enforce that clicks remain outside the root's
	// descendant tree, even when dragged. This should also get triggered on
	// touch devices.
	onMouseUp(e) {
		const { onOutsideClick } = this.props

		const isDescendantOfRoot =
			this.childNode && this.childNode.contains(e.target)

		if (this.removeMouseUp) {
			this.removeMouseUp()
			this.removeMouseUp = null
		}

		if (!isDescendantOfRoot) {
			onOutsideClick(e)
		}
	}

	setChildNodeRef(ref) {
		if (this.props.wrapperProps && this.props.wrapperProps.ref) {
			this.props.wrapperProps.ref(ref)
		}
		this.childNode = ref
	}

	addMouseDownEventListener(useCapture) {
		document.addEventListener('mousedown', this.onMouseDown, useCapture)

		this.removeMouseDown = () => {
			document.removeEventListener(
				'mousedown',
				this.onMouseDown,
				useCapture
			)
		}
	}

	removeEventListeners() {
		if (this.removeMouseDown) this.removeMouseDown()
		if (this.removeMouseUp) this.removeMouseUp()
	}

	render() {
		const { children, display, className, wrapperProps } = this.props

		return (
			<div
				className={cls(className)}
				{...(wrapperProps || {})}
				ref={this.setChildNodeRef}>
				{children}
			</div>
		)
	}
}

OutsideClickHandler.defaultProps = defaultProps
