import {
  createElement,
  Component,
  useState,
  Fragment
} from '@wordpress/element'
import DraggableItems from './DraggableItems'
import { DragDropContext } from './BuilderRoot'
import cls from 'classnames'
import Panel, { PanelMetaWrapper } from '../../../options/options/ct-panel'
import CustomizerOptions from '../../controls/options'

const PanelsBuilderItems = ({ builderValue, inlinedItemsFromBuilder }) => {
  const secondaryItems =
    ct_customizer_localizations.header_builder_data.secondary_items['header']

  return (
    <CustomizerOptions
      option={{
        'inner-options': secondaryItems.reduce(
          (currentOptions, { options }) => ({
            ...currentOptions,
            ...options
          }),
          {}
        )
      }}
      renderOptions={({ onChange, value }) => (
        <div className="ct-available-items">
          <DraggableItems
            options={{ sort: false, filter: '.ct-item-in-builder' }}
            group={{
              name: 'header_sortables',
              put: false,
              pull: 'clone'
            }}
            draggableId={'available-items'}
            items={secondaryItems.map(({ id }) => id)}
            hasPointers={false}
            propsForItem={item => ({
              renderItem: ({ item, itemData }) => {
                const option = {
                  label: itemData.config.name,
                  'inner-options': secondaryItems.find(({ id }) => id === item)
                    .options
                }

                const itemInBuilder = inlinedItemsFromBuilder.indexOf(item) > -1

                return (
                  <PanelMetaWrapper
                    option={option}
                    getActualOption={({ open, container }) => (
                      <Fragment>
                        <Panel
                          id="test"
                          values={value}
                          option={option}
                          onChangeFor={onChange}
                          view="simple"
                        />

                        <div
                          ref={container}
                          data-id={item}
                          className={cls({
                            'ct-item-in-builder': itemInBuilder,
                            'ct-builder-item': !itemInBuilder
                          })}
                          onClick={() => itemInBuilder && open()}>
                          {itemData.config.name}
                        </div>
                      </Fragment>
                    )}></PanelMetaWrapper>
                )
              }
            })}
            direction="vertical"
          />
        </div>
      )}
    />
  )
}

export default PanelsBuilderItems
