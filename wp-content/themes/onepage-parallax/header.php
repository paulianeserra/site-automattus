<?php
/**
* The header for our theme.
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
	?>
<body id="home" <?php body_class($onepage_parallax_animation_class); ?> style='background:<?php echo esc_html( get_theme_mod( 'onepage_parallax_colors_background' ) ); ?>' data-spy="scroll" data-target="#navbarNav" data-offset="0">
  <header class="wpb_header formal_header" style="background:<?php echo esc_url( get_theme_mod( 'onepage_parallax_header_bg_color', '#000' ) ); ?>">
    <!-- <div class="header_top container-fluid">
    <div class="row pt-4 pb-5">
    <div class="col-md-4">
    <a href="" id="logo" class="d-block"><img src="assets/images/one_page_parallax_black.svg" alt="onePage Parallax"></a>
  </div>
  <div class="col-md-4 offset-md-4">
  <form action="" class="search_form">
  <input type="search" class="form-control" placeholder="Search">
</form>
</div>
</div>
</div> -->

<div class="wpb_nav  <?php if ( 'enable' == get_theme_mod( 'onepage_parallax_sticky_header', 'enable' ) ) { echo "makeMeSticky" ;} ?>">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg">
      <?php echo onepage_parallax_logo(); ?>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse  justify-content-end" id="navbarNav">
        <?php wp_nav_menu(
          array(
            'theme_location' => 'subpage-menu',
            // 'menu_class' => 'navbar-nav',
            'menu_id' => 'onepage_parallax_menu',
            'container' => '',
          )
        ); ?>
      </div>
    </nav>
  </div>
</div>
<!-- /.wpb_nav -->
</header>
