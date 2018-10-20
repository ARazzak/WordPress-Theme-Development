<?php
/**
 * Add or expand custom function related to the Scholarship theme.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

/*-----------------------------------------------------------------------------------------------------------------------*/
/**
 * Register Google fonts for Scholarship.
 *
 * @return string Google fonts URL for the theme.
 * @since 1.0.0
 */
if ( ! function_exists( 'scholarship_fonts_url' ) ) :
    function scholarship_fonts_url() {
        $fonts_url = '';
        $font_families = array();

        /*
         * Translators: If there are characters in your language that are not supported
         * by Roboto Condensed, translate this to 'off'. Do not translate into your own language.
         */
        if ( 'off' !== _x( 'on', 'Roboto Slab font: on or off', 'scholarship' ) ) {
            $font_families[] = 'Roboto Slab:300italic,400italic,700italic,400,300,700';
        }      

        if( $font_families ) {
            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
endif;

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue Scripts and styles for admin
 *
 * @since 1.0.0
 */
function scholarship_admin_scripts_style( $hook ) {

    if( 'widgets.php' != $hook && 'edit.php' != $hook && 'post.php' != $hook && 'post-new.php' != $hook ) {
        return;
    }

    if ( function_exists( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }

    wp_enqueue_script( 'jquery-ui-button' );

    wp_enqueue_script( 'scholarship-admin-script', get_template_directory_uri() .'/assets/js/admin-scripts.js', array('jquery'), '1.0.0', true );

    wp_enqueue_style( 'scholarship-admin-style', get_template_directory_uri() .'/assets/css/admin-styles.css', '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'scholarship_admin_scripts_style' );

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Enqueue scripts and styles.
 */
function scholarship_scripts() {
	
	wp_enqueue_script( 'jquery-lightslider', get_template_directory_uri() . '/assets/library/lightslider/js/lightslider.min.js', array('jquery'), '20170605', true );

    $header_sticky_option = get_theme_mod( 'header_sticky_option', 'show' );
    if( $header_sticky_option != 'hide' ) {
        wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() .'/assets/library/sticky/jquery.sticky.js', array( 'jquery' ), '1.0.2', true );
        wp_enqueue_script( 'scholarship-sticky-setting', get_template_directory_uri() .'/assets/library/sticky/sticky-setting.js', array( 'jquery-sticky' ), '1.0.0', true );
    }

	wp_enqueue_script( 'scholarship-custom-script', get_template_directory_uri(). '/assets/js/custom-script.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/library/font-awesome/css/font-awesome.min.css', array(), '4.5.0' );

    wp_enqueue_style( 'scholarship-fonts', scholarship_fonts_url(), array(), null );

    wp_enqueue_style( 'lightslider-style', get_template_directory_uri() .'/assets/library/lightslider/css/lightslider.min.css', array(), '1.1.5' );

	wp_enqueue_style( 'scholarship-style', get_stylesheet_uri() );

    wp_enqueue_style( 'scholarship-responsive-style', get_template_directory_uri() .'/assets/css/scholarship-responsive.css' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'scholarship_scripts' );

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * scholarship category list
 *
 * @return array();
 */
if( !function_exists( 'scholarship_categories_lists' ) ):
    function scholarship_categories_lists() {
        $scholarship_cat_args = array(
                        'type'                     => 'post',
                        'child_of'                 => 0,
                        'orderby'                  => 'name',
                        'order'                    => 'ASC',
                        'hide_empty'               => 1,
                        'taxonomy'                 => 'category',
                    );
        $scholarship_categories = get_categories( $scholarship_cat_args );
        $scholarship_categories_lists = array();
        foreach( $scholarship_categories as $category ) {
            $scholarship_categories_lists[$category->slug] = $category->name;
        }
        return $scholarship_categories_lists;
    }
endif;


/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Function define about page/post/archive sidebar
 *
 * @since 1.0.0
 */
if( ! function_exists( 'scholarship_get_sidebar' ) ):
function scholarship_get_sidebar() {
    global $post;

    if( 'post' === get_post_type() ) {
        $sidebar_meta_option = get_post_meta( $post->ID, 'single_post_sidebar', true );
    }

    if( 'page' === get_post_type() ) {
        $sidebar_meta_option = get_post_meta( $post->ID, 'single_page_sidebar', true );
    }
     
    if( is_home() ) {
        $set_id = get_option( 'page_for_posts' );
        $sidebar_meta_option = get_post_meta( $set_id, 'single_page_sidebar', true );
    }
    
    if( empty( $sidebar_meta_option ) || is_archive() || is_search() ) {
        $sidebar_meta_option = 'default_sidebar';
    }
    
    $archive_sidebar = get_theme_mod( 'scholarship_archive_sidebar', 'right_sidebar' );
    $post_default_sidebar = get_theme_mod( 'scholarship_default_post_sidebar', 'right_sidebar' );
    $page_default_sidebar = get_theme_mod( 'scholarship_default_page_sidebar', 'right_sidebar' );
    
    if( $sidebar_meta_option == 'default_sidebar' ) {
        if( is_single() ) {
            if( $post_default_sidebar == 'right_sidebar' ) {
                get_sidebar();
            } elseif( $post_default_sidebar == 'left_sidebar' ) {
                get_sidebar( 'left' );
            }
        } elseif( is_page() ) {
            if( $page_default_sidebar == 'right_sidebar' ) {
                get_sidebar();
            } elseif( $page_default_sidebar == 'left_sidebar' ) {
                get_sidebar( 'left' );
            }
        } elseif( $archive_sidebar == 'right_sidebar' ) {
            get_sidebar();
        } elseif( $archive_sidebar == 'left_sidebar' ) {
            get_sidebar( 'left' );
        }
    } elseif( $sidebar_meta_option == 'right_sidebar' ) {
        get_sidebar();
    } elseif( $sidebar_meta_option == 'left_sidebar' ) {
        get_sidebar( 'left' );
    }
}
endif;

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * scholarship homepage excerpt
 */
if( ! function_exists( 'scholarship_get_excerpt' ) ):
function scholarship_get_excerpt( $content, $limit ) {
    $striped_content = strip_tags( $content );
    $striped_content = strip_shortcodes( $striped_content );
    $limit_content = mb_substr( $striped_content, 0 , $limit );
    if( $limit_content < $content ){
        $limit_content .= "..."; 
    }
    return $limit_content;
}
endif;

/**
 * Function to get excerpt content according to define length
 */
if( ! function_exists( 'scholarship_archive_excerpt' ) ):
    function scholarship_archive_excerpt( $content, $limit ) {
        $content = strip_tags( $content );
        $content = strip_shortcodes( $content );
        $words = explode( ' ', $content );    
        return implode( ' ', array_slice( $words, 0, $limit ) );
    }
endif;

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Define font awesome social media icons
 *
 * @return array();
 * @since 1.0.0
 */
if( ! function_exists( 'scholarship_font_awesome_social_icon_array' ) ) :
    function scholarship_font_awesome_social_icon_array(){
        return array(
                "fa fa-facebook-square","fa fa-facebook-f","fa fa-facebook","fa fa-facebook-official","fa fa-twitter-square","fa fa-twitter","fa fa-yahoo","fa fa-google","fa fa-google-wallet","fa fa-google-plus-circle","fa fa-google-plus-official","fa fa-instagram","fa fa-linkedin-square","fa fa-linkedin","fa fa-pinterest-p","fa fa-pinterest","fa fa-pinterest-square","fa fa-google-plus-square","fa fa-google-plus","fa fa-youtube-square","fa fa-youtube","fa fa-youtube-play","fa fa-vimeo","fa fa-vimeo-square",
            );
    }
endif;

/*---------------------------------------------------------------------------------------------------------------*/
/**
 * Social media function
 *
 * @since 1.0.0
 */

if( !function_exists( 'scholarship_social_icons' ) ):
    function scholarship_social_icons() {
        $get_social_media_icons = get_theme_mod( 'social_media_icons', '' );
        $get_decode_social_media = json_decode( $get_social_media_icons );
        if( ! empty( $get_decode_social_media ) ) {
            echo '<div class="mt-social-icons-wrapper">';
            foreach ( $get_decode_social_media as $single_icon ) {
                $icon_class = $single_icon->social_icon_class;
                $icon_url = $single_icon->social_icon_url;
                if( !empty( $icon_url ) ) {
                    echo '<span class="social-link"><a href="'. esc_url( $icon_url ) .'" target="_blank"><i class="'. esc_attr( $icon_class ) .'"></i></a></span>';
                }
            }
            echo '</div><!-- .mt-social-icons-wrapper -->';
        }
    }
endif;

/*---------------------------------------------------------------------------------------------------------------*/
/**
 * Get rgba color from hex
 *
 * @since 1.0.0
 */
function scholarship_get_hex2rgba( $color, $opacity ) {
    if ( $color[0] == '#' ) {
        $color = substr( $color, 1 );
    }
    $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    $rgb =  array_map( 'hexdec', $hex );
    $output = 'rgba( '.implode( ",", $rgb ).','.$opacity.' )';
    return $output;
}