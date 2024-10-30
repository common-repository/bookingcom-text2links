<?php
add_filter( 'the_content', 'bdotcom_ttl_text_scanner' );
function bdotcom_ttl_text_scanner( $content ) {
                //echo '<h3 style="color:#FF0000;">We are in file: ' . __FILE__ . '</h3>';
                if ( !empty( $content ) ) {
                                //Load user settings' options
                                @include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_user_options.php';
                                $page_and_post_included = bdotcom_ttl_page_and_post_included( $excluded_pages );
                                if ( $page_and_post_included ) {
                                                @include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_json_data_path.php';
                                                if ( $is_valid_json ) {
                                                                $data             = bdotcom_ttl_json_encode_decode( $data );
                                                                $internal_counter = 0;
                                                                $search = array();
                                                                $replace = array();
                                                                // check wheateher match our keywords                                                                           
                                                                for ( $i = 0; $i < count( $data ); $i++ ) {
                                                                                // We need to know because boundaries \b works  just on word character
                                                                                // Populate arrays for the keywords replacements
                                                                                if ( preg_match( "/<p[^>]*>(.*?)" . $data[ $i ][ 'word' ] . "(.*?)<\/p>/", $content ) //just part of a paragraph
                                                                                                ) {
                                                                                                if ( !preg_match( "/<\\s*(img)[^>]*" . $data[ $i ][ 'word' ] . "/", $content ) //not part of an image
                                                                                                                
                                                                                                //not part of a link
                                                                                                                && !preg_match( "/<\\s*a[^<]*" . $data[ $i ][ 'word' ] . "[^<]*(<\\/a>)/", $content ) ) {
                                                                                                                $search[ ]  = '/\b' . $data[ $i ][ 'word' ] . '\b/'; // \b ensure an exact match - no substring accepted
                                                                                                                //$search[] = '/\b'. $keyword_case .  substr( $data[$i]['word'] , 1 ) .'\b/' ; // \b ensure an exact match - no substring accepted                  
                                                                                                                $replace[ ] = ' <a rel="nofollow" target="_blank" class="bdotcom_ttl_links" title="' . htmlentities( $data[ $i ][ 'title' ] ) . '" href="' . $data[ $i ][ 'link' ] . '?aid=' . $affiliate_id . ';label=wp-text2link-widget-' . $language . '-' . $affiliate_id . '">' . htmlentities( $data[ $i ][ 'word' ] ) . '</a> ';
                                                                                                                $internal_counter++;
                                                                                                } //!preg_match( "/<\\s*(img)[^>]*" . $data[ $i ][ 'word' ] . "/", $content ) && !preg_match( "/<\\s*a[^<]*" . $data[ $i ][ 'word' ] . "[^<]*(<\\/a>)/", $content )
                                                                                } //preg_match( "/<p[^>]*>(.*?)" . $data[ $i ][ 'word' ] . "(.*?)<\/p>/", $content )
                                                                                //exit the loop if we have a maximum links per page and if links are more then this number
                                                                                if ( $max_links ) {
                                                                                                if ( $internal_counter == $max_links ) {
                                                                                                                break;
                                                                                                } //$internal_counter == $max_links
                                                                                } //$max_links
                                                                } //$paragraphs_content as $key => $paragraph_content                                                                                  
                                                                return bdotcom_ttl_word2links_replace( $search, $replace, $content, 1 ); // replace just first occurency
                                                                //return  $content;                                                                                                                                                                      
                                                } //$is_valid_json
                                                else {
                                                                return $content;
                                                }
                                } //( is_single() || is_page() ) && !is_page( $excluded_pages )
                                else {
                                                return $content;
                                }
                } //!empty( $content )
}
