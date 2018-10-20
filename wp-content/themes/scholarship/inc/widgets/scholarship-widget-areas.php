<?php
/**
 * File to be add or expand widget area and functions related to the Scholarship theme widget.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function scholarship_widgets_init() {
	
	/**
	 * Register Right Sidebar
	 *
	 * @since 1.0.0
	 */
	register_sidebar( array(
		'name'          => esc_html__( 'Right Sidebar', 'scholarship' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'scholarship' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	/**
	 * Register Left Sidebar
	 *
	 * @since 1.0.0
	 */
	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'scholarship' ),
		'id'            => 'scholarship_sidebar_left',
		'description'   => esc_html__( 'Add widgets here.', 'scholarship' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	/**
	 * Register Homepage Fullwidth area
	 *
	 * @since 1.0.0
	 */
	register_sidebar( array(
		'name'          => esc_html__( 'Homepage Section Area', 'scholarship' ),
		'id'            => 'scholarship_home_section_area',
		'description'   => esc_html__( 'Add widgets here.', 'scholarship' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	/**
	 * Register 4 different Footer Area 
	 *
	 * @since 1.0.0
	 */
	register_sidebars( 4 , array(
		'name'          => esc_html__( 'Footer Area %d', 'scholarship' ),
		'id'            => 'scholarship_footer_sidebar',
		'description'   => esc_html__( 'Added widgets are display at Footer Widget Area.', 'scholarship' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'scholarship_widgets_init' );