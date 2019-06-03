import { createElement, Component, Fragment } from '@wordpress/element'
import classnames from 'classnames'
import { __ } from 'ct-i18n'
import _ from 'underscore'

export default class ImageUploader extends Component {
	params = {
		height: 250,
		width: 250,
		flex_width: true,
		flex_height: true
	}

	state = {
		attachment_info: null
	}

	onChange = value => {
		this.props.onChange(
			this.props.option.inline_value
				? value || ''
				: {
						...this.props.value,
						attachment_id: value
					}
		)
	}

	getAttachmentId = () => {
		return this.props.option.inline_value
			? this.props.value
			: this.props.value.attachment_id
	}

	/**
	 * Create a media modal select frame, and store it so the instance can be reused when needed.
	 */
	initFrame() {
		this.frame = wp.media({
			button: {
				text: 'Select',
				close: false
			},
			states: [
				new wp.media.controller.Library({
					title: 'Select logo',
					library: wp.media.query({ type: 'image' }),
					multiple: false,
					date: false,
					priority: 20,
					suggestedWidth: (this.props.option.logo || {}).width,
					suggestedHeight: (this.props.option.logo || {}).height
				}),

				...(this.props.option.skipCrop || true
					? []
					: [
							new wp.media.controller.CustomizeImageCropper({
								imgSelectOptions: this
									.calculateImageSelectOptions,
								control: this
							})
						])
			]
		})

		this.frame.on('select', this.onSelect, this)
		this.frame.on('cropped', this.onCropped, this)
		this.frame.on('skippedcrop', this.onSkippedCrop, this)
	}

	/**
	 * Open the media modal to the library state.
	 */
	openFrame() {
		this.initFrame()
		this.frame.setState('library').open()
	}

	/**
	 * After an image is selected in the media modal, switch to the cropper
	 * state if the image isn't the right size.
	 */
	onSelect = () => {
		var attachment = this.frame
			.state()
			.get('selection')
			.first()
			.toJSON()

		if (
			((this.props.option.logo || {}).width === attachment.width &&
				(this.props.option.logo || {}).height === attachment.height &&
				!(this.props.option.logo || {}).flex_width &&
				!(this.props.option.logo || {}).flex_height) ||
			(this.props.option.skipCrop || true)
		) {
			this.setImageFromAttachment(attachment)
			this.frame.close()
		} else {
			this.frame.setState('cropper')
		}
	}

	/**
	 * After the image has been cropped, apply the cropped image data to the setting.
	 *
	 * @param {object} croppedImage Cropped attachment data.
	 */
	onCropped = croppedImage => {
		this.setImageFromAttachment(croppedImage)
	}

	/**
	 * Returns a set of options, computed from the attached image data and
	 * control-specific data, to be fed to the imgAreaSelect plugin in
	 * wp.media.view.Cropper.
	 *
	 * @param {wp.media.model.Attachment} attachment
	 * @param {wp.media.controller.Cropper} controller
	 * @returns {Object} Options
	 */
	calculateImageSelectOptions(attachment, controller) {
		var control = controller.get('control')
		var flexWidth = !!parseInt(
			(control.props.option.logo || {}).flex_width,
			10
		)
		var flexHeight = !!parseInt(
			(control.props.option.logo || {}).flex_height,
			10
		)
		var realWidth = attachment.get('width')
		var realHeight = attachment.get('height')
		var xInit = parseInt((control.props.option.logo || {}).width, 10)
		var yInit = parseInt((control.props.option.logo || {}).height, 10)
		var ratio = xInit / yInit
		var xImg = xInit
		var yImg = yInit
		var x1
		var y1
		var imgSelectOptions

		controller.set(
			'canSkipCrop',
			!control.mustBeCropped(
				flexWidth,
				flexHeight,
				xInit,
				yInit,
				realWidth,
				realHeight
			)
		)

		if (realWidth / realHeight > ratio) {
			yInit = realHeight
			xInit = yInit * ratio
		} else {
			xInit = realWidth
			yInit = xInit / ratio
		}

		x1 = (realWidth - xInit) / 2
		y1 = (realHeight - yInit) / 2

		imgSelectOptions = {
			handles: true,
			keys: true,
			instance: true,
			persistent: true,
			imageWidth: realWidth,
			imageHeight: realHeight,
			minWidth: xImg > xInit ? xInit : xImg,
			minHeight: yImg > yInit ? yInit : yImg,
			x1: x1,
			y1: y1,
			x2: xInit + x1,
			y2: yInit + y1
		}

		if (flexHeight === false && flexWidth === false) {
			imgSelectOptions.aspectRatio = xInit + ':' + yInit
		}

		if (true === flexHeight) {
			delete imgSelectOptions.minHeight
			imgSelectOptions.maxWidth = realWidth
		}

		if (true === flexWidth) {
			delete imgSelectOptions.minWidth
			imgSelectOptions.maxHeight = realHeight
		}

		return imgSelectOptions
	}

