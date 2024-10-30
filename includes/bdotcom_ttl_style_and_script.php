<?php
/**
 * STYLE 'N SCRIPTS
 * ----------------------------------------------------------------------------
 */
// Register our style to WP
add_action( 'init', 'bdotcom_ttl_add_styles' );
function bdotcom_ttl_add_styles( ) {
                //wp_register_style( $handle, $src, $deps, $ver, $media );    
                wp_register_style( 'bdotcom_ttl_admin_css', BDOTCOM_TTL_CSS_PLUGIN_DIR . '/bdotcom_ttl_admin.css', '', '1.0' );
                wp_register_style( 'bdotcom_ttl_public_css', BDOTCOM_TTL_CSS_PLUGIN_DIR . '/bdotcom_ttl_public.css', '', '1.0' );
}
// Register our scripts to WP 
add_action( 'init', 'bdotcom_ttl_add_scripts' );
function bdotcom_ttl_add_scripts( ) {
                // retrieve all use information
                @include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_user_options.php';                
                //wp_register_script( $handle, $src, $deps, $ver, $in_footer );
                wp_register_script( 'bdotcom_ttl_admin_js', BDOTCOM_TTL_JS_PLUGIN_DIR . '/bdotcom_ttl_admin.js', array(
                                 'jquery' 
                ), '1.0', true );
                wp_register_script( 'bdotcom_ttl_tooltip_js', BDOTCOM_TTL_JS_PLUGIN_DIR . '/bdotcom_ttl_tooltip.js', array(
                                 'jquery' 
                ), '1.0', true );
                wp_localize_script( 'bdotcom_ttl_admin_js', 'bdotcom_ttl_objectL10n', array(
                                 'aff_id' => $affiliate_id, // this will be used as a variable in javascript files
                                //set the path for json keyword  files                                
                                'json_keyword_path' => BDOTCOM_TTL_JS_PLUGIN_DIR . '/' . $language . '_' . BDOTCOM_TTL_DEFAULT_JSON_DATA_PATH //path for json keywords file to be called from javascript     
                ) );
}
// Add style 'n script just for admin settings page
add_action( 'admin_print_styles-settings_page_bdotcom_ttl', 'bdotcom_ttl_add_settings_styles' );
function bdotcom_ttl_add_settings_styles( ) {
                wp_enqueue_style( 'bdotcom_ttl_admin_css' );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'jquery-ui-autocomplete', '', array(
                                 'jquery-ui-widget',
                                'jquery-ui-position' 
                ), '' );
                wp_enqueue_script( 'bdotcom_ttl_admin_js' );
}
// Add style 'n scripts just for public pages after main theme style
add_action( 'wp_enqueue_scripts', 'bdotcom_ttl_add_sb_style_script', 11 );
function bdotcom_ttl_add_sb_style_script( ) {
                // retrieve all use information
                @include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_user_options.php';
                $page_and_post_included = bdotcom_ttl_page_and_post_included( $excluded_pages );
                //if ( ( is_single() || is_page() ) && ( !is_single( $excluded_pages ) && !is_page( $excluded_pages )  && !is_attachment() ) ) {
                if ( $page_and_post_included ) {
                                wp_enqueue_style( 'bdotcom_ttl_public_css' );
                                wp_enqueue_script( 'jquery' );
                                if ( $tooltip === 'checked' ) { // activate just if user checked in settings
                                                wp_enqueue_script( 'jquery-ui-tooltip' ); // tooltip won't work without css
                                                wp_enqueue_script( 'bdotcom_ttl_tooltip_js' );
                                } //$tooltip === 'checked'
                } //$page_and_post_included
}
?>