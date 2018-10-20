<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function scholarship_body_classes( $classes ) {

    wp_reset_postdata();
    
    global $post;

    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of boxed-layout for whole site
    $scholarship_site_layout = get_theme_mod( 'site_layout_option', 'wide_layout' );
    if( $scholarship_site_layout == 'boxed_layout' ) {
        $classes[] = 'boxed-layout';
    }

    //Adds a archive layout class
    $scholarship_archive_layout = get_theme_mod( 'scholarship_archive_layout', 'classic' );
    if( is_archive() || is_home() ) {
        $classes[] = $scholarship_archive_layout.'-archive-layout';
    }

    /**
     * Sidebar option for post/page/archive
     */
    if( 'post' === get_post_type() ) {
        $sidebar_meta_option = get_post_meta( $post->ID, 'single_post_sidebar', true );
    }

    if( 'page' === get_post_type() ) {
        $sidebar_meta_option = get_post_meta( $post->ID, 'single_page_sidebar', true );
    }
     
    if( is_home() ) {
        $home_id = get_option( 'page_for_posts' );
        $sidebar_meta_option = get_post_meta( $home_id, 'single_page_sidebar', true );
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
                $classes[] = 'right-sidebar';
            } elseif( $post_default_sidebar == 'left_sidebar' ) {
                $classes[] = 'left-sidebar';
            } elseif( $post_default_sidebar == 'no_sidebar' ) {
                $classes[] = 'no-sidebar';
            } elseif( $post_default_sidebar == 'no_sidebar_center' ) {
                $classes[] = 'no-sidebar-center';
            }
        } elseif( is_page() && !is_page_template( 'templates/template-home.php' ) ) {
            if( $page_default_sidebar == 'right_sidebar' ) {
                $classes[] = 'right-sidebar';
            } elseif( $page_default_sidebar == 'left_sidebar' ) {
                $classes[] = 'left-sidebar';
            } elseif( $page_default_sidebar == 'no_sidebar' ) {
                $classes[] = 'no-sidebar';
            } elseif( $page_default_sidebar == 'no_sidebar_center' ) {
                $classes[] = 'no-sidebar-center';
            }
        } elseif( $archive_sidebar == 'right_sidebar' ) {
            $classes[] = 'right-sidebar';
        } elseif( $archive_sidebar == 'left_sidebar' ) {
            $classes[] = 'left-sidebar';
        } elseif( $archive_sidebar == 'no_sidebar' ) {
            $classes[] = 'no-sidebar';
        } elseif( $archive_sidebar == 'no_sidebar_center' ) {
            $classes[] = 'no-sidebar-center';
        }
    } elseif( $sidebar_meta_option == 'right_sidebar' ) {
        $classes[] = 'right-sidebar';
    } elseif( $sidebar_meta_option == 'left_sidebar' ) {
        $classes[] = 'left-sidebar';
    } elseif( $sidebar_meta_option == 'no_sidebar' ) {
        $classes[] = 'no-sidebar';
    } elseif( $sidebar_meta_option == 'no_sidebar_center' ) {
        $classes[] = 'no-sidebar-center';
    }

    return $classes;
}
add_filter( 'body_class', 'scholarship_body_classes' );

/**
 * Dynamic theme color option
 *
 * @since 1.0.0
 */
