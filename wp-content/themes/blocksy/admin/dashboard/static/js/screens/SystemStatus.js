import { createElement, Component } from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'

import Tooltip from '../components/Tooltip'
import { Transition, animated } from 'react-spring'

import fileSaver from 'file-saver'

const upperCase = val => (val ? val.toUpperCase() : val)

let systemStatusData = null

export default class SystemStatus extends Component {
	state = {
		isLoading: !systemStatusData,
		systemStatusData: systemStatusData || {}
	}

	componentDidMount() {
		wp.ajax.post('ct_load_system_status').then(data => {
			this.setState({ isLoading: false, systemStatusData: data })
			systemStatusData = data
		})
	}

	performDownload() {
		var blob = new Blob(
			[
				JSON.stringify(
					{
						...this.state.systemStatusData,
						browser_info: jQuery.browser
					},
					null,
					'  '
				)
			],
			{
				type: 'text/plain;charset=utf-8'
			}
		)

		let date = new Date()

		let year = date.getFullYear()
		let month = date.getMonth()
		let day = date.getDate()
		let hour = date.getHours()
		let minutes = date.getMinutes()

		const filename = `blocksy-system-status-${year}-${month}-${day}-${hour}-${minutes}.json.txt`

		fileSaver.saveAs(blob, filename)
	}

	render() {
		return (
			<section className="ct-system-status">
				<Transition
					items={this.state.isLoading}
					from={{ opacity: 0 }}
					enter={[{ opacity: 1 }]}
					leave={[{ opacity: 0 }]}
					initial={null}
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
					{isLoading => {
						if (isLoading) {
							return props => (
								<animated.p
									style={props}
									className="ct-loading-text">
									<span />
									{__(
										'Collecting System Status...',
										'blocksy'
									)}
								</animated.p>
							)
						}

						return props => (
							<animated.div style={props}>
								<div className="ct-info">
									<i />

									<p>
										{__(
											'Download the system report file by clicking this button and send it to us in case you have problems. This report will help us identify faster the problem and fix it.',
											'blocksy'
										)}
									</p>
									<a
										tabIndex="-1"
										onClick={() => this.performDownload()}
										className="ct-button-primary">
										{__('Download Report', 'blocksy')}
									</a>
								</div>

								{Object.values(this.state.systemStatusData).map(
									(group, i) => (
										<div
											key={i}
											className="ct-system-status-group">
											<h3>{upperCase(group.title)}</h3>

											<ul>
												{Object.values(
													group.options
												).map((entry, ii) => (
													<li
														key={ii}
														className={classnames({
															[`ct-system-status-entry`]: true,
															success:
																entry.success,
															error: !entry.success
														})}>
														<span className="ct-validity-badge" />
														<p className="ct-entry-title">
															{entry.title}
														</p>

														<p className="ct-entry-value">
															{entry.value}
															{entry.message &&
																entry.doc && (
																	<span>
																		<a
																			target="_blank"
																			href={
																				entry.doc
																			}>
																			{
																				entry.text
																			}
																		</a>
																	</span>
																)}
														</p>

														<Tooltip
															placement="top"
															tooltips={
																entry.desc
															}>
															<i
																title={
																	entry.desc
																}
																className={classnames(
																	{
																		[`ct-system-status-help`]: true
																	}
																)}>
																<svg
																	width="15"
																	height="15"
																	viewBox="0 0 15 15">
																	<path d="M7.5,0C3.4,0,0,3.4,0,7.5S3.4,15,7.5,15S15,11.6,15,7.5S11.6,0,7.5,0z M8.5,11c0,0.6-0.4,1-1,1s-1-0.4-1-1V7.5  c0-0.6,0.4-1,1-1s1,0.4,1,1V11z M7.5,5.6c-0.6,0-1.1-0.5-1.1-1.1s0.5-1.1,1.1-1.1s1.1,0.5,1.1,1.1S8.1,5.6,7.5,5.6L7.5,5.6z" />
																</svg>
															</i>
														</Tooltip>
													</li>
												))}
											</ul>
										</div>
									)
								)}
							</animated.div>
						)
					}}
				</Transition>
			</section>
		)
	}
}
