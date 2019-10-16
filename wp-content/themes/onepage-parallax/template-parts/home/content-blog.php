<?php
/**
* Home page Blog content used for template-home.php
*
* @package OnePage Parallax
* @since 0.0.1
* @version 1.0.6
*/

/**
* $onepage_parallax_blogpost_no Get number of post to show.
* $onepage_parallax_blogpost_char Get character lenght for excerpt post content.
*/
$onepage_parallax_blogpost_no    = esc_html( get_theme_mod( 'onepage_parallax_blog3', __( '4', 'onepage-parallax' ) ) );
$onepage_parallax_blogpost_char  = esc_html( get_theme_mod( 'onepage_parallax_blog4', __( '300', 'onepage-parallax' ) ) );
$onepage_parallax_blog_args = array(
  'post_type'           => 'post',
  'posts_per_page'      => $onepage_parallax_blogpost_no,
  'post_status'         => 'publish',
  'ignore_sticky_posts' => true,
  'no_found_rows'       => true,
);

/**
* $onepage_parallaxBlogQuery Geting posts.
*/
$onepage_parallaxBlogQuery = new WP_Query( $onepage_parallax_blog_args );

?>
<div class="wpb_our_blog_section section" id="blog">
  <div class="container-fluid">
    <div class="text-center mb-5 animJs" data-anim="slideUp">
      <h2><?php echo esc_html( get_theme_mod( 'onepage_parallax_blog1', __( 'Blog', 'onepage-parallax' ) ) ); ?></h2>
      <p class="display-4"><?php echo esc_html(  get_theme_mod( 'onepage_parallax_blog2', __( 'Our random ramblings', 'onepage-parallax' ) ) ); ?></p>
    </div>
    <div class="row">
      <?php
      if ( $onepage_parallaxBlogQuery->have_posts() ) :
        while ( $onepage_parallaxBlogQuery->have_posts() ) : $onepage_parallaxBlogQuery->the_post(); ?>

          <div class="col-md-6 animJs" data-anim="slideUp">
            <div class="random_post">
              <?php if ( has_post_thumbnail() ) : ?>
                <div class="post_img">
                  <img src="<?php echo esc_url( the_post_thumbnail_url( 'onepage-parallax-blog-thumb' ) ); ?>" alt="" class="img-fluid">
                  <a href="<?php the_permalink(); ?>" class="post_img_ovrlay"></a>
                </div>
              <?php endif; ?>
              <div class="post_caption">
                <h4 class="font-weight-bold">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
                <div class="blog-content">
                  <?php echo onepage_parallax_excerpt_max_charlength( $onepage_parallax_blogpost_char ); ?>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile;
        else : ?>
          <div class="col-md-6 blogPost">
            <p>
              <?php esc_html_e( 'Sorry, no posts matched your criteria.', 'onepage-parallax' ); ?>
            </p>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.wpb_blog -->
