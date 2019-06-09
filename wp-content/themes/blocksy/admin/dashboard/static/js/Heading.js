import { createElement, Component, useContext } from '@wordpress/element'
import DashboardContext from './context'
import { sprintf, __ } from 'ct-i18n'

const Heading = () => {
	const { theme_name } = useContext(DashboardContext)

	return (
		<div>
			<h2>
				<svg width="25" height="25" viewBox="0 0 100 100">
					<defs>
						<linearGradient
							id="a"
							x1="1"
							y1="0.66"
							x2="-0.083"
							y2="0.282"
							gradientUnits="objectBoundingBox">
							<stop offset="0" stop-color="#3e5667" />
							<stop offset="1" stop-color="#293d4b" />
						</linearGradient>
						<clipPath id="c">
							<rect width="100" height="100" />
						</clipPath>
					</defs>
					<g id="b" clip-path="url(#c)">
						<g transform="translate(7)">
							<path
								d="M0,24.936,43.257,0,86.514,24.936,43.257,49.873Z"
								fill="#3e5667"
							/>
							<path
								d="M0,59.673V9.8L43.257,34.736V84.864Z"
								transform="translate(0 15.136)"
								fill="#394f5f"
							/>
							<path
								d="M60.257,59.673V9.8L17,34.736V84.864Z"
								transform="translate(26.257 15.136)"
								fill="url(#a)"
							/>
						</g>
					</g>
				</svg>

				{theme_name}
			</h2>
			<p>
				{__(
					`The most innovative, lightning fast and super charged WordPress theme. Build visually your next web project in no minutes`,
					'blocksy'
				)}
			</p>
		</div>
	)
}

export default Heading
