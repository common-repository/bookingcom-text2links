<?php
/**
 * CORE SCRIPT
 * ----------------------------------------------------------------------------
 */
 
//Update plugin version on DB
register_activation_hook( BDOTCOM_TTL_PLUGIN_FILE, 'bdotcom_ttl_install' );
function bdotcom_ttl_install( ) {
                //this install defaults values
                $bdotcom_ttl_options = array(
                                 'plugin_ver' => BDOTCOM_TTL_PLUGIN_VERSION //plugin version 
                );
                update_option( 'bdotcom_ttl_options', $bdotcom_ttl_options );
}
// Add settings link on plugin page
add_filter( 'plugin_action_links_' . BDOTCOM_TTL_PLUGIN_FILE, 'bdotcom_ttl_settings_link' );
function bdotcom_ttl_settings_link( $links ) {
                $settings_link = '<a href="options-general.php?page=bdotcom_ttl.php">' . __( 'Settings', BDOTCOM_TTL_TEXT_DOMAIN ) . '</a>';
                array_unshift( $links, $settings_link );
                return $links;
}
// Add a menu for our option page in Settings
add_action( 'admin_menu', 'bdotcom_ttl_add_page' );
function bdotcom_ttl_add_page( ) {
                add_options_page( BDOTCOM_TTL_PLUGIN_NAME . ' settings', // Page title on browser bar 
                                BDOTCOM_TTL_PLUGIN_NAME, // menu item text
                                'manage_options', // only administartors can open this
                                'bdotcom_ttl', // unique name of settings page
                                'bdotcom_ttl_option_page' //call to fucntion which creates the form
                                );
}
/* Localization and internazionalization */
add_action( 'plugins_loaded', 'bdotcom_ttl_init' );
function bdotcom_ttl_init( ) {
                load_plugin_textdomain( BDOTCOM_TTL_TEXT_DOMAIN, false, dirname( BDOTCOM_TTL_PLUGIN_FILE ) . '/languages/' );
}
?>