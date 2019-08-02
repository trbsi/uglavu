import {
  createElement,
  Component,
  createRef,
  useState,
  useContext,
  createContext,
  createPortal
} from '@wordpress/element'
import classnames from 'classnames'
import bezierEasing from 'bezier-easing'

import OptionsPanel from '../../options/OptionsPanel'
import {
  getFirstLevelOptions,
  getValueFromInput
} from '../../options/helpers/get-value-from-input'
import Switch from './ct-switch'
import { Transition } from 'react-spring'

const PanelContext = createContext({
  isOpen: false,
  isTransitioning: false,
  titlePrefix: null
})

export class PanelMetaWrapper extends Component {
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

    setTimeout(() =>
      (this.container.current.querySelector('button')
        ? this.container.current.querySelector('button')
        : this.container.current
      ).focus()
    )
  }

  render() {
    return (
      <PanelContext.Provider
        value={{
          ...this.state,
          container: this.container,
          close: () => this.close(),
          finishTransitioning: () => this.setState({ isTransitioning: false })
        }}>
        {this.props.getActualOption({
          open: () => this.open(),
          container: this.container,
          wrapperAttr: {
            className: `${
              this.props.option.switch
                ? this.props.value === 'yes'
                  ? 'ct-click-allowed'
                  : ''
                : 'ct-click-allowed'
            } ct-panel`,
            onClick: () => {
              if (this.props.option.switch && this.props.value !== 'yes') {
                return
              }

              this.open()
            }
          }
        })}
      </PanelContext.Provider>
    )
  }
}

const PanelContainer = ({ option, id, onChange, values, onChangeFor }) => {
  let maybeLabel =
    Object.keys(option).indexOf('label') === -1
      ? (id || '').replace(/./, s => s.toUpperCase()).replace(/\_|\-/g, ' ')
      : option.label

  const {
    isOpen,
    finishTransitioning,
    container,
    titlePrefix,
    close
  } = useContext(PanelContext)

  return createPortal(
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
          <div style={props} className="ct-customizer-panel">
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
                onChange={(key, val) => onChangeFor(key, val)}
                options={option['inner-options']}
                value={values}
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

const Panel = ({
  id,
  values,
  onChangeFor,
  option,
  value,
  view = 'normal',
  onChange
}) => {
  const { isOpen, container, isTransitioning } = useContext(PanelContext)

  if (view === 'simple') {
    return isTransitioning || isOpen ? (
      <PanelContainer
        id={id}
        values={values}
        onChangeFor={onChangeFor}
        onChange={() => {
          // this.forceUpdate()
        }}
        option={option}
      />
    ) : null
  }

  return (
    <div ref={container} className="ct-customizer-panel-container">
      <div className={classnames('ct-customizer-panel-option')}>
        {option.switch && (
          <Switch
            value={value}
            onChange={onChange}
            onClick={e => e.stopPropagation()}
          />
        )}

        <button type="button" />
      </div>

      {(isTransitioning || isOpen) && (
        <PanelContainer
          id={id}
          values={values}
          onChangeFor={onChangeFor}
          onChange={() => {
            // this.forceUpdate()
          }}
          option={option}
        />
      )}
    </div>
  )
}

Panel.renderingConfig = {
  design: 'inline'
}

Panel.MetaWrapper = PanelMetaWrapper

export default Panel
