import { createElement, Component } from '@wordpress/element'
import classnames from 'classnames'

export default class Radio extends Component {
	renderAsText() {}

	renderAsRadio() {
		const { inline = false } = this.props.option

		return (
			<div
				className="ct-radio-option"
				{...(inline ? { ['data-inline']: '' } : {})}
				{...this.props.option.attr || {}}>
				{Object.keys(this.props.option.choices).map(choice => (
					<label key={choice}>
						<input
							type="radio"
							checked={choice === this.props.value}
							onChange={() => this.props.onChange(choice)}
						/>

						{this.props.option.choices[choice]}
					</label>
				))}
			</div>
		)
	}

	render() {
		if (this.props.option.view === 'radio') {
			return this.renderAsRadio()
		}

		const { inline = false } = this.props.option

		return (
			<ul
				className="ct-radio-option ct-buttons-group"
				{...(inline ? { ['data-inline']: '' } : {})}
				{...this.props.option.attr || {}}>
				{Object.keys(this.props.option.choices).map(choice => (
					<li
						className={classnames({
							active: choice === this.props.value
						})}
						onClick={() => this.props.onChange(choice)}
						key={choice}
						{...(this.props.singleChoiceProps
							? this.props.singleChoiceProps(choice)
							: {})}>
						{this.props.option.choices[choice]}
					</li>
				))}
			</ul>
		)
	}
}