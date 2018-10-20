<?php
/**
 * Define custom fields for widgets
 * 
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

function scholarship_widgets_show_widget_field( $instance = '', $widget_field = '', $mt_widget_field_value = '' ) {
    
    extract( $widget_field );

    switch ( $scholarship_widgets_field_type ) {

        /**
         * text field
         */
        case 'text' :
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $scholarship_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $scholarship_widgets_name ) ); ?>" type="text" value="<?php echo esc_html( $mt_widget_field_value ); ?>" />

                <?php if ( isset( $scholarship_widgets_description ) ) { ?>
                    <br />
                    <small><em><?php echo esc_html( $scholarship_widgets_description ); ?></em></small>
                <?php } ?>
            </p>
        <?php
            break;

        /**
         * number field
         */
        case 'number' :
            if( empty( $mt_widget_field_value ) ) {
                $mt_widget_field_value = $scholarship_widgets_default;
            }
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $scholarship_widgets_title ); ?>:</label>
                <input name="<?php echo esc_attr( $instance->get_field_name( $scholarship_widgets_name ) ); ?>" type="number" step="1" min="1" id="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>" value="<?php echo esc_html( $mt_widget_field_value ); ?>" class="small-text" />

                <?php if ( isset( $scholarship_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $scholarship_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        /**
         * url field
         */
        case 'url' :
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $scholarship_widgets_title ); ?>:</label>
                <input class="widefat" id="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $scholarship_widgets_name ) ); ?>" type="text" value="<?php echo esc_url( $mt_widget_field_value ); ?>" />

                <?php if ( isset( $scholarship_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $scholarship_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        /**
         * textarea field
         */
        case 'textarea' :
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $scholarship_widgets_title ); ?>:</label>
                <textarea class="widefat" rows="<?php echo intval( $scholarship_widgets_row ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $mt_widget_field_value ); ?></textarea>
            </p>
        <?php
            break;

        /**
         * select field
         */
        case 'select' :
            if( empty( $mt_widget_field_value ) ) {
                $mt_widget_field_value = $scholarship_widgets_default;
            }
        ?>
            <p>
                <label for="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $scholarship_widgets_title ); ?>:</label>
                <select name="<?php echo esc_attr( $instance->get_field_name( $scholarship_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>" class="widefat">
                    <?php foreach ( $scholarship_widgets_field_options as $athm_option_name => $athm_option_title ) { ?>
                        <option value="<?php echo esc_attr( $athm_option_name ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>" <?php selected( $athm_option_name, $mt_widget_field_value ); ?>><?php echo esc_html( $athm_option_title ); ?></option>
                    <?php } ?>
                </select>

                <?php if ( isset( $scholarship_widgets_description ) ) { ?>
                    <br />
                    <small><?php echo esc_html( $scholarship_widgets_description ); ?></small>
                <?php } ?>
            </p>
        <?php
            break;

        /**
         * category dropdown field
         */
        case 'category_dropdown' :
            if( empty( $mt_widget_field_value ) ) {
                $mt_widget_field_value = $scholarship_widgets_default;
            }
            $select_field = 'name="'. esc_attr( $instance->get_field_name( $scholarship_widgets_name ) ) .'" id="'. esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ) .'" class="widefat"';
        ?>
                <p>
                    <label for="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $scholarship_widgets_title ); ?>:</label>
                    <?php
                        $dropdown_args = wp_parse_args( array(
                            'taxonomy'          => 'category',
                            'show_option_none'  => __( '- - Select Category - -', 'scholarship' ),
                            'selected'          => esc_attr( $mt_widget_field_value ),
                            'show_option_all'   => '',
                            'orderby'           => 'id',
                            'order'             => 'ASC',
                            'show_count'        => 0,
                            'hide_empty'        => 1,
                            'child_of'          => 0,
                            'exclude'           => '',
                            'hierarchical'      => 1,
                            'depth'             => 0,
                            'tab_index'         => 0,
                            'hide_if_empty'     => false,
                            'option_none_value' => 0,
                            'value_field'       => 'slug',
                        ) );

                        $dropdown_args['echo'] = false;

                        $dropdown = wp_dropdown_categories( $dropdown_args );
                        $dropdown = str_replace( '<select', '<select ' . $select_field, $dropdown );
                        echo $dropdown;
                    ?>
                </p>
        <?php
            break;

        /**
         * upload file field
         */
        case 'upload':
            $image = $image_class = "";
            if( $mt_widget_field_value ){ 
                $image = '<img src="'.esc_url( $mt_widget_field_value ).'" style="max-width:100%;"/>';
                $image_class = ' hidden';
            }
            ?>
            <div class="attachment-media-view">

            <label for="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>"><?php echo esc_html( $scholarship_widgets_title ); ?>:</label><br />
            
                <div class="placeholder<?php echo esc_attr( $image_class ); ?>">
                    <?php esc_html_e( 'No image selected', 'scholarship' ); ?>
                </div>
                <div class="thumbnail thumbnail-image">
                    <?php echo $image; ?>
                </div>

                <div class="actions clearfix">
                    <button type="button" class="button mt-delete-button align-left"><?php _e( 'Remove', 'scholarship' ); ?></button>
                    <button type="button" class="button mt-upload-button alignright"><?php _e( 'Select Image', 'scholarship' ); ?></button>
                    
                    <input name="<?php echo esc_attr( $instance->get_field_name( $scholarship_widgets_name ) ); ?>" id="<?php echo esc_attr( $instance->get_field_id( $scholarship_widgets_name ) ); ?>" class="upload-id" type="hidden" value="<?php echo esc_url( $mt_widget_field_value ) ?>"/>
                </div>

            <?php if ( isset( $scholarship_widgets_description ) ) { ?>
                <br />
                <small><?php echo wp_kses_post( $scholarship_widgets_description ); ?></small>
            <?php } ?>

            </div>
            <?php
            break;

        /**
         * multicheckboxes field
         */
        case 'multicheckboxes':
        ?>
            <label><?php echo esc_html( $scholarship_widgets_title ); ?>:</label>

        <?php    
            foreach ( $scholarship_widgets_field_options as $athm_option_name => $athm_option_title) {
                if( isset( $mt_widget_field_value[$athm_option_name] ) ) {
                    $mt_widget_field_value[$athm_option_name] = 1;
                }else{
                    $mt_widget_field_value[$athm_option_name] = 0;
                }
                
            ?>
                <div class="mt-single-checkbox">
                    <p>
                        <input id="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>" name="<?php echo esc_attr( $instance->get_field_name( $scholarship_widgets_name ).'['.$athm_option_name.']' ); ?>" type="checkbox" value="1" <?php checked('1', $mt_widget_field_value[$athm_option_name]); ?>/>
                        <label for="<?php echo esc_attr( $instance->get_field_id( $athm_option_name ) ); ?>"><?php echo esc_html( $athm_option_title ); ?></label>
                    </p>
                </div><!-- .mt-single-checkbox -->
            <?php
                }
                if ( isset( $scholarship_widgets_description ) ) {
            ?>
                    <small><em><?php echo esc_html( $scholarship_widgets_description ); ?></em></small>
            <?php
                }
            break;
    }
}

function scholarship_widgets_updated_field_value( $widget_field, $new_field_value ) {

    extract( $widget_field );

    if ( $scholarship_widgets_field_type == 'number') {
        return scholarship_sanitize_number( $new_field_value );
    } elseif ( $scholarship_widgets_field_type == 'textarea' ) {
        return wp_kses_post( $new_field_value );
    } elseif ( $scholarship_widgets_field_type == 'url' ) {
        return esc_url_raw( $new_field_value );
    } elseif( $scholarship_widgets_field_type == 'multicheckboxes' ) {
        return wp_kses_post( $new_field_value );
    } else {
        return sanitize_text_field( $new_field_value );
    }
}