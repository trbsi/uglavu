import { startListeningToValuesAndReact } from './conditions.js'
import { defineCustomizerControl } from './controls/utils.js'
import { listenToChanges } from './customizer-color-scheme.js'
import { listenToPreviewEventsAndAct } from './preview-events'
import { listenToVariables } from './customizer-variables'
import './reset'

import ImagePicker from './controls/image-picker.js'
import Switch from './controls/switch.js'
import Radio from './controls/radio.js'
import Slider from './controls/slider.js'
import Layers from './controls/layers.js'
import ColorPicker from './controls/color-picker.js'
import Title from './controls/title.js'
import Panel from './controls/panel.js'
import NumberControl from './controls/number.js'
import Divider from './controls/divider.js'
import Options from './controls/options.js'

startListeningToValuesAndReact()
listenToChanges()
listenToPreviewEventsAndAct()
listenToVariables()

defineCustomizerControl('ct-title', Title)
defineCustomizerControl('ct-image-picker', ImagePicker)
defineCustomizerControl('ct-switch', Switch)
defineCustomizerControl('ct-radio', Radio)
defineCustomizerControl('ct-slider', Slider)
defineCustomizerControl('ct-layers', Layers)
defineCustomizerControl('ct-color-picker', ColorPicker)
defineCustomizerControl('ct-number', NumberControl)
defineCustomizerControl('ct-panel', Panel)
defineCustomizerControl('ct-divider', Divider)
defineCustomizerControl('ct-options', Options)
