<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */

?>
<div class="onepage-parallax-post">

	<h1 class=""><?php esc_html_e( 'No matches', 'onepage-parallax' ); ?></h1>

	<div class="">

		<p><?php esc_html_e( 'Please try again to find what you search for.', 'onepage-parallax' ); ?></p>

		<?php get_search_form(); ?>

	</div>

</div>
