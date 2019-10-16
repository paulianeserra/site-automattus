<?php
/**
* Home page Subscriber content used for template-home.php
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.6
*/
?>
<div class="wpb_our_newsletter_section animJs" data-anim="slideUp">
  <?php if ( get_theme_mod( 'onepage_parallax_subscribe_shortcode' ) ) :
    echo do_shortcode( wp_kses_post( get_theme_mod( 'onepage_parallax_subscribe_shortcode' ) ) );
  else :
    if ( is_customize_preview() ) {
      echo "<p style='text-align:center;'>Please add mailchimp shortcode for scbscriber</p>";
    }
  endif; ?>
</div>
<!-- /.wpb_get_in_touch_section -->
