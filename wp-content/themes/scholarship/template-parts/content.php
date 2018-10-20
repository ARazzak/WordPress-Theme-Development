<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mystery Themes
 * @subpackage Scholarship
 * @since 1.0.0
 */

if( has_post_thumbnail() ) {
	$post_class = 'has-thumbnail';
} else {
	$post_class = 'no-thumbnail';
}

?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
		<header class="entry-header">
	        <div class="single-post-image">
	            <figure>
	            	<?php
	            		$scholarship_archive_layout = get_theme_mod( 'scholarship_archive_layout', 'classic' );
	            		if( $scholarship_archive_layout == 'classic' ) {
	            			the_post_thumbnail( 'scholarship-blog-large' );
	            		} else {
	            			the_post_thumbnail( 'scholarship-blog-medium' );
	            		}
	            	?>
	            </figure>
	        </div>
		</header><!-- .entry-header -->
		<div class="archive-content-wrapper">
			<?php
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php scholarship_posted_on(); ?>
					<?php scholarship_entry_footer(); ?>
				</div><!-- .entry-meta -->
				<?php
				endif; ?>
			<div class="entry-content">
				<?php
					the_excerpt();

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'scholarship' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->
		</div> <!-- archive-content-wrapper -->
	</article><!-- #post-## -->
