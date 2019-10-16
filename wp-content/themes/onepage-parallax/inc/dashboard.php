<?php
/**
 * Add theme dashboard page
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */

add_action( 'admin_menu', 'onepage_parallax_theme_info' );
function onepage_parallax_theme_info() {
	$theme_data = wp_get_theme();
	add_theme_page( sprintf( esc_html__( '%s Dashboard', 'onepage-parallax' ), $theme_data->Name ), sprintf( esc_html__( '%s Theme', 'onepage-parallax' ), $theme_data->Name ), 'edit_theme_options', 'OnePage_Parallax', 'onepage_parallax_theme_info_page' );
}

/**
 * Enqueue script
 */


function onepage_parallax_theme_info_page() {

	$theme_data = wp_get_theme();

	?>
	<div class="wrap about-wrap theme_info_wrapper">
		<h1><?php printf( esc_html__( '%1$1s - Version %2$2s', 'onepage-parallax' ), esc_html( $theme_data->Name ), esc_html( $theme_data->Version ) ); ?></h1>
		<div class="about-text"><?php esc_html_e( 'Onepage Parallax is a Multipurpose OnePage WordPress theme can be used to build websites for Freelancers, Creative Agencies, Small Businesses, Product Showcase, Personal Portfolio, Selling Digital Goods.', 'onepage-parallax' ); ?></div>
		<a target="_blank" href="<?php echo esc_url( 'https://wpbrigade.com' ); ?>" class="wpbrigade-themes-badge wp-badge"><span> <?php echo esc_html('WPBrigade'); ?> </span></a>
		<h2 class="nav-tab-wrapper">
			<a href="#info-tab-content_a" class="nav-tab nav-tab-active dnav_tab_a"><?php esc_html_e( 'Getting Started', 'onepage-parallax' ); ?></a>

		</h2>

		<div class="theme_info active" id="info-tab-content_a">
			<div class="theme_info_column clearfix">
				<div class="theme_info_left">

					<div class="theme_link">
						<h3><?php esc_html_e( 'Installation Steps', 'onepage-parallax' ); ?></h3>
						<p class="about"><?php printf( esc_html__( 'Step 1. ', 'onepage-parallax' ) ); ?><a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install Recommended Plugins', 'onepage-parallax' ); ?></a></p>
						<p class="about"> <?php esc_html_e( 'Step 2. ', 'onepage-parallax' ); ?><a href="<?php echo esc_url( 'https://wpbrigade.com/docs-article/import-demo-content-wordpress-themes/' ); ?>" target="_blank" class="button button-primary"><?php esc_html_e( 'Import Demo Content', 'onepage-parallax' ); ?></a></p>
						<p class="info-tab-image">
							<?php printf( esc_html__( 'Step 3. ', 'onepage-parallax' ), esc_html( $theme_data->Name ) ); ?><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Happy Customizing', 'onepage-parallax' ); ?></a>
						</p>
					</div>

					<div class="theme_link">
						<h3><?php esc_html_e( 'Theme Documentation', 'onepage-parallax' ); ?></h3>
						<p class="about"><?php printf( esc_html__( 'Need any help to setup and configure %s? Please have a look at our documentations instructions.', 'onepage-parallax' ), esc_html( $theme_data->Name ) ); ?></p>
						<p>
							<a href="<?php echo esc_url( 'https://wpbrigade.com/docs-article/onepage-parallax-wordpress-theme-documentation/' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Online Documentation', 'onepage-parallax' ); ?></a>
						</p>
					</div>

					<div class="theme_link">
						<h3><?php esc_html_e( 'Theme Support', 'onepage-parallax' ); ?></h3>
						<p class="about"><?php printf( esc_html__( 'If there is something not in our Theme docs, contact us. Happy to help !!', 'onepage-parallax' ), esc_html( $theme_data->Name ) ); ?></p>
						<p>
							<a href="<?php echo esc_url( 'https://wpbrigade.com/contact/' ); ?>" target="_blank" class="button button-secondary"><?php esc_html_e( 'Create Theme Support Ticket', 'onepage-parallax' ); ?></a>
						</p>
					</div>

				</div>

				<div class="theme_info_right">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>"  alt="Theme Screenshot" />
				</div>

			</div>
		</div>

	</div> <!-- END .theme_info -->

<?php
}
?>
