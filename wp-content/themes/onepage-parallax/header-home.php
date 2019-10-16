<?php
/**
* The header for template-home.php.
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.0
*/

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php wp_head(); ?>
</head>
<?php
	if ( 'enable' == get_theme_mod( 'onepage_parallax_page_animations', 'enable' ) ) {
		$onepage_parallax_animation_class = 'pleaseAnimate';
	} else {
		$onepage_parallax_animation_class = 'DontAnimate';
	}
  if ( checked( get_theme_mod( 'onepage_parallax_hero_visible', true ), true, false ) ) {
    $onepage_parallax_header_banner = '';
  } else {
    $onepage_parallax_header_banner = ' no-banner';
  }
	?>
<body id="home" <?php body_class($onepage_parallax_animation_class); ?> style='background:<?php echo esc_html( get_theme_mod( 'onepage_parallax_colors_background' ) ); ?>' data-spy="scroll" data-target="#navbarNav" data-offset="0">
  <header class="wpb_header<?php echo $onepage_parallax_header_banner; ?>">
    <div class="wpb_nav <?php if ( 'enable' == get_theme_mod( 'onepage_parallax_sticky_header', 'enable' ) ) { echo "makeMeSticky" ;} ?>" style="background:<?php echo esc_url( get_theme_mod( 'onepage_parallax_header_nav_bg_color' ) ); ?>">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
          <?php echo onepage_parallax_logo(); ?>
          <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse  justify-content-end" id="navbarNav">
            <?php wp_nav_menu(
              array(
                'theme_location' => 'onepage-parallax-front-menu',
                // 'menu_class' => 'navbar-nav',
                'menu_id' => 'onepage_parallax_menu',
                'container' => '',
              )
            ); ?>
          </div><!-- /.navbar-collapse -->
        </nav>
      </div><!-- /.container-fluid -->
    </div><!-- /.wpb_nav -->

    <?php

    if ( checked( get_theme_mod( 'onepage_parallax_hero_visible', true ), true, false ) ) {
      $onepage_parallax_header_img = has_header_image();
      $onepage_parallax_overlay = get_theme_mod( 'onepage_parallax_hero_color', '#000' );

      if ( checked( get_theme_mod( 'onepage_parallax_hero_parallex_visible', true ), true, false ) ) {
        $onepage_parallax_parallax = 'data-speed="5" data-type="background"';
      } else {
        $onepage_parallax_parallax = '';
      }

      $onepage_parallax_opacityVal = get_theme_mod( 'onepage_parallax_hero_opecity', '3' );
      if ( $onepage_parallax_opacityVal == 10 ) {
        $onepage_parallax_opacity = '1';
      } else {
        $onepage_parallax_opacity = "0.{$onepage_parallax_opacityVal}";
      }
      $onepage_parallax_default_heading_text = __( '<h1>Branding & creative digital solution</h1><p>Our website is under construction. We`ll be here soon with our new awesome site, subscribe to be notified.</p><a href="#" class="action-btn">Action Button</a><a href="#" class="fill-btn">Action Button2</a>', 'onepage-parallax' );

      $onepage_parallax_heading_text = get_theme_mod( 'onepage_parallax_hero_textarea', $onepage_parallax_default_heading_text );

      if( '' == get_theme_mod( 'onepage_parallax_hero_gradient0_color', '#9dc02e' ) ){
        $onepage_parallax_gradient_color1 = '#9dc02e';
      } else {
        $onepage_parallax_gradient_color1 = get_theme_mod( 'onepage_parallax_hero_gradient0_color' );
      }
      if( '' == get_theme_mod( 'onepage_parallax_hero_gradient1_color', '#b75595' ) ){
        $onepage_parallax_gradient_color2 = '#b75595';
      } else {
        $onepage_parallax_gradient_color2 = get_theme_mod( 'onepage_parallax_hero_gradient1_color' );
      }
      if( '' == get_theme_mod( 'onepage_parallax_hero_gradient2_color', '#3498db' ) ){
        $onepage_parallax_gradient_color3 = '#3498db';
      } else {
        $onepage_parallax_gradient_color3 = get_theme_mod( 'onepage_parallax_hero_gradient2_color' );
      }
      if( '' == get_theme_mod( 'onepage_parallax_hero_gradient3_color', '#e7a800' ) ){
        $onepage_parallax_gradient_color4 = '#e7a800';
      } else {
        $onepage_parallax_gradient_color4 = get_theme_mod( 'onepage_parallax_hero_gradient3_color' );
      }

      $onepage_parallax_slider_shortcode = get_theme_mod( 'onepage_parallax_hero_slider_shortcode' );

      $onepage_parallax_hero_type = get_theme_mod( 'onepage_parallax_hero_type', 'image' );

      if ( 'image' == $onepage_parallax_hero_type ) : ?>
      <div class="wpb_banner" <?php echo $onepage_parallax_parallax; ?> style="background-image:url(<?php header_image(); ?>">
        <div class="banner-overlayer" style="background-color:<?php echo $onepage_parallax_overlay; ?>; opacity:<?php echo $onepage_parallax_opacity; ?>;">
        </div>

      <?php elseif ( 'gradient-image' == $onepage_parallax_hero_type ) : ?>

        <div class="wpb_banner" <?php echo $onepage_parallax_parallax; ?> style="background-image:url(<?php header_image(); ?>">
          <div class="banner-overlayer" style="opacity:.6; background-color:<?php echo $onepage_parallax_gradient_color1; ?>; filter:progid:DXImageTransform.Microsoft.gradient(GradientType=1,startColorstr=<?php echo $onepage_parallax_gradient_color1; ?>, endColorstr=<?php echo $onepage_parallax_gradient_color2 ?>); background-image:-moz-linear-gradient(left, <?php echo $onepage_parallax_gradient_color1; ?> 0%, <?php echo $onepage_parallax_gradient_color2 ?> 25%,<?php echo $onepage_parallax_gradient_color3; ?> 50%,<?php echo $onepage_parallax_gradient_color4 ?> 100%);
          background-image:linear-gradient(left, <?php echo $onepage_parallax_gradient_color1; ?> 0%, <?php echo $onepage_parallax_gradient_color2 ?> 25%,<?php echo $onepage_parallax_gradient_color3; ?> 50%,<?php echo $onepage_parallax_gradient_color4 ?> 100%);
          background-image:-webkit-linear-gradient(left, <?php echo $onepage_parallax_gradient_color1; ?> 0%, <?php echo $onepage_parallax_gradient_color2 ?> 25%,<?php echo $onepage_parallax_gradient_color3; ?> 50%,<?php echo $onepage_parallax_gradient_color4 ?> 100%);
          background-image:-o-linear-gradient(left, <?php echo $onepage_parallax_gradient_color1; ?> 0%, <?php echo $onepage_parallax_gradient_color2 ?> 25%,<?php echo $onepage_parallax_gradient_color3; ?> 50%,<?php echo $onepage_parallax_gradient_color4 ?> 100%);
          background-image:-ms-linear-gradient(left, <?php echo $onepage_parallax_gradient_color1; ?> 0%, <?php echo $onepage_parallax_gradient_color2 ?> 25%,<?php echo $onepage_parallax_gradient_color3; ?> 50%,<?php echo $onepage_parallax_gradient_color4 ?> 100%);
          background-image:-webkit-gradient(linear, left bottom, right bottom, color-stop(0%,<?php echo $onepage_parallax_gradient_color1; ?>), color-stop(25%,<?php echo $onepage_parallax_gradient_color2 ?>),color-stop(50%,<?php echo $onepage_parallax_gradient_color3; ?>),color-stop(100%,<?php echo $onepage_parallax_gradient_color4 ?>));}
          "></div>
        <?php elseif ( 'gradient-color' == $onepage_parallax_hero_type ) : ?>

          <div class="wpb_banner"><div class="banner-overlayer" id="animated-gradient"></div>
        <?php elseif ( 'shortcode' == $onepage_parallax_hero_type ) : ?>
          <div class="wpb_banner">
            <?php
            if ( get_theme_mod( 'onepage_parallax_hero_slider_shortcode' ) ) :
              echo  do_shortcode( get_theme_mod( 'onepage_parallax_hero_slider_shortcode' ) );
              else :
                if ( is_customize_preview() ) {
                  echo "<p style='text-align:center;'>Please add shortcode for the slider in the field which is yet empty</p>";
                }
              endif;
              ?>
            <?php else : ?>
              <div class="header-top-sec">
                <div class="container">
                  <h1 class="brandLogo"  data-trans="pop"><a href="#"  title="<?php echo esc_attr__( 'OnePage Parallax', 'onepage-parallax' ); ?>"><img src="<?php echo esc_url( ONEPAGE_PARALLAX_DIR_URI . '/assets/images/logo.png' ); ?>" alt=""></a></h1>
                  <div class="top-search-form">
                    <?php get_search_form(); ?>
                  </div>
                </div>

              </div>
            <?php endif; ?>
            <?php if ( ( 'image' == $onepage_parallax_hero_type ) || ( 'gradient-color' == $onepage_parallax_hero_type ) || ( 'gradient-image' == $onepage_parallax_hero_type ) ) : ?>
              <div class="container-fluid">
                <div class="row text-center">
                  <div class="col-md-10 offset-md-1">
                    <?php echo $onepage_parallax_heading_text; ?>
                  </div>
                  <!--  .col-md-6 -->
                </div>
                <!--  .row -->
              </div>
            <?php endif; ?>
            <!--  .container-fluid -->

          </div>
          <?php
        } ?>
        <!--  .banner-wrapper -->
      </header>
