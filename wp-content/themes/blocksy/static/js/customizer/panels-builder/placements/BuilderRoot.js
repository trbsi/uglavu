import {
  Fragment,
  createElement,
  createContext,
  createPortal,
  useState,
  useCallback
} from '@wordpress/element'
import PlacementsBuilder from './PlacementsBuilder'
import DraggableItems from './DraggableItems'
import ViewSwitch from './ViewSwitch'
import AvailableItems from './AvailableItems'

export const DragDropContext = createContext({})

export const getOptionIdFor = (panelType, id) => `${panelType}_item_${id}`
export const expandOptionsFor = (panelType, id) =>
  wp.customize
    .section(`${getOptionIdFor(panelType, id.replace(/-/g, '_'))}_panel`)
    .expand()

const BuilderRoot = ({ builderValue: externalBuilderValue }) => {
  const [builderValue, setBuilderValue] = useState(externalBuilderValue)
  const [isDragging, setIsDragging] = useState(false)

  // desktop | mobile
  const [currentView, setCurrentView] = useState('desktop')

  const inlinedItemsFromBuilder = builderValue[currentView].reduce(
    (currentItems, { id, placements }) => [
      ...currentItems,
      ...(placements || []).reduce((c, { id, items }) => [...c, ...items], [])
    ],
    []
  )

  const getList = useCallback(id => {
    return []

    const [barId, placementId] = id.split(':')

    return builderValue[currentView]
      .find(({ id }) => id === barId)
      .placements.find(({ id }) => id === placementId).items
  }, [])

  const setList = useCallback(
    globalItems => {
      setBuilderValue(builderValue => ({
        ...builderValue,
        [currentView]: builderValue[currentView].map(
          ({ id: barId, placements }) => {
            if (
              globalItems[`${barId}:middle`] &&
              globalItems[`${barId}:middle`].length === 0 &&
              placements.find(({ id }) => id === 'middle').items.length > 0
            ) {
              globalItems[`${barId}:start-middle`] = []
              globalItems[`${barId}:end-middle`] = []
            }

            const keys = Object.keys(globalItems)

            if (keys.map(k => k.split(':')[0]).indexOf(barId) > -1) {
              return {
                id: barId,
                placements: placements.map(({ id, items }) => {
                  if (keys.map(k => k.split(':')[1]).indexOf(id) > -1) {
                    return {
                      id,
                      items: globalItems[`${barId}:${id}`]
                    }
                  }

                  return { id, items }
                })
              }
            }

            return {
              id: barId,
              placements
            }
          }
        )
      }))
    },

    [currentView]
  )

  return (
    <Fragment>
      <DragDropContext.Provider
        value={{
          isDragging,
          setIsDragging,
          setList,

          onChange: ({ id, value }) => setList({ [id]: value })
        }}>
        <div>
          <ViewSwitch
            currentView={currentView}
            setCurrentView={view => {
              setCurrentView(view)
            }}
          />

          <PlacementsBuilder builderValue={builderValue} view={currentView} />
        </div>

        {createPortal(
          <AvailableItems inlinedItemsFromBuilder={inlinedItemsFromBuilder} />,
          document.querySelector('#ct-option-header-builder-items')
        )}
      </DragDropContext.Provider>
    </Fragment>
  )
}

export default BuilderRoot
