<?php
/**
 * Widget to show the content of Call To Action
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */
add_action( 'widgets_init', 'scholarship_register_call_to_action_widget' );

function scholarship_register_call_to_action_widget() {
    register_widget( 'Scholarship_Call_To_Action' );
}

class Scholarship_Call_To_Action extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'scholarship_call_to_action',
            'description' => __( 'Display content as Call To Action.', 'scholarship' )
        );
        parent::__construct( 'scholarship_call_to_action', __( 'Scholarship: Call To Action', 'scholarship' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'section_bg_image' => array(
                'scholarship_widgets_name' => 'section_bg_image',
                'scholarship_widgets_title' => __( 'Section Background Image', 'scholarship' ),
                'scholarship_widgets_field_type' => 'upload',
            ),

            'section_content' => array(
                'scholarship_widgets_name'         => 'section_content',
                'scholarship_widgets_title'        => __( 'Section Content', 'scholarship' ),
                'scholarship_widgets_row'          => 5,
                'scholarship_widgets_field_type'   => 'textarea'
            ),

            'section_btn_text' => array(
                'scholarship_widgets_name'         => 'section_btn_text',
                'scholarship_widgets_title'        => __( 'Section Button Text', 'scholarship' ),
                'scholarship_widgets_field_type'   => 'text'
            ),

            'section_btn_url' => array(
                'scholarship_widgets_name'         => 'section_btn_url',
                'scholarship_widgets_title'        => __( 'Section Button Url', 'scholarship' ),
                'scholarship_widgets_field_type'   => 'url'
            ),
        );
        return $fields;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        if( empty( $instance ) ) {
            return ;
        }

        $scholarship_section_bg_image   = empty( $instance['section_bg_image'] ) ? '' : $instance['section_bg_image'];
        $scholarship_section_content    = empty( $instance['section_content'] ) ? '' : $instance['section_content'];
        $scholarship_section_btn_text   = empty( $instance['section_btn_text'] ) ? '' : $instance['section_btn_text'];
        $scholarship_section_btn_url    = empty( $instance['section_btn_url'] ) ? '' : $instance['section_btn_url'];

        echo $before_widget;
    ?>
            <div class="section-wrapper scholarship-widget-wrapper" style="background-image:url('<?php echo esc_url( $scholarship_section_bg_image ); ?>'); background-position: center; background-attachment: fixed; background-size: cover;">
                <div class="mt-container">
                    <div class="cta-content-wrapper">
                        <div class="cta-content"><?php echo esc_html( $scholarship_section_content ); ?></div>
                        <?php if( !empty( $scholarship_section_btn_text ) ) { ?>
                            <div class="cta-btn-wrap">
                                <a href="<?php echo esc_url( $scholarship_section_btn_url ); ?>"><?php echo esc_html( $scholarship_section_btn_text ); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div><!-- .mt-container -->
            </div><!-- .section-wrapper -->
    <?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param   array   $new_instance   Values just sent to be saved.
     * @param   array   $old_instance   Previously saved values from database.
     *
     * @uses    scholarship_widgets_updated_field_value()      defined in scholarship-widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            extract( $widget_field );

            // Use helper function to get updated field values
            $instance[$scholarship_widgets_name] = scholarship_widgets_updated_field_value( $widget_field, $new_instance[$scholarship_widgets_name] );
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param   array $instance Previously saved values from database.
     *
     * @uses    scholarship_widgets_show_widget_field()        defined in scholarship-widget-fields.php
     */
    public function form( $instance ) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ( $widget_fields as $widget_field ) {

            // Make array elements available as variables
            extract( $widget_field );
            $scholarship_widgets_field_value = !empty( $instance[$scholarship_widgets_name] ) ? wp_kses_post( $instance[$scholarship_widgets_name] ) : '';
            scholarship_widgets_show_widget_field( $this, $widget_field, $scholarship_widgets_field_value );
        }
    }

}