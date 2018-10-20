<?php
/**
 * Scholarship Theme Customizer panel for Design Layout.
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

add_action( 'customize_register', 'scholarship_design_panel_register' );

if( ! function_exists( 'scholarship_design_panel_register' ) ):
function scholarship_design_panel_register( $wp_customize ) {

	// Register the radio image control class as a JS control type.
	$wp_customize->register_control_type( 'Scholarship_Customize_Control_Radio_Image' );

	/**
	 * Design Settings Panel on customizer
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_panel(
        'scholarship_design_settings_panel', 
        	array(
        		'priority'       => 20,
            	'capability'     => 'edit_theme_options',
            	'theme_supports' => '',
            	'title'          => esc_html__( 'Design Settings', 'scholarship' ),
            ) 
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Archive Settings
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'archive_settings_section',
        array(
            'title'		=> esc_html__( 'Archive Settings', 'scholarship' ),
            'panel'     => 'scholarship_design_settings_panel',
            'priority'  => 5,
        )
    );	    

    /**
     * Field for Archive Sidebar images
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_archive_sidebar',
        array(
            'default'           => 'right_sidebar',
            'sanitize_callback' => 'sanitize_key',
        )
    );
    $wp_customize->add_control( new Scholarship_Customize_Control_Radio_Image(
        $wp_customize,
        'scholarship_archive_sidebar',
            array(
                'label'    => esc_html__( 'Archive Sidebars', 'scholarship' ),
                'description' => esc_html__( 'Choose sidebar from available layouts', 'scholarship' ),
                'section'  => 'archive_settings_section',
                'choices'  => array(
	                    'left_sidebar' => array(
	                        'label' => esc_html__( 'Left Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/left-sidebar.png'
	                    ),
	                    'right_sidebar' => array(
	                        'label' => esc_html__( 'Right Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/right-sidebar.png'
	                    ),
	                    'no_sidebar' => array(
	                        'label' => esc_html__( 'No Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/no-sidebar.png'
	                    ),
	                    'no_sidebar_center' => array(
	                        'label' => esc_html__( 'No Sidebar Center', 'scholarship' ),
	                        'url'   => '%s/assets/images/no-sidebar-center.png'
	                    )
	            ),
	            'priority' => 5
            )
        )
    );

    /**
     * Radio button for archive layouts
     *
     * @since 1.0.0
     */
	$wp_customize->add_setting(
        'scholarship_archive_layout',
        array(
            'default'           => 'classic',
            'sanitize_callback' => 'scholarship_sanitize_archive_layout_option',
        )
    );
    $wp_customize->add_control(
        'scholarship_archive_layout',
        array(
            'type' 			=> 'radio',
            'priority'    	=> 10,
            'label' 		=> __( 'Archive Layout', 'scholarship' ),
            'description' 	=> esc_html__( 'Choose layout from available layouts.', 'scholarship' ),
            'section' 		=> 'archive_settings_section',
            'choices' => array(
                'classic' => __( 'Classic Layout', 'scholarship' ),
                'grid' => __( 'Grid Layout', 'scholarship' )
            ),
        )
    );

/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Page Settings
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'page_settings_section',
        array(
            'title'		=> esc_html__( 'Page Settings', 'scholarship' ),
            'panel'     => 'scholarship_design_settings_panel',
            'priority'  => 10,
        )
    );

    /**
     * Field for sidebar Image Radio
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_default_page_sidebar',
        array(
            'default'           => 'right_sidebar',
            'sanitize_callback' => 'sanitize_key',
        )
    );	    
    $wp_customize->add_control( new Scholarship_Customize_Control_Radio_Image(
        $wp_customize,
        'scholarship_default_page_sidebar',
            array(
                'label'    => esc_html__( 'Page Sidebars', 'scholarship' ),
                'description' => esc_html__( 'Choose sidebar from available layouts', 'scholarship' ),
                'section'  => 'page_settings_section',
                'choices'  => array(
	                    'left_sidebar' => array(
	                        'label' => esc_html__( 'Left Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/left-sidebar.png'
	                    ),
	                    'right_sidebar' => array(
	                        'label' => esc_html__( 'Right Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/right-sidebar.png'
	                    ),
	                    'no_sidebar' => array(
	                        'label' => esc_html__( 'No Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/no-sidebar.png'
	                    ),
	                    'no_sidebar_center' => array(
	                        'label' => esc_html__( 'No Sidebar Center', 'scholarship' ),
	                        'url'   => '%s/assets/images/no-sidebar-center.png'
	                    )
	            ),
	            'priority' => 5
            )
        )
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Post Settings
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'post_settings_section',
        array(
            'title'		=> esc_html__( 'Post Settings', 'scholarship' ),
            'panel'     => 'scholarship_design_settings_panel',
            'priority'  => 15,
        )
    );

    /**
     * Field for sidebar Image Radio
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'scholarship_default_post_sidebar',
        array(
            'default'           => 'right_sidebar',
            'sanitize_callback' => 'sanitize_key',
        )
    );	    
    $wp_customize->add_control( new Scholarship_Customize_Control_Radio_Image(
        $wp_customize,
        'scholarship_default_post_sidebar',
            array(
                'label'    => esc_html__( 'Post Sidebars', 'scholarship' ),
                'description' => esc_html__( 'Choose sidebar from available layouts', 'scholarship' ),
                'section'  => 'post_settings_section',
                'choices'  => array(
	                    'left_sidebar' => array(
	                        'label' => esc_html__( 'Left Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/left-sidebar.png'
	                    ),
	                    'right_sidebar' => array(
	                        'label' => esc_html__( 'Right Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/right-sidebar.png'
	                    ),
	                    'no_sidebar' => array(
	                        'label' => esc_html__( 'No Sidebar', 'scholarship' ),
	                        'url'   => '%s/assets/images/no-sidebar.png'
	                    ),
	                    'no_sidebar_center' => array(
	                        'label' => esc_html__( 'No Sidebar Center', 'scholarship' ),
	                        'url'   => '%s/assets/images/no-sidebar-center.png'
	                    )
	            ),
	            'priority' => 5
            )
        )
    );

}// close function
endif;