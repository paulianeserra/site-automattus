<?php
/**
 * The template for displaying all single page.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */

get_header(); ?>

<?php
if ( checked( get_theme_mod( 'onepage_parallax_SPageHImage_visible', true ), true, false ) ) {
	$onepage_parallax_singlepost_bg_img = get_theme_mod( 'onepage_parallax_page_header_image', ONEPAGE_PARALLAX_DIR_URI . 'assets/images/header-img2.jpg' );
	?>
	<div class="post_banner">
	    <img src="<?php echo esc_url( $onepage_parallax_singlepost_bg_img ); ?>" alt="" class="img-fluid w-100">
	    <div class="container-fluid">
	        <div class="post_banner_desc pb-4">
	            <h1 class="text-white h3">
								<?php the_title(); ?>
							</h1>
	        </div>
	    </div>
	</div>
	<?php
	$onepage_parallax_page_title = '';
} else {
	$onepage_parallax_page_title = '<header class="post-header"><h2 class="entry-title">' . get_the_title() . '</h2></header>';
}

$onepage_parallax_page_sidebar_position = get_theme_mod( 'onepage_parallax_page_sidebar', 'right' );
if ( 'left' == $onepage_parallax_page_sidebar_position || 'right' == $onepage_parallax_page_sidebar_position ) {
	$onepage_parallax_page_class = 'col-md-9';
} else {
	$onepage_parallax_page_class = 'col-12';
}
?>

<div <?php post_class( 'blog-single-page' ); ?> id="post-<?php the_ID(); ?>">
	<div class="container-fluid">
    <?php echo $onepage_parallax_page_title; ?>
		<div class="row">
			<?php if ( 'left' == $onepage_parallax_page_sidebar_position ) : ?>
				<div class="col-md-3 onepage-parallax-sidebar">
					<?php
					if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
						dynamic_sidebar( 'sidebar-widget-area' );
					} else {
						get_sidebar();
					} ?>
				</div>
			<?php endif; ?>
		  <div class="<?php echo $onepage_parallax_page_class; ?>">
		    <?php
				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/page/content', 'page' );

				endwhile; // End of the loop.
				?>
		  </div> <!-- /.$onepage_parallax_page_class -->
			<?php if ( 'right' == $onepage_parallax_page_sidebar_position ) : ?>
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
</div><!-- /.blog-single-page -->
<?php get_footer(); ?>
