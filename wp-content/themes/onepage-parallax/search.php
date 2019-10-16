<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */

get_header(); ?>
<?php get_header(); ?>
<?php

$onepage_parallax_search_post_sidebar_position = get_theme_mod( 'onepage_parallax_search_sidebar', 'right' );

if ( 'left' == $onepage_parallax_search_post_sidebar_position || 'right' == $onepage_parallax_search_post_sidebar_position  ) {
	$onepage_parallax_search_class = 'col-md-9';
} else {
	$onepage_parallax_search_class = 'col-12';
}
?>

<div <?php post_class( 'onepage-parallax-search' ); ?> id="post-<?php the_ID(); ?>">
	<div class="container-fluid">
		<div class="row">
			<?php if ( 'left' == $onepage_parallax_search_post_sidebar_position ) : ?>
				<div class="col-md-3 onepage-parallax-sidebar">
					<?php
					if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
						dynamic_sidebar( 'sidebar-widget-area' );
					} else {
						get_sidebar();
					} ?>
				</div>
			<?php endif; ?>
		  <div class="<?php echo $onepage_parallax_search_class; ?>">
				<?php
				if ( have_posts() ) : ?>
				<h2 class="onepage-parallax-search-result"><?php echo sprintf( esc_html__( 'Search Results for: %s', 'onepage-parallax' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/post/content', 'excerpt' );

					endwhile; // End of the loop.

					// Display Pagination.
					onepage_parallax_pagination();

				else :
					get_template_part( 'template-parts/search', 'none' );
				endif;
				?>
		  </div> <!-- /.$onepage_parallax_search_class -->
			<?php if ( 'right' == $onepage_parallax_search_post_sidebar_position ) : ?>
			  <div class="col-md-3 onepage-parallax-sidebar">
					<?php
					if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
						dynamic_sidebar( 'sidebar-widget-area' );
					} else {
						get_sidebar();
					} ?>
			  </div>
			<?php endif; ?>
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div><!-- /.blog-single-post -->
<?php get_footer(); ?>
