<?php
/**
 * File to sanitize customizer field
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

/**
 * Sanitize email
 *
 * @since 1.0.0
 */
function scholarship_sanitize_email( $input ) {
    return sanitize_email( $input );
}

/**
 * Sanitize checkbox
 *
 * @since 1.0.0
 */
function scholarship_sanitize_checkbox( $input ) {
    //returns true if checkbox is checked
    return ( ( isset( $input ) && true == $input ) ? true : false );
}

/**
 * Sanitize number
 *
 * @since 1.0.0
 */
function scholarship_sanitize_number( $input ) {
    $output = intval($input);
     return $output;
}

/**
 * Sanitize site layout
 *
 * @since 1.0.0
 */
function scholarship_sanitize_site_layout( $input ) {
    $valid_keys = array(
        'wide_layout'   => __( 'Wide Layout', 'scholarship' ),
        'boxed_layout'  => __( 'Boxed Layout', 'scholarship' )
        );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize archive page layout
 *
 * @since 1.0.0
 */
function scholarship_sanitize_archive_layout_option( $input ) {
    $valid_keys = array(
        'classic' => __( 'Classic Layout', 'scholarship' ),
        'grid' => __( 'Grid Layout', 'scholarship' )
        );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize switch button
 *
 * @since 1.0.0
 */
function scholarship_sanitize_switch_option( $input ) {
    $valid_keys = array(
            'show'  => esc_html__( 'Show', 'scholarship' ),
            'hide'  => esc_html__( 'Hide', 'scholarship' )
        );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize sub footer type
 *
 * @since 1.0.0
 */
function scholarship_sanitize_sub_footer_type( $input ) {
    $valid_keys = array(
            'social_icon' => __( 'Social Icon', 'scholarship' ),
            'footer_nav'  => __( 'Footer Menu', 'scholarship' )
        );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }
}

/**
 * Sanitize repeater value
 *
 * @since 1.0.0
 */
function scholarship_sanitize_repeater( $input ){
    $input_decoded = json_decode( $input, true );
        
    if( !empty( $input_decoded ) ) {
        foreach ( $input_decoded as $boxes => $box ){
            foreach ( $box as $key => $value ){
                $input_decoded[$boxes][$key] = wp_kses_post( $value );
            }
        }
        return json_encode( $input_decoded );
    }
    
    return $input;
}