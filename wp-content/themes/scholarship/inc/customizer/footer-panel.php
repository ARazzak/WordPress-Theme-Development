<?php
/**
 * Scholarship Theme Customizer panel for Footer Settings.
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

add_action( 'customize_register', 'scholarship_footer_panel_register' );

if( ! function_exists( 'scholarship_footer_panel_register' ) ):
function scholarship_footer_panel_register( $wp_customize ) {

	/**
	 * Footer Settings Panel on customizer
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_panel(
        'scholarship_footer_settings_panel', 
        	array(
        		'priority'       => 30,
            	'capability'     => 'edit_theme_options',
            	'theme_supports' => '',
            	'title'          => esc_html__( 'Footer Settings', 'scholarship' ),
            ) 
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Footer Widget Settings
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'footer_widget_section',
        array(
            'title'		=> esc_html__( 'Footer Widget Settings', 'scholarship' ),
            'panel'     => 'scholarship_footer_settings_panel',
            'priority'  => 5,
        )
    );

    /**
     * Switch option for footer widget area
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'footer_widget_option',
        array(
            'default' => 'show',
            'sanitize_callback' => 'scholarship_sanitize_switch_option',
            )
    );
    $wp_customize->add_control( new Scholarship_Customize_Switch_Control(
        $wp_customize, 
            'footer_widget_option', 
            array(
                'type' 		=> 'switch',
                'label' 	=> esc_html__( 'Footer Widget Option', 'scholarship' ),
                'description' 	=> esc_html__( 'Show/hide option for widget area located in footer section.', 'scholarship' ),
                'section' 	=> 'footer_widget_section',
                'choices'   => array(
                    'show' 	=> esc_html__( 'Show', 'scholarship' ),
                    'hide' 	=> esc_html__( 'Hide', 'scholarship' )
                    ),
                'priority'  => 5,
            )
        )
    );

    /**
     * Field for Image Radio
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'footer_widget_layout',
        array(
            'default'           => 'column_three',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_control( new Scholarship_Customize_Control_Radio_Image(
        $wp_customize,
        'footer_widget_layout',
            array(
                'label'    => esc_html__( 'Footer Widget Layout', 'scholarship' ),
                'description' => esc_html__( 'Choose layout from available layouts', 'scholarship' ),
                'section'  => 'footer_widget_section',
                'choices'  => array(
	                    'column_four' => array(
	                        'label' => esc_html__( 'Columns Four', 'scholarship' ),
	                        'url'   => '%s/assets/images/footer-4.png'
	                    ),
	                    'column_three' => array(
	                        'label' => esc_html__( 'Columns Three', 'scholarship' ),
	                        'url'   => '%s/assets/images/footer-3.png'
	                    ),
	                    'column_two' => array(
	                        'label' => esc_html__( 'Columns Two', 'scholarship' ),
	                        'url'   => '%s/assets/images/footer-2.png'
	                    ),
	                    'column_one' => array(
	                        'label' => esc_html__( 'Column One', 'scholarship' ),
	                        'url'   => '%s/assets/images/footer-1.png'
	                    )
	            ),
	            'priority' => 10
            )
        )
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
	
	/**
	 * Footer Settings
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'bottom_footer_section',
        array(
            'title'		=> esc_html__( 'Bottom Footer Settings', 'scholarship' ),
            'panel'     => 'scholarship_footer_settings_panel',
            'priority'  => 10,
        )
    );

    /**
     * Field for Archive read more button text
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_copyright_text', 
            array(
                'default' => esc_html__( 'Scholarship', 'scholarship' ),
                'sanitize_callback' => 'wp_kses_post',
                'transport' => 'postMessage'
	       	)
    );
    $wp_customize->add_control(
        'scholarship_copyright_text',
            array(
	            'type' => 'textarea',
	            'label' => esc_html__( 'Copyright Text', 'scholarship' ),
	            'section' => 'bottom_footer_section',
	            'priority' => 5
            )
    );

    /**
     * Radio button for footer menu/ social icons
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'mt_sub_footer_type',
        array(
            'default'           => 'social_icon',
            'sanitize_callback' => 'scholarship_sanitize_sub_footer_type',
        )
    );
    $wp_customize->add_control(
        'mt_sub_footer_type',
        array(
            'type'          => 'radio',
            'priority'      => 10,
            'label'         => __( 'Sub Footer Content', 'scholarship' ),
            'description'   => esc_html__( 'Choose content to display at sub footer right side.', 'scholarship' ),
            'section'       => 'bottom_footer_section',
            'choices' => array(
                'social_icon' => __( 'Social Icon', 'scholarship' ),
                'footer_nav'  => __( 'Footer Menu', 'scholarship' )
            ),
        )
    );

}// close function
endif;