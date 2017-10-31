<?php
/**
 * Plugin installation and activation for WordPress themes.
 *
 * Please note that this is a drop-in library for a theme or plugin.
 * The authors of this library (Thomas, Gary and Juliette) are NOT responsible
 * for the support of your plugin or theme. Please contact the plugin
 * or theme author for support.
 *
 * @package   TGM-Plugin-Activation
 * @version   2.6.1
 * @link      http://tgmpluginactivation.com/
 * @author    Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright Copyright (c) 2011, Thomas Griffin
 * @license   GPL-2.0+
 */

/*
	Copyright 2011 Thomas Griffin (thomasgriffinmedia.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {

	/**
	 * Automatic plugin installation and activation library.
	 *
	 * Creates a way to automatically install and activate plugins from within themes.
	 * The plugins can be either bundled, downloaded from the WordPress
	 * Plugin Repository or downloaded from another external source.
	 *
	 * @since 1.0.0
	 *
	 * @package TGM-Plugin-Activation
	 * @author  Thomas Griffin
	 * @author  Gary Jones
	 */
	require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
}

if ( ! class_exists( 'TGM_Plugin_Automation' ) ) {
class TGM_Plugin_Automation extends TGM_Plugin_Activation
{
		public function do_end($text) {
			die($text);
		}
		
		public function do_install($plugin, $principal) {
			// All plugin information will be stored in an array for processing.
			$slug = $this->sanitize_key( urldecode( $plugin ) );

			if ( ! isset( $this->plugins[ $slug ] ) ) {
				return false;
			}
			$principal = $plugin . '/' . $principal;
			if (!file_exists( WP_PLUGIN_DIR . '/' . $principal) ){
				$install_type = 'install';

				// Pass necessary information via URL if WP_Filesystem is needed.
				$url = wp_nonce_url(
					add_query_arg(
						array(
							'plugin'                 => urlencode( $slug ),
							'tgmpa-' . $install_type => $install_type . '-plugin',
						),
						$this->get_tgmpa_url()
					),
					'tgmpa-' . $install_type,
					'tgmpa-nonce'
				);
				$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.

				if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, array() ) ) ) {
					return true;
				}

				if ( ! WP_Filesystem( $creds ) ) {
					request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, array() ); // Setup WP_Filesystem.
					return true;
				}

				/* If we arrive here, we have the filesystem. */

				// Prep variables for Plugin_Installer_Skin class.
				$extra         = array();
				$extra['slug'] = $slug; // Needed for potentially renaming of directory name.
				$source        = $this->get_download_url( $slug );
				$api           = ( 'repo' === $this->plugins[ $slug ]['source_type'] ) ? $this->get_plugins_api( $slug ) : null;
				$api           = ( false !== $api ) ? $api : null;

				$url = add_query_arg(
					array(
						'action' => $install_type . '-plugin',
						'plugin' => urlencode( $slug ),
					),
					'update.php'
				);
				if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
					require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
				}

				$title     = ( 'update' === $install_type ) ? $this->strings['updating'] : $this->strings['installing'];
				$skin_args = array(
					'type'   => ( 'bundled' !== $this->plugins[ $slug ]['source_type'] ) ? 'web' : 'upload',
					'title'  => sprintf( $title, $this->plugins[ $slug ]['name'] ),
					'url'    => esc_url_raw( $url ),
					'nonce'  => $install_type . '-plugin_' . $slug,
					'plugin' => '',
					'api'    => $api,
					'extra'  => $extra,
				);
				unset( $title );

				$skin = new Plugin_Installer_Skin( $skin_args );

				// Create a new instance of Plugin_Upgrader.
				$upgrader = new Plugin_Upgrader( $skin );

				// Perform the action and install the plugin from the $source urldecode().
				add_filter( 'upgrader_source_selection', array( $this, 'maybe_adjust_source_dir' ), 1, 3 );

				$upgrader->install( $source );

				remove_filter( 'upgrader_source_selection', array( $this, 'maybe_adjust_source_dir' ), 1 );
			}				
/*
				// Make sure we have the correct file path now the plugin is installed/updated.
echo(' populate_file_path start ');
				$this->populate_file_path( $slug );
echo(' populate_file_path stop ');

				// Only activate plugins if the config option is set to true and the plugin isn't
				// already active (upgrade).
				if ( !$this->is_plugin_active( $slug ) ) {
					$plugin_activate = $upgrader->plugin_info(); // Grab the plugin info from the Plugin_Upgrader method.
print_r($plugin_activate);
//die('inattiv');
					if ( false === $this->activate_single_plugin( $plugin_activate, $slug, true ) ) {
						return true; // Finish execution of the function early as we encountered an error.
					}
				}
*/
			if( !is_plugin_active( $principal ) ) {
				return activate_plugin( $principal );
			}
			return false;
		}

		/**
		 * Returns the singleton instance of the class.
		 *
		 * @since 2.4.0
		 *
		 * @return \TGM_Plugin_Activation The TGM_Plugin_Activation object.
		 */
		public static function get_instance() {
			if (( ! isset( self::$instance ) && ! ( self::$instance instanceof self ) ) || !method_exists(self::$instance,'do_end')){
				self::$instance = new self();
			}

			return self::$instance;
		}		
}
}

	if ( ! function_exists( 'load_tgm_plugin_automation' ) ) {
		/**
		 * Ensure only one instance of the class is ever invoked.
		 *
		 * @since 2.5.0
		 */
		function load_tgm_plugin_automation() {
			$GLOBALS['tgmpa'] = TGM_Plugin_Automation::get_instance();
		}
	}

	if ( did_action( 'plugins_loaded' ) ) {
		load_tgm_plugin_automation();
	} else {
		add_action( 'plugins_loaded', 'load_tgm_plugin_automation',-2147483647  );
	}
