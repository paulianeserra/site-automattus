<?php
/**
 * OnePage Parallax offers filter hooks that allow to modify various types of internal data at runtime.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 1.0.6
 */

/**
 * filter for change the target property of the about us section block link.
 * @var string $target
 * @since 1.0.6
 */
add_filter( 'onepage_parallax_about_link_target', 'onepage_parallax_about_link_callback', 1 );
function onepage_parallax_about_link_callback( $target ){
  return $target;
}

/**
 * filter for change the button text of the about us section block.
 * @var string $text
 * @since 1.0.6
 */
add_filter( 'onepage_parallax_about_button_text', 'onepage_parallax_about_buttton_callback', 1 );
function onepage_parallax_about_buttton_callback( $text ){
  return $text;
}

/**
 * filter for change the excerpt of the about us section block.
 * @var string $excerpt
 * @since 1.0.6
 */
add_filter( 'onepage_parallax_about_excerpt', 'onepage_parallax_about_excerpt_callback', 1 );
function onepage_parallax_about_excerpt_callback( $excerpt ){
  return $excerpt;
}

/**
 * filter for change the excerpt of the service section block.
 * @var string $excerpt
 * @since 1.0.6
 */
add_filter( 'onepage_parallax_service_excerpt', 'onepage_parallax_service_excerpt_callback', 1 );
function onepage_parallax_service_excerpt_callback( $excerpt ){
  return $excerpt;
}

/**
 * filter for change the excerpt of the team section block.
 * @var string $excerpt
 * @since 1.0.6
 */
add_filter( 'onepage_parallax_team_excerpt', 'onepage_parallax_team_excerpt_callback', 1 );
function onepage_parallax_team_excerpt_callback( $excerpt ){
  return $excerpt;
}

/**
 * filter for change the CTA button link of the get in touch block.
 * @var string $link
 * @since 1.0.6
 */
add_filter( 'onepage_parallax_contact_button_link', 'onepage_parallax_contact_button_id_callback', 1 );
function onepage_parallax_contact_button_id_callback( $link ){
  return $link;
}
?>
