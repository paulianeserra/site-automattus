<?php
/**
* Home page Our Team content used for template-home.php
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.6
*/
$onepage_parallax_team_mod = get_theme_mod( 'onepage_parallax_team_items' );
?>
<div class="wpb_ourteam" id="our-team">
  <div class="text-center mb-5">
    <h2 class="animJs" data-anim="slideUp">
      <?php echo esc_html( get_theme_mod( 'onepage_parallax_team_title', __( 'Our team', 'onepage-parallax' ) ) ); ?>
    </h2>
    <p class="display-4 animJs" data-anim="slideUp">
      <?php echo esc_html( get_theme_mod( 'onepage_parallax_team_subtitle', __( 'We are amazing and we know it' , 'onepage-parallax' ) ) ); ?>
    </p>
    <div class="wpb_aemon-team-slider animJs" data-anim="slideUp">
      <?php
      if ( ! empty( $onepage_parallax_team_mod ) ) {

        $onepage_parallax_repeater_team         = get_theme_mod( 'onepage_parallax_team_items' );
        $onepage_parallax_repeater_team_decoded = json_decode( $onepage_parallax_repeater_team );
        if ( isset( $onepage_parallax_repeater_team ) ) :

          global $post;
          foreach ( $onepage_parallax_repeater_team_decoded as $onepage_parallax_team_item ) :

            if ( !empty( $onepage_parallax_team_item->pages ) && 'NULL' != $onepage_parallax_team_item->pages ) {

              $post = get_post( $onepage_parallax_team_item->pages ); // WPCS: override ok.
              setup_postdata( $post );
              $onepage_parallax_team_title   = get_the_title();
              $onepage_parallax_team_content = get_the_excerpt();
            } else {

              $onepage_parallax_team_title   = '';
              $onepage_parallax_team_content = '';
            }
            ?>
            <div class="item">
              <?php if ( 'on' == $onepage_parallax_team_item->pages_image ) : ?>
                <?php the_post_thumbnail( 'onepage-parallax-teamwork' ); ?>
              <?php endif; ?>
              <div class="slider_inner_content">
                <h3>
                  <?php if ( ! empty( $onepage_parallax_team_item->pages_title ) && 'on' == $onepage_parallax_team_item->pages_title ) {
                    echo esc_html( $onepage_parallax_team_title );
                  } ?>
                </h3>
                <h4>
                  <?php echo esc_html ( $onepage_parallax_team_item->subtitle ); ?>
                </h4>
                <div class="team-detail">
                  <?php echo apply_filters( 'onepage_parallax_team_excerpt', wp_kses_post( $onepage_parallax_team_content ) ); ?>
                </div>
                <?php
                $onepage_parallax_social_repeater = json_decode( html_entity_decode( $onepage_parallax_team_item->social_repeater ) );
                if ( isset( $onepage_parallax_social_repeater ) ) :
                  foreach ( $onepage_parallax_social_repeater as $onepage_parallax_social_repeater ) : ?>
                  <a href="<?php echo esc_url( $onepage_parallax_social_repeater->link ); ?>">
                    <i class="<?php echo esc_attr( $onepage_parallax_social_repeater->icon );?>" aria-hidden="true"></i>
                  </a>
                <?php endforeach;
                endif;
                ?>
              </div>
            </div>
          <?php endforeach;
          wp_reset_postdata();
        endif; ?>
      <?php } ?>
    </div>
    <!--  .wpb_aemon-team-slider -->
  </div>
</div>
<!-- /.wpb_ourteam -->
