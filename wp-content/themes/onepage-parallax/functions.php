<?php
/**
 * OnePage Parallax functions and definitions.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.6
 */

	/**
	 * Creating constant for the theme relative path.
	 * @since 0.0.1
	 */
	if ( ! defined( 'ONEPAGE_PARALLAX_DIR_URI' ) ) {
		define( 'ONEPAGE_PARALLAX_DIR_URI', get_template_directory_uri() . '/' );
	}

	/**
	 * Creating constant for the theme absolute path.
	 * @since 0.0.1
	 */
	if ( ! defined( 'ONEPAGE_PARALLAX_DIR' ) ) {
		define( 'ONEPAGE_PARALLAX_DIR', get_template_directory() . '/' );
	}

	/**
	 * Get theme Version for use it in enqueue function.
	 * @return string.
	 * @since 0.0.3
	 */
	function onepage_parallax_version() {

		$theme_data = wp_get_theme();
		return esc_html( $theme_data->Version );
	}

	/**
	* OnePage Parallax functions and definitions
	* @since 1.0.0
	*/

	add_action( 'wp_enqueue_scripts', 'onepage_parallax_scripts_styles' );
	/**
	* Enqueue Google Fonts on Front End
	* @since 1.0.0
	*/
	function onepage_parallax_scripts_styles() {
		wp_enqueue_style( 'onepage-parallax-fonts', "https://fonts.googleapis.com/css?family=Playfair+Display:400|Source+Sans+Pro:300,400,600,700,900", array(), null );
	}

	add_action( 'admin_print_styles-appearance_page_custom-header', 'onepage_parallax_custom_header_fonts' );
	/**
	* Enqueue Google Fonts on Custom Header Page
	*
	* @since 1.0.0
	*/
	function onepage_parallax_custom_header_fonts() {
		wp_enqueue_style( 'onepage-parallax-fonts', "https://fonts.googleapis.com/css?family=Playfair+Display:400|Source+Sans+Pro:300,400,600,700,900", array(), null );
	}

	add_action( 'wp_enqueue_scripts', 'onepage_parallax_styles' );

	/**
	 * Enqueuing styles for OnePage Parallax.
	 * @since 0.0.1
	 * @version 1.0.0
	 */
	function onepage_parallax_styles() {

		wp_enqueue_style( 'fa-brands', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fa-brands.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'fa-solid', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fa-solid.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'fa-regular', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fa-regular.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'font-awesome', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fontawesome.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'onepage_parallax_style', ONEPAGE_PARALLAX_DIR_URI . 'style.css', array(), onepage_parallax_version() );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {

			wp_enqueue_script( 'comment-reply' );
		}

		$onepage_parallax_header_mod_bg = esc_url( get_theme_mod( 'onepage_parallax_header_nav_bg_color' ) );
		$onepage_parallax_header_mod = esc_html( get_theme_mod( 'onepage_parallax_header_nav_color' ) );


		if ( !empty( $onepage_parallax_header_mod ) ) {
	    $onepage_parallax_header_mod = "#onepage_parallax_menu a{ color: {$onepage_parallax_header_mod}; } #onepage_parallax_menu a:after{ background-color: {$onepage_parallax_header_mod}; }.wpb_nav li ul{border-top-color: {$onepage_parallax_header_mod}; }";
	    wp_add_inline_style( 'onepage_parallax_style', $onepage_parallax_header_mod );
		}

		if ( !empty( $onepage_parallax_header_mod_bg ) ) {
	    $onepage_parallax_header_mod_bg = ".wpb_nav,.wpb_nav li ul{ background: {$onepage_parallax_header_mod_bg}; }";
	    wp_add_inline_style( 'onepage_parallax_style', $onepage_parallax_header_mod_bg );
		}
	}

	add_action( 'wp_enqueue_scripts', 'onepage_parallax_scripts' );

	function onepage_parallax_scripts() {

		wp_enqueue_script( 'jquery-3.3.1', ONEPAGE_PARALLAX_DIR_URI . 'assets/js/jquery-3.3.1.min.js', false, '3.3.1', true);

	  wp_enqueue_script( 'mg-jquery-3.0.1', ONEPAGE_PARALLAX_DIR_URI . 'assets/js/jquery-migrate-3.0.1.min.js', false, '3.0.1', true );

		wp_enqueue_script( 'onepage_parallax_script', ONEPAGE_PARALLAX_DIR_URI . 'assets/js/script.js', array( 'jquery-3.3.1' ), onepage_parallax_version(), true );

		wp_enqueue_script( 'onepage_parallax_js_gradient', ONEPAGE_PARALLAX_DIR_URI . 'assets/js/gradient.js', array( 'jquery' ), onepage_parallax_version(), true );

		$onepage_parallax_gradient_color1 = get_theme_mod( 'onepage_parallax_hero_gradient0_color', '#9dc02e' );
		$onepage_parallax_gradient_color2 = get_theme_mod( 'onepage_parallax_hero_gradient1_color', '#b75595' );
		$onepage_parallax_gradient_color3 = get_theme_mod( 'onepage_parallax_hero_gradient2_color', '#3498db' );
		$onepage_parallax_gradient_color4 = get_theme_mod( 'onepage_parallax_hero_gradient3_color', '#e7a800' );

		$onepage_parallax_hex1 	= $onepage_parallax_gradient_color1;
		list( $r, $g, $b ) 			= sscanf( $onepage_parallax_hex1, "#%02x%02x%02x" );
		$onepage_parallax_hex1X = "$r , $g , $b";
		$onepage_parallax_hex2 	= $onepage_parallax_gradient_color2;
		list( $r, $g, $b ) 			= sscanf( $onepage_parallax_hex2, "#%02x%02x%02x" );
		$onepage_parallax_hex2X = "$r , $g , $b";
		$onepage_parallax_hex3 	= $onepage_parallax_gradient_color3;
		list( $r, $g, $b ) 			= sscanf( $onepage_parallax_hex3, "#%02x%02x%02x" );
		$onepage_parallax_hex3X = "$r , $g , $b";
		$onepage_parallax_hex4 	= $onepage_parallax_gradient_color4;
		list( $r, $g, $b ) 			= sscanf( $onepage_parallax_hex4, "#%02x%02x%02x" );
		$onepage_parallax_hex4X = "$r , $g , $b";

		$onepage_parallax_gradient = array(
			'hex1' => $onepage_parallax_hex1X,
			'hex2' => $onepage_parallax_hex2X,
			'hex3' => $onepage_parallax_hex3X,
			'hex4' => $onepage_parallax_hex4X );

		wp_localize_script( 'onepage_parallax_js_gradient', 'onepage_parallax_gradient', $onepage_parallax_gradient );
	}

	/**
 * Creating customizer live controls.
 */
