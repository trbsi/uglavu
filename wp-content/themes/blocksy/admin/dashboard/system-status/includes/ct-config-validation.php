<?php
/**
 * Validate config
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package Blocksy
 */

class Blocksy_Config_Validation {
	protected $requirements = array();

	public function __construct() {
		$this->response = array(
			'response' => null,
			'error' => '',
		);

		$this->set_requirements();
	}

	protected function set_requirements() {
		$file = dirname( __FILE__ ) . '/ct-validation-requirements.php';
		if ( file_exists( $file ) ) {
			$this->requirements = require $file;
		}
	}

	public function config( $key ) {
		if ( isset( $this->requirements[ $key ] ) ) {
			return $this->requirements[ $key ];
		}

		return false;
	}

	public function value( $key ) {
		$config = $this->config( $key );

		if ( $config ) {
			return $config['value'];
		}

		return null;
	}

	public function error( $key ) {
		$config = $this->config( $key );

		if ( $config ) {
			return $config['error'];
		}

		return '';
	}

	public function message( $key, $values = array() ) {
		$error_text = $this->error( $key );

		if ( $error_text ) {
			foreach ( $values as $search => $repalce ) {
				$error_text = str_replace( ":{$search}", $repalce, $error_text );
			}
		}

		return $error_text;
	}

	public function version( $key, $value ) {
		$response = $this->response;
		$need_version = $this->value( $key );
		if ( version_compare( $value, $need_version ) >= 0 ) {
			$response['response'] = true;
		} else {
			$response['response'] = false;
			$response['error'] = $this->message(
				$key,
				array(
					'required' => $need_version,
				)
			);
		}

		return $response;
	}

	public function compare( $key, $value ) {
		$response = $this->response;
		$good_value = $this->value( $key );

		if ( false === $good_value ) {
			$response['response'] = true;
			return $response;
		}

		if ( (int) $value >= (int) $good_value ) {
			$response['response'] = true;
		} else {
			$response['response'] = false;
			$response['error'] = $this->message(
				$key,
				array(
					'required' => $good_value,
					'value' => $value,
				)
			);
		}

		return $response;
	}

	public function is( $key, $value ) {
		$response = $this->response;
		$good_value = $this->value( $key );

		if ( null === $good_value ) {
			$response['response'] = true;
			return $response;
		}

		if ( (bool) $value === (bool) $good_value ) {
			$response['response'] = true;
		} else {
			$response['response'] = false;
			$response['error'] = $this->message(
				$key,
				array(
					'required' => $good_value,
					'value' => $value,
				)
			);
		}

		return $response;
	}
}
