import { createElement, Component } from '@wordpress/element'
import { Provider, getDefaultValue } from './context'
import createHashSource from 'hash-source'
import Heading from './Heading'
import {
	Router,
	Link,
	Location,
	LocationProvider,
	createHistory
} from '@reach/router'
import ctEvents from 'ct-events'
import { Transition, animated } from 'react-spring'

import Navigation from './Navigation'
import Home from './screens/Home'
import SystemStatus from './screens/SystemStatus'
import RecommendedPlugins from './screens/RecommendedPlugins'
import Changelog from './screens/Changelog'

let history = createHistory(createHashSource())
/*
ctEvents.on('ct:dashboard:routes', r =>
	r.push({
		Component: () => <div key="test">hello</div>,
		path: '/test'
	})
)
*/

const SpringRouter = ({ children }) => (
	<Location>
		{({ location }) => (
			<Transition
				items={location}
				initial={null}
				keys={location => location.pathname}
				from={{ opacity: 0 }}
				enter={[{ opacity: 1 }]}
				leave={[{ opacity: 0 }]}
				config={(key, phase) => {
					return phase === 'leave'
						? {
								duration: 300
							}
						: {
								delay: 300,
								duration: 300
							}
				}}>
				{location => props => (
					<animated.div
						style={{
							...props
						}}>
						<Router primary={false} location={location}>
							{children}
						</Router>
					</animated.div>
				)}
			</Transition>
		)}
	</Location>
)

const FadeTransitionRouter = props => (
	<Location>
		{({ location }) => (
			<TransitionGroup className="transition-group">
				<CSSTransition
					key={location.key}
					classNames="fade"
					timeout={500}>
					{/* the only difference between a router animation and
              any other animation is that you have to pass the
              location to the router so the old screen renders
              the "old location" */}
					<Router
						location={location}
						className="router"
						primary={false}>
						{props.children}
					</Router>
				</CSSTransition>
			</TransitionGroup>
		)}
	</Location>
)

export default class Dashboard extends Component {
	render() {
		const userRoutes = []
		ctEvents.trigger('ct:dashboard:routes', userRoutes)

		return (
			<LocationProvider history={history}>
				<Provider
					value={{
						...getDefaultValue(),
						theme_version: ctDashboardLocalizations.theme_version,
						theme_name: ctDashboardLocalizations.theme_name
					}}>
					<header>
						<Heading />
						<Navigation />
					</header>

					<section>
						<SpringRouter primary={false} className="router">
							<Home path="/" />
							<SystemStatus focus={false} path="system" />
							<RecommendedPlugins path="plugins" />
							<Changelog path="changelog" />

							{userRoutes.map(({ Component, path }) => (
								<Component key={path} path={path} />
							))}
						</SpringRouter>
					</section>
				</Provider>
			</LocationProvider>
		)
	}
}
