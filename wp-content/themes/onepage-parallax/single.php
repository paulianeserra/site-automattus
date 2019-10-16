<?php
/**
 * The template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */

get_header(); ?>
<?php
if ( checked( get_theme_mod( 'onepage_parallax_SPHImage_visible', true ), true, false ) ) {
	$onepage_parallax_singlepost_bg_img = get_theme_mod( 'onepage_parallax_single_header_image', ONEPAGE_PARALLAX_DIR_URI . 'assets/images/header-img2.jpg' );
	?>
	<div class="post_banner">
	    <img src="<?php echo esc_url( $onepage_parallax_singlepost_bg_img ); ?>" alt="" class="img-fluid w-100">
	    <div class="container-fluid">
	        <div class="post_banner_desc pb-4">
	            <h1 class="text-white h3">
								<?php echo get_theme_mod( 'onepage_parallax_SPHImage_title', 'Blog' ); ?>
							</h1>
	        </div>
	    </div>
	</div>
	<?php
}

$onepage_parallax_single_post_sidebar_position = get_theme_mod( 'onepage_parallax_single_sidebar', 'right' );

if ( 'left' == $onepage_parallax_single_post_sidebar_position || 'right' == $onepage_parallax_single_post_sidebar_position  ) {
	$onepage_parallax_single_class = 'col-md-9';
} else {
	$onepage_parallax_single_class = 'col-12';
}
?>

<div <?php post_class( 'blog-single-post' ); ?> id="post-<?php the_ID(); ?>">
	<div class="container-fluid">
		<div class="row">
			<?php if ( 'left' == $onepage_parallax_single_post_sidebar_position ) : ?>
				<div class="col-md-3 onepage-parallax-sidebar">
					<?php
					if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
						dynamic_sidebar( 'sidebar-widget-area' );
					} else {
						get_sidebar();
					} ?>
				</div>
			<?php endif; ?>
		  <div class="<?php echo $onepage_parallax_single_class; ?>">
		    <?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/post/content', get_post_format() );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
		  </div> <!-- /.$onepage_parallax_single_class -->
			<?php if ( 'right' == $onepage_parallax_single_post_sidebar_position ) : ?>
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