if( ! function_exists( 'scholarship_dynamic_styles' ) ):
    function scholarship_dynamic_styles() {

        $scholarship_title_option = get_theme_mod( 'scholarship_title_option', true );
        $scholarship_primary_theme_color = get_theme_mod( 'scholarship_primary_theme_color', '#004b8e' );
        $scholarship_secondary_theme_color = get_theme_mod( 'scholarship_secondary_theme_color', '#f2552c' );
        $scholarship_title_color = get_theme_mod( 'scholarship_title_color', '#004b8e' );

            $output_css = '';
            $output_css .=" a,a:hover,a:focus,a:active,.entry-footer a:hover,.comment-author .fn .url:hover .commentmetadata .comment-edit-link,#cancel-comment-reply-link,#cancel-comment-reply-link:before,.logged-in-as a,.header-elements-holder .top-info::after,.widget hover,.widget a:hover::before,.widget li:hover::before,.widget .widget-title,.scholarship_grid_layout .post-title a:hover,.scholarship_portfolio .single-post-wrapper .portfolio-title-wrapper .portfolio-link,.team-title-wrapper .post-title a:hover,.latest-posts-wrapper .byline a:hover,.latest-posts-wrapper .posted-on a:hover,.latest-posts-wrapper .news-title a:hover,.entry-title a:hover,.entry-meta span a:hover,.post-readmore a:hover,.grid-archive-layout .entry-title a:hover,.widget a:hover, .widget a:hover::before, .widget li:hover::before {
                    color:". esc_attr( $scholarship_primary_theme_color ) .";
                }\n";
                
            $output_css .=".navigation .nav-links a:hover,.bttn:hover,button,input[type='button']:hover,input[type='reset']:hover,input[type='submit']:hover,.edit-link .post-edit-link,.reply .comment-reply-link,#masthead .menu-search-wrapper,#site-navigation ul.sub-menu,#site-navigation ul.children,.header-search-wrapper .search-submit,.mt-slider-btn-wrap .slider-btn:hover,.mt-slider-btn-wrap .slider-btn:first-child,.scholarship-slider-wrapper .lSAction>a:hover,.widget_search .search-submit,.team-wrapper .team-desc-wrapper,.site-info,#mt-scrollup,.scholarship_latest_blog .news-more:hover{
                   background:". esc_attr( $scholarship_primary_theme_color ) .";
                }\n";
                
           $output_css .=".navigation .nav-links a,.bttn,button,input[type='button'],input[type='reset'],input[type='submit'],.header-elements-holder .top-info::after,.mt-slider-btn-wrap .slider-btn:hover,.mt-slider-btn-wrap .slider-btn:first-child,.widget_search .search-submit,.cta-btn-wrap a:hover{
                  border-color:". esc_attr( $scholarship_primary_theme_color ) .";
               }\n";
                
           $output_css .=".comment-list .comment-body,#masthead .menu-search-wrapper::before,#masthead .menu-search-wrapper::after{
                  border-top-color:". esc_attr( $scholarship_primary_theme_color ) .";
                }\n";
                
            $output_css .="#masthead,.site-info:before,.site-info:after,.site-info-wrapper {
                  border-bottom-color:". esc_attr( $scholarship_primary_theme_color ) .";
                }\n";
               
            $output_css .="#site-navigation ul li.current-menu-item > a,#site-navigation ul li.current-menu-ancestor>a,#site-navigation ul li:hover>a,#site-navigation ul li.current_page_ancestor > a,.header-search-wrapper .search-submit:hover,.mt-slider-btn-wrap .slider-btn,.mt-slider-btn-wrap .slider-btn:first-child:hover,.widget .scholarship-widget-wrapper .widget-title::before,.widget .scholarship-widget-wrapper .widget-title::after,.cta-btn-wrap a,.scholarship_portfolio .single-post-wrapper .portfolio-title-wrapper .portfolio-link:hover,.scholarship_latest_blog .news-more,#mt-scrollup:hover{
                   background:". esc_attr( $scholarship_secondary_theme_color ) .";
                }\n";

            $output_css .=".scholarship_call_to_action .section-wrapper::before,.scholarship_portfolio .single-post-wrapper .portfolio-title-wrapper,.scholarship_testimonials .section-wrapper::before{
                    background:". esc_attr( scholarship_get_hex2rgba( $scholarship_primary_theme_color, '0.9' ) ) ."
                }\n"; 
            
            $output_css .=".header-search-wrapper .search-main:hover,.site-info a:hover{
                   color:". esc_attr( $scholarship_secondary_theme_color ) .";
                }\n";
                
            $output_css .=".header-search-wrapper .search-submit:hover{
                   border-color:". esc_attr( $scholarship_secondary_theme_color ) .";
                }\n";
                
            $output_css .=".widget .widget-title{
                   border-left-color:". esc_attr( $scholarship_secondary_theme_color ) .";
                }\n";               
               

            if ( $scholarship_title_option == true ) {
                $output_css .=".site-title a, .site-description {
                            color:". esc_attr( $scholarship_title_color ) .";
                        }\n";
            } else {
                $output_css .=".site-title, .site-description {
                            position: absolute;
                            clip: rect(1px, 1px, 1px, 1px);
                        }\n";
            }

        wp_add_inline_style( 'scholarship-style', $output_css );
    }
endif;
add_action( 'wp_enqueue_scripts', 'scholarship_dynamic_styles' );