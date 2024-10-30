<?php
/**
 * SETTINGS SECTION
 * ----------------------------------------------------------------------------
 */
// Fields input arrays 
function bdotcom_ttl_settings_fields_array( ) {
                $fields                                 = array( );
                // 'field name', 'input type',  'field label', 'field bonus expl.', 'input maxlenght', 'input size', 'required', 'which section belongs to?'
                $fields[ 'bdotcom_ttl_aid' ]            = array(
                                 'bdotcom_ttl_aid',
                                'text',
                                __( 'What Is Your affiliate ID', BDOTCOM_TTL_TEXT_DOMAIN ),
                                __( 'Your affiliate ID is a unique number that allows Booking.com to track commission. If you are not an affiliate yet, <a href="http://www.booking.com/affiliate-program/index.html" target="_blank">check our affiliate programme</a> and get an affiliate ID. It\'s easy and fast. Start earning money, <a href="https://secure.booking.com/affiliate-program/register.html" target="_blank">sign up now!</a>', BDOTCOM_TTL_TEXT_DOMAIN ),
                                7,
                                10,
                                0,
                                'main' 
                );
                $fields[ 'bdotcom_ttl_maximum_links' ]  = array(
                                 'bdotcom_ttl_maximum_links',
                                'text',
                                __( 'Maximum Links Per Page', BDOTCOM_TTL_TEXT_DOMAIN ),
                                '',
                                3,
                                3,
                                0,
                                'main' 
                );
                $fields[ 'bdotcom_ttl_excluded_pages' ] = array(
                                 'bdotcom_ttl_excluded_pages',
                                'text',
                                __( 'Exclude Pages/Posts ( exclude per ID ) using a comma (",") if multiple', BDOTCOM_TTL_TEXT_DOMAIN ),
                                '',
                                '',
                                '',
                                0,
                                'main' 
                );
                $fields[ 'bdotcom_ttl_tooltip' ]        = array(
                                 'bdotcom_ttl_tooltip',
                                'checkbox',
                                __( 'Tooltip', BDOTCOM_TTL_TEXT_DOMAIN ),
                                __( 'If checked a tooltip effect will be activated on each links created via the plugin ', BDOTCOM_TTL_TEXT_DOMAIN ),
                                '',
                                '',
                                0,
                                'main' 
                );
                
                $fields[ 'bdotcom_ttl_language' ] = array( 'bdotcom_ttl_language', 'select', __( 'Keywords language', BDOTCOM_TTL_TEXT_DOMAIN ) , '', '', '', 0, 'main' ) ;
                return $fields;
}
function bdotcom_ttl_retrieve_all_user_options( ) {
                // Retrieve all user options from DB
                $user_options = get_option( 'bdotcom_ttl_user_options' );
                return $user_options;
}
// Draw the option page - called in core
function bdotcom_ttl_option_page( ) {
                $output = ''; //initialize main output
?>
    <div class="wrap">   

        <h2><img src="<?php
                echo BDOTCOM_TTL_IMG_PLUGIN_DIR . '/booking_logotype_blue_150x25.png';
?>" /></h2>       
     
        <div id="bdotcom_ttl_wrap">
            <div id="bdotcom_ttl_left">
                <form action="options.php" method="post" id="bdotcom_ttl_form">
                    <?php
                settings_fields( 'bdotcom_ttl_settings' );
?>
                    <?php
                do_settings_sections( 'bdotcom_ttl' );
?>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php
                _e( 'Save Changes', BDOTCOM_TTL_TEXT_DOMAIN );
?>" />                   
                </p>
                </form>
            </div>  
            <div id="bdotcom_ttl_right_wrapper">
                <h2><?php
                _e( 'Check keywords list and links', BDOTCOM_TTL_TEXT_DOMAIN );
?></h2>
                <div id="bdotcom_ttl_destination_finder">
                    <?php
                _e( 'Quick destination finder', BDOTCOM_TTL_TEXT_DOMAIN );
?> : 
                    <div id="bdotcom_ttl_destination_wrapper">
                        <p><input type="text" id="bdotcom_ttl_destination" name="bdotcom_ttl_destination"/> <a href="#" id="bdotcom_ttl_right_opener"><?php
                _e( 'Or see full list', BDOTCOM_TTL_TEXT_DOMAIN );
?></a></p>
                        <div id="bdotcom_ttl_destination_popup_wrapper">
                            <span class="bdotcom_ttl_arrow"></span>
                            <div id="bdotcom_ttl_destination_popup"></div>
                        </div>
                    </div>                    
                </div>
                
                   <div id="bdotcom_ttl_right">
                       <hr>

                    <?php
                @include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_json_data_path.php';
                 @include BDOTCOM_TTL_INC_PLUGIN_DIR . '/bdotcom_ttl_user_options.php';
                if ( $is_valid_json ) {
                                $data = bdotcom_ttl_json_encode_decode( $data );
                                $output .= '<table class="bdotcom_ttl_column first">';
                                $output .= '<th>Keywords</th>';
                                $output .= '<th>Links</th>';
                                for ( $i = 0; $i < count( $data ); $i++ ) {
                                                $output .= '<tr>';
                                                $output .= '<td>' . $data[ $i ][ 'word' ] . '</td>';
                                                $output .= '<td>' . $data[ $i ][ 'link' ] . '?aid=' . $affiliate_id .  '</td>';
                                                $output .= '</tr>';
                                } //$i = 0; $i < count( $data ); $i++
                                $output .= '</table>';
                } // if(  $is_valid_json )
                else {
                                echo __( 'Sorry, no valid data found on servers', BDOTCOM_TTL_TEXT_DOMAIN );
                }
                echo $output;
?>
            </div>
            
            </div>
            <div class="bdotcom_ttl_clear"></div>
         </div>
    </div>
    <?php
}
// Register and define the settings
add_action( 'admin_init', 'bdotcom_ttl_admin_init' );
function bdotcom_ttl_admin_init( ) {
                register_setting( 'bdotcom_ttl_settings', 'bdotcom_ttl_user_options', 'bdotcom_ttl_validate_options' );
                add_settings_section( //Main settings 
                                'bdotcom_ttl_main', //id
                                __( 'Main settings', BDOTCOM_TTL_TEXT_DOMAIN ), //title
                                'bdotcom_ttl_section_main', //callback
                                'bdotcom_ttl' //page
                                );
                $arrayFields = bdotcom_ttl_settings_fields_array();
                foreach ( $arrayFields as $field ) {
                                add_settings_field( $field[ 0 ], //id
                                                __( $field[ 2 ], BDOTCOM_TTL_TEXT_DOMAIN ), //title
                                                'bdotcom_ttl_settings_field', //callback
                                                'bdotcom_ttl', //page
                                                'bdotcom_ttl_' . $field[ 7 ], //section
                                                $args = array(
                                                $field[ 0 ],
                                                $field[ 1 ],
                                                $field[ 3 ],
                                                $field[ 4 ],
                                                $field[ 5 ]
                                ) //args
                                                );
                } //$arrayFields as $field
}
// Draw section header
function bdotcom_ttl_section_main( ) {
                echo '<p><em>' . __( 'Use these settings to customise your Text2Links plugin.', BDOTCOM_TTL_TEXT_DOMAIN ) . '</em></p>';
}
// Display and fill general fields
function bdotcom_ttl_settings_field( $args ) {
                // get options value from the database        
                $options      = bdotcom_ttl_retrieve_all_user_options();
                $fields_array = $args[ 0 ];
                $fields_value = '';
                if ( !empty( $options[ $fields_array ] ) ) {
                                $fields_value = $options[ $fields_array ]; // if user eneterd values fields_value
                } //!empty( $options[ $fields_array ] )
                $output = '';
                // echo the fields
                if ( $args[ 1 ] == 'text' ) {
                                $output .= '<input name="bdotcom_ttl_user_options[' . $fields_array . ']" id="' . $args[ 0 ] . '" type="' . $args[ 1 ] . '" ';
                                if ( !empty( $args[ 3 ] ) ) {
                                                $output .= ' maxlength="' . $args[ 3 ] . '" ';
                                } //!empty( $args[ 3 ] )
                                if ( !empty( $args[ 4 ] ) ) {
                                                $output .= ' size="' . $args[ 4 ] . '" ';
                                } //!empty( $args[ 4 ] )
                                // If default plugin values empty show default values  ( but for aid as we do not want the default aid is shown on the input field )
                                if ( $args[ 0 ] == 'bdotcom_ttl_aid' && ( $fields_value == BDOTCOM_TTL_DEFAULT_AID || empty( $fields_value ) || $fields_value == '' || $fields_value == ' ' || !is_numeric( $fields_value ) ) ) {
                                                $fields_value = '';
                                                $output .= 'placeholder="' . __( 'e.g.', BDOTCOM_TTL_TEXT_DOMAIN ) . ' ' . BDOTCOM_TTL_DEFAULT_AID . '"';
                                } //$args[ 0 ] == 'bdotcom_ttl_aid' && ( $fields_value == BDOTCOM_TTL_DEFAULT_AID || empty( $fields_value ) || $fields_value == '' || $fields_value == ' ' || !is_numeric( $fields_value ) )
                                if ( $args[ 0 ] == 'bdotcom_ttl_excluded_pages' && ( $fields_value == '' || $fields_value == ' ' ) ) {
                                                $fields_value = '';
                                                $output .= 'placeholder="' . __( 'e.g. 23,25,28 ', BDOTCOM_TTL_TEXT_DOMAIN ) . '"';
                                } //$args[ 0 ] == 'bdotcom_ttl_excluded_pages' && ( $fields_value == '' || $fields_value == ' ' )
                                $output .= 'value="' . $fields_value . '" />&nbsp;' . __( $args[ 2 ], BDOTCOM_TTL_TEXT_DOMAIN );
                } // $args[ 1 ] == 'text'
                elseif ( $args[ 1 ] == 'checkbox' ) {
                                if ( $args[ 0 ] == 'bdotcom_ttl_tooltip' ) {
                                                if ( empty( $fields_value ) ) {
                                                                $fields_value = BDOTCOM_TTL_DEFAULT_TOOLTIP;
                                                } //empty( $fields_value )
                                } //$args[ 0 ] == 'bdotcom_ttl_tooltip'
                                $output .= '<input name="bdotcom_ttl_user_options[' . $fields_array . ']" id="' . $args[ 0 ] . '" type="' . $args[ 1 ] . '"  ' . checked( 'checked', $fields_value, false ) . ' />';
                } //$args[ 1 ] == 'checkbox'
                                elseif ( $args[ 1 ] == 'radio' ) {
                } // $args[ 1 ] == 'radio'      
                                elseif ( $args[ 1 ] == 'select' ) {
                                             if( $args[ 0 ] == 'bdotcom_ttl_language' ) {                                   
                                                    $output .= '<select name="bdotcom_ttl_user_options[' . $fields_array . ']  id="' . $args[ 0 ] . '">' ; 
                                                    //$output .= '<option value="select" ' . selected( 'select', $fields_value, false ) . '>' . __( 'Let the browser choose...' , BDOTCOM_TTL_TEXT_DOMAIN) . '</option>' ;                 
                                                    $output .= '<option value="en-gb" ' . selected( 'en-gb', $fields_value, false ) . '>English (UK)</option>' ;
                                                    $output .= '<option value="en-us" ' . selected( 'en-us', $fields_value, false ) . '>English (US)</option>' ;
                                                    $output .= '<option value="de" ' . selected( 'de', $fields_value, false ) . '>Deutsch</option>' ;
                                                    $output .= '<option value="nl" ' . selected( 'nl', $fields_value, false ) . '>Nederlands</option>' ;
                                                    $output .= '<option value="fr" ' . selected( 'fr', $fields_value, false ) . '>Français</option>' ;
                                                    $output .= '<option value="es" ' . selected( 'es', $fields_value, false ) . '>Español</option>' ;
                                                    $output .= '<option value="ca" ' . selected( 'ca', $fields_value, false ) . '>Català</option>' ;
                                                    $output .= '<option value="it" ' . selected( 'it', $fields_value, false ) . '>Italiano</option>' ;
                                                    $output .= '<option value="pt-pt" ' . selected( 'pt-pt', $fields_value, false ) . '>Português (PT)</option>' ;
                                                    $output .= '<option value="pt-br" ' . selected( 'pt-br', $fields_value, false ) . '>Português (BR)</option>' ;
                                                    $output .= '<option value="no" ' . selected( 'no', $fields_value, false ) . '>Norsk</option>' ;
                                                    $output .= '<option value="fi" ' . selected( 'fi', $fields_value, false ) . '>Suomi</option>' ;
                                                    $output .= '<option value="sv" ' . selected( 'sv', $fields_value, false ) . '>Svenska</option>' ;
                                                    $output .= '<option value="da" ' . selected( 'da', $fields_value, false ) . '>Dansk</option>' ;
                                                    $output .= '<option value="cs" ' . selected( 'cs', $fields_value, false ) . '>Čeština</option>' ;
                                                    $output .= '<option value="hu" ' . selected( 'hu', $fields_value, false ) . '>Magyar</option>' ;
                                                    $output .= '<option value="ro" ' . selected( 'ro', $fields_value, false ) . '>Română</option>' ;
                                                    //$output .= '<option value="ja" ' . selected( 'ja', $fields_value, false ) . '>日本語</option>' ;
                                                    //$output .= '<option value="zh-cn" ' . selected( 'zh-cn', $fields_value, false ) . '>简体中文</option>' ;
                                                    //$output .= '<option value="zh-tw" ' . selected( 'zh-tw', $fields_value, false ) . '>繁體中文</option>' ;
                                                    $output .= '<option value="pl" ' . selected( 'pl', $fields_value, false ) . '>Polski</option>' ;
                                                    //$output .= '<option value="el" ' . selected( 'el', $fields_value, false ) . '>Ελληνικά</option>' ;
                                                    //$output .= '<option value="ru" ' . selected( 'ru', $fields_value, false ) . '>Русский</option>' ;
                                                    $output .= '<option value="tr" ' . selected( 'tr', $fields_value, false ) . '>Türkçe</option>' ;
                                                    //$output .= '<option value="bg" ' . selected( 'bg', $fields_value, false ) . '>Български</option>' ;
                                                    //$output .= '<option value="ar" ' . selected( 'ar', $fields_value, false ) . '>عربي</option>' ;
                                                    //$output .= '<option value="ko" ' . selected( 'ko', $fields_value, false ) . '>한국어</option>' ;
                                                    //$output .= '<option value="he" ' . selected( 'he', $fields_value, false ) . '>עברית</option>' ;
                                                    $output .= '<option value="lv" ' . selected( 'lv', $fields_value, false ) . '>Latviski</option>' ;
                                                    //$output .= '<option value="uk" ' . selected( 'uk', $fields_value, false ) . '>Українська</option>' ;
                                                    $output .= '<option value="id" ' . selected( 'id', $fields_value, false ) . '>Bahasa Indonesia</option>' ;
                                                    $output .= '<option value="ms" ' . selected( 'ms', $fields_value, false ) . '>Bahasa Malaysia</option>' ;
                                                    //$output .= '<option value="th" ' . selected( 'th', $fields_value, false ) . '>ภาษาไทย</option>' ;
                                                    $output .= '<option value="et" ' . selected( 'et', $fields_value, false ) . '>Eesti</option>' ;
                                                    $output .= '<option value="hr" ' . selected( 'hr', $fields_value, false ) . '>Hrvatski</option>' ;
                                                    $output .= '<option value="lt" ' . selected( 'lt', $fields_value, false ) . '>Lietuvių</option>' ;
                                                    $output .= '<option value="sk" ' . selected( 'sk', $fields_value, false ) . '>Slovenčina</option>' ;
                                                    $output .= '<option value="sr" ' . selected( 'sr', $fields_value, false ) . '>Srpski</option>' ;
                                                    $output .= '<option value="sl" ' . selected( 'sl', $fields_value, false ) . '>Slovenščina</option>' ;
                                                    $output .= '<option value="vi" ' . selected( 'vi', $fields_value, false ) . '>Tiếng Việt</option>' ;
                                                    $output .= '<option value="tl" ' . selected( 'tl', $fields_value, false ) . '>Filipino</option>' ;
                                                    $output .= '<option value="is" ' . selected( 'is', $fields_value, false ) . '>Íslenska</option>' ;  
                                                    $output .= '</select>  &nbsp;' . __( $args[ 2 ], BDOTCOM_TTL_TEXT_DOMAIN ) ; 
    
                }  //  if( $args[ 0 ] == 'bdotcom_ttl_language' ) 
                } // $args[ 1 ] == 'select'       
                echo $output;
}
// Validate user inputs 
function bdotcom_ttl_validate_options( $input ) {
                $valid       = array( );
                $message     = array( );
                $error       = false;
                $arrayFields = bdotcom_ttl_settings_fields_array();
                foreach ( $arrayFields as $field ) {
                                if ( $field[ 1 ] == 'text' ) {
                                                if ( $field[ 0 ] == 'bdotcom_ttl_aid' ) {
                                                                $valid[ $field[ 0 ] ] = $input[ $field[ 0 ] ];
                                                                if ( !empty( $input[ $field[ 0 ] ] ) && $input[ $field[ 0 ] ] != '' && !is_numeric( $input[ $field[ 0 ] ] ) ) {
                                                                                $error      = true;
                                                                                $message[ ] = '"' . $field[ 2 ] . '": ' . __( 'needs to be an integer', BDOTCOM_TTL_TEXT_DOMAIN ) . '<br>';
                                                                } //!empty( $input[ $field[ 0 ] ] ) && $input[ $field[ 0 ] ] != '' && !is_numeric( $input[ $field[ 0 ] ] )
                                                                else if ( !empty( $input[ $field[ 0 ] ] ) && is_numeric( $input[ $field[ 0 ] ] ) ) {
                                                                                $input[ $field[ 0 ] ] = strval( $input[ $field[ 0 ] ] );
                                                                                if ( $input[ $field[ 0 ] ][ 0 ] == '4' || $input[ $field[ 0 ] ][ 0 ] == '5'  ) { // check first number of the converted value into a string 
                                                                                                $error                = true;
                                                                                                $valid[ $field[ 0 ] ] = '';
                                                                                                $message[ ]           = '"' . $field[ 2 ] . '": ' . __( 'affiliate ID is different from partner ID: should start with a 3, an 8 or a 9. Please change it.', BDOTCOM_TTL_TEXT_DOMAIN ) . '<br>';
                                                                                } //$input[ $field[ 0 ] ][ 0 ] == '4'  || $input[ $field[ 0 ] ][ 0 ] == '5'
                                                                } //!empty( $input[ $field[ 0 ] ] ) && is_numeric( $input[ $field[ 0 ] ] )
                                                } //$field[ 0 ] == 'bdotcom_ttl_aid'
                                                else if ( $field[ 0 ] == 'bdotcom_ttl_maximum_links' ) {
                                                                $valid[ $field[ 0 ] ] = $input[ $field[ 0 ] ];
                                                                if ( !empty( $input[ $field[ 0 ] ] ) && $input[ $field[ 0 ] ] != '' && !is_numeric( $input[ $field[ 0 ] ] ) ) {
                                                                                $error                = true;
                                                                                $valid[ $field[ 0 ] ] = '';
                                                                                $message[ ]           = '"' . $field[ 2 ] . '": ' . __( 'needs to be an integer', BDOTCOM_TTL_TEXT_DOMAIN ) . '<br>';
                                                                } //!empty( $input[ $field[ 0 ] ] ) && $input[ $field[ 0 ] ] != '' && !is_numeric( $input[ $field[ 0 ] ] )
                                                } //$field[ 0 ] == 'bdotcom_ttl_maximum_links'
                                                else if ( $field[ 0 ] == 'bdotcom_ttl_excluded_pages' ) {
                                                                $valid[ $field[ 0 ] ] = $input[ $field[ 0 ] ];
                                                                if ( !empty( $input[ $field[ 0 ] ] ) && !preg_match_all( "/\\d+,*/", $input[ $field[ 0 ] ] ) ) {
                                                                    // valid only if numbers and if multiple split by commas
                                                                                $error = true;
                                                                                $valid[ $field[ 0 ] ] = '';
                                                                                $message[ ] = '"' . $field[ 2 ] . '": ' . __( 'use page/post id separated by commas if multiple', BDOTCOM_TTL_TEXT_DOMAIN ) . '<br>';
                                                                } //!empty( $input[ $field[ 0 ] ] ) && $input[ $field[ 0 ] ] != '' && !is_numeric( $input[ $field[ 0 ] ] )
                                                } //$field[ 0 ] == 'bdotcom_ttl_excluded_pages'
                                                else {
                                                                $valid[ $field[ 0 ] ] = sanitize_text_field( $input[ $field[ 0 ] ] ); //sanitize and escape malicius input
                                                                if ( $valid[ trim( $field[ 0 ] ) ] != trim( $input[ $field[ 0 ] ] ) ) {
                                                                                $error      = true;
                                                                                $message[ ] = '"' . $field[ 2 ] . '": ' . __( 'Missing or incorrect information', BDOTCOM_TTL_TEXT_DOMAIN ) . '<br>';
                                                                } //$valid[ trim( $field[ 0 ] ) ] != trim( $input[ $field[ 0 ] ] )
                                                }
                                } //if ( $field[ 1 ] == 'text' )
                                elseif ( $field[ 1 ] == 'checkbox' ) {
                                                if ( $field[ 0 ] == 'bdotcom_ttl_tooltip' ) {
                                                                $valid[ $field[ 0 ] ] = empty( $input[ $field[ 0 ] ] ) ? 'unchecked' : 'checked';
                                                } //if ( $field[ 0 ] == 'calendar' )            
                                } //$field[ 1 ] == 'checkbox'
                                
                                elseif( $field[ 1 ] == 'select' ) {
                                                if ( $field[ 0 ] == 'bdotcom_ttl_language' ) {
                                                                $valid[ $field[ 0 ] ] = $input[ $field[ 0 ] ]  ;
                                                } // if ( $field[ 0 ] == 'bdotcom_ttl_language' )  
                                }
                } //foreach( $arrayFields as $field)
                if ( $error ) {
                                add_settings_error( 'bdotcom_ttl_user_options', //setting
                                                'bdotcom_ttl_texterror', //code added to tag #id            
                                                implode( '', $message ), 'error' );
                } //$error
                return $valid;
}
?>