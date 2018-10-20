<?php
/**
 * Scholarship Theme Customizer panel for Additional Settings.
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

add_action( 'customize_register', 'scholarship_additional_panel_register' );

if( ! function_exists( 'scholarship_additional_panel_register' ) ):
function scholarship_additional_panel_register( $wp_customize ) {

	/**
	 * Additional Settings Panel on customizer
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_panel(
        'scholarship_additional_settings_panel', 
        	array(
        		'priority'       => 25,
            	'capability'     => 'edit_theme_options',
            	'theme_supports' => '',
            	'title'          => esc_html__( 'Additional Settings', 'scholarship' ),
            ) 
    );
/*------------------------------------------------------------------------------------------------------------------------------------*/
	/**
	 * Social Icons Section
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_section(
        'social_icons_section',
        array(
            'title'		=> esc_html__( 'Social Icons', 'scholarship' ),
            'panel'     => 'scholarship_additional_settings_panel',
            'priority'  => 5,
        )
    );

    /**
     * Repeater field for social media icons
     *
     * @since 1.0.0
     */
    $wp_customize->add_setting(
        'social_media_icons',
        array(
            'sanitize_callback' => 'scholarship_sanitize_repeater',
            'default' => json_encode(array(
                array(
                    'social_icon_class' => 'fa fa-facebook-f',
                    'social_icon_url' => '',
                    )
            ))
        )
    );
    $wp_customize->add_control( new Scholarship_Repeater_Controler(
        $wp_customize, 
            'social_media_icons',
            array(
                'label'   => __( 'Social Media Icons', 'scholarship' ),
                'section' => 'social_icons_section',
                'settings' => 'social_media_icons',
                'priority' => 5,
                'scholarship_box_label' => __( 'Social Media Icon','scholarship' ),
                'scholarship_box_add_control' => __( 'Add Icon','scholarship' )
            ),
            array(
                'social_icon_class' => array(
                    'type'        => 'social_icon',
                    'label'       => __( 'Social Media Logo', 'scholarship' ),
                    'description' => __( 'Choose social media icon.', 'scholarship' )
                ),
                'social_icon_url' => array(
                    'type'        => 'url',
                    'label'       => __( 'Social Icon Url', 'scholarship' ),
                    'description' => __( 'Enter social media url.', 'scholarship' )
                )
            )
        ) 
    );

}// close function
endif;