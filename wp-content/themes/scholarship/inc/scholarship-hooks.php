<?php
/**
 * File to define the custom hook functions 
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 *
 */
/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * function for header section start
 */
if( ! function_exists( 'scholarship_header_section_start' ) ):
	function scholarship_header_section_start() {
		echo '<header id="masthead" class="site-header" role="banner">';		
	}
endif;

/**
 * function for site branding
 */
if( ! function_exists( 'scholarship_site_branding' ) ):
	function scholarship_site_branding() {
?>
		<div class="logo-ads-wrapper clearfix">
			<div class="mt-container">
				<div class="site-branding">
					<?php if ( the_custom_logo() ) { ?>
						<div class="site-logo">
							<?php the_custom_logo(); ?>
						</div><!-- .site-logo -->
					<?php } ?>
					<?php 
						$site_title_option = get_theme_mod( 'header_textcolor' );
						if( $site_title_option != 'blank' ) {
					?>
						<div class="site-title-wrapper">
							<?php
							if ( is_front_page() && is_home() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
							endif;

							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
							<?php
							endif; ?>
						</div><!-- .site-title-wrapper -->
					<?php 
						}
					?>
				</div><!-- .site-branding -->			
<?php
	}
endif;

/**
 * function for header elements
 */
if( ! function_exists( 'scholarship_header_elements' ) ) :
	function scholarship_header_elements() {
		$top_header_address = get_theme_mod( 'header_address', '' );
		$top_header_email = get_theme_mod( 'header_email', '' );
		$top_header_phone = get_theme_mod( 'header_phone', '' );
		echo '<div class="header-elements-holder">';
		if( !empty( $top_header_address ) ) {
			echo '<span class="top-address top-info">'. esc_html( $top_header_address ) .'</span>';
		}
		if( !empty( $top_header_email ) ) {
			echo '<span class="top-email top-info">'. antispambot( $top_header_email ) .'</span>';
		}
		if( !empty( $top_header_phone ) ) {
			echo '<span class="top-phone top-info">'. esc_html( $top_header_phone ) .'</span>';
		}
		echo '</div><!-- .header-elements-holder --><div class="clearfix"> </div>';
		echo '</div><!-- .mt-container -->';
		echo '</div><!-- .logo-ads-wrapper -->';
	}
endif;

/**
 * function for primary menu
 */
if( ! function_exists( 'scholarship_primary_menu_section' ) ):
	function scholarship_primary_menu_section() {
?>
		<div class="menu-search-wrapper">
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<div class="menu-toggle hide"> <i class="fa fa-navicon"> </i> </div>
					<?php wp_nav_menu( array( 'theme_location' => 'scholarship_primary_menu', 'menu_id' => 'primary-menu' ) ); ?>
				</nav><!-- #site-navigation -->

				<?php 
					if( get_theme_mod( 'menu_search_option', 'show' ) == 'show' ) { ?>
					<div class="header-search-wrapper">
		                <span class="search-main"><i class="fa fa-search"></i></span>
		                <div class="search-form-main clearfix">
							<div class="mt-container">
			                	<?php get_search_form(); ?>
			                </div>
			            </div>
		            </div><!-- .header-search-wrapper -->
	            <?php } ?>
        </div><!-- .menu-search-wrapper -->
<?php
	}
endif;

/**
 * function for header section end
 */
if( ! function_exists( 'scholarship_header_section_end' ) ):
	function scholarship_header_section_end() {		
		echo '</header><!-- #masthead -->';
	}
endif;

/**
 * managed function for header section
 *
 * @since 1.1.0
 */
add_action( 'scholarship_header_section', 'scholarship_header_section_start', 5 );
add_action( 'scholarship_header_section', 'scholarship_site_branding', 10 );
add_action( 'scholarship_header_section', 'scholarship_header_elements', 15 );
add_action( 'scholarship_header_section', 'scholarship_primary_menu_section', 15 );
add_action( 'scholarship_header_section', 'scholarship_header_section_end', 25 );

/*------------------------------------------------------------------------------------------------------------------------------------*/
/**
 * function for slider wrapper start
 */
if( ! function_exists( 'scholarship_slider_wrapper_start' ) ):
	function scholarship_slider_wrapper_start() {
		echo '<div class="scholarship-slider-wrapper">';
	}
endif;

/**
 * function for slider content
 */
if( ! function_exists( 'scholarship_slider_content' ) ):
	function scholarship_slider_content() {
		$slider_cat_slug = get_theme_mod( 'scholarship_slider_category', 0 );
		if( empty( $slider_cat_slug ) ) {
			return;
		}
		$slider_args = array(
				'post_type' 	=> 'post',
				'category_name'	=> sanitize_text_field( $slider_cat_slug )
			);
		$slider_query = new WP_Query( $slider_args );
		if( $slider_query->have_posts() ) {
			echo '<ul class="homepage-slider cS-hidden">';
			while ( $slider_query->have_posts() ) {
				$slider_query->the_post();
				if( has_post_thumbnail() ) {
	?>
					<li>
						<div class="single-slide">
							<div class="slider-overlay"> </div>
							<div class="slide-thumb">
								<?php the_post_thumbnail( 'full' ); ?>
							</div>
							<div class="slider-content-wrapper">
								<div class="mt-container">
									<h2 class="slide-title"><?php the_title(); ?></h2>
									<div class="slide-content"><?php the_content(); ?></div>
								</div>
							</div><!-- .slider-content-wrapper -->
						</div><!-- .single-slide -->
					</li>
	<?php
				}
			}
			echo '</ul>';
		}
	}
endif;

/**
 * function for slider wrapper end
 */
if( ! function_exists( 'scholarship_slider_wrapper_end' ) ):
	function scholarship_slider_wrapper_end() {
		echo '</div><!-- .scholarship-slider-wrapper -->';
	}
endif;

/**
 * managed function for slider section
 */
add_action( 'scholarship_slider_section', 'scholarship_slider_wrapper_start', 5 );
add_action( 'scholarship_slider_section', 'scholarship_slider_content', 10 );
add_action( 'scholarship_slider_section', 'scholarship_slider_wrapper_end', 15 );
/*------------------------------------------------------------------------------------------------------------------------------------*/