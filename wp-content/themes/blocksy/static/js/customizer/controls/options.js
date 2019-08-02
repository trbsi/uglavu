import {
  createElement,
  Component,
  createRef,
  createContext,
  useEffect,
  useState,
  createPortal
} from '@wordpress/element'
import classnames from 'classnames'

import OptionsPanel from '../../options/OptionsPanel'
import {
  getFirstLevelOptions,
  getValueFromInput
} from '../../options/helpers/get-value-from-input'

const Options = ({ option, renderOptions = null }) => {
  const [values, setValues] = useState(null)

  return (
    <div className="ct-options-wrapper">
      <OptionsPanel
        renderOptions={renderOptions}
        purpose="customizer"
        onChange={(key, val) => {
          setValues({
            ...(values ||
              getValueFromInput(
                option['inner-options'],
                {},
                id => wp.customize(id) && wp.customize(id)()
              )),
            [key]: val
          })

          wp.customize(key) && wp.customize(key).set(val)
        }}
        options={option['inner-options']}
        value={
          values ||
          getValueFromInput(
            option['inner-options'],
            {},
            id => wp.customize(id) && wp.customize(id)()
          )
        }
      />
    </div>
  )
}

export default Options
