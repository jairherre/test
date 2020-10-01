<?php
/**
 * Cartflows Helper.
 *
 * @package CARTFLOWS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Cartflows_Pro_Helper.
 */
class Cartflows_Pro_Helper {

	/**
	 * Get Optin fields.
	 *
	 * @return array.
	 */
	public static function get_optin_default_fields() {

		$optin_fields = array(
			'billing_first_name' => array(
				'label'        => __( 'First name', 'cartflows-pro' ),
				'required'     => true,
				'class'        => array(
					'form-row-first',
				),
				'autocomplete' => 'given-name',
				'priority'     => 10,
			),
			'billing_last_name'  => array(
				'label'        => __( 'Last name', 'cartflows-pro' ),
				'required'     => true,
				'class'        => array(
					'form-row-last',
				),
				'autocomplete' => 'family-name',
				'priority'     => 20,
			),
			'billing_email'      => array(
				'label'        => __( 'Email address', 'cartflows-pro' ),
				'required'     => true,
				'type'         => 'email',
				'class'        => array(
					'form-row-wide',
				),
				'validate'     => array(
					'email',
				),
				'autocomplete' => 'email username',
				'priority'     => 30,
			),
		);

		return $optin_fields;
	}

	/**
	 * Get Optin field.
	 *
	 * @param string $key Field key.
	 * @param int    $post_id Post id.
	 * @return array.
	 */
	public static function get_optin_fields( $key, $post_id ) {

		$saved_fields = get_post_meta( $post_id, 'wcf_fields_' . $key, true );

		if ( ! $saved_fields ) {
			$saved_fields = array();
		}

		$fields = array_filter( $saved_fields );

		if ( empty( $fields ) ) {
			if ( 'billing' === $key ) {

				$fields = self::get_optin_default_fields();

				update_post_meta( $post_id, 'wcf_fields_' . $key, $fields );
			}
		}

		return $fields;
	}
}
