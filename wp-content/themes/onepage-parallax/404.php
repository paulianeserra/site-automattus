<?php
/**
 * The template page for display 404 Pages.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 0.0.8
 */

get_header();
?>
<div class="wrapper-404">
	<div class="page404">
		<div class="container">
			<h1><?php esc_html_e( '404', 'onepage-parallax' ); ?></h1>
			<p><?php esc_html_e( 'Not Found', 'onepage-parallax' ); ?></p>
			<h3><?php esc_html_e( 'You are lost, But dont worry it happens to the best of us.', 'onepage-parallax' ); ?></h3>
			<div class="onepage-parallax-sidebar">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
