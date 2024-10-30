<?php
/**
     * Plugin Name: Booking.com Text2Links
     * Plugin URI: http://www.booking.com/general.html?tmpl=docs/partners_affiliate_examples
     * Description: Text2Links picks up within more than one hundred destinations’ keywords, turning your matched words into links to your implementation on Booking.com
     * Version: 1.3
     * Author: Strategic Partnership Department at Booking.com
     * Author URI: http://www.booking.com/general.html?tmpl=docs/partners_affiliate_examples
     * License: GPLv2 or later
     */
     
     
     /* Booking.com Text2Links is free software: you can redistribute it and/or modify
            it under the terms of the GNU General Public License as published by
            the Free Software Foundation, either version 2 of the License, or
            any later version.
             
            Booking.com Text2Links is distributed in the hope that it will be useful,
            but WITHOUT ANY WARRANTY; without even the implied warranty of
            MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
            GNU General Public License for more details.
             
            You should have received a copy of the GNU General Public License
            along with Booking.com Text2Links. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
    */
    
    
    
/*Define constants and paths*/
define( 'BDOTCOM_TTL_TEXT_DOMAIN' , 'bdotcom_ttl_text_domain' ) ; //If changed, please change even the .po and .mo files with new name
define( 'BDOTCOM_TTL_PLUGIN_NAME' , 'Booking.com Text2Links' ) ;
define( 'BDOTCOM_TTL_PLUGIN_VERSION' , '1.3' ) ;
define( 'BDOTCOM_TTL_PHP_MIN_VERSION' , '5.3.6' ) ;

define( 'BDOTCOM_TTL_PLUGIN_FILE' , plugin_basename( __FILE__ ) ) ;    
define( 'BDOTCOM_TTL_PLUGIN_DIR_PATH' , plugin_dir_path( __FILE__ ) ) ;
define( 'BDOTCOM_TTL_PLUGIN_DIR_URL' , plugin_dir_url( __FILE__ ) ) ;
define( 'BDOTCOM_TTL_JS_PLUGIN_DIR', BDOTCOM_TTL_PLUGIN_DIR_URL.'js' ) ;
define( 'BDOTCOM_TTL_CSS_PLUGIN_DIR', BDOTCOM_TTL_PLUGIN_DIR_URL.'css' ) ;
define( 'BDOTCOM_TTL_IMG_PLUGIN_DIR', BDOTCOM_TTL_PLUGIN_DIR_URL.'images' ) ;
define( 'BDOTCOM_TTL_INC_PLUGIN_DIR', BDOTCOM_TTL_PLUGIN_DIR_PATH.'includes' ) ;
define( 'BDOTCOM_TTL_WP_VERSION' , get_bloginfo( 'version' ) ) ;

//Default fallback values
define( 'BDOTCOM_TTL_DEFAULT_JSON_DATA_PATH' , 'bdotcom_ttl_json_keywords.json' ) ;
define( 'BDOTCOM_TTL_DEFAULT_AID' , 821487 ) ;
define( 'BDOTCOM_TTL_DEFAULT_TARGET_AID' , 304142 ) ;// booking.com default aid
define( 'BDOTCOM_TTL_DEFAULT_MAX_LINKS' , 10 ) ;
define( 'BDOTCOM_TTL_DEFAULT_LANGUAGE' , 'en-gb' ) ;
define( 'BDOTCOM_TTL_DEFAULT_TOOLTIP' , 'unchecked' ) ;

@include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_general_functions.php' ;
@include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_style_and_script.php' ;
@include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_core.php' ;
@include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_forms.php' ;
@include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_text_scanner.php' ;
?>