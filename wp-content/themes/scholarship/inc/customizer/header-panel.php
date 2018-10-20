<?php
/**
 * Scholarship Theme Customizer panel for header.
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

add_action( 'customize_register', 'scholarship_header_panel_register' );

if( ! function_exists( 'scholarship_header_panel_register' ) ):
function scholarship_header_panel_register( $wp_customize ) {

	//$wp_customize->remove_section( 'header_image' );

	/**
	 * Header Settings Panel on customizer
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_panel(
        'scholarship_header_settings_panel', 
        	array(
        		'priority'       => 10,
            	'capability'     => 'edit_theme_options',
            	'theme_supports' => '',
            	'title'          => esc_html__( 'Header Settings', 'scholarship' ),
            ) 
    );

/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Header Elements Section
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'header_elements_section',
        array(
            'title'		=> esc_html__( 'Header Elements', 'scholarship' ),
            'panel'     => 'scholarship_header_settings_panel',
            'priority'  => 5,
        )
    );

    /**
     * Field for Address
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'header_address', 
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
       	)
    );
    $wp_customize->add_control(
        'header_address',
        array(
            'type' => 'text',
            'label' => esc_html__( 'Header Address', 'scholarship' ),
            'section' => 'header_elements_section',
            'priority' => 5
        )
    );

    /**
     * Field for email
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'header_email', 
        array(
            'default' => '',
            'sanitize_callback' => 'scholarship_sanitize_email',
            'transport' => 'postMessage'
       	)
    );
    $wp_customize->add_control(
        'header_email',
        array(
            'type' => 'text',
            'label' => esc_html__( 'Header E-mail', 'scholarship' ),
            'section' => 'header_elements_section',
            'priority' => 10
        )
    );

    /**
     * Field for phone
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'header_phone', 
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
       	)
    );
    $wp_customize->add_control(
        'header_phone',
        array(
            'type' => 'text',
            'label' => esc_html__( 'Header Phone', 'scholarship' ),
            'section' => 'header_elements_section',
            'priority' => 15
        )
    );

    /**
     * Switch option for Top Header Section
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'top_social_option',
        array(
            'default' => 'show',
            'sanitize_callback' => 'scholarship_sanitize_switch_option',
            )
    );
    $wp_customize->add_control( new Scholarship_Customize_Switch_Control(
        $wp_customize, 
            'top_social_option', 
            array(
                'type' 		=> 'switch',
                'label' 	=> esc_html__( 'Top Social Icons', 'scholarship' ),
                'description' 	=> esc_html__( 'Show/hide option for Social Icons at top.', 'scholarship' ),
                'section' 	=> 'top_header_section',
                'choices'   => array(
                    'show' 	=> esc_html__( 'Show', 'scholarship' ),
                    'hide' 	=> esc_html__( 'Hide', 'scholarship' )
                    ),
                'priority'  => 20,
            )
        )
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Additional Header settings
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'additional_header_section',
        array(
            'title'		=> esc_html__( 'Additional Header Settings', 'scholarship' ),
            'panel'     => 'scholarship_header_settings_panel',
            'priority'  => 10,
        )
    );

    /**
     * Switch option for sticky menu
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'header_sticky_option',
        array(
            'default' => 'show',
            'sanitize_callback' => 'scholarship_sanitize_switch_option',
            )
    );
    $wp_customize->add_control( new Scholarship_Customize_Switch_Control(
        $wp_customize, 
            'header_sticky_option', 
            array(
                'type' 		=> 'switch',
                'label' 	=> esc_html__( 'Header Sticky', 'scholarship' ),
                'description' 	=> esc_html__( 'Enable/Disable header sticky option.', 'scholarship' ),
                'section' 	=> 'additional_header_section',
                'choices'   => array(
                    'show' 	=> esc_html__( 'Enable', 'scholarship' ),
                    'hide' 	=> esc_html__( 'Disable', 'scholarship' )
                    ),
                'priority'  => 5,
            )
        )
    );

    /**
     * Switch option for search icon at primary section
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'menu_search_option',
        array(
            'default' => 'show',
            'sanitize_callback' => 'scholarship_sanitize_switch_option',
            )
    );
    $wp_customize->add_control( new Scholarship_Customize_Switch_Control(
        $wp_customize, 
            'menu_search_option', 
            array(
                'type' 		=> 'switch',
                'label' 	=> esc_html__( 'Search Icon', 'scholarship' ),
                'description' 	=> esc_html__( 'show/hide search icon at primary menu section.', 'scholarship' ),
                'section' 	=> 'additional_header_section',
                'choices'   => array(
                    'show' 	=> esc_html__( 'Show', 'scholarship' ),
                    'hide' 	=> esc_html__( 'Hide', 'scholarship' )
                    ),
                'priority'  => 10,
            )
        )
    );

}// close function
endif;