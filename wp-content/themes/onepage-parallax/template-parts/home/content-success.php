<?php
/**
* Home page Success content used for template-home.php
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.6
*/

$onepage_parallax_success_class = onepage_parallax_default_strings( 'home_temp', 'success_class' );
$onepage_parallax_success_img   = onepage_parallax_default_strings( 'home_temp', 'success_image' );
$onepage_parallax_success_mod   = get_theme_mod( 'onepage_parallax_seccuss_items' ); ?>

<div class="wpb_goals section" data-speed="10">
  <div class="container-fluid">
    <div class="row no-gutters">
      <?php
      if ( ! empty( $onepage_parallax_success_mod ) ) {

        $onepage_parallax_repeater_success         = get_theme_mod( 'onepage_parallax_seccuss_items' );
        $onepage_parallax_repeater_success_decoded = json_decode( $onepage_parallax_repeater_success );
        if ( isset( $onepage_parallax_repeater_success ) ) :

          $onepage_parallax_success_count = 0;
          foreach ( $onepage_parallax_repeater_success_decoded as $onepage_parallax_item_success ) :

            $onepage_parallax_success_count++;
            $onepage_parallax_item_success_strip = $onepage_parallax_item_success->title;
            preg_match_all('!\d+!', $onepage_parallax_item_success_strip,  $item_strip_res);
            $onepage_parallax_item_success_num = implode('',  $item_strip_res[0]);
            ?>
            <div class="col-md-6 col-lg-3 animJs" data-anim="slideUp">
              <div class="goal_sec-1">
                <p class="display-1" data-count="<?php echo esc_html( $onepage_parallax_item_success->title ); ?>"><?php echo esc_html( $onepage_parallax_item_success->title ); ?></p>
                <h4>
                  <?php echo wp_kses( $onepage_parallax_item_success->subtitle , array(
                      'br'     => array(),
                      'strong' => array(),
                      'b'      => array(),
                      'em'     => array(),
                      'i'      => array(),
                    ) ); ?>
                </h4>
              <div class="rounded-circle m-auto goal_circle_sec">
                <?php if ( ! empty( $onepage_parallax_item_success->image_url ) ) { ?>
                  <img src="<?php echo esc_url( $onepage_parallax_item_success->image_url ); ?> ">
                <?php } else { ?>
                  <img src="<?php echo esc_url( $onepage_parallax_success_img[ $onepage_parallax_success_count - 1 ] ); ?>" alt="">
                <?php } ?>
              </div>
            </div>
          </div>
          <?php
          if ( $onepage_parallax_success_count > 3 ) {
            $onepage_parallax_success_count = 0;
          }
        endforeach;
      endif;
    }
    ?>
  </div>
</div>
<!-- /.container-fluid -->
</div>
