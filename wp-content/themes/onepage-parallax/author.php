<?php
/**
* The template for displaying author pages.
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.0
*/

get_header();
?>

<?php
$onepage_parallax_author_sidebar_position = get_theme_mod( 'onepage_parallax_author_sidebar', 'right' );

if ( 'left' == $onepage_parallax_author_sidebar_position || 'right' == $onepage_parallax_author_sidebar_position ) {
  $onepage_parallax_author_class = 'col-md-9';
} else {
  $onepage_parallax_author_class = 'col-12';
}
?>
<div <?php post_class( 'author-page' ); ?> id="post-<?php the_ID(); ?>">
  <div class="container-fluid">
    <div  class="row">
      <?php if ( 'left' == $onepage_parallax_author_sidebar_position ) : ?>
        <div class="col-md-3 onepage-parallax-sidebar">
          <?php
					if ( is_active_sidebar( 'sidebar-widget-area' ) ) {
						dynamic_sidebar( 'sidebar-widget-area' );
					} else {
						get_sidebar();
					} ?>
        </div>
      <?php endif; ?>

      <div class="<?php echo $onepage_parallax_author_class; ?>">
        <div class="author-section">
          <?php onepage_parallax_author_fullname(); ?>
          <?php onepage_parallax_short_about_author(); ?>
          <h4> <?php echo sprintf( 'Posts by %1$s:' , esc_html( get_the_author() ) );  ?> </h4>
          <div class="author-posts">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

              <?php get_template_part( 'template-parts/page/content', 'author' ); ?>

            <?php endwhile; ?>
          </div>
          <?php
          // Display Pagination.
          onepage_parallax_pagination(); ?>

        <?php else : ?>
          <p><?php esc_html_e( 'No posts by this author.', 'onepage-parallax' ); ?></p>
        <?php endif; ?>
      </div>
    </div>

    <?php if ( 'right' == $onepage_parallax_author_sidebar_position ) : ?>
      <di class="col-md-3 onepage-parallax-sidebar">
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