function onepage_parallax_live() {

	wp_enqueue_script( 'onepage_parallax_live_control', ONEPAGE_PARALLAX_DIR_URI . 'assets/js/customizer-live.js', array( 'jquery', 'customize-preview' ), onepage_parallax_version() );
}

add_action( 'customize_preview_init', 'onepage_parallax_live' );

/**
	 * Enqueue Admin styles and scripts for OnePage Parallax.
	 */
	function onepage_parallax_custom_wp_admin_style() {

		$onepage_parallax_screen = get_current_screen();

		if ( 'appearance_page_OnePage_Parallax' == $onepage_parallax_screen->base ) {
			wp_enqueue_script( 'onepage_parallax_dash_js', ONEPAGE_PARALLAX_DIR_URI . 'assets/js/onepage-parallax-dashboard.js', array( 'jquery' ), onepage_parallax_version() );
			wp_enqueue_style( 'onepage_parallax_dash_css', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/onepage-parallax-dashboard.css', array(), onepage_parallax_version() );
		}
	}

	add_action( 'admin_enqueue_scripts', 'onepage_parallax_custom_wp_admin_style' );

	/**
	 *  TGM Registration
	 */
	function onepage_parallax_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$onepage_parallax_plugins = array(
		array(
			'name'      => 'Google analytics dashboard for WordPress',
			'slug'      => 'wp-analytify',
			'required'  => false,
		),
		array(
			'name'      => 'LoginPress | Login Page Customizer',
			'slug'      => 'loginpress',
			'required'  => false,
		),
		array(
			'name'      => 'Maintenance Mode',
			'slug'      => 'under-construction-maintenance-mode',
			'required'  => false,
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'name'      => 'MailChimp for WordPress',
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
		),
	);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$onepage_parallax_config = array(
			'id'           => 'onepage-parallax',      // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.


			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'onepage-parallax' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'onepage-parallax' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'onepage-parallax' ),
				'updating'                        => esc_html__( 'Updating Plugin: %s', 'onepage-parallax' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'onepage-parallax' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'onepage-parallax'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'onepage-parallax'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'onepage-parallax'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'onepage-parallax'
				),
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'onepage-parallax'
				),
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'onepage-parallax'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'onepage-parallax'
				),
				'update_link' 					  => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'onepage-parallax'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'onepage-parallax'
				),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'onepage-parallax' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'onepage-parallax' ),
				'activated_successfully'          => esc_html__( 'The following plugin was activated successfully:', 'onepage-parallax' ),
				'plugin_already_active'           => esc_html__( 'No action taken. Plugin %1$s was already active.', 'onepage-parallax' ),
				'plugin_needs_higher_version'     => esc_html__( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'onepage-parallax' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %1$s', 'onepage-parallax' ),
				'dismiss'                         => esc_html__( 'Dismiss this notice', 'onepage-parallax' ),
				'notice_cannot_install_activate'  => esc_html__( 'There are one or more required or recommended plugins to install, update or activate.', 'onepage-parallax' ),
				'contact_admin'                   => esc_html__( 'Please contact the administrator of this site for help.', 'onepage-parallax' ),
				'nag_type'                        => 'updated',
			),
		);

		tgmpa( $onepage_parallax_plugins, $onepage_parallax_config );
	}

	add_action( 'tgmpa_register', 'onepage_parallax_register_required_plugins' );

	/**
	 * OnePage Parallax configuration file.
	 */
	require_once( ONEPAGE_PARALLAX_DIR . 'inc/config.php' );

	/**
 * Customizer additions.
 */
require_once( ONEPAGE_PARALLAX_DIR . 'inc/customizer.php' );

/**
 * Additional methods for the theme OnePage Parallax.
 */
require_once( ONEPAGE_PARALLAX_DIR . 'inc/methods.php' );

/**
 * Theme actions hooks.
 */
require_once( ONEPAGE_PARALLAX_DIR . 'inc/hooks.php' );

/**
 * Theme dashboard page.
 */
require_once( ONEPAGE_PARALLAX_DIR . 'inc/dashboard.php' );

/**
 * TGM Activation Class
 */
require_once( ONEPAGE_PARALLAX_DIR . 'inc/plugin-activation.php' );
