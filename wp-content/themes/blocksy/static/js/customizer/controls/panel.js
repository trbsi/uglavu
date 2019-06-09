import {
	createElement,
	Component,
	createRef,
	useState,
	createContext,
	createPortal
} from '@wordpress/element'
import classnames from 'classnames'
import bezierEasing from 'bezier-easing'

import OptionsPanel from '../../options/OptionsPanel'
import { getFirstLevelOptions } from '../../options/helpers/get-value-from-input'
import Switch from './switch'
import { Transition } from 'react-spring'

const { Provider: PanelProvider, Consumer: PanelConsumer } = createContext({
	isOpen: false,
	isTransitioning: false,
	titlePrefix: null
})

class PanelMetaWrapper extends Component {
	state = {
		isOpen: false,
		isTransitioning: false,
		titlePrefix: null
	}

	container = createRef()

	open = () => {
		const wrapper = document.createElement('div')

		wrapper.classList.add('ct-tmp-panel-wrapper')

		this.container.current
			.closest('[id="customize-theme-controls"]')
			.appendChild(wrapper)

		this.setState({ isOpen: true, isTransitioning: true })

		this.container.current
			.closest('.accordion-section-content')
			.classList.add('ct-panel-open')

		const h3 = this.container.current
			.closest('ul')
			.querySelector('.customize-section-description-container h3')

		this.setState({
			titlePrefix: `${h3.querySelector('span').innerText} ▸ ${
				h3.innerText.split('\n')[h3.innerText.split('\n').length - 1]
			}`
		})
	}

	close = () => {
		this.setState({ isOpen: false })

		this.container.current
			.closest('.accordion-section-content')
			.classList.remove('ct-panel-open')

		setTimeout(() => this.container.current.querySelector('button').focus())
	}

	render() {
		return (
			<PanelProvider
				value={{
					...this.state,
					container: this.container,
					close: () => this.close(),
					finishTransitioning: () =>
						this.setState({ isTransitioning: false })
				}}>
				{this.props.getActualOption({
					wrapperAttr: {
						className: `${
							this.props.option.switch
								? this.props.value === 'yes'
									? 'ct-click-allowed'
									: ''
								: 'ct-click-allowed'
						} ct-panel`,
						onClick: () => {
							if (
								this.props.option.switch &&
								this.props.value !== 'yes'
							) {
								return
							}

							this.open()
						}
					}
				})}
			</PanelProvider>
		)
	}
}

const PanelContainer = ({ option, id, onChange }) => {
	const [currentPanelValues, setCurrentPanelValues] = useState(null)

	let maybeLabel =
		Object.keys(option).indexOf('label') === -1
			? (id || '')
					.replace(/./, s => s.toUpperCase())
					.replace(/\_|\-/g, ' ')
			: option.label

	return (
		<PanelConsumer>
			{({ isOpen, finishTransitioning, container, titlePrefix, close }) =>
				createPortal(
					<Transition
						items={isOpen}
						from={{ transform: 'translate3d(100%,0,0)' }}
						enter={{ transform: 'translate3d(0,0,0)' }}
						leave={{ transform: 'translate3d(100%,0,0)' }}
						config={(item, type) => ({
							// delay: type === 'enter' ? 180 * 10 : 0,
							duration: 180,
							easing: bezierEasing(0.645, 0.045, 0.355, 1)
						})}
						onRest={isOpen => {
							if (isOpen) return

							finishTransitioning()
							;[
								...container.current
									.closest('[id="customize-theme-controls"]')
									.querySelectorAll('.ct-tmp-panel-wrapper')
							].map(el => el.parentNode.removeChild(el))
						}}>
						{isOpen =>
							isOpen &&
							(props => (
								<div
									style={props}
									className="ct-customizer-panel">
									<div className="customize-panel-actions">
										<button
											onClick={e => {
												e.stopPropagation()
												close()
											}}
											type="button"
											className="customize-section-back"
										/>

										<h3>
											<span>{titlePrefix}</span>
											{maybeLabel}
										</h3>
									</div>

									<div className="customizer-panel-content">
										<OptionsPanel
											purpose="customizer"
											onChange={val => {
												setCurrentPanelValues(val)

												Object.keys(
													getFirstLevelOptions(
														option['inner-options']
													)
												).map(
													id =>
														wp.customize(id) &&
														wp
															.customize(id)
															.set(val[id])
												)

												// onChange()
											}}
											options={option['inner-options']}
											value={
												currentPanelValues ||
												Object.keys(
													wp.customize._value
												).reduce(
													(
														finalValue,
														currentValue
													) => ({
														...finalValue,
														[currentValue]: wp.customize._value[
															currentValue
														]()
													}),

													{}
												)
											}
										/>
									</div>
								</div>
							))
						}
					</Transition>,
					container.current
						.closest('[id="customize-theme-controls"]')
						.querySelector('.ct-tmp-panel-wrapper')
				)
			}
		</PanelConsumer>
	)
}

export default class Panel extends Component {
	static renderingConfig = {
		design: 'inline'
	}

	static MetaWrapper = PanelMetaWrapper

	render() {
		return (
			<PanelConsumer>
				{({ isOpen, container, isTransitioning }) => (
					<div
						ref={container}
						className="ct-customizer-panel-container">
						<div
							className={classnames(
								'ct-customizer-panel-option'
							)}>
							{this.props.option.switch && (
								<Switch
									value={this.props.value}
									onChange={this.props.onChange}
									onClick={e => e.stopPropagation()}
								/>
							)}

							<button type="button" />
						</div>

						{(isTransitioning || isOpen) && (
							<PanelContainer
								id={this.props.id}
								onChange={() => {
									// this.forceUpdate()
								}}
								option={this.props.option}
							/>
						)}
					</div>
				)}
			</PanelConsumer>
		)
	}
}
