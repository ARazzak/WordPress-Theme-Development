<?php
/**
 * Widget for Team section.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */
add_action( 'widgets_init', 'scholarship_register_team_widget' );

function scholarship_register_team_widget() {
    register_widget( 'Scholarship_Team' );
}

class Scholarship_Team extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'scholarship_team',
            'description' => __( 'Display posts from selected category show as team layout.', 'scholarship' )
        );
        parent::__construct( 'scholarship_team', __( 'Scholarship: Team Member', 'scholarship' ), $widget_ops );
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

            'section_cat_slug' => array(
                'scholarship_widgets_name'         => 'section_cat_slug',
                'scholarship_widgets_title'        => __( 'Section Category', 'scholarship' ),
                'scholarship_widgets_default'      => '',
                'scholarship_widgets_field_type'   => 'category_dropdown'
            ),

            'section_post_count' => array(
                'scholarship_widgets_name'         => 'section_post_count',
                'scholarship_widgets_title'        => __( 'Section Post Count', 'scholarship' ),
                'scholarship_widgets_default'      => 4,
                'scholarship_widgets_field_type'   => 'number'
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

        $scholarship_section_title      = empty( $instance['section_title'] ) ? '' : $instance['section_title'];
        $scholarship_section_info       = empty( $instance['section_info'] ) ? '' : $instance['section_info'];
        $scholarship_section_cat_slug   = empty( $instance['section_cat_slug'] ) ? '' : $instance['section_cat_slug'];
        $scholarship_section_post_count = empty( $instance['section_post_count'] ) ? 3 : $instance['section_post_count'];

        if( empty( $scholarship_section_cat_slug ) ) {
            return ;
        }

        if( !empty( $scholarship_section_title ) || !empty( $scholarship_section_info ) ) {
            $sec_title_class = 'has-title';
        } else {
            $sec_title_class = 'no-title';
        }

        $scholarship_team_args = array(
                        'post_type'      => 'post',
                        'category_name'  => esc_attr( $scholarship_section_cat_slug ),
                        'posts_per_page' => absint( $scholarship_section_post_count )
                    );
        $scholarship_team_query = new WP_Query( $scholarship_team_args );
        echo $before_widget;
    ?>
            <div class="section-wrapper scholarship-widget-wrapper">
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
                    <div class="team-wrapper mt-column-wrapper">
                        <?php
                            if( $scholarship_team_query->have_posts() ) {
                                while( $scholarship_team_query->have_posts() ) {
                                    $scholarship_team_query->the_post();
                                    $image_id = get_post_thumbnail_id();
                                    $team_position = get_post( $image_id )->post_excerpt;
                        ?>
                                    <div class="single-post-wrapper mt-column-4">
                                        <?php if( has_post_thumbnail() ) { ?>
                                            <div class="img-holder">
                                                <?php the_post_thumbnail( 'scholarship-team-medium' ); ?>
                                                <div class="team-desc-wrapper">
                                                    <div class="team-desc">
                                                        <span>
                                                            <?php
                                                                the_excerpt();
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div><!-- .team-desc -->
                                            </div><!-- .img-holder -->
                                        <?php } ?>
                                        <div class="team-title-wrapper">
                                            <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <span class="team-position"><?php echo esc_html( $team_position ); ?></span>
                                        </div>
                                    </div><!-- .single-post-wrapper -->
                        <?php
                                }
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