import {
  createElement,
  Component,
  createRef,
  Fragment
} from '@wordpress/element'
import ColorPickerIris from './color-picker-iris.js'
import classnames from 'classnames'
import { __ } from 'ct-i18n'

export const getNoColorPropFor = option =>
  option.noColorTransparent ? 'transparent' : `CT_CSS_SKIP_RULE`

const focusOrOpenCustomizerSectionProps = section => ({
  target: '_blank',
  href: `${
    window.ct_localizations ? window.ct_localizations.customizer_url : ''
  }${encodeURIComponent(`[section]=${section}`)}`,
  ...(wp && wp.customize && wp.customize.section
    ? {
        onClick: e => {
          e.preventDefault()
          wp.customize.section(section).expand()
        }
      }
    : {})
})

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
        {this.props.el && (
          <span
            className="ct-arrow"
            ref={this.arrow}
            style={{
              ...getLeftForEl(this.arrow.current, this.props.el.current),

              ...(this.props.style ? { opacity: this.props.style.opacity } : {})
            }}
          />
        )}

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
                      background: getComputedStyle(document.documentElement)
                        .getPropertyValue(`--${color}`)
                        .trim()
                    }}
                    className={classnames({
                      active: this.props.value.color === `var(--${color})`
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

              {!this.props.option.skipNoColorPill && (
                <span
                  onClick={() =>
                    this.props.onChange({
                      ...this.props.value,
                      color: getNoColorPropFor(this.props.option)
                    })
                  }
                  className={classnames('ct-no-color-pill', {
                    active:
                      this.props.value.color ===
                      getNoColorPropFor(this.props.option)
                  })}>
                  <i className="ct-tooltip-top">{__('No Color', 'blocksy')}</i>
                </span>
              )}

              {!this.props.option.skipEditPalette && (
                <a
                  className="ct-edit-palette"
                  {...focusOrOpenCustomizerSectionProps('color')}>
                  <svg width="10" height="10" viewBox="0 0 10 10">
                    <path
                      fill="#EB8D8D"
                      d="M8.5,1.5C7.6,0.6,6.4,0,5,0v5L8.5,1.5z"
                    />
                    <path
                      fill="#F0A371"
                      d="M10,5c0-1.3-0.5-2.6-1.5-3.5L5,5H10z"
                    />
                    <path
                      fill="#F2DC7E"
                      d="M8.5,8.5C9.4,7.6,10,6.4,10,5H5L8.5,8.5z"
                    />
                    <path
                      fill="#96D69B"
                      d="M5,10c1.3,0,2.6-0.5,3.5-1.5L5,5V10z"
                    />
                    <path
                      fill="#80B1F2"
                      d="M1.5,8.5C2.4,9.4,3.6,10,5,10V5L1.5,8.5z"
                    />
                    <path
                      fill="#7D91E8"
                      d="M0,5c0,1.3,0.5,2.6,1.5,3.5L5,5H0z"
                    />
                    <path
                      fill="#C185E6"
                      d="M1.5,1.5C0.6,2.4,0,3.6,0,5h5L1.5,1.5z"
                    />
                    <path
                      fill="#DB84E0"
                      d="M5,0C3.7,0,2.4,0.5,1.5,1.5L5,5V0z"
                    />
                    <path
                      fill="#000000"
                      fillOpacity="0.3"
                      d="M5,0C2.2,0,0,2.2,0,5s2.2,5,5,5s5-2.2,5-5S7.8,0,5,0zM5,9.5c-2.5,0-4.5-2-4.5-4.5s2-4.5,4.5-4.5s4.5,2,4.5,4.5S7.5,9.5,5,9.5z"
                    />
                  </svg>
                  <i className="ct-tooltip-top">
                    {__('Edit Palette', 'blocksy')}
                  </i>
                </a>
              )}
            </div>
          )}

          <ColorPickerIris
            onChange={v => this.props.onChange(v)}
            value={{
              ...this.props.value,
              color:
                this.props.value.color === getNoColorPropFor(this.props.option)
                  ? ''
                  : this.props.value.color.indexOf('var') > -1
                  ? getComputedStyle(document.documentElement)
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
