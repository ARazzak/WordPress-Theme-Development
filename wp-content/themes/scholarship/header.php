<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'scholarship_before_main' ); ?>
<div id="page" class="site">
	<?php do_action( 'scholarship_before_header' ); ?>

	<?php 
		/**
		 * scholarship_header_section hook.
		 *
		 * @hooked scholarship_header_section_start - 5
		 * @hooked scholarship_site_branding - 10
		 * @hooked scholarship_header_elements - 15
		 * @hooked scholarship_primary_menu_section - 20
		 * @hooked scholarship_header_section_end - 25
		 */
		do_action( 'scholarship_header_section' ); 
	?>

	<div id="content" class="site-content">
		<?php if( ! is_page_template( 'templates/template-home.php' ) && !is_front_page() ) { ?>
			<header class="entry-header">
	            <div class="mt-container">
	    			<?php
	    				if( is_single() || is_page() ) {
	    					the_title( '<h1 class="entry-title">', '</h1>' );
	    				}elseif( is_home() ) {
	    				   echo '<h1 class="entry-title">'. apply_filters( 'the_title', get_the_title( get_option( 'page_for_posts' ) ) ) .'</h1>';
	    				} elseif( is_archive() ) {
	    					the_archive_title( '<h1 class="page-title">', '</h1>' );
	    					the_archive_description( '<div class="taxonomy-description">', '</div>' );
	    				} elseif( is_search() ) {
	    			?>
	    					<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'scholarship' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
	    			<?php
	    				}
	    			?>
	            </div><!-- .mt-container -->
			</header><!-- .entry-header -->
		<?php } ?>
		<?php 
			if( is_front_page() ) {
				/**
				 * scholarship_slider_section hook.
				 *
				 * @hooked scholarship_slider_wrapper_start - 5
				 * @hooked scholarship_slider_content - 10
				 * @hooked scholarship_slider_wrapper_end - 15
				 */
				do_action( 'scholarship_slider_section' );
			}
			if( ! is_page_template( 'templates/template-home.php' ) ) {
            	echo '<div class="mt-container">';
        	}
		?>
