<?php
/**
 * User contact methods
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

add_filter(
	'user_contactmethods',
	function ( $field ) {
		$fields['facebook'] = __( 'Facebook', 'blocksy' );
		$fields['twitter'] = __( 'Twitter', 'blocksy' );
		$fields['gplus'] = __( 'Google+', 'blocksy' );
		$fields['linkedin'] = __( 'LinkedIn', 'blocksy' );
		$fields['dribbble'] = __( 'Dribbble', 'blocksy' );
		$fields['instagram'] = __( 'Instagram', 'blocksy' );

		return $fields;
	}
);

