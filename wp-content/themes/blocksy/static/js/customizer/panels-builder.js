import {
  unmountComponentAtNode,
  render,
  createElement
} from '@wordpress/element'

const buildersMaps = {
  new_header: {
    panelType: 'header',
    customizerFieldKey: 'header_placements'
  },

  footer: {
    panelType: 'footer',
    customizerFieldKey: 'footer_placements'
  }
}

const openBuilderFor = key => {
  return

  document.querySelector('.wp-full-overlay').classList.add('ct-show-builder')

  const builderValue = wp.customize(buildersMaps[key].customizerFieldKey)()

  const panelType = buildersMaps[key].panelType

  const initFor = BuilderRoot => {
    render(
      <BuilderRoot
        panelType={buildersMaps[key].panelType}
        builderValue={builderValue.sections.find(
          ({ id }) => id === builderValue.current_section
        )}
        onBuilderValueChange={() => {
          console.log('here change')
        }}
      />,
      document.querySelector('.ct-panel-builder')
    )
  }

  if (panelType === 'header') {
    import('./panels-builder/placements/BuilderRoot').then(
      ({ default: BuilderRoot }) => initFor(BuilderRoot)
    )
  } else {
    import('./panels-builder/rows/BuilderRoot').then(
      ({ default: BuilderRoot }) => initFor(BuilderRoot)
    )
  }
}

const closeBuilderFor = key => {
  document.querySelector('.wp-full-overlay').classList.remove('ct-show-builder')

  unmountComponentAtNode(document.querySelector('.ct-panel-builder'))
}

export const initBuilder = () => {
  const root = document.createElement('div')
  root.classList.add('ct-panel-builder')

  document.querySelector('.wp-full-overlay').appendChild(root)

  Object.keys(buildersMaps).map(singleKey =>
    (wp.customize.panel(singleKey) ? wp.customize.panel : wp.customize.section)(
      singleKey,
      section =>
        section.expanded.bind(value =>
          value ? openBuilderFor(singleKey) : closeBuilderFor(singleKey)
        )
    )
  )
}
