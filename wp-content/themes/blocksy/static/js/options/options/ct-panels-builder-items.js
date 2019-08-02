import { createElement, Component, useState } from '@wordpress/element'
import DraggableItems from '../../customizer/panels-builder/placements/DraggableItems'
import { DragDropContext } from '../../customizer/panels-builder/placements/BuilderRoot'

const PanelsBuilderItems = ({ value, option, onChange }) => {
  return <div id="ct-option-header-builder-items"></div>

  const secondaryItems =
    ct_customizer_localizations.header_builder_data.secondary_items[
      option.panelType
    ]

  const [isDragging, setIsDragging] = useState(false)

  return (
    <DragDropContext.Provider
      value={{
        setIsDragging: () => {},
        isDragging: false,
        onChange: () => {},
        setList: () => {}
      }}>
      <div className="ct-option-builder-items">
        <div className="ct-available-items">
          <DraggableItems
            options={{ sort: false }}
            group={{
              name: 'header_sortables',
              put: false,
              pull: 'clone'
            }}
            draggableId={'available-items'}
            items={secondaryItems.map(({ id }) => id)}
          />
        </div>
      </div>
    </DragDropContext.Provider>
  )
}

PanelsBuilderItems.renderingConfig = { design: 'none' }

export default PanelsBuilderItems
