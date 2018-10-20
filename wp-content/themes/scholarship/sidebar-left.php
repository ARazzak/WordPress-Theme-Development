<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

if ( ! is_active_sidebar( 'scholarship_sidebar_left' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'scholarship_sidebar_left' ); ?>
</aside><!-- #secondary -->
