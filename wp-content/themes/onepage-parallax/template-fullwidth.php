<?php
/**
 * The template for displaying full width single page.
 * Template Name: Fullwidth Template
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
?>
<div <?php post_class( 'container blog-single-page' ); ?> id="post-<?php the_ID(); ?>">
  <div class="row">
    <?php echo $onepage_parallax_page_title; ?>
    <div class="col-12">
      <?php
      	/* Start the Loop */
      	while ( have_posts() ) : the_post();

      		get_template_part( 'template-parts/page/content', 'page' );

      	endwhile; // End of the loop.
      	?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
