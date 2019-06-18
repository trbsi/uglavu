<?php
/**
 * About me widget
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

class Blocksy_Widget_Ct_About_Me extends BlocksyWidgetFactory {
	protected function get_config() {
		return [
			'name' => __('About Me', 'blc'),
			'description' => __('About me', 'blc'),
		];
	}

	public function get_path() {
		return dirname(__FILE__);
	}
}
