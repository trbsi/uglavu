<?php
/**
 * Helpers for generating CSS output.
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

/**
 * Generate colors based on input.
 *
 * @param array $color_descriptor Colors array.
 */
function blocksy_get_colors( $color_descriptor ) {
	$result = [];

	if ( is_array( $color_descriptor ) ) {
		foreach ( $color_descriptor as $id => $data ) {
			$result[ $id ] = blocksy_get_color( $data );
		}

		return $result;
	}

	return false;
}

/**
 * Extract color from a descriptor.
 * id:
 *   - fw-custom
 *   - fw-no-color
 *   - color_skin_*
 *   - fw-inherit:location
 *   - fw-inherit:location:hover
 *   - fw-inherit:location:default
 *
 * @param array $color_descriptor Single color descriptor.
 */
function blocksy_get_color( $color_descriptor ) {
	if ( ! isset( $color_descriptor['color'] ) ) {
		return null;
	}

	return $color_descriptor['color'];
}

function blocksy_expand_responsive_value( $value ) {
	if ( is_array( $value ) && isset( $value['desktop'] ) ) {
		return $value;
	}

	return [
		'desktop' => $value,
		'tablet' => $value,
		'mobile' => $value,
	];
}

function blocksy_output_responsive_variable( $css, $selector, $variableName, $value ) {
	$value = blocksy_expand_responsive_value( $value );

	$css->put( $selector, '--' . $variableName . '-sm: ' . $value['mobile'] . 'px' );
	$css->put( $selector, '--' . $variableName . '-md: ' . $value['tablet'] . 'px' );
	$css->put( $selector, '--' . $variableName . '-lg: ' . $value['desktop'] . 'px' );
}

function blocksy_output_responsive($args = []) {
	$args = wp_parse_args(
		$args,
		[
			'css' => null,
			'tablet_css' => null,
			'mobile_css' => null,
			'selector' => null,
			'variableName' => null,
			'unit' => 'px',
			'value' => null,
			'respect_visibility' => null,
			'respect_stacking' => null,
			'enabled' => null
		]
	);

	if (! $args['variableName']) {
		throw new Error('variableName missing in args!');
	}

	$value = blocksy_expand_responsive_value( $args['value'] );

	if ($args['respect_visibility']) {
		if (! $args['respect_visibility']['mobile']) {
			$value['mobile'] = 0 . (
				empty($args['unit']) ? 'px' : ''
			);
		}

		if (! $args['respect_visibility']['tablet']) {
			$value['tablet'] = 0 . (
				empty($args['unit']) ? 'px' : ''
			);
		}

		if (! $args['respect_visibility']['desktop']) {
			$value['desktop'] = 0 . (
				empty($args['unit']) ? 'px' : ''
			);
		}
	}

	if ($args['respect_stacking']) {
		if ($args['respect_stacking']['mobile']) {
			$value['mobile'] = (intval($value['mobile']) * 2) . (
				empty($args['unit']) ? 'px' : ''
			);
		}

		if ($args['respect_stacking']['tablet']) {
			$value['tablet'] = (intval($value['tablet']) * 2) . (
				empty($args['unit']) ? 'px' : ''
			);
		}
	}

	if ($args['enabled']) {
		if ($args['enabled'] === 'no') {
			$value['mobile'] = 0 . (empty($args['unit']) ? 'px' : '');
			$value['tablet'] = 0 . (empty($args['unit']) ? 'px' : '');
			$value['desktop'] = 0 . (empty($args['unit']) ? 'px' : '');
		}
	}

	$args['mobile_css']->put( $args['selector'], '--' . $args['variableName'] . ': ' . $value['mobile'] . $args['unit'] );
	$args['tablet_css']->put( $args['selector'], '--' . $args['variableName'] . ': ' . $value['tablet'] . $args['unit'] );

	$args['css']->put( $args['selector'], '--' . $args['variableName'] . ': ' . $value['desktop'] . $args['unit'] );
}

function blocksy_units_config( $overrides = [] ) {
	$units = [
		[
			'unit' => 'px',
			'min' => 0,
			'max' => 40,
		],
		[
			'unit' => 'em',
			'min' => 0,
			'max' => 30,
		],
		[
			'unit' => '%',
			'min' => 0,
			'max' => 100,
		],
		[
			'unit' => 'vw',
			'min' => 0,
			'max' => 100,
		],
		[
			'unit' => 'vh',
			'min' => 0,
			'max' => 100,
		],
		[
			'unit' => 'pt',
			'min' => 0,
			'max' => 100,
		],
		[
			'unit' => 'rem',
			'min' => 0,
			'max' => 30,
		],
	];

	foreach ( $overrides as $single_override ) {
		foreach ( $units as $key => $single_unit ) {
			if ( $single_override['unit'] === $single_unit['unit'] ) {
				$units[ $key ] = $single_override;
			}
		}
	}

	return $units;
}

function blocksy_output_border($args = []) {
	$args = wp_parse_args(
		$args,
		[
			'css' => null,
			'selector' => null,

			'variableName' => null,
			'value' => null,
		]
	);

	if ($args['value']['style'] === 'none') {
		$args['css']->put($args['selector'], '--' . $args['variableName'] . ': none');
		return;
	}


	$color = blocksy_get_colors([
		'default' => $args['value']['color']
	]);

	$args['css']->put(
		$args['selector'],
		'--' . $args['variableName'] .
		': ' . $args['value']['width'] . 'px ' .
		$args['value']['style'] . ' ' . $color['default']
	);
}
