<?php
/**
 * JSON DATA PATH
 * ----------------------------------------------------------------------------
 */
 
@include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_user_options.php';
$data_path =  BDOTCOM_TTL_JS_PLUGIN_DIR . '/' . $language . '_' . BDOTCOM_TTL_DEFAULT_JSON_DATA_PATH ;
$data = file_get_contents( $data_path );
if ( is_string( $data ) && json_decode( $data ) ) {
                $is_valid_json = true;
} //is_string( $data ) && json_decode( $data )
else {
                $is_valid_json = false;
}
?>