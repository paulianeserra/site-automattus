<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */

get_header();

$onepage_parallax_index_sidebar_position = get_theme_mod( 'onepage_parallax_blog_sidebar', 'right' );

if ( 'left' == $onepage_parallax_index_sidebar_position || 'right' == $onepage_parallax_index_sidebar_position ) {
 $onepage_parallax_index_class = 'col-md-9';
} else {
 $onepage_parallax_index_class = 'col-12';
}

 $onepage_parallax_blogpost_bg_img = esc_url( get_theme_mod( 'onepage_parallax_blog_header_image', ONEPAGE_PARALLAX_DIR_URI . 'assets/images/header-img.jpg' ) );
 $onepage_parallax_blogpost_heading = esc_html( get_bloginfo( 'name' ) );
 $onepage_parallax_blogpost_short_desc = esc_html( get_bloginfo( 'description' ) );

?>
<header class="blog-header" style="background-image:url(<?php echo $onepage_parallax_blogpost_bg_img; ?> ); background:<?php echo esc_url( get_theme_mod( 'onepage_parallax_header_bg_color' ) ); ?>">
  <div class="container blogimg">
    <?php if ( display_header_text() ): ?>
      <div class="blog-heading-inner">
        <h2 class="blogheader" style="color:<?php echo esc_url( get_theme_mod( 'onepage_parallax_header_title_color' ) ); ?>"><?php echo $onepage_parallax_blogpost_heading; ?></h2>
        <p class="blogtagline" style="color:<?php echo esc_url( get_theme_mod( 'onepage_parallax_header_title_color' ) ); ?>"><?php echo $onepage_parallax_blogpost_short_desc; ?></p>
      </div>
    <?php endif; ?>
  </div>
</header>
<div <?php post_class( 'blog-page' ); ?> id="post-<?php the_ID(); ?>">
	<div class="container-fluid">
   <div class="row">
  	 <?php if ( 'left' == $onepage_parallax_index_sidebar_position ) : ?>
   		<div class="col-md-3 onepage-parallax-sidebar">
   			<?php
        if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
          dynamic_sidebar( 'sidebar-widget-area' );
        } else {
          get_sidebar();
        } ?>
   		</div>
   	<?php endif; ?>
  	<div class="<?php echo $onepage_parallax_index_class; ?>">
  		<?php
  		if ( have_posts() ) :

  			while ( have_posts() ) :
  				the_post();

  				/*
  				 * Include the Post-Format-specific template for the content.
  				 * If you want to override this in a child theme, then include a file
  				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
  				 */

  				get_template_part( 'template-parts/post/content', get_post_format() );

  			endwhile;

  			// Display Pagination.
  			onepage_parallax_pagination();

  	 else :

  			get_template_part( 'template-parts/content', 'none' );

  	 endif;
  		?>
  	</div>

  	<?php if ( 'right' == $onepage_parallax_index_sidebar_position ) : ?>
  		<div class="col-md-3 onepage-parallax-sidebar">
  			<?php
        if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
          dynamic_sidebar( 'sidebar-widget-area' );
        } else {
          get_sidebar();
        } ?>
  		</div>
  	<?php endif; ?>


   </div>
 </div>
</div>
	<?php get_footer(); ?>
