<?php
/**
 * Theme Customizer for FrontPage Settings Panel.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

add_action( 'customize_register', 'scholarship_frontpage_panel_register' );

if( ! function_exists( 'scholarship_frontpage_panel_register' ) ):
function scholarship_frontpage_panel_register( $wp_customize ) {

	/**
	 * Frontpage Settings Panel on customizer
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_panel(
        'scholarship_frontpage_settings_panel',
        	array(
        		'priority'       => 15,
            	'capability'     => 'edit_theme_options',
            	'theme_supports' => '',
            	'title'          => esc_html__( 'FrontPage Settings', 'scholarship' ),
            ) 
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     * Slider section
     *
     * @since 1.0.0
     */
    $wp_customize->add_section(
        'scholarship_slider_section',
        array(
            'title'     => __( 'Slider Settings', 'scholarship' ),
            'panel'     => 'scholarship_frontpage_settings_panel',
            'priority'  => 5
        )
    );

    /** 
     * Slider Category
     * 
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_slider_category',
        array(
            'default' => '0',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control( new Scholarship_Customize_Category_Control(
        $wp_customize,
        'scholarship_slider_category',
        array(
            'label' 		=> __( 'Slider Category', 'scholarship' ),
            'description' 	=> __( 'Select category slider for only in homepage.', 'scholarship' ),
            'section' 		=> 'scholarship_slider_section',
            'priority' 		=> 5
            )
        )
    );
}// close function
endif;