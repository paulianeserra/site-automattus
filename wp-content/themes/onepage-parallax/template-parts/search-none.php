<?php
/**
* The template for displaying archive pages.
*
* @package WordPress
* @subpackage OnePage Parallax
* @since 0.0.1
* @version 0.0.1
*/
?>
<div class="">

	<h2 class="onepage-parallax-search-result"><?php esc_html_e( 'No matches', 'onepage-parallax' ); ?></h2>

	<div class="onepage-parallax-sidebar">

		<p><?php esc_html_e( 'Please try again to find what you search for.', 'onepage-parallax' ); ?></p>

		<?php get_search_form(); ?>

	</div>

</div>
