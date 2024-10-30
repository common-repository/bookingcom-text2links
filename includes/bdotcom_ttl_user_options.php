<?php
/**
 * CORE SCRIPT
 * ----------------------------------------------------------------------------
 */
 
// retrieve all use information
$options        = bdotcom_ttl_retrieve_all_user_options();
$affiliate_id   = !empty( $options[ 'bdotcom_ttl_aid' ] ) ? $options[ 'bdotcom_ttl_aid' ] : BDOTCOM_TTL_DEFAULT_AID;
$max_links      = !empty( $options[ 'bdotcom_ttl_maximum_links' ] ) ? $options[ 'bdotcom_ttl_maximum_links' ] : false;
$excluded_pages = trim( $options[ 'bdotcom_ttl_excluded_pages' ] );
$excluded_pages = explode( ',', $excluded_pages );
$language   =  !empty( $options[ 'bdotcom_ttl_language' ] ) ? $options[ 'bdotcom_ttl_language' ] : BDOTCOM_TTL_DEFAULT_LANGUAGE ; 
$tooltip        = $options[ 'bdotcom_ttl_tooltip' ];
?>