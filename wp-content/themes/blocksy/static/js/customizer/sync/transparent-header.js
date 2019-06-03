import { stackingClassesFor } from './footer'
import { getCache } from './helpers'

const renderTransparent = () => {
	const cache = getCache()
	const hasCustom = cache.querySelector(
		'.ct-customizer-preview-cache [data-transparent-header-custom]'
	)

	const forcedByCheckboxes = cache.querySelector(
		'.ct-customizer-preview-cache [data-transparent-forced-by-checkboxes]'
	)

	if (forcedByCheckboxes) {
		return
	}

	if (hasCustom && hasCustom.dataset.transparentHeaderCustom === 'disabled') {
		return
	}

	stackingClassesFor(
		'transparent_header_visibility',
		document.body,
		'transparentHeader',
		wp.customize('has_global_transparent_header')() === 'yes' || hasCustom
	)
}

wp.customize('has_global_transparent_header', val =>
	val.bind(() => renderTransparent())
)

wp.customize('transparent_header_visibility', val =>
	val.bind(() => renderTransparent())
)
