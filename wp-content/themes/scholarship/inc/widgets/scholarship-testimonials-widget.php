<?php
/**
 * Widget for grid layout which is suitable for services/features and teams.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */
add_action( 'widgets_init', 'scholarship_register_testimonials_widget' );

function scholarship_register_testimonials_widget() {
    register_widget( 'Scholarship_Testimonials' );
}

class Scholarship_Testimonials extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'scholarship_testimonials',
            'description' => __( 'Display posts from selected category as testimonials layout.', 'scholarship' )
        );
        parent::__construct( 'scholarship_testimonials', __( 'Scholarship: Testimonials', 'scholarship' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
        $fields = array(

            'section_title' => array(
                'scholarship_widgets_name'         => 'section_title',
                'scholarship_widgets_title'        => __( 'Section Title', 'scholarship' ),
                'scholarship_widgets_field_type'   => 'text'
            ),

            'section_info' => array(
                'scholarship_widgets_name'         => 'section_info',
                'scholarship_widgets_title'        => __( 'Section Info', 'scholarship' ),
                'scholarship_widgets_row'          => 5,
                'scholarship_widgets_field_type'   => 'textarea'
            ),

            'section_bg_image' => array(
                'scholarship_widgets_name' => 'section_bg_image',
                'scholarship_widgets_title' => __( 'Section Background Image', 'scholarship' ),
                'scholarship_widgets_field_type' => 'upload',
            ),

            'section_cat_slug' => array(
                'scholarship_widgets_name'         => 'section_cat_slug',
                'scholarship_widgets_title'        => __( 'Section Category', 'scholarship' ),
                'scholarship_widgets_default'      => '',
                'scholarship_widgets_field_type'   => 'category_dropdown'
            )
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

        $scholarship_section_title      = empty( $instance['section_title'] ) ? '' : $instance['section_title'];
        $scholarship_section_info       = empty( $instance['section_info'] ) ? '' : $instance['section_info'];
        $scholarship_section_bg_image   = empty( $instance['section_bg_image'] ) ? '' : $instance['section_bg_image'];
        $scholarship_section_cat_slug   = empty( $instance['section_cat_slug'] ) ? '' : $instance['section_cat_slug'];

        if( empty( $scholarship_section_cat_slug ) ) {
            return ;
        }

        if( !empty( $scholarship_section_title ) || !empty( $scholarship_section_info ) ) {
            $sec_title_class = 'has-title';
        } else {
            $sec_title_class = 'no-title';
        }

        $testimonials_args = array(
                        'post_type'      => 'post',
                        'category_name'  => esc_attr( $scholarship_section_cat_slug ),
                        'posts_per_page' => -1
                    );
        $testimonials_query = new WP_Query( $testimonials_args );
        echo $before_widget;
    ?>
            <div class="section-wrapper scholarship-widget-wrapper" style="background-image:url('<?php echo esc_url( $scholarship_section_bg_image ); ?>'); background-position: center; background-attachment: fixed; background-size: cover;">
                <div class="mt-container">
                    <div class="section-title-wrapper <?php echo esc_attr( $sec_title_class ); ?> clearfix">
                        <?php
                            if( !empty( $scholarship_section_title ) ) {
                                echo $before_title . esc_html( $scholarship_section_title ) . $after_title;
                            }

                            if( !empty( $scholarship_section_info ) ) {
                                echo '<span class="section-info">'. esc_html( $scholarship_section_info ) .'</span>';
                            }
                        ?>
                    </div><!-- .section-title-wrapper -->

                    <div class="section-items-wrapper">
                        <?php
                            if( $testimonials_query->have_posts() ) {
                                echo '<ul class="testimonialsSlider">';
                                while( $testimonials_query->have_posts() ) {
                                    $testimonials_query->the_post();
                                    $image_id = get_post_thumbnail_id();
                                    $client_position = get_post( $image_id )->post_excerpt;
                        ?>
                                    <li>
                                        <div class="single-post-wrapper">
                                            <div class="testimonial-content"><?php the_content(); ?></div>
                                            <div class="testimonial-img-name-wrap clearfix">
                                                <?php if( has_post_thumbnail() ) { ?>
                                                    <div class="img-holder">
                                                        <?php the_post_thumbnail( 'medium' ); ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="testimonial-name-wrap">
                                                    <h3 class="client-name"><?php the_title(); ?></h3>
                                                    <span class="client-position"><?php echo esc_html( $client_position ); ?></span>
                                                </div>
                                            </div> <!-- testimonial-img-name-wrap -->
                                        </div><!-- .single-post-wrapper -->
                                    </li>
                        <?php
                                }
                                echo '</ul>';
                            }
                        ?>
                    </div><!-- .grid-items-wrapper -->
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