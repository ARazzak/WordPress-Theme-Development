<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

	if( ! is_page_template( 'templates/template-home.php' ) ) { 
    	echo '</div><!-- .mt-container -->';
	}
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php 
			$footer_widget_option = get_theme_mod( 'footer_widget_option', 'show' );
			if( $footer_widget_option == 'show' ) {
				get_sidebar( 'footer' );
			}
		?>
		<div class="site-info-wrapper">
			<div class="site-info">
				<div class="mt-container">
					<div class="scholarship-copyright-wrapper">
						<?php $scholarship_copyright_text = get_theme_mod( 'scholarship_copyright_text', __( 'Scholarship', 'scholarship' ) ); ?>
						<span class="scholarship-copyright"><?php echo wp_kses_post( $scholarship_copyright_text ); ?></span>
						<span class="sep"> | </span>
						<?php printf( esc_html__( '%1$s Customized by %2$s.', 'scholarship' ), 'Scholarship Theme', '<a href="'. esc_url( 'http://mdabdurrazzak.com/' ).'" rel="designer">Abdur Razzak</a>' ); ?>
					</div>
					<?php 
						$mt_sub_footer_type = get_theme_mod( 'mt_sub_footer_type', 'social_icon' );
						if( $mt_sub_footer_type == 'social_icon' ) {
					?>
		                <div class="mt-footer-social">
			           		<?php scholarship_social_icons(); ?>
			           	</div><!-- .mt-footer-social -->
			        <?php } else { ?>
			           	<nav id="site-footer-navigation" class="footer-navigation" role="navigation">
					        <?php wp_nav_menu( array( 'theme_location' => 'scholarship_footer_menu', 'menu_id' => 'footer-menu' ) ); ?>
			           	</nav><!-- #site-navigation -->
		           	<?php } ?>
				</div>
			</div><!-- .site-info -->
		</div>
	</footer><!-- #colophon -->
	<div id="mt-scrollup" class="animated arrow-hide"><i class="fa fa-chevron-up"></i></div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>