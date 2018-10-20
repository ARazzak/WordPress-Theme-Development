<?php
/**
 * Theme Customizer for General Settings Panel.
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

add_action( 'customize_register', 'scholarship_general_panel_register' );

if( ! function_exists( 'scholarship_general_panel_register' ) ):
function scholarship_general_panel_register( $wp_customize ) {

	$wp_customize->get_section( 'title_tagline' )->panel = 'scholarship_general_settings_panel';
    $wp_customize->get_section( 'title_tagline' )->priority = '5';
    $wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Site Logo/Title/Favicon', 'scholarship' );
    $wp_customize->get_section( 'colors' )->panel = 'scholarship_general_settings_panel';
    $wp_customize->get_section( 'colors' )->priority = '10';
    $wp_customize->get_section( 'background_image' )->panel = 'scholarship_general_settings_panel';
    $wp_customize->get_section( 'background_image' )->priority = '15';
    $wp_customize->get_section( 'static_front_page' )->panel = 'scholarship_general_settings_panel';
    $wp_customize->get_section( 'static_front_page' )->priority = '20';


	/**
	 * General Settings Panel on customizer
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_panel(
        'scholarship_general_settings_panel', 
        	array(
        		'priority'       => 5,
            	'capability'     => 'edit_theme_options',
            	'theme_supports' => '',
            	'title'          => esc_html__( 'General Settings', 'scholarship' ),
            ) 
    );

/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Website Layout
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'website_layout_section',
        array(
            'title'		=> esc_html__( 'Website Layout', 'scholarship' ),
            'panel'     => 'scholarship_general_settings_panel',
            'priority'  => 35,
        )
    );

	/**
	 * Select options for website layout option
	 *
	 * @since 1.0.0
	 */
    $wp_customize->add_setting(
        'site_layout_option',
        array(
            'default'           => 'wide_layout',
            'sanitize_callback' => 'scholarship_sanitize_site_layout',
        )       
    );
    $wp_customize->add_control(
        'site_layout_option',
        array(
            'type' => 'select',
            'priority'    => 5,
            'label' => __( 'Site Layout', 'scholarship' ),
            'description' 	=> esc_html__( 'Select the website layout.', 'scholarship' ),
            'section' => 'website_layout_section',
            'choices' => array(
                'wide_layout' => __( 'Wide Layout', 'scholarship' ),
                'boxed_layout' => __( 'Boxed Layout', 'scholarship' )
            ),
        )
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     * Primary Theme Color
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_primary_theme_color',
        array(
            'default'           => '#004b8e',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'scholarship_primary_theme_color',
            array(
                'label'      => __( 'Primary Theme Color', 'scholarship' ),
                'section'    => 'colors',
                'priority'   => 10
            )
        )
    );

    /**
     * Secondary Theme Color
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_secondary_theme_color',
        array(
            'default'           => '#f2552c',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'scholarship_secondary_theme_color',
            array(
                'label'      => __( 'Secondary Theme Color', 'scholarship' ),
                'section'    => 'colors',
                'priority'   => 15
            )
        )
    );

    /**
     * Title Color
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_title_color',
        array(
            'default'     => '#004b8e',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
 
    $wp_customize->add_control( new WP_Customize_Color_Control(
            $wp_customize,
            'scholarship_title_color',
            array(
                'label'      => __( 'Header Text Color', 'scholarship' ),
                'section'    => 'colors',
                'priority' 	 => 20
            )
        )
    );

/*------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     * Title and tagline checkbox
     *
     * @since 1.0.5
     */
    $wp_customize->add_setting( 
        'scholarship_title_option', 
        array(
            'default' => true,
            'sanitize_callback' => 'scholarship_sanitize_checkbox'
        )
    );
    $wp_customize->add_control( 
        'scholarship_title_option', 
        array(
            'label' => esc_html__( 'Display Site Title and Tagline', 'scholarship' ),
            'section' => 'title_tagline',
            'type' => 'checkbox'
        )
    );

}// close function
endif;