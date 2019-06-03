import { createElement, Component } from '@wordpress/element'
import classnames from 'classnames'
import { composeEventHandlers } from '../../options/helpers/compose-event-handlers'

export default class Switch extends Component {
	static renderingConfig = {
		design: 'inline'
	}

	state = {
		value: null
	}

	getState = () => this.state.value || this.props.value

	triggerChange(value) {
		this.setState({ value })
		this.props.onChange(value)
	}

	render() {
		return (
			<div
				className={classnames({
					[`ct-option-switch`]: true,
					[`ct-active`]: this.props.value === 'yes'
				})}
				onClick={composeEventHandlers(e => {
					e.stopPropagation()
					this.triggerChange(
						this.props.value === 'yes' ? 'no' : 'yes'
					)
				}, this.props.onClick)}>
				<span />
			</div>
		)
	}
}
