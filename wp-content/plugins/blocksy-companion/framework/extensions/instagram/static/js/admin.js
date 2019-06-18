import './ct-events'
import ctEvents from 'ct-events'
import ResetInstagramCaches from './ResetInstagramCaches'

ctEvents.on('blocksy:options:register', opts => {
	opts['blocksy-instagram-reset'] = ResetInstagramCaches
})
