<?php
/**
* Single page home template.
* Template Name: Home Template
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 1.0.0
*/

get_header( 'home' );

$onepage_parallax_sections_reposition_mod = get_theme_mod( 'onepage_parallax_sections_reposition_settings' );
if ( ! empty( $onepage_parallax_sections_reposition_mod ) && has_action( 'onepage_parallax_reposition' ) ) :
  do_action( 'onepage_parallax_reposition' );
else:

  $onepage_parallax_sections = onepage_parallax_default_strings( 'home_temp', 'section' );

  foreach ( $onepage_parallax_sections as $onepage_parallax_section ) {

    if ( true == get_theme_mod( "onepage_parallax_{$onepage_parallax_section}_visible" ) ) {

      if ( 'portfolio' == $onepage_parallax_section ) {
        do_action( 'onepage_parallax_portfolio' );
      }
      if ( 'pricing' == $onepage_parallax_section ) {
        do_action( 'onepage_parallax_pricing' );
      }
      
      get_template_part( 'template-parts/home/content', $onepage_parallax_section );
    }
  }


endif;

if ( true == get_theme_mod( 'onepage_parallax_contact_visible' ) ) {
  get_template_part( 'template-parts/home/content', 'contactus' );
}

if ( true == get_theme_mod( 'onepage_parallax_gmap_visible') ) {
  do_action( 'onepage_parallax_gmap' );
} ?>

<?php get_footer(); ?>
