<?php
/**
 * Expand WP_Customize_Control as requirement and develop according theme settings.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

if( class_exists( 'WP_Customize_Control' ) ) {

	/**
     * Category dropdwon control
     * @return HTML
     *
     * @since 1.0.0
     */
    class Scholarship_Customize_Category_Control extends WP_Customize_Control {
        /**
         * Render the control's content.
         *
         * @since 3.4.0
         */
        public function render_content() {
            $dropdown = wp_dropdown_categories(
                array(
                    'name'              => '_customize-dropdown-categories-' . $this->id,
                    'echo'              => 0,
                    'show_option_none'  => __( '&mdash; Select Category &mdash;', 'scholarship' ),
                    'option_none_value' => '0',
                    'selected'          => $this->value(),
                    'value_field'       => 'slug',
                )
            );
 
            // Hackily add in the data link parameter.
            $dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
 
            printf(
                '<label class="customize-control-select"><span class="customize-control-title">%s</span><span class="description customize-control-description">%s</span> %s </label>',
                $this->label,
                $this->description,
                $dropdown
            );
        }
    }

/*------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     * Switch button customize control.
     *
     * @since 1.0.0
     * @access public
     */
    class Scholarship_Customize_Switch_Control extends WP_Customize_Control {

        /**
         * The type of customize control being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'switch';

        /**
         * Displays the control content.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function render_content() {
    ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <div class="description customize-control-description"><?php echo esc_html( $this->description ); ?></div>
                <div class="switch_options">
                    <?php 
                        $show_choices = $this->choices;
                        foreach ( $show_choices as $key => $value ) {
                            echo '<span class="switch_part '. esc_attr( $key ).'" data-switch="'. esc_attr( $key ).'">'. esc_html( $value ).'</span>';
                        }
                    ?>
                    <input type="hidden" id="mt_switch_option" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
                </div>
            </label>
    <?php
        }
    }

/*------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     * Radio image customize control.
     *
     * @since  1.0.0
     * @access public
     */
    class Scholarship_Customize_Control_Radio_Image extends WP_Customize_Control {
        /**
         * The type of customize control being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'radio-image';

        /**
         * Loads the jQuery UI Button script and custom scripts/styles.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function enqueue() {
            wp_enqueue_script( 'jquery-ui-button' );
        }

        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();

            // We need to make sure we have the correct image URL.
            foreach ( $this->choices as $value => $args )
                $this->choices[ $value ]['url'] = esc_url( sprintf( $args['url'], get_template_directory_uri(), get_stylesheet_directory_uri() ) );

            $this->json['choices'] = $this->choices;
            $this->json['link']    = $this->get_link();
            $this->json['value']   = $this->value();
            $this->json['id']      = $this->id;
        }


        /**
         * Underscore JS template to handle the control's output.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */

        public function content_template() { ?>
            <# if ( data.label ) { #>
                <span class="customize-control-title">{{ data.label }}</span>
            <# } #>

            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>

            <div class="buttonset">

                <# for ( key in data.choices ) { #>

                    <input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" {{{ data.link }}} <# if ( key === data.value ) { #> checked="checked" <# } #> /> 

                    <label for="{{ data.id }}-{{ key }}">
                        <span class="screen-reader-text">{{ data.choices[ key ]['label'] }}</span>
                        <img src="{{ data.choices[ key ]['url'] }}" title="{{ data.choices[ key ]['label'] }}" alt="{{ data.choices[ key ]['label'] }}" />
                    </label>
                <# } #>

            </div><!-- .buttonset -->
        <?php }
    }

/*------------------------------------------------------------------------------------------------------------------------------------*/
    /**
     * Customize controls for repeater field
     *
     * @since 1.0.0
     */
    class Scholarship_Repeater_Controler extends WP_Customize_Control {
        /**
         * The control type.
         *
         * @access public
         * @var string
         */
        public $type = 'repeater';

        public $scholarship_box_label = '';

        public $scholarship_box_add_control = '';

        /**
         * The fields that each container row will contain.
         *
         * @access public
         * @var array
         */
        public $fields = array();

        /**
         * Repeater drag and drop controller
         *
         * @since  1.0.0
         */
        public function __construct( $manager, $id, $args = array(), $fields = array() ) {
            $this->fields = $fields;
            $this->scholarship_box_label = $args['scholarship_box_label'] ;
            $this->scholarship_box_add_control = $args['scholarship_box_add_control'];
            parent::__construct( $manager, $id, $args );
        }

        public function render_content() {

            $values = json_decode( $this->value() );
            $repeater_id = $this->id;
            $field_count = count( $values );;
        ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

            <?php if( $this->description ){ ?>
                <span class="description customize-control-description">
                    <?php echo wp_kses_post( $this->description ); ?>
                </span>
            <?php } ?>

            <ul class="mt-repeater-field-control-wrap">
                <?php $this->scholarship_get_fields(); ?>
            </ul>

            <input type="hidden" <?php esc_attr( $this->link() ); ?> class="mt-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
            <input type="hidden" name="<?php echo esc_attr( $repeater_id ).'_count'; ?>" class="field-count" value="<?php echo absint( $field_count ); ?>">
            <input type="hidden" name="field_limit" class="field-limit" value="5">
            <button type="button" class="button mt-repeater-add-control-field"><?php echo esc_html( $this->scholarship_box_add_control ); ?></button>
    <?php
        }

        private function scholarship_get_fields(){
            $fields = $this->fields;
            $values = json_decode( $this->value() );

            if( is_array( $values ) ){
            foreach( $values as $value ){
        ?>
            <li class="mt-repeater-field-control">
            <h3 class="mt-repeater-field-title"><?php echo esc_html( $this->scholarship_box_label ); ?></h3>
            
            <div class="mt-repeater-fields">
            <?php
                foreach ( $fields as $key => $field ) {
                $class = isset( $field['class'] ) ? $field['class'] : '';
            ?>
                <div class="mt-repeater-field mt-repeater-type-<?php echo esc_attr( $field['type'] ).' '. esc_attr( $class ); ?>">

                <?php 
                    $label = isset( $field['label'] ) ? $field['label'] : '';
                    $description = isset( $field['description'] ) ? $field['description'] : '';
                    if( $field['type'] != 'checkbox' ) { 
                ?>
                        <span class="customize-control-title"><?php echo esc_html( $label ); ?></span>
                        <span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
                <?php 
                    }

                    $new_value = isset( $value->$key ) ? $value->$key : '';
                    $default = isset( $field['default'] ) ? $field['default'] : '';

                    switch ( $field['type'] ) {

                        case 'url':
                            echo '<input data-default="'.esc_attr( $default ).'" data-name="'.esc_attr( $key ).'" type="text" value="'.esc_url( $new_value ).'"/>';
                            break;

                        case 'social_icon':
                            echo '<div class="mt-repeater-selected-icon">';
                            echo '<i class="'.esc_attr( $new_value ).'"></i>';
                            echo '<span><i class="fa fa-angle-down"></i></span>';
                            echo '</div>';
                            echo '<ul class="mt-repeater-icon-list clearfix">';
                            $scholarship_font_awesome_social_icon_array = scholarship_font_awesome_social_icon_array();
                            foreach ( $scholarship_font_awesome_social_icon_array as $scholarship_font_awesome_icon ) {
                                $icon_class = $new_value == $scholarship_font_awesome_icon ? 'icon-active' : '';
                                echo '<li class='.esc_attr( $icon_class ).'><i class="'. esc_attr( $scholarship_font_awesome_icon ).'"></i></li>';
                            }
                            echo '</ul>';
                            echo '<input data-default="'.esc_attr( $default ).'" type="hidden" value="'.esc_attr( $new_value ).'" data-name="'.esc_attr($key).'"/>';
                            break;

                        default:
                            break;
                    }
                ?>
                </div>
                <?php
                } ?>

                <div class="clearfix mt-repeater-footer">
                    <div class="alignright">
                    <a class="mt-repeater-field-remove" href="#remove"><?php esc_html_e( 'Delete', 'scholarship' ) ?></a> |
                    <a class="mt-repeater-field-close" href="#close"><?php esc_html_e( 'Close', 'scholarship' ) ?></a>
                    </div>
                </div>
            </div>
            </li>
            <?php   
            }
            }
        }
    }

/*-----------------------------------------------------------------------------------------------------------------------*/
    
    /**
     * Upsell customizer section.
     *
     * @since  1.0.5
     * @access public
     */
    class Scholarship_Customize_Section_Upsell extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'upsell';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();

            $json['pro_text'] = $this->pro_text;
            $json['pro_url']  = esc_url( $this->pro_url );

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>

            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    {{ data.title }}

                    <# if ( data.pro_text && data.pro_url ) { #>
                        <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                    <# } #>
                </h3>
            </li>
        <?php }
    }
}