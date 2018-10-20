<?php
/**
 * Widget for grid layout which is suitable for services/features and teams.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */
add_action( 'widgets_init', 'scholarship_register_grid_layout_widget' );

function scholarship_register_grid_layout_widget() {
    register_widget( 'Scholarship_Grid_Layout' );
}

class Scholarship_Grid_Layout extends WP_Widget {

	/**
     * Register widget with WordPress.
     */
    public function __construct() {
        $widget_ops = array( 
            'classname' => 'scholarship_grid_layout',
            'description' => __( 'Display posts from selected category as grid view.', 'scholarship' )
        );
        parent::__construct( 'scholarship_grid_layout', __( 'Scholarship: Grid Items', 'scholarship' ), $widget_ops );
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
                'scholarship_widgets_default'      => 3,
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

    	$scholarship_section_title 	    = empty( $instance['section_title'] ) ? '' : $instance['section_title'];
    	$scholarship_section_info		= empty( $instance['section_info'] ) ? '' : $instance['section_info'];    	
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

        $grid_args = array(
        				'post_type'      => 'post',
        				'category_name'  => esc_attr( $scholarship_section_cat_slug ),
        				'posts_per_page' => absint( $scholarship_section_post_count )
        			);
        $grid_query = new WP_Query( $grid_args );
        echo $before_widget;
    ?>
    		<div class="section-wrapper scholarship-widget-wrapper clearfix">
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

	                <div class="grid-items-wrapper mt-column-wrapper">
	                	<?php
	                		if( $grid_query->have_posts() ) {
	                			while( $grid_query->have_posts() ) {
	                				$grid_query->the_post();
	                	?>
	                				<div class="single-post-wrapper mt-column-3">
		                				<?php if( has_post_thumbnail() ) { ?>
                                            <div class="img-holder">
                                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                        <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                        <?php the_excerpt(); ?>
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