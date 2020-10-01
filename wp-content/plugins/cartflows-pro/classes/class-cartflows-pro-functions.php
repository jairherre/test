<?php
/**
 * Cartflows Functions.
 *
 * @package CARTFLOWS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Is custom checkout?
 *
 * @param int $checkout_id checkout ID.
 * @since 1.0.0
 */
function _is_wcf_optin_custom_fields( $checkout_id ) {

	$is_custom = wcf()->options->get_optin_meta_value( $checkout_id, 'wcf-optin-enable-custom-fields' );

	if ( 'yes' === $is_custom ) {

		return true;
	}

	return false;
}
