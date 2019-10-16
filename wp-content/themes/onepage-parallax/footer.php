<?php
/**
* The template for displaying the footer
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.0
*/

$onepage_parallax_FooterSMClass = onepage_parallax_default_strings( 'footer', 'socialmedia_class' );
?>
<footer class="wpb_footer">
  <div class="container-fluid">
    <ul class="social_nav text-center list-unstyled section">
      <?php
      $onepage_parallax_footer_count = 0;
      while ( $onepage_parallax_footer_count < 6 ) :

        $onepage_parallax_footer_count++;
        $onepage_parallax_footer_mod = get_theme_mod( "onepage_parallax_footer_{$onepage_parallax_footer_count}");

        if ( ! empty( $onepage_parallax_footer_mod ) ) : ?>
        <li><a href="<?php echo esc_url( get_theme_mod( "onepage_parallax_footer_{$onepage_parallax_footer_count}" ) ); ?>" class="<?php echo $onepage_parallax_FooterSMClass[ intval( $onepage_parallax_footer_count ) - 1 ]; ?>"></a></li>
        <?php
      endif;
    endwhile;
    ?>
  </ul>

</div><!-- /.container-fluid -->
<div class="wpb_copy_right py-4 bg-inverse" style="background: <?php echo esc_html( get_theme_mod( 'onepage_parallax_colors_footer_bg' ) ); ?>">
  <div class="container-fluid">
    <div class="row">
      <?php onepage_parallax_footer(); ?>
    </div>
  </div><!-- /.container-fluid -->
</div><!-- /.wpb_copy_right -->
</footer><!-- /.wpb_footer -->
<?php if ( 'enable' == get_theme_mod( 'onepage_parallax_global_totop', 'enable' ) ) {

			?> <a href="#" class="btn gotop"><i class="fas fa-chevron-up" aria-hidden="true"></i></a> <?php
		} ?>
<?php wp_footer(); ?>
</body>

</html>
