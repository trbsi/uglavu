import { createElement } from '@wordpress/element'
import { expandOptionsFor } from './BuilderRoot'
import { __ } from 'ct-i18n'
import cls from 'classnames'
import DraggableItems from './DraggableItems'

const PrimaryPlacement = ({ placementName, bar, direction }) => {
  const placement = bar.placements.find(({ id }) => id === placementName)

  let placementsToRender = [placement]

  if (placementName !== 'middle') {
    const middle = bar.placements.find(({ id }) => id === 'middle')

    if (middle && middle.items.length > 0) {
      if (placementName === 'start') {
        const startMiddle = bar.placements.find(
          ({ id }) => id === 'start-middle'
        )

        placementsToRender = [placement, startMiddle]
      }

      if (placementName === 'end') {
        const endMiddle = bar.placements.find(({ id }) => id === 'end-middle')

        placementsToRender = [endMiddle, placement]
      }
    }
  }

  return (
    <li
      className={[`ct-builder-column-${placement.id}`]}
      {...(placement.id === 'middle'
        ? { 'data-count': placement.items.length }
        : {})}>
      {placementsToRender.map(placement => (
        <DraggableItems
          key={placement.id}
          className={
            placement.id === 'middle'
              ? ''
              : `ct-${
                  placement.id.indexOf('-') > -1 ? 'secondary' : 'primary'
                }-column`
          }
          draggableId={`${bar.id}:${placement.id}`}
          items={placement.items}
        />
      ))}
    </li>
  )
}

const Bar = ({ bar, direction = 'horizontal' }) => {
  return (
    <li className="builder-row">
      <div className="ct-row-actions">
        <button
          className="row-settings"
          onClick={() => expandOptionsFor('header', bar.id)}></button>
        {
          {
            'top-bar': __('Top Row', 'blocksy'),
            'middle-bar': __('Middle Row', 'blocksy'),
            'bottom-bar': __('Bottom Row', 'blocksy'),
            'offcanvas-bar': __('Offcanvas', 'blocksy')
          }[bar.id]
        }
      </div>

      <ul className="row-inner">
        {['start', 'middle', 'end']
          .filter(
            placementName =>
              !!bar.placements.find(({ id }) => id === placementName)
          )
          .map(placementName => (
            <PrimaryPlacement
              key={placementName}
              bar={bar}
              placementName={placementName}
              direction={direction}
            />
          ))}
      </ul>
    </li>
  )
}

const PlacementsBuilder = ({ view, builderValue }) => (
  <div
    className={cls('placements-builder', {
      'ct-mobile': view === 'mobile'
    })}>
    {view === 'mobile' && (
      <ul className="offcanvas-container">
        <Bar
          direction="vertical"
          bar={builderValue[view].find(({ id }) => id === 'offcanvas-bar')}
        />
      </ul>
    )}

    <ul className="horizontal-rows">
      {['top-bar', 'middle-bar', 'bottom-bar'].map(bar => (
        <Bar bar={builderValue[view].find(({ id }) => id === bar)} key={bar} />
      ))}
    </ul>
  </div>
)

export default PlacementsBuilder
