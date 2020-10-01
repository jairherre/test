<?php
/**
 * WooCommerce Admin Add Install Jetpack and WooCommerce Services Plugin Note Provider.
 *
 * Adds a note to the merchant's inbox prompting them to install the Jetpack
 * and WooCommerce Services plugins after it fails to install during
 * WooCommerce setup.
 *
 * @package WooCommerce Admin
 */

namespace Automattic\WooCommerce\Admin\Notes;

defined( 'ABSPATH' ) || exit;

use \Automattic\WooCommerce\Admin\PluginsHelper;

/**
 * WC_Admin_Notes_Install_JP_And_WCS_Plugins
 */
class WC_Admin_Notes_Install_JP_And_WCS_Plugins {
	/**
	 * Note traits.
	 */
	use NoteTraits;

	/**
	 * Name of the note for use in the database.
	 */
	const NOTE_NAME = 'wc-admin-install-jp-and-wcs-plugins';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'woocommerce_note_action_install-jp-and-wcs-plugins', array( $this, 'install_jp_and_wcs_plugins' ) );
		add_action( 'activated_plugin', array( $this, 'action_note' ) );
	}

	/**
	 * Get the note.
	 */
	public static function get_note() {
		$content = __( 'We noticed that there was a problem during the Jetpack and WooCommerce Services install. Please try again and enjoy all the advantages of having the plugins connected to your store! Sorry for the inconvenience. The "Jetpack" and "WooCommerce Services" plugins will be installed & activated for free.', 'woocommerce-admin' );

		$note = new WC_Admin_Note();
		$note->set_title( __( 'Uh oh... There was a problem during the Jetpack and WooCommerce Services install. Please try again.', 'woocommerce-admin' ) );
		$note->set_content( $content );
		$note->set_content_data( (object) array() );
		$note->set_type( WC_ADMIN_Note::E_WC_ADMIN_NOTE_INFORMATIONAL );
		$note->set_name( self::NOTE_NAME );
		$note->set_source( 'woocommerce-admin' );
		$note->add_action(
			'install-jp-and-wcs-plugins',
			__( 'Install plugins', 'woocommerce-admin' ),
			false,
			WC_Admin_Note::E_WC_ADMIN_NOTE_ACTIONED,
			true
		);
		return $note;
	}

	/**
	 * Action the Install Jetpack and WooCommerce Services note, if any exists,
	 * and as long as both the Jetpack and WooCommerce Services plugins have been
	 * activated.
	 */
	public static function action_note() {
		// Make sure that both plugins are active before actioning the note.
		$active_plugin_slugs = PluginsHelper::get_active_plugin_slugs();
		$jp_active           = in_array( 'jetpack', $active_plugin_slugs, true );
		$wcs_active          = in_array( 'woocommerce-services', $active_plugin_slugs, true );

		if ( ! $jp_active || ! $wcs_active ) {
			return;
		}

		// Action any notes with a matching name.
		$data_store = \WC_Data_Store::load( 'admin-note' );
		$note_ids   = $data_store->get_notes_with_name( self::NOTE_NAME );

		foreach ( $note_ids as $note_id ) {
			$note = WC_Admin_Notes::get_note( $note_id );

			if ( $note ) {
				$note->set_status( WC_Admin_Note::E_WC_ADMIN_NOTE_ACTIONED );
				$note->save();
			}
		}
	}

	/**
	 * Install the Jetpack and WooCommerce Services plugins in response to the action
	 * being clicked in the admin note.
	 *
	 * @param WC_Admin_Note $note The note being actioned.
	 */
	public function install_jp_and_wcs_plugins( $note ) {
		if ( self::NOTE_NAME !== $note->get_name() ) {
			return;
		}

		$this->install_and_activate_plugin( 'jetpack' );
		$this->install_and_activate_plugin( 'woocommerce-services' );
	}

	/**
	 * Installs and activates the specified plugin.
	 *
	 * @param string $plugin The plugin slug.
	 */
	private function install_and_activate_plugin( $plugin ) {
		$install_request = array( 'plugin' => $plugin );
		$installer       = new \Automattic\WooCommerce\Admin\API\OnboardingPlugins();
		$result          = $installer->install_plugin( $install_request );

		// @todo Use the error statuses to decide whether or not to action the note.
		if ( is_wp_error( $result ) ) {
			return;
		}

		$activate_request = array( 'plugins' => $plugin );

		$installer->activate_plugins( $activate_request );
	}
}