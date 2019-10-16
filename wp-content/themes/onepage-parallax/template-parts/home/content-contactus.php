<?php
/**
* Home page Contact content used for template-home.php
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.0
*/

$onepage_parallax_contactus_textarea = '
<ul class="list-unstyled">
<li>
<h6>Address:</h6>
<p><strong>4699 Harvest Anchor Court, Beaukiss North Carolina, 27070-1683, US,</strong></p>
</li>
<li>
<h6>Phone:</h6>
<a href="tel:"><strong>(704) 806-9609</strong></a>
</li>
<li>
<h6>Email:</h6>
<a href="mailto:"><strong>hey@aemon.com</strong></a>
</li>
</ul>';
?>
<div class="wpb_contact_section bg-faded section" id="contact">
  <div class="container-fluid">
    <div class="text-center mb-5 animJs" data-anim="slideUp">
      <h2><?php echo esc_html( get_theme_mod( 'onepage_parallax_contact_title', 'Get In Touch' ) ); ?></h2>
      <p class="display-4"><?php echo esc_html( get_theme_mod( 'onepage_parallax_contact_subtitle', "Let's Have A Chat" ) ); ?></p>
    </div>
    <div class="row">
      <div class="col-lg-4 wpb_address_info animJs" data-anim="slideUp">
        <?php
        $onepage_parallax_contact_mod = get_theme_mod( 'onepage_parallax_contact_textarea', $onepage_parallax_contactus_textarea );
        echo wp_kses_post( $onepage_parallax_contact_mod ); ?>
      </div>
      <div class="col-lg-8 wpb_contact_form animJs" data-anim="slideUp">
        <?php
        if ( get_theme_mod( 'onepage_parallax_contact_shortcode' ) ) :
          echo  do_shortcode( wp_kses_post( get_theme_mod( 'onepage_parallax_contact_shortcode' ) ) );
          else :
            if ( is_customize_preview() ){
              echo "<p style='text-align:center;'>Please add contact-form-7 shortcode</p>";
            }
          endif;
          ?>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.wpb_getintouch -->