	/**
	 * Return whether the image must be cropped, based on required dimensions.
	 *
	 * @param {bool} flexW
	 * @param {bool} flexH
	 * @param {int}  dstW
	 * @param {int}  dstH
	 * @param {int}  imgW
	 * @param {int}  imgH
	 * @return {bool}
	 */
	mustBeCropped(flexW, flexH, dstW, dstH, imgW, imgH) {
		if (true === flexW && true === flexH) {
			return false
		}

		if (true === flexW && dstH === imgH) {
			return false
		}

		if (true === flexH && dstW === imgW) {
			return false
		}

		if (dstW === imgW && dstH === imgH) {
			return false
		}

		if (imgW <= dstW) {
			return false
		}

		return true
	}

	/**
	 * If cropping was skipped, apply the image data directly to the setting.
	 */
	onSkippedCrop = () => {
		var attachment = this.frame
			.state()
			.get('selection')
			.first()
			.toJSON()

		this.setImageFromAttachment(attachment)
	}

	/**
	 * Updates the setting and re-renders the control UI.
	 *
	 * @param {object} attachment
	 */
	setImageFromAttachment(attachment) {
		this.onChange(attachment.id)
		this.updateAttachmentInfo()
	}

	updateAttachmentInfo = (force = false) => {
		let id = this.getAttachmentId()

		if (!id) return

		if (!wp.media.attachment(id).get('url') || force) {
			wp.media
				.attachment(id)
				.fetch()
				.then(() =>
					this.setState({
						attachment_info: JSON.parse(
							JSON.stringify(wp.media.attachment(id).toJSON())
						)
					})
				)
		} else {
			this.setState({
				attachment_info: JSON.parse(
					JSON.stringify(wp.media.attachment(id).toJSON())
				)
			})
		}

		this.detachListener()
		wp.media.attachment(id).on('change', this.updateAttachmentInfo)
	}

	detachListener() {
		if (!this.getAttachmentId()) return

		wp.media
			.attachment(this.getAttachmentId())
			.off('change', this.updateAttachmentInfo)
	}

	componentDidMount() {
		this.updateAttachmentInfo()
	}

	componentWillUnmount() {
		this.detachListener()
	}

	render() {
		return (
			<div
				className={classnames('attachment-media-view ct-attachment', {
					['landscape']:
						this.getAttachmentId() && this.state.attachment_info,
					['attachment-media-view-image']:
						this.getAttachmentId() && this.state.attachment_info
				})}
				{...this.props.option.attr || {}}>
				{this.getAttachmentId() && this.state.attachment_info ? (
					<Fragment>
						<div
							className="thumbnail thumbnail-image"
							onClick={() => this.openFrame()}>
							<img
								className="attachment-thumb"
								src={
									(this.state.attachment_info.width < 700
										? this.state.attachment_info.sizes.full
										: _.max(
												_.values(
													_.keys(
														this.state
															.attachment_info
															.sizes
													).length === 1
														? this.state
																.attachment_info
																.sizes
														: _.omit(
																this.state
																	.attachment_info
																	.sizes,
																'full'
															)
												),
												({ width }) => width
											)
									).url || this.state.attachment_info.url
								}
								draggable="false"
								alt=""
							/>

							<span
								onClick={e => {
									this.setState({ attachment_info: null })
									e.stopPropagation()

									this.onChange(null)
								}}
								className="small-remove-button">
								×
							</span>
						</div>

						<div className="actions">
							<button
								onClick={() => {
									this.setState({ attachment_info: null })
									this.onChange(null)
								}}
								type="button"
								className="button remove-button">
								Remove
							</button>
							<button
								type="button"
								className="button upload-button control-focus"
								onClick={() => this.openFrame()}
								id="customize-media-control-button-35">
								{this.props.option.filledLabel || 'Change logo'}
							</button>
						</div>
					</Fragment>
				) : (
					<Fragment>
						<div className="placeholder">No logo selected</div>
						<div className="actions">
							<button
								type="button"
								onClick={() => this.openFrame()}
								className="button upload-button"
								id="customize-media-control-button-50">
								{this.props.option.emptyLabel || 'Select logo'}
							</button>
						</div>
					</Fragment>
				)}
			</div>
		)
	}
}
