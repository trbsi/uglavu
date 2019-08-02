import { createElement, Component, Fragment } from '@wordpress/element'
import SinglePicker from './color-picker/single-picker.js'
import './color-picker/quick-color-picker.js'
import OutsideClickHandler from './react-outside-click-handler'
import { normalizeCondition, matchValuesWithCondition } from 'match-conditions'

class ColorPicker extends Component {
  static ControlEnd = () => (
    <div
      className="ct-color-modal-wrapper"
      onMouseDown={e => {
        e.stopPropagation()
      }}
      onMouseUp={e => {
        e.stopPropagation()
      }}
    />
  )

  state = {
    is_picking: null,
    isTransitioning: null,
    shouldAnimate: true
  }

  render() {
    return (
      <OutsideClickHandler
        useCapture={false}
        display="inline-block"
        disabled={!this.state.is_picking}
        onOutsideClick={() =>
          this.setState({
            is_picking: null,
            isTransitioning: this.state.is_picking,
            shouldAnimate: true
          })
        }>
        {this.props.option.pickers
          .filter(
            picker =>
              !picker.condition ||
              matchValuesWithCondition(
                normalizeCondition(picker.condition),
                this.props.values
              )
          )
          .map(picker => (
            <SinglePicker
              picker={picker}
              key={picker.id}
              option={this.props.option}
              is_picking={this.state.is_picking}
              isTransitioning={this.state.isTransitioning}
              shouldAnimate={this.state.shouldAnimate}
              onPickingChange={is_picking =>
                this.setState(({ is_picking }) => ({
                  isTransitioning: picker.id,
                  shouldAnimate: is_picking
                    ? is_picking === picker.id
                      ? true
                      : false
                    : true,
                  is_picking: is_picking === picker.id ? null : picker.id
                }))
              }
              stopTransitioning={() =>
                this.setState({
                  isTransitioning: false,
                  shouldAnimate: true
                })
              }
              onChange={newPicker =>
                this.props.onChange({
                  ...this.props.value,
                  [picker.id]: newPicker
                })
              }
              value={
                this.props.value[picker.id] ||
                this.props.option.value[picker.id]
              }
            />
          ))}
      </OutsideClickHandler>
    )
  }
}

export default ColorPicker
