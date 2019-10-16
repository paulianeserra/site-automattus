<?php
/**
* Home page About us content used for template-home.php
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.6
*/
$onepage_parallax_aboutus_class = onepage_parallax_default_strings( 'home_temp', 'about_class' );
$onepage_parallax_aboutus_cdata = onepage_parallax_default_strings( 'home_temp', 'about_class_data' );

if ( 'col-4' == get_theme_mod( 'onepage_parallax_about_column', 'col-4' ) ) :
  $onepage_parallax_aboutus_tr_class = 'col-sm-6 col-lg-3';
elseif( 'col-3' == get_theme_mod( 'onepage_parallax_about_column' ) ) :
  $onepage_parallax_aboutus_tr_class = 'col-sm-6 col-lg-4';
elseif( 'col-2' == get_theme_mod( 'onepage_parallax_about_column' ) ) :
  $onepage_parallax_aboutus_tr_class = 'col-sm-6';
endif;

$onepage_parallax_aboutus_mod         = get_theme_mod( 'onepage_parallax_about_items' );
$onepage_parallax_about_button_target = 'target ="_blank"';
$onepage_parallax_about_button_text   = esc_html__( 'find out more', 'onepage-parallax' );
?>
<div class="wpb_about section" id="about-us">
  <div class="container-fluid">
    <div class="wpb_abt_hd animJs" data-anim="slideUp">
      <h2>
        <?php echo esc_html( get_theme_mod( 'onepage_parallax_about_title', esc_html__( 'About Us', 'onepage-parallax' ) ) ); ?>
      </h2>
      <p class="display-4">
        <?php echo esc_html( get_theme_mod( 'onepage_parallax_about_subtitle', esc_html__( 'Who are we and what are we doing', 'onepage-parallax' ) ) ); ?>
      </p>
    </div>
    <div class="row no-gutters">
      <?php
      if ( ! empty( $onepage_parallax_aboutus_mod ) ) {

        $onepage_parallax_repeater_about           = get_theme_mod( 'onepage_parallax_about_items' );
        $onepage_parallax_repeater_aboutus_decoded = json_decode( $onepage_parallax_aboutus_mod );
        if ( isset( $onepage_parallax_repeater_about ) ) :
          global $post;
          $onepage_parallax_about_count = 0;

          foreach ( $onepage_parallax_repeater_aboutus_decoded as $onepage_parallax_about_item ) :
            $onepage_parallax_about_count++;

            if ( !empty( $onepage_parallax_about_item->pages ) && 'NULL' != $onepage_parallax_about_item->pages ) {

              $post = get_post( $onepage_parallax_about_item->pages ); // WPCS: override ok.
              setup_postdata( $post );
              $onepage_parallax_about_title           = get_the_title();
              $onepage_parallax_about_content         = get_the_excerpt();
              $onepage_parallax_repeater_aboutus_link = get_permalink();
            } else {

              $onepage_parallax_about_title           = '';
              $onepage_parallax_about_content         = '';
              $onepage_parallax_repeater_aboutus_link = '';
            }
            ?>
            <div class="<?php echo $onepage_parallax_aboutus_tr_class; ?> about_items animJs"  data-anim="slideUp">

              <div class="abt_sec-1">
                <?php if ( 'on' == $onepage_parallax_about_item->pages_image ) { ?>
                  <div class="abt_imgs">
                    <?php the_post_thumbnail( 'onepage-parallax-aboutus-thumb', array( 'class' => 'about-img' ) ); ?>
                  </div>
                <?php } else { ?>
                  <div class="<?php echo $onepage_parallax_aboutus_class[ $onepage_parallax_about_count - 1 ]; ?>" data-class="<?php echo $onepage_parallax_aboutus_cdata[ $onepage_parallax_about_count - 1 ]; ?>" id="<?php echo 'onepage_parallax_aboutus_id_' . $onepage_parallax_about_count; ?>" >
                  </div>
                <?php } ?>

                <h4 class="display-4">
                  <?php if ( !empty ( $onepage_parallax_about_item->subtitle ) ) { echo esc_html( $onepage_parallax_about_item->subtitle ); } ?>
                </h4>
                <?php if ( ! empty( $onepage_parallax_about_item->pages_title ) && 'on' == $onepage_parallax_about_item->pages_title ) { ?>
                  <h3><?php echo esc_html( $onepage_parallax_about_title ); ?></h3>
                <?php } ?>
                <p class="<?php echo 'aboutus_disc' . $onepage_parallax_about_count; ?>">
                  <?php echo apply_filters( 'onepage_parallax_about_excerpt', $onepage_parallax_about_content ); ?>
                </p>
              </div>

              <?php if ( !empty( $onepage_parallax_about_item->pages_link ) && 'on' == $onepage_parallax_about_item->pages_link ) { ?>
                <a href="<?php echo esc_url( $onepage_parallax_repeater_aboutus_link ); ?>" <?php echo apply_filters( 'onepage_parallax_about_link_target', $onepage_parallax_about_button_target ); ?> class="find_more_btn"> <?php echo apply_filters( 'onepage_parallax_about_button_text', $onepage_parallax_about_button_text ); ?> </a>
              <?php  } ?>

            </div>
            <?php
            if ( $onepage_parallax_about_count > 3 ) {
              $onepage_parallax_about_count = 0;
            }
          endforeach;
        wp_reset_postdata();
      endif; }
      ?>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
    <!-- /.wpb_about -->
