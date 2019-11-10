<?php
/**
 * The settings functionality of the plugin.
 *
 * @since      0.1.8
 * @package    Classic_SEO
 * @subpackage Classic_SEO\Core
 */

namespace Classic_SEO;

defined( 'ABSPATH' ) || exit;

/**
 * Settings class.
 */
class Settings {

	/**
	 * Hold option data.
	 *
	 * @var array
	 */
	private $keys = [];

	/**
	 * Options holder.
	 *
	 * @var array
	 */
	private $options = null;

	/**
	 * The Constructor.
	 */
	public function __construct() {
		add_action( 'wpml_loaded', [ $this, 'init' ] );

		$this->add_options( 'titles',  'cpseo-options-titles' );
		$this->add_options( 'general', 'cpseo-options-general' );
		$this->add_options( 'sitemap', 'cpseo-options-sitemap' );
	}

	/**
	 * Init.
	 */
	public function init() {
		foreach ( $this->get_keys() as $id => $key ) {
			do_action( 'wpml_multilingual_options', $key );
			$this->add_options( $id, $key );
		}
	}

	/**
	 * Add new option data.
	 *
	 * @param string $id  Unique id.
	 * @param string $key Option key.
	 */
	public function add_options( $id, $key ) {
		if ( ! empty( $id ) && ! empty( $key ) ) {

			$this->keys[ $id ] = $key;

			// Lazy-Load options.
			if ( ! is_null( $this->options ) ) {
				$options = get_option( $key, [] );
				$options = $this->normalize_it( $options );

				$this->options[ $id ] = $options;
			}
		}
	}

	/**
	 * Get settings keys.
	 *
	 * @return array
	 */
	public function get_keys() {
		return $this->keys;
	}

	/**
	 * Get Setting.
	 *
	 * @param  string $field_id ID of field to get.
	 * @param  mixed  $default  (Optional) Default value.
	 * @return mixed
	 */
	public function get( $field_id = '', $default = false ) {
		$opts = $this->get_options();
		$ids  = explode( '.', $field_id );

		foreach ( $ids as $id ) {
			if ( is_null( $opts ) ) {
				break;
			}
			$opts = isset( $opts[ $id ] ) ? $opts[ $id ] : null;
		}

		if ( is_null( $opts ) ) {
			return $default;
		}

		return $opts;
	}

	/**
	 * Set value.
	 *
	 * @param string $group Setting group.
	 * @param string $id    Setting id.
	 * @param string $value Setting value.
	 */
	public function set( $group, $id, $value ) {
		$this->options[ $group ][ $id ] = $value;
	}

	/**
	 * Get all settings.
	 *
	 * @return array
	 */
	public function all() {
		return $this->get_options();
	}

	/**
	 * Get all settings.
	 *
	 * @return array
	 */
	public function all_raw() {
		$options = [];

		if ( ! empty( $this->keys ) ) {
			foreach ( $this->keys as $id => $key ) {
				$options[ $id ] = get_option( $key, [] );
			}
		}

		return $options;
	}

	/**
	 * Get options once for use throughout the plugin cycle.
	 *
	 * @return array
	 */
	private function get_options() {

		if ( is_null( $this->options ) && ! empty( $this->keys ) ) {

			$options = [];
			foreach ( $this->keys as $id => $key ) {
				$options[ $id ] = get_option( $key, [] );
			}

			$this->options = $this->normalize_it( $options );
		}

		return (array) $this->options;
	}

	/**
	 * Normalize option data
	 *
	 * @param mixed $options Array to normalize.
	 * @return mixed
	 */
	private function normalize_it( $options ) {
		foreach ( (array) $options as $key => $value ) {
			$options[ $key ] = is_array( $value ) ? $this->normalize_it( $value ) : Helper::normalize_data( $value );
		}

		return $options;
	}
}
