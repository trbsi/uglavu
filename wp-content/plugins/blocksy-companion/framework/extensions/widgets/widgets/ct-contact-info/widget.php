<?php
/**
 * Contact Info widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

class Blocksy_Widget_Ct_Contact_Info extends BlocksyWidgetFactory {
	protected function get_config() {
		return [
			'name' => __('Contact Info', 'blc'),
			'description' => __('Contact info', 'blc'),
		];
	}

	public function get_path() {
		return dirname(__FILE__);
	}
}