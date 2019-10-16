<?php
/**
* Home page Services content used for template-home.php
*
* @package OnePage Parallax
* @since 0.0.1
* @version 1.0.6
*/

if ( 'col-4' == get_theme_mod( 'onepage_parallax_service_column', 'col-4' ) ) :
  $onepage_parallax_service_tr_class = 'col-sm-6 col-lg-3';
elseif( 'col-3' == get_theme_mod( 'onepage_parallax_service_column' ) ) :
  $onepage_parallax_service_tr_class = 'col-sm-6 col-lg-4';
elseif( 'col-2' == get_theme_mod( 'onepage_parallax_service_column' ) ) :
  $onepage_parallax_service_tr_class = 'col-sm-6';
endif;

$onepage_parallax_service_mod = get_theme_mod( 'onepage_parallax_service_items' );
?>

<div class="wpb_services bg-faded more_padding section" id="services">
  <div class="container-fluid">
    <div class="text-center mb-5 animJs" data-anim="slideUp">
      <h2>
        <?php echo esc_html( get_theme_mod( 'onepage_parallax_service_title', __( 'Services', 'onepage-parallax' ) ) ); ?>
      </h2>
      <p class="display-4">
        <?php echo esc_html( get_theme_mod( 'onepage_parallax_service_subtitle', __( 'What can we help you with?', 'onepage-parallax' ) ) ); ?>
      </p>
    </div>
    <div class="row">
      <?php if ( ! empty( $onepage_parallax_service_mod ) ) :

        $onepage_parallax_repeater_services         = get_theme_mod( 'onepage_parallax_service_items' );
        $onepage_parallax_repeater_services_decoded = json_decode( $onepage_parallax_repeater_services );
        if ( isset( $onepage_parallax_repeater_services ) ) :

          global $post;
          $onepage_parallax_service_count = 0;

          foreach ( $onepage_parallax_repeater_services_decoded as $onepage_parallax_item_services ) :

            $onepage_parallax_service_count++;
            if ( !empty( $onepage_parallax_item_services->pages ) && 'NULL' != $onepage_parallax_item_services->pages ) {

              $post = get_post( $onepage_parallax_item_services->pages ); // WPCS: override ok.
              setup_postdata( $post );
              $onepage_parallax_services_title   = get_the_title();
              $onepage_parallax_services_content = get_the_excerpt();
            } else {

              $onepage_parallax_services_title   = '';
              $onepage_parallax_services_content = '';
            } ?>
            <div class="<?php echo $onepage_parallax_service_tr_class; ?> animJs" data-anim="slideUp">
              <div class="service_box">
                <?php if ( 'on' == $onepage_parallax_item_services->pages_image ) : ?>
                  <?php the_post_thumbnail( 'onepage-parallax-services-thumb', array('class' => 'service-img service_icon') ); ?>
                <?php else : ?>
                  <span class="<?php echo $onepage_parallaxServClasses[ intval( $onepage_parallax_service_count ) - 1 ]; echo ' onepage_parallax_services_ico_' . $onepage_parallax_service_count; ?>" data-trans="<?php echo $onepage_parallaxServDataTrans[ intval( $onepage_parallax_service_count ) - 1 ]; ?>" ></span>
                <?php endif; ?>

                <div class="service_txt">
                  <?php if ( !empty( $onepage_parallax_item_services->pages_title ) && 'on' == $onepage_parallax_item_services->pages_title ) { ?>
                    <h4 class="font-weight-bold"><?php echo esc_html( $onepage_parallax_services_title ); ?></h4>
                  <?php } ?>
                  <div class="service-content">
                    <?php echo apply_filters( 'onepage_parallax_service_excerpt', $onepage_parallax_services_content ); ?>
                  </div>
                </div>
              </div>
            </div>
            <?php
            if ( $onepage_parallax_service_count > 3 ) {
              $onepage_parallax_service_count = 0;
            }
          endforeach;
          wp_reset_postdata();
        endif;
      endif; ?>
    </div>
  </div><!-- /.container-fluid -->
</div><!-- /.wpb_services -->
