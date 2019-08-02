import { createElement, useContext } from '@wordpress/element'
import { getOptionIdFor } from './BuilderRoot'
import cls from 'classnames'
import Sortable from './Sortable'
import { DragDropContext } from './BuilderRoot'

export const DraggableItem = ({
  item,
  index,
  panelType,
  onRemove,
  renderItem,
  className
}) => {
  const itemData = ct_customizer_localizations.header_builder_data[
    panelType
  ].find(({ id }) => id === item)

  if (renderItem) {
    return renderItem({ item, itemData })
  }

  return (
    <div
      data-id={item}
      className={cls('ct-builder-item', className, {
        // 'ct-is-dragging': snapshot.isDragging
      })}
      onClick={() =>
        wp.customize
          .section(`${getOptionIdFor(panelType, item)}_panel`)
          .expand()
      }>
      {itemData.config.name}

      <button
        className="ct-btn-remove"
        onClick={e => {
          e.stopPropagation()
          onRemove()
        }}></button>
    </div>
  )
}

const DraggableItems = ({
  items,
  draggableId,
  hasPointers = true,
  className,
  tagName = 'div',
  direction = 'horizontal',
  group = 'header_sortables',
  options = {},
  propsForItem = item => ({}),
  ...props
}) => {
  const { isDragging, setIsDragging, onChange, setList } = useContext(
    DragDropContext
  )

  return (
    <Sortable
      options={{
        group,
        fallbackOnBody: true,
        forceFallback: true,
        filter: '.ct-pointer',
        direction: direction,
        onStart: function(event) {
          setIsDragging(true)
          document.body.classList.add('ct-builder-dragging')

          if (event.from && group && group.pull !== 'clone') {
            event.to.classList.add('ct-is-over')
          }
        },

        onEnd: () => {
          setIsDragging(false)
          document.body.classList.remove('ct-builder-dragging')
          ;[...document.querySelectorAll('.ct-panel-builder .ct-is-over')].map(
            el => el.classList.remove('ct-is-over')
          )
        },

        onMove: (event, originalEvent) => {
          if (event.from.closest('#ct-option-header-builder-items')) {
            Promise.resolve().then(() =>
              [
                ...event.from.querySelectorAll(
                  `[data-id="${event.dragged.dataset.id}"]`
                )
              ].map(el => {
                el.classList.remove('ct-builder-item')
                el.classList.add('ct-item-in-builder')
              })
            )
          }

          ;[...document.querySelectorAll('.ct-panel-builder .ct-is-over')].map(
            el => el.classList.remove('ct-is-over')
          )

          if (event.to) {
            event.to.classList.add('ct-is-over')
          }
        },
        ...options
      }}
      onChange={(order, sortable, evt) => {
        onChange({
          id: draggableId,
          value: order.filter(i => i !== '__pointer__' && i !== '__filler__')
        })
      }}
      tag={tagName}
      className={cls('ct-builder-items', className)}
      {...props}>
      {['end', 'start-middle'].indexOf(draggableId.split(':')[1]) > -1 && (
        <div data-id="__filler__" className="ct-filler"></div>
      )}

      {hasPointers && isDragging && (
        <div data-id="__pointer__" className="ct-pointer"></div>
      )}

      {items.map((item, index) => (
        <DraggableItem
          key={item}
          index={index}
          panelType={'header'}
          item={item}
          onRemove={() =>
            setList({
              [draggableId]: items.filter(id => id !== item),
              'available-items': null
            })
          }
          {...propsForItem(item)}
        />
      ))}
    </Sortable>
  )
}

export default DraggableItems
