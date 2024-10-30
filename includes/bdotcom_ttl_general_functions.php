<?php
/**
 * GENERAL FUNCTIONS
 * ----------------------------------------------------------------------------
 */
function bdotcom_ttl_json_encode_decode( $data ) {
                $data = json_decode( $data, true );
                return $data;
}
function bdotcom_ttl_page_and_post_included( $excluded_pages ) {
                if ( ( is_single() || is_page() ) && ( !is_single( $excluded_pages ) && !is_page( $excluded_pages ) && !is_attachment() ) ) {
                                $page_and_post_included = true;
                } //( is_single() || is_page() ) && ( !is_single( $excluded_pages ) && !is_page( $excluded_pages ) && !is_attachment() )
                else {
                                $page_and_post_included = false;
                }
                return $page_and_post_included;
}
function bdotcom_ttl_word2links_replace( $search, $replace, $subject, $limit ) {
                return preg_replace( $search, $replace, $subject, $limit );
}
// Get if a string is multibyte
function bdotcom_ttl_contains_any_multibyte( $string ) {
                return !mb_check_encoding( $string, 'ASCII' ) && mb_check_encoding( $string, 'UTF-8' );
}
?>