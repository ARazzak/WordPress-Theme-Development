<?php
/**
 * Widget for Latest News Section
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */
add_action( 'widgets_init', 'scholarship_register_latest_blog_widget' );

function scholarship_register_latest_blog_widget() {
    register_widget( 'Scholarship_Latest_Blog' );
}

class Scholarship_Latest_Blog extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'scholarship_latest_blog',
            'description' => __( 'Display latest posts except from selected categories.', 'scholarship' )
        );
        parent::__construct( 'scholarship_latest_blog', __( 'Scholarship: Latest Blog', 'scholarship' ), $widget_ops );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {

        $scholarship_categories_lists = scholarship_categories_lists();
        
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

            'section_cat_slugs' => array(
                'scholarship_widgets_name'         => 'section_cat_slugs',
                'scholarship_widgets_title'        => __( 'Section Categories', 'scholarship' ),
                'scholarship_widgets_field_type'   => 'multicheckboxes',
                'scholarship_widgets_field_options' => $scholarship_categories_lists
            ),

            'section_post_count' => array(
                'scholarship_widgets_name'         => 'section_post_count',
                'scholarship_widgets_title'        => __( 'Section Post Count', 'scholarship' ),
                'scholarship_widgets_default'      => 3,
                'scholarship_widgets_field_type'   => 'number'
            ),

            'section_btn_text' => array(
                'scholarship_widgets_name'         => 'section_btn_text',
                'scholarship_widgets_title'        => __( 'Section button text', 'scholarship' ),
                'scholarship_widgets_field_type'   => 'text'
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
        $scholarship_section_cat_slugs  = empty( $instance['section_cat_slugs'] ) ? '' : $instance['section_cat_slugs'];
        $scholarship_section_post_count = empty( $instance['section_post_count'] ) ? 3 : $instance['section_post_count'];
        $scholarship_section_btn_text   = empty( $instance['section_btn_text'] ) ? __( 'Read More', 'scholarship' ) : $instance['section_btn_text'];


        if( !empty( $scholarship_section_title ) || !empty( $scholarship_section_info ) ) {
            $sec_title_class = 'has-title';
        } else {
            $sec_title_class = 'no-title';
        }

        echo $before_widget;
    ?>
        <div class="section-wrapper scholarship-widget-wrapper">
            <div class="mt-container">
                <div class="section-title-wrapper <?php echo esc_attr( $sec_title_class ); ?>">
                    <?php
                        if( !empty( $scholarship_section_title ) ) {
                            echo $before_title . esc_html( $scholarship_section_title ) . $after_title;
                        }

                        if( !empty( $scholarship_section_info ) ) {
                            echo '<span class="section-info">'. esc_html( $scholarship_section_info ) .'</span>';
                        }
                    ?>
                </div><!-- .section-title-wrapper -->
                <?php
                    if( !empty( $scholarship_section_cat_slugs ) ) {
                        $checked_cats = array();
                        foreach( $scholarship_section_cat_slugs as $cat_key => $cat_value ){
                            $checked_cats[] = $cat_key;
                        }
                        $get_checked_cat_slugs = implode( ",", $checked_cats );

                        $latest_blog_args = array(
                                    'post_type'      => 'post',
                                    'category_name'  => wp_kses_post( $get_checked_cat_slugs ),
                                    'posts_per_page' => absint( $scholarship_section_post_count )
                                );
                        $latest_blog_query = new WP_Query( $latest_blog_args );
                ?>
                    <div class="latest-posts-wrapper mt-column-wrapper">
                    <?php
                        if( $latest_blog_query->have_posts() ) {
                            while( $latest_blog_query->have_posts() ) {
                                $latest_blog_query->the_post();
                    ?>
                            <div class="single-post-wrapper mt-column-3">
                                <div class="post-thumb">
                                <?php if( has_post_thumbnail() ) { ?>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail( 'scholarship-blog-medium' ); ?>
                                    </a>
                                <?php } ?>
                                </div>

                                <div class="blog-content-wrapper">
                                    <h3 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <div class="post-meta">
                                        <?php scholarship_posted_on(); ?>
                                     </div>
                                    <div class="post-excerpt">
                                        <?php 
                                            $post_content = get_the_content();
                                            echo scholarship_get_excerpt( $post_content, 150 ); 
                                        ?>
                                    </div>
                                    <a class="news-more" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php echo esc_html( $scholarship_section_btn_text ); ?></a>
                                </div>
                            </div><!-- .single-post-wrapper -->
                    <?php
                            }
                        }
                    ?>
                        </div><!-- .latest-posts-wrapper -->
                <?php
                    }
                ?>
            </div><!-- .scholarship-container -->
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