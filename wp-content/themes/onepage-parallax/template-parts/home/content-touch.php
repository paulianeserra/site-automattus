<?php
/**
* Home page Get in Touch content used for template-home.php
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.6
*/

$onepage_parallax_get_in_touch      = onepage_parallax_default_strings( 'home_temp', 'get_in_touch' );
$onepage_parallax_getintouch_text_0 = esc_html ( get_theme_mod( 'onepage_parallax_touch_title', $onepage_parallax_get_in_touch['0'] ) );
$onepage_parallax_getintouch_text_1 = esc_html ( get_theme_mod( 'onepage_parallax_touch_number_2', $onepage_parallax_get_in_touch['1'] ) );
$onepage_parallax_getintouch_text_2 = esc_html ( get_theme_mod( 'onepage_parallax_touch_number_3', $onepage_parallax_get_in_touch['2'] ) );
$onepage_parallax_getintouch_text_3 = esc_html ( get_theme_mod( 'onepage_parallax_touch_number_4', $onepage_parallax_get_in_touch['3'] ) );
$onepage_parallax_getintouch_text_4 = esc_html ( get_theme_mod( 'onepage_parallax_touch_number_5', $onepage_parallax_get_in_touch['4'] ) );
?>
<div class="wpb_get_in_touch_section animJs" data-anim="slideUp">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 text-center get_in_touch_hdng">
        <h4 class="display-2 text-white text-uppercase font-weight-normal m-0">
          <span class="d-block display-1 text-white">
            <?php echo $onepage_parallax_getintouch_text_0; ?>
          </span>
          <?php echo $onepage_parallax_getintouch_text_1; ?>
        </h4>
      </div>
      <div class="col-lg-9 get_in_touch_sec">
        <div class="row no-gutters">
          <div class="col-lg-6 pt-3">
            <span class="call_us text-white">
              <?php echo $onepage_parallax_getintouch_text_2; ?>
            </span>
            <a href="tel:<?php echo $onepage_parallax_getintouch_text_3; ?>" class="d-block text-white font-weight-bold cell_no"><?php echo $onepage_parallax_getintouch_text_3; ?></a>
          </div>
          <div class="col-lg-2 pt-3">
            <span class="m-auto text-center rounded-circle or d-block text-white"><?php esc_html_e( 'Or', 'onepage-parallax' ) ?></span>
          </div>
          <div class="col-8 col-md-4 pt-3 m-auto">
            <a href="<?php echo apply_filters( 'onepage_parallax_contact_button_link', "#contact" ); ?>"><button class="btn msg_btn w-100 text-white font-weight-bold py-3"><?php echo $onepage_parallax_getintouch_text_4; ?></button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.wpb_get_in_touch_section -->
