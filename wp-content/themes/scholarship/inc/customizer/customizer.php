<?php
/**
 * Scholarship Theme Customizer.
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
function scholarship_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 
        'blogname', 
            array(
                'selector' => '.site-title a',
                'render_callback' => 'scholarship_customize_partial_blogname',
            )
    );

    $wp_customize->selective_refresh->add_partial( 
        'blogdescription', 
            array(
                'selector' => '.site-description',
                'render_callback' => 'scholarship_customize_partial_blogdescription',
            )
    );

    /**
     * Register custom section types.
     *
     * @since 1.0.5
     */
    $wp_customize->register_section_type( 'Scholarship_Customize_Section_Upsell' );

    /**
     * Register theme upsell sections.
     *
     * @since 1.0.5
     */
    $wp_customize->add_section( new Scholarship_Customize_Section_Upsell(
        $wp_customize,
            'theme_upsell',
            array(
                'title'    => esc_html__( 'Scholarship Pro', 'scholarship' ),
                'pro_text' => esc_html__( 'Buy Pro', 'scholarship' ),
                'pro_url'  => 'https://mysterythemes.com/wp-themes/scholarship-pro/',
                'priority'  => 1,
            )
        )
    );

}
add_action( 'customize_register', 'scholarship_customize_register' );

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function scholarship_customize_preview_js() {
	wp_enqueue_script( 'scholarship_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'scholarship_customize_preview_js' );

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue required scripts/styles for customizer panel
 */
function scholarship_customize_backend_scripts() {
    global $scholarship_version;

    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/library/font-awesome/css/font-awesome.min.css', array(), '4.6.3' );
    
    wp_enqueue_style( 'scholarship_admin_customizer_style', get_template_directory_uri() . '/assets/css/customizer-style.css', array(), esc_attr( $scholarship_version ) );
    
    wp_enqueue_script( 'scholarship_admin_customizer', get_template_directory_uri() . '/assets/js/customizer-control.js', array( 'jquery', 'customize-controls' ), '20160918', true );
}
add_action( 'customize_controls_enqueue_scripts', 'scholarship_customize_backend_scripts', 10 );

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Load section files
 */
require get_template_directory() . '/inc/customizer/general-panel.php';
require get_template_directory() . '/inc/customizer/header-panel.php';
require get_template_directory() . '/inc/customizer/frontpage-panel.php';
require get_template_directory() . '/inc/customizer/design-panel.php';
require get_template_directory() . '/inc/customizer/additional-panel.php';
require get_template_directory() . '/inc/customizer/footer-panel.php';
