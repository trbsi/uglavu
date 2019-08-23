import './public-path'
import {
  createElement,
  render,
  unmountComponentAtNode
} from '@wordpress/element'
import { defineCustomizerControl } from './controls/utils.js'
import { listenToChanges } from './customizer-color-scheme.js'
import './preview-events'
import { listenToVariables } from './customizer-variables'
import './reset'
import { initAllPanels } from '../options/initPanels'

import { initBuilder } from './panels-builder'

import Options from './controls/options.js'

listenToChanges()
listenToVariables()

defineCustomizerControl('ct-options', Options)

if ($ && $.fn) {
  $(document).on('widget-added', () => initAllPanels())
}

document.addEventListener('DOMContentLoaded', () => {
  initAllPanels()
  initBuilder()

  Object.values(wp.customize.control._value)
    .filter(({ params: { type } }) => type === 'ct-options')
    .map(control => {
      ;(wp.customize.panel(control.section())
        ? wp.customize.panel
        : wp.customize.section)(control.section(), section => {
        section.expanded.bind(value => {
          if (value) {
            const ChildComponent = Options

            let MyChildComponent = Options

            // block | inline
            let design = 'none'

            render(
              <MyChildComponent
                id={control.id}
                onChange={v => control.setting.set(v)}
                value={control.setting.get()}
                option={control.params.option}>
                {props => <ChildComponent {...props} />}
              </MyChildComponent>,

              control.container[0]
            )

            return
          }

          setTimeout(() => {
            unmountComponentAtNode(control.container[0])
          }, 500)
        })
      })
    })

  if ($ && $.fn) {
    $(document).on('click', '[data-trigger-section]', e => {
      e.preventDefault()

      wp.customize.section(e.target.dataset.triggerSection).expand()
    })
  }
})
