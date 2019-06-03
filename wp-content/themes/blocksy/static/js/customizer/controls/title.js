import { Fragment, createElement, Component } from '@wordpress/element'

const Title = ({ option: { label = '', desc = '' } }) => (
	<Fragment>
		<h3>{label}</h3>
		{desc && <p>{desc}</p>}
	</Fragment>
)

Title.renderingConfig = { design: 'none' }

export default Title
