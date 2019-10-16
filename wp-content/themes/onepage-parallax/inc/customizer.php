<?php

/**
 * Theme's customizer function.
 *
 * @param  object $wp_customize
 * @package OnePage Parallax
 * @since 0.0.1
 * @version 1.0.0
 */
function onepage_parallax_theme_customizer( $wp_customize ) {

	/**
	 * Requiring customizer class.
	 */
	require ONEPAGE_PARALLAX_DIR . 'inc/onepage-parallax-control/classes/class-repeater-control.php' ;
	require ONEPAGE_PARALLAX_DIR . 'inc/onepage-parallax-control/classes/class-promo-control.php';
	require ONEPAGE_PARALLAX_DIR . 'inc/onepage-parallax-control/classes/class-editor-control.php';

	/**
	 * [onepage_parallax_sanitize_text] > Sanitize Input Text
	 *
	 * @param  string $input
	 * @return string
	 */
	function onepage_parallax_sanitize_text( $input ) {

		return sanitize_text_field( $input );
	}

	/**
	 * Select sanitization callback.
	 *
	 * - Sanitization: select
	 * - Control: select, radio
	 *
	 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
	 * as a slug, and then validates `$input` against the choices defined for the control.
	 *
	 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
	 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
	 *
	 * @param string               $input   Slug to sanitize.
	 * @param WP_Customize_Setting $setting Setting instance.
	 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
	 */
	function onepage_parallax_sanitize_select( $input, $setting ) {

    // Ensure input is a slug.
    $input = sanitize_key( $input );
    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Repeater sanitizaion callback.
	 *
	 * @param string  $input   String to sanitize.
	 * @return string Sanitized
	 */
	function onepage_parallax_repeater_sanitize( $input ) {

		$input_decoded = json_decode( $input, true );

		if ( ! empty( $input_decoded ) ) {
			foreach ( $input_decoded as $boxk => $box ) {
				foreach ( $box as $key => $value ) {

						$input_decoded[ $boxk ][ $key ] = wp_kses_post( force_balance_tags( $value ) );

				}
			}
			return json_encode( $input_decoded );
		}
		return $input;
	}

	/**
	 * Checkbox sanitization callback example.
	 *
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function onepage_parallax_sanitize_checkbox( $checked ) {
		// Boolean check.

		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}

	/**
	 * HEX Color sanitization callback example.
	 *
	 * - Sanitization: hex_color
	 * - Control: text, WP_Customize_Color_Control
	 *
	 * Note: sanitize_hex_color_no_hash() can also be used here, depending on whether
	 * or not the hash prefix should be stored/retrieved with the hex color value.
	 *
	 * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
	 * @link sanitize_hex_color_no_hash() https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
	 *
	 * @param string               $hex_color HEX color to sanitize.
	 * @param WP_Customize_Setting $setting   Setting instance.
	 * @return string The sanitized hex color if not null; otherwise, the setting default.
	 */
	function onepage_parallax_sanitize_hex_color( $hex_color, $setting ) {

		// Sanitize $input as a hex value without the hash prefix.
		$hex_color = sanitize_hex_color( $hex_color );

		// If $input is a valid hex value, return it; otherwise, return the default.
		return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
	}

	/**
	 * No-HTML sanitization callback example.
	 *
	 * - Sanitization: nohtml
	 * - Control: text, textarea, password
	 *
	 * Sanitization callback for 'nohtml' type text inputs. This callback sanitizes `$nohtml`
	 * to remove all HTML.
	 *
	 * NOTE: wp_filter_nohtml_kses() can be passed directly as `$wp_customize->add_setting()`
	 * 'sanitize_callback'. It is wrapped in a callback here merely for example purposes.
	 *
	 * @see wp_filter_nohtml_kses() https://developer.wordpress.org/reference/functions/wp_filter_nohtml_kses/
	 *
	 * @param string $nohtml The no-HTML content to sanitize.
	 * @return string Sanitized no-HTML content.
	 */
	function onepage_parallax_sanitize_nohtml( $nohtml ) {

		return wp_filter_nohtml_kses( $nohtml );
	}

	/**
	 * Move Header Image control into Hero Section.
	 */
	$wp_customize->get_control('header_image')->section = 'onepage_parallax_section_hero';

	/**
	 * Enqueuing customizers styling.
	 */
	function onepage_parallax_customize_js_settings() {

		wp_register_style( 'onepage-parallax-customizer-controls', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/customizer.css' );

	  wp_enqueue_style( 'onepage-parallax-customizer-controls' );
		wp_enqueue_script( 'onepage-parallax-customizer-control', ONEPAGE_PARALLAX_DIR_URI . 'assets/js/admin-customizer.js', array( 'jquery' ), '20171021', true );
	}

	add_action( 'customize_controls_enqueue_scripts', 'onepage_parallax_customize_js_settings' );

	/*
  * Setting section and control for footer social icons.
  * Callback esc_url_raw
  *
	*/
	$wp_customize->add_section( 'onepage_parallax_section_social_icon' , array(
		'title'     => esc_html__( 'Social Links', 'onepage-parallax' ),
		'priority'  => 31,
		'panel'   	=> 'onepage_parallax_footer_panel',
	) );

	$socailMediaLabel = onepage_parallax_default_strings( 'customizer', 'sec_footer_label' );
	// $socialMediaLinks = onepage_parallax_default_strings( 'customizer', 'sec_footer_link' );
	$i = 0;

	while ( $i < 6 ) :

		$i++;

	  $wp_customize->add_setting( "onepage_parallax_footer_{$i}", array(
		  // 'default' 					=> $socialMediaLinks[ intval( $i ) - 1 ],
		  'sanitize_callback' => 'esc_url_raw',
	  ) );

	  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, "onepage_parallax_footer_{$i}", array(
		  'label'     => $socailMediaLabel[ intval( $i ) - 1 ],
		  'section'   => 'onepage_parallax_section_social_icon',
		  'settings'  => "onepage_parallax_footer_{$i}",
		  'type'      => 'text',
		  'priority'  => 10,
	  ) ) );

	  $wp_customize->selective_refresh->add_partial( "onepage_parallax_footer_{$i}", array(
		  'selector'            => ".onepage_parallax_social_{$i} a",
		  'container_inclusive' => true,
	  ) );

	endwhile;

	/**
	 * Create a panal for Theme Options.
	 *
	 * Sections: Global Settings, Header Settings, Site Colors, Blog Page Settings & Single Page Settings.
	 * Controls: Select, Checkbox, Color, Image & Radio.
	 */
	 $wp_customize->add_panel( 'onepage_parallax_general_panel', array(
		 'priority'          => 21,
		 'capability'        => 'edit_theme_options',
		 'theme_supports'    => '',
		 'title'             => esc_html__( 'Theme Options', 'onepage-parallax' ),
		 'description'       => esc_html__( 'This panel allows you to customize general setting of the theme.', 'onepage-parallax' ),
	 ) );

	 /**
	  * Create a Section for Global Settings.
	  *
	  * Settings: Sidebars, Scroll up, Sticky Header & Animation.
	  * Controls: Select.
	  */
	$wp_customize->add_section( 'onepage_parallax_section_global', array(
		'title'     => esc_html__( 'Global Settings', 'onepage-parallax' ),
		'priority'  => 1,
		'panel'   	=> 'onepage_parallax_general_panel',
	) );

	// Settings for pages sidebar position.
	$wp_customize->add_setting( 'onepage_parallax_page_sidebar', array(
		'default' 					=> 'right',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_page_sidebar', array(
		'label'       => __( 'Pages Sidebar Position', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_page_sidebar',
		'type'        => 'select',
		'choices'     => array(
			'right'  		=> __( 'Right', 'onepage-parallax' ),
			'left'  		=> __( 'Left', 'onepage-parallax' ),
			'none'  		=> __( 'None', 'onepage-parallax' ) ),
		'priority'    => 1,
	) ) );

	// Settings for blog sidebar position.
	$wp_customize->add_setting( 'onepage_parallax_blog_sidebar', array(
		'default' 					=> 'right',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_blog_sidebar', array(
		'label'       => __( 'Blog Sidebar Position', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_blog_sidebar',
		'type'        => 'select',
		'choices'     => array(
			'right'   	=> __( 'Right', 'onepage-parallax' ),
			'left'  		=> __( 'Left', 'onepage-parallax' ),
			'none'  		=> __( 'None', 'onepage-parallax' ) ),
		'priority'    => 2,
	) ) );

	// Settings for Search page sidebar position.
	$wp_customize->add_setting( 'onepage_parallax_search_sidebar', array(
		'default' 					=> 'right',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_search_sidebar', array(
		'label'       => __( 'Search Sidebar Position', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_search_sidebar',
		'type'        => 'select',
		'choices'     => array(
			'right'   	=> __( 'Right', 'onepage-parallax' ),
			'left'  		=> __( 'Left', 'onepage-parallax' ),
			'none'  		=> __( 'None', 'onepage-parallax' ) ),
		'priority'    => 3,
	) ) );

	// Settings for Author page sidebar position.
	$wp_customize->add_setting( 'onepage_parallax_author_sidebar', array(
		'default' 					=> 'right',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_author_sidebar', array(
		'label'       => __( 'Author Page Sidebar Position', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_author_sidebar',
		'type'        => 'select',
		'choices'     => array(
			'right'   	=> __( 'Right', 'onepage-parallax' ),
			'left'  		=> __( 'Left', 'onepage-parallax' ),
			'none'  		=> __( 'None', 'onepage-parallax' ) ),
		'priority'    => 4,
	) ) );

	// Settings for single post page sidebar position.
	$wp_customize->add_setting( 'onepage_parallax_single_sidebar', array(
		'default' 					=> 'right',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_single_sidebar', array(
		'label'       => __( 'Single Post Sidebar Position', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_single_sidebar',
		'type'        => 'select',
		'choices'     => array(
			'right'   	=> __( 'Right', 'onepage-parallax' ),
			'left'  		=> __( 'Left', 'onepage-parallax' ),
			'none'  		=> __( 'None', 'onepage-parallax' ) ),
		'priority'    => 5,
	) ) );


	// Settings for Scroll up icon.
	$wp_customize->add_setting( 'onepage_parallax_global_totop', array(
		'default' 					=> 'enable',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_global_totop', array(
		'label'       => __( 'Scroll Up Icon', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_global_totop',
		'type'        => 'select',
		'choices'    	=> array(
			'enable'   	=> __( 'Enable', 'onepage-parallax' ),
			'disable'  	=> __( 'Disable', 'onepage-parallax' ) ),
		'priority'    => 6,
	) ) );

	// Settings for sticky header.
	$wp_customize->add_setting( 'onepage_parallax_sticky_header', array(
		'default' 					=> 'enable',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_sticky_header', array(
		'label'       => __( 'Sticky Header', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_sticky_header',
		'type'        => 'select',
		'choices'     => array(
			'enable'   	=> __( 'Enable', 'onepage-parallax' ),
			'disable'  	=> __( 'Disable', 'onepage-parallax' ) ),
		'priority'    => 7,
	) ) );

	// Settings for element animations.
	$wp_customize->add_setting( 'onepage_parallax_page_animations', array(
		'default' 					=> 'enable',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_page_animations', array(
		'label'       => __( 'Animation On Sections', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_global',
		'settings'    => 'onepage_parallax_page_animations',
		'type'        => 'select',
		'choices'     => array(
			'enable'   	=> esc_html__( 'Enable', 'onepage-parallax' ),
			'disable'  	=> esc_html__( 'Disable', 'onepage-parallax' ) ),
		'priority'    => 8,
	) ) );

	/**
	 * Section for Header Settings.
	 *
	 * Settings: Title and Tagline Color, Header Background Color, Navigation Background Color & Navigation Color.
	 * Controls: Colors.
	 */
	$wp_customize->add_section( 'onepage_parallax_section_header', array(
		'title'     => esc_html__( 'Header Settings', 'onepage-parallax' ),
		'priority'  => 2,
		'panel'   	=> 'onepage_parallax_general_panel',
	) );

	// Settings for title and tagline color.
	$wp_customize->add_setting( 'onepage_parallax_header_title_color', array(
		'default' 					=> '#000',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_header_title_color', array(
		'label'       => esc_html__( 'Title and Tagline Color', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_header',
		'settings'    => 'onepage_parallax_header_title_color',
		'priority'    => 1,
	) ) );

	// Settings for header background color.
	$wp_customize->add_setting( 'onepage_parallax_header_bg_color', array(
		'default' 					=> '#ffffff',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_header_bg_color', array(
		'label'       => __( 'Header Background Color', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_header',
		'settings'    => 'onepage_parallax_header_bg_color',
		'priority'    => 2,
	) ) );

	// Settings for navigation color.
	$wp_customize->add_setting( 'onepage_parallax_header_nav_bg_color', array(
		'default' 					=> '#000',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_header_nav_bg_color', array(
		'label'       => __( 'Navigation Background Color', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_header',
		'settings'    => 'onepage_parallax_header_nav_bg_color',
		'priority'    => 3,
	) ) );

	//Settings for navigation background color.
	$wp_customize->add_setting( 'onepage_parallax_header_nav_color', array(
		'default' 					=> '#ffffff',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_header_nav_color', array(
		'label'       => __( 'Navigation Color', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_header',
		'settings'    => 'onepage_parallax_header_nav_color',
		'priority'    => 4,
	) ) );

	/**
	 * Section for Site Colors
	 *
	 * Settings: Site Background Color, Footer Color & Footer Background Color.
	 * Controls: Colors.
	 */
	$wp_customize->add_section( 'onepage_parallax_section_colors', array(
		'title'     => esc_html__( 'Site Colors', 'onepage-parallax' ),
		'priority'  => 3,
		'panel'   	=> 'onepage_parallax_general_panel',
	) );

	// Settings for background color.
	$wp_customize->add_setting( 'onepage_parallax_colors_background', array(
		'default' 					=> '#ffffff',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_colors_background', array(
		'label'       => esc_html__( 'Site Background Color', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_colors',
		'settings'    => 'onepage_parallax_colors_background',
		'priority'    => 1,
	) ) );

	// Settings for footer color.
	$wp_customize->add_setting( 'onepage_parallax_colors_footer', array(
		'default' 					=> '#4c4c4c',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_colors_footer', array(
		'label'       => __( 'Footer Color', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_colors',
		'settings'    => 'onepage_parallax_colors_footer',
		'priority'    => 3,
	) ) );

	// Settings for footer background color.
	$wp_customize->add_setting( 'onepage_parallax_colors_footer_bg', array(
		'default' 					=> '#000000',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_colors_footer_bg', array(
		'label'       => __( 'Footer Background Color', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_colors',
		'settings'    => 'onepage_parallax_colors_footer_bg',
		'priority'    => 4,
	) ) );

	/**
	 * Section for Blog Page
	 *
	 * Settings: Header Image for Blog Page, Enable/Disable ( Metadata on blog page ) & Show excerpt or full content.
	 * Controls: Image, Checnkbox & Radio.
	 */
	$wp_customize->add_section( 'onepage_parallax_section_blog_post', array(
		'title'     	=> esc_html__( 'Blog Page Settings', 'onepage-parallax' ),
		'description' => esc_html__( 'Settings for the blog posts', 'onepage-parallax' ),
		'priority'  	=> 4,
		'panel'   		=> 'onepage_parallax_general_panel',
	) );

	// BackGround upload.
	$wp_customize->add_setting( 'onepage_parallax_blog_header_image', array(
		'default'						=> esc_url( ONEPAGE_PARALLAX_DIR_URI . '/assets/images/header-img.jpg' ),
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'onepage_parallax_blog_header_image', array(
		'label'     => __( 'Header Image for Blog Page.', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_blog_post',
		'settings'  => 'onepage_parallax_blog_header_image',
		'priority'  => 1,
	) ) );

	$wp_customize->add_setting( 'onepage_parallax_blog_header_select', array(
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_blog_header_select', array(
		'type'          => 'hidden',
		'section'   		=> 'onepage_parallax_section_blog_post',
		'settings'  => "onepage_parallax_blog_header_select"
	) ) );

	$wp_customize->selective_refresh->add_partial( 'onepage_parallax_blog_header_select', array(
		'selector'            => '.blogimg',
		'container_inclusive' => true,
	) );

	// Control for Show or Hide meta on blog posts.
	$BPControl 	= onepage_parallax_default_strings( 'customizer', 'sec_blog_post_control' );
	$BPlabel 		= onepage_parallax_default_strings( 'customizer', 'sec_blog_post_label' );
	$countBP = 0;
	while ( $countBP < 6 ) :

		$wp_customize->add_setting( "onepage_parallax_{$BPControl[$countBP]}_visible", array(
			'default' 					=> true,
			'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "onepage_parallax_{$BPControl[$countBP]}_visible", array(
			'label'     => $BPlabel[$countBP],
			'section'   => 'onepage_parallax_section_blog_post',
			'settings'  => "onepage_parallax_{$BPControl[$countBP]}_visible",
			'type'      => 'checkbox',
			'priority'  => $countBP + 5,
		) ) );

		$countBP++;
	endwhile;

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'            => '.blogheader',
		'container_inclusive' => true,
	) );

	// excerpts.
	$wp_customize->add_setting( 'onepage_parallax_content_type', array(
		'default'          	=> 'excerpt',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_content_type', array(
		'type'          => 'radio',
		'label'         => __( 'Show content type on blog', 'onepage-parallax' ),
		'section'   		=> 'onepage_parallax_section_blog_post',
		'choices'   		=> array(
			'excerpt'     => __( 'The Excerpt', 'onepage-parallax' ),
			'fullcontent' => __( 'Full Content', 'onepage-parallax' ) ),
		'priority'  		=> 30,
	) ) );

	/**
	 * Section for Single Post.
	 *
	 * Settings: Enable Header Image on single post, Change Header Title & Image for Single Post & Enable/Disable ( Metadata on single post ).
	 * Controls: Image, Textarea & Checkbox.
	 */
	$wp_customize->add_section( 'onepage_parallax_section_single_post', array(
		'title'     	=> esc_html__( 'Single Post Settings', 'onepage-parallax' ),
		'description' => esc_html__( 'Settings for the single posts', 'onepage-parallax' ),
		'priority'  	=> 5,
		'panel'   		=> 'onepage_parallax_general_panel',
	) );

	// Show or Hide this section.
	$wp_customize->add_setting( 'onepage_parallax_SPHImage_visible', array(
		'default' 					=> true,
		'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_SPHImage_visible', array(
		'label'       => __( 'Enable Header Image on single post.', 'onepage-parallax' ),
		'section' 		=> 'onepage_parallax_section_single_post',
		'settings'    => 'onepage_parallax_SPHImage_visible',
		'type'        => 'checkbox',
		'priority'    => 1,
	) ) );

	// Heading on single post banner.
	$wp_customize->add_setting( 'onepage_parallax_SPHImage_title', array(
	  'default' 					=> __( 'Blog', 'onepage-parallax' ),
	  'sanitize_callback' => 'onepage_parallax_sanitize_text',
	  // 'transport' 				=> 'postMessage',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_SPHImage_title', array(
	  'label'     => esc_html__( 'Single Post Banner Title', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_single_post',
	  'settings'  => 'onepage_parallax_SPHImage_title',
	  'type'      => 'textarea',
	  'priority'  => 1,
  ) ) );

	// BackGround upload.
	$wp_customize->add_setting( 'onepage_parallax_single_header_image', array(
		'default'           => esc_url( ONEPAGE_PARALLAX_DIR_URI . '/assets/images/header-img2.jpg' ),
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'onepage_parallax_single_header_image', array(
		'label'     => __( 'Header Image for Single Post.', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_single_post',
		'settings'  => 'onepage_parallax_single_header_image',
		'priority'  => 1,
	) ) );

	// Control for Show or Hide meta on single posts.
	$SPControl = onepage_parallax_default_strings( 'customizer', 'sec_single_post_control' );
	$SPlabel = onepage_parallax_default_strings( 'customizer', 'sec_single_post_label' );
	$countSP = 0;

	while ( $countSP < 6 ) :

		$wp_customize->add_setting( "onepage_parallax_{$SPControl[$countSP]}_visible", array(
			'default' 					=> true,
			'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "onepage_parallax_{$SPControl[$countSP]}_visible", array(
			'label'     => $SPlabel[$countSP],
			'section'   => 'onepage_parallax_section_single_post',
			'settings'  => "onepage_parallax_{$SPControl[$countSP]}_visible",
			'type'      => 'checkbox',
			'priority'  => $countSP + 5,
		) ) );

		$countSP++;
	endwhile;

	/**
	 * Section for Single Page.
	 *
	 * Settings: Enable Header Image on single page, Change Header Title & Image for Single Post & Enable/Disable ( Metadata on single post ).
	 * Controls: Image, Textarea & Checkbox.
	 */
	$wp_customize->add_section( 'onepage_parallax_section_single_page', array(
		'title'     	=> esc_html__( 'Single Page Settings', 'onepage-parallax' ),
		'description' => esc_html__( 'Settings for the single page', 'onepage-parallax' ),
		'priority'  	=> 6,
		'panel'   		=> 'onepage_parallax_general_panel',
	) );

	// Show or Hide this section.
	$wp_customize->add_setting( 'onepage_parallax_SPageHImage_visible', array(
		'default' 					=> true,
		'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_SPageHImage_visible', array(
		'label'       => __( 'Enable Header Image on single page.', 'onepage-parallax' ),
		'section' 		=> 'onepage_parallax_section_single_page',
		'settings'    => 'onepage_parallax_SPageHImage_visible',
		'type'        => 'checkbox',
		'priority'    => 1,
	) ) );

	// BackGround upload.
	$wp_customize->add_setting( 'onepage_parallax_page_header_image', array(
		'default'           => esc_url( ONEPAGE_PARALLAX_DIR_URI . '/assets/images/header-img2.jpg' ),
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'onepage_parallax_page_header_image', array(
		'label'     => __( 'Header Image for Single Page.', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_single_page',
		'settings'  => 'onepage_parallax_page_header_image',
		'priority'  => 1,
	) ) );

	/*
  * Setting and Control for the Section Subscribe.
  *
	*/

	$wp_customize->add_section( 'onepage_parallax_section_subscribe' , array(
		'title'     => esc_html__( 'Section: Subscribe', 'onepage-parallax' ),
		'priority'  => 28,
	) );

	//Selector
	$wp_customize->add_setting( "onepage_parallax_subscribe_select", array(
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "onepage_parallax_subscribe_select", array(
		'section'   => 'onepage_parallax_section_subscribe',
		'settings'  => "onepage_parallax_subscribe_select",
		'type'      => 'hidden',
	) ) );

	$wp_customize->selective_refresh->add_partial( 'onepage_parallax_subscribe_select', array(
		'selector'            => '.freeUpdatesContents',
		'container_inclusive' => true,
	) );

	// Show or Hide this section.
	$wp_customize->add_setting( 'onepage_parallax_subscribe_visible', array(
		'default' 					=> false,
		'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_subscribe_visible', array(
		'label'     => __( 'Make this section visible', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_subscribe',
		'settings'  => 'onepage_parallax_subscribe_visible',
		'type'      => 'checkbox',
		'priority'  => 1,
	) ) );

	$wp_customize->add_setting( 'onepage_parallax_subscribe_shortcode', array(
		'sanitize_callback' => 'wp_kses',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_subscribe_shortcode', array(
		'label'     => __( 'Mailchimp shortcode', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_subscribe',
		'settings'  => 'onepage_parallax_subscribe_shortcode',
		'type'      => 'text',
		'priority'  => 2,
	) ) );




	/**
	 * Create a panal for About.
	 *
	 * Sections: About Settings & About Content/ Layout.
	 * Controls: Checkbox, Text, Textarea, Select & Repeater for ( Image, Title, Subtitle, Description & link ).
	 */

	$wp_customize->add_panel( 'onepage_parallax_about_panel', array(
		'priority'          => 23,
		'capability'        => 'edit_theme_options',
		'theme_supports'    => '',
		'title'             => esc_html__( 'Section: About', 'onepage-parallax' ),
		'description'       => esc_html__( 'This panel allows you to customize About areas of the Theme.', 'onepage-parallax' ),
	) );

	/**
	 * Section for About Settings.
	 *
	 * Settings: Enable/Disable Section, Title, Subtitle.
	 * Controls: Checnkbox, Text & Textarea.
	 */
	$aboutHead = array( 'About Us', 'Who are we and what are we doing' );

	$wp_customize->add_section( 'onepage_parallax_section_about_top' , array(
	  'title'     => esc_html__( 'About Settings', 'onepage-parallax' ),
	  'priority'  => 10,
	  'panel'   => 'onepage_parallax_about_panel',
  ) );

	// Heading 1
	$wp_customize->add_setting( 'onepage_parallax_about_title', array(
	  'default' 					=> $aboutHead['0'],
	  'sanitize_callback' => 'onepage_parallax_sanitize_text',
  ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_about_title', array(
	  'label'     => esc_html__( 'Title', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_about_top',
	  'settings'  => 'onepage_parallax_about_title',
	  'type'      => 'text',
	  'priority'  => 5,
  ) ) );

	 $wp_customize->selective_refresh->add_partial( 'onepage_parallax_about_title', array(
	  'selector'            => '.about_top_h1',
	  'container_inclusive' => true,
  ) );

	// Heading 2
	$wp_customize->add_setting( 'onepage_parallax_about_subtitle', array(
	  'default' 					=> $aboutHead['1'],
	  'sanitize_callback' => 'onepage_parallax_sanitize_text',
	  'transport' 				=> 'postMessage',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_about_subtitle', array(
	  'label'     => esc_html__( 'Subtitle', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_about_top',
	  'settings'  => 'onepage_parallax_about_subtitle',
	  'type'      => 'textarea',
	  'priority'  => 10,
  ) ) );

  // Show or Hide this section.
  $wp_customize->add_setting( 'onepage_parallax_about_visible', array(
	  'default' 					=> false,
	  'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_about_visible', array(
	  'label'     => __( 'Make this section visible', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_about_top',
	  'settings'  => 'onepage_parallax_about_visible',
	  'type'      => 'checkbox',
	  'priority'  => 1,
  ) ) );

	/**
	 * Section for About Content / Layout.
	 *
	 * Settings: Columns & Item.
	 * Controls: Select & Repeater for ( Image, Title, Subtitle, Description & link ).
	 */
	$wp_customize->add_section( 'onepage_parallax_section_about_content' , array(
		'title'     => esc_html__( 'About Content / Layout', 'onepage-parallax' ),
		'priority'  => 10,
		'panel'     => 'onepage_parallax_about_panel',
	) );

	$wp_customize->add_setting( 'onepage_parallax_about_column', array(
		'default' => 'col-4',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_about_column', array(
		'label'    => esc_html__( 'Columns', 'onepage-parallax' ),
		'section'  => 'onepage_parallax_section_about_content',
		'settings' => 'onepage_parallax_about_column',
		'type'     => 'select',
		'choices'  => array(
			'col-2'  => __( '2 Column', 'onepage-parallax' ),
			'col-3'  => __( '3 Column', 'onepage-parallax' ),
			'col-4'  => __( '4 Column', 'onepage-parallax' ) ),
		'priority' => 1,
	) ) );

	$wp_customize->add_setting( 'onepage_parallax_about_items', array(
		'sanitize_callback' => 'onepage_parallax_repeater_sanitize'
	) );

	$wp_customize->add_control( new OnePage_Parallax_Repeater_Control( $wp_customize, 'onepage_parallax_about_items', array(
		'label'   								=> esc_html__( 'Item','onepage-parallax' ),
		'section' 								=> 'onepage_parallax_section_about_content',
		'priority' 								=> 15,
	  'onepage_parallax_subtitle_control' 			=> true,
		'onepage_parallax_pages_control' 					=> true,
		'onepage_parallax_pages_title_control' 		=> true,
		'onepage_parallax_pages_link_control' 		=> true,
		'onepage_parallax_pages_image_control' 		=> true,
		'onepage_parallax_order'     							=> '1',
	) ) );

	/**
 	* Create a panal for Success.
 	*
 	* Sections: Success Settings & Success Content.
 	* Controls: Checkbox & Repeater for ( Image, Title & Description ).
 	*/
	$wp_customize->add_panel( 'onepage_parallax_success_panel', array(
		'priority'          => 24,
		'capability'        => 'edit_theme_options',
		'theme_supports'    => '',
		'title'             => esc_html__( 'Section: Success', 'onepage-parallax' ),
		'description'       => esc_html__( 'This panel allows you to customize Success areas of the Theme.', 'onepage-parallax' ),
	) );

	/**
	 * Section for Success Settings.
	 *
	 * Settings: Enable/Disable Section.
	 * Controls: Checkbox.
	 */
 $wp_customize->add_section( 'onepage_parallax_section_seccuss_settings' , array(
   'title'     	=> esc_html__( 'Success Settings', 'onepage-parallax' ),
   'priority'  	=> 10,
   'panel'  		=> 'onepage_parallax_success_panel',
 ) );

 // Show or Hide this section.
 $wp_customize->add_setting( 'onepage_parallax_success_visible', array(
   'default' 						=> false,
   'sanitize_callback' 	=> 'onepage_parallax_sanitize_checkbox',
 ) );

 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_success_visible', array(
   'label'        => esc_html__( 'Make this section visible', 'onepage-parallax' ),
   'section'  		=> 'onepage_parallax_section_seccuss_settings',
   'settings' 		=> 'onepage_parallax_success_visible',
   'type'     		=> 'checkbox',
   'priority'     => 1,
 ) ) );

 // Selector section.
 $wp_customize->add_setting( 'onepage_parallax_seccuss_selector', array(
	 'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
 ) );

 $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_seccuss_selector', array(
	 'section'  		=> 'onepage_parallax_section_seccuss_settings',
	 'settings' 		=> 'onepage_parallax_seccuss_selector',
	 'type'     		=> 'hidden',
	 'priority'     => 1,
 ) ) );

 $wp_customize->selective_refresh->add_partial( 'onepage_parallax_seccuss_selector', array(
	 'selector'            => '.onepage_parallax_services_selector',
	 'container_inclusive' => true,
 ) );

 /**
	* Section for About Content / Layout.
	*
	* Settings: Item.
	* Controls: Repeater for ( Image, Title, & Description ).
	*/
	$wp_customize->add_section( 'onepage_parallax_section_seccuss_content' , array(
		'title'     => esc_html__( 'Success Content', 'onepage-parallax' ),
		'priority'  => 10,
		'panel'     => 'onepage_parallax_success_panel',
	) );

	$wp_customize->add_setting( 'onepage_parallax_seccuss_items', array(
		'sanitize_callback' => 'onepage_parallax_repeater_sanitize'
	) );

	$wp_customize->add_control( new OnePage_Parallax_Repeater_Control( $wp_customize, 'onepage_parallax_seccuss_items', array(
		'label'   						=> esc_html__( 'Items','onepage-parallax' ),
		'section' 						=> 'onepage_parallax_section_seccuss_content',
		'priority' 						=> 15,
		'onepage_parallax_image_control' 		=> true,
		'onepage_parallax_title_control' 		=> true,
		'onepage_parallax_subtitle_control'	=> true,
		'onepage_parallax_order'     				=> '2',
	) ) );

  /*
   * Setting and Control for the Services Section.
   *
   */

	$wp_customize->add_panel( 'onepage_parallax_service_panel', array(
	'priority'          => 25,
	'capability'        => 'edit_theme_options',
	'theme_supports'    => '',
	'title'             => esc_html__( 'Section: Services', 'onepage-parallax' ),
	'description'       => esc_html__( 'This panel allows you to customize Service areas of the Theme.', 'onepage-parallax' ),
	) );

 	$serviceHead = array( 'Services', 'What can we help you with?' );

	$wp_customize->add_section( 'onepage_parallax_section_service_settings' , array(
	'title'     => esc_html__( 'Service Settings', 'onepage-parallax' ),
	'priority'  => 10,
	'panel'   	=> 'onepage_parallax_service_panel',
	) );

	// Heading 1
  $wp_customize->add_setting( 'onepage_parallax_service_title', array(
	  'default' => $serviceHead['0'],
	  'sanitize_callback' => 'onepage_parallax_sanitize_text',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_service_title', array(
	  'label'     => esc_html__( 'Title', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_service_settings',
	  'settings'  => 'onepage_parallax_service_title',
	  'type'      => 'text',
	  'priority'  => 5,
  ) ) );

  // Heading 2
  $wp_customize->add_setting( 'onepage_parallax_service_subtitle', array(
	  'default' 					=> $serviceHead['1'],
	  'sanitize_callback' => 'onepage_parallax_sanitize_text',
	  'transport' 				=> 'postMessage',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_service_subtitle', array(
	  'label'     => esc_html__( 'Subtitle', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_service_settings',
	  'settings'  => 'onepage_parallax_service_subtitle',
	  'type'      => 'textarea',
	  'priority'  => 10,
  ) ) );

	$wp_customize->selective_refresh->add_partial( 'onepage_parallax_service_title', array(
		'selector'            => '.onepage_parallax_services_title',
		'container_inclusive' => true,
	) );

  // Show or Hide this section.
  $wp_customize->add_setting( 'onepage_parallax_service_visible', array(
	  'default' 					=> false,
	  'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_service_visible', array(
	  'label'     => esc_html__( 'Make this section visible', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_service_settings',
	  'settings'  => 'onepage_parallax_service_visible',
	  'type'      => 'checkbox',
	  'priority'  => 1,
  ) ) );

  // Addine new services section
  $wp_customize->add_section( 'onepage_parallax_section_service_content' , array(
	  'title'     => esc_html__( 'Services Content / Layout', 'onepage-parallax' ),
	  'priority'  => 15,
	  'panel'   	=> 'onepage_parallax_service_panel',
  ) );

	$wp_customize->add_setting( 'onepage_parallax_service_column', array(
		'default' 					=> 'col-4',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_service_column', array(
		'label'         => 'Layout Setting',
		'section'       => 'onepage_parallax_section_service_content',
		'settings'  		=> 'onepage_parallax_service_column',
		'type'          => 'select',
		'choices'       => array(
			'col-2'   		=> esc_html__( '2 Column', 'onepage-parallax' ),
			'col-3'  			=> esc_html__( '3 Column', 'onepage-parallax' ),
			'col-4'  			=> esc_html__( '4 Column', 'onepage-parallax' ) ),
		'priority'  		=> 1,
	) ) );

  $wp_customize->add_setting( 'onepage_parallax_service_items', array(
	  'sanitize_callback' => 'onepage_parallax_repeater_sanitize'
	) );

  $wp_customize->add_control( new OnePage_Parallax_Repeater_Control( $wp_customize, 'onepage_parallax_service_items', array(
	  'label'   						=> esc_html__( 'Services','onepage-parallax' ),
	  'section' 						=> 'onepage_parallax_section_service_content',
	  'priority' 						=> 15,
		'onepage_parallax_pages_control' 		=> true,
		'onepage_parallax_pages_title_control' 		=> true,
		'onepage_parallax_pages_image_control' 		=> true,
	  'onepage_parallax_order'     		=> '3',
  ) ) );

	/*
  * Setting and Control for the Get in Touch Section.
  *
  */

  $wp_customize->add_section( 'onepage_parallax_section_touch' , array(
	  'title'     => esc_html__( 'Section: Get in Touch', 'onepage-parallax' ),
	  'priority'  => 26,
  ) );

  $touchLabel = onepage_parallax_default_strings( 'customizer', 'sec_touch_label' );
  $touchDefault = onepage_parallax_default_strings( 'home_temp', 'get_in_touch' );

	// Heading
	$wp_customize->add_setting( "onepage_parallax_touch_title", array(
		'default' => $touchDefault[0],
		'sanitize_callback' => 'onepage_parallax_sanitize_text',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "onepage_parallax_touch_title", array(
		'label'     => $touchLabel[0],
		'section'   => 'onepage_parallax_section_touch',
		'settings'  => "onepage_parallax_touch_title",
		'type'      => 'text',
		'priority'  => 9,
	) ) );

	$wp_customize->selective_refresh->add_partial( 'onepage_parallax_touch_title', array(
		'selector'            => '.onepage_parallax_git_num_1',
		'container_inclusive' => true,
	) );

	$i = 1;

	while ( $i < 5 ) :

		$i++;

		$wp_customize->add_setting( "onepage_parallax_touch_number_{$i}", array(
			'default' 					=> $touchDefault[ intval( $i ) - 1 ],
			'sanitize_callback' => 'onepage_parallax_sanitize_text',
			'transport' 				=> 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "onepage_parallax_touch_number_{$i}", array(
			'label'     => $touchLabel[intval($i)-1],
			'section'   => 'onepage_parallax_section_touch',
			'settings'  => "onepage_parallax_touch_number_{$i}",
			'type'      => 'text',
			'priority'  => 10,
		) ) );

	endwhile;

  // Show or Hide this section.
  $wp_customize->add_setting( 'onepage_parallax_touch_visible', array(
	  'default' 					=> false,
	  'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
  ) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_touch_visible', array(
	  'label'     => __( 'Make this section visible', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_touch',
	  'settings'  => 'onepage_parallax_touch_visible',
	  'type'      => 'checkbox',
	  'priority'  => 1,
  ) ) );

	/*
   * Setting and Control for the Team Section.
   *
   */

	$wp_customize->add_panel( 'onepage_parallax_team_panel', array(
	 'priority'          => 27,
	 'capability'        => 'edit_theme_options',
	 'theme_supports'    => '',
	 'title'             => esc_html__( 'Section: Team', 'onepage-parallax' ),
	 'description'       => esc_html__( 'This panel allows you to customize Team areas of the Theme.', 'onepage-parallax' )
	) );

  $wp_customize->add_section( 'onepage_parallax_section_team_settings' , array(
	  'title'     => __( 'Team Settings', 'onepage-parallax' ),
	  'priority'  => 10,
	  'panel'   	=> 'onepage_parallax_team_panel',
  ) );

	// Heading 1
	$wp_customize->add_setting( 'onepage_parallax_team_title', array(
		'default' 					=> esc_html__( 'Our team', 'onepage-parallax' ),
		'sanitize_callback' => 'onepage_parallax_sanitize_text',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_team_title', array(
		'label'       => esc_html__( 'Title', 'onepage-parallax' ),
		'section' 		=> 'onepage_parallax_section_team_settings',
		'settings'    => 'onepage_parallax_team_title',
		'type'        => 'text',
		'priority'    => 5,
	) ) );

	$wp_customize->selective_refresh->add_partial( 'onepage_parallax_team_title', array(
		'selector'            => '.onepage_parallax_team_title',
		'container_inclusive' => true,
	) );

	// Heading 2
  $wp_customize->add_setting( 'onepage_parallax_team_subtitle', array(
	  'default' 					=> __( 'We are amazing and we know it', 'onepage-parallax' ),
	  'sanitize_callback' => 'onepage_parallax_sanitize_text',
	  'transport' 				=> 'postMessage',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_team_subtitle', array(
	  'label'     => esc_html__( 'Subtitle', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_team_settings',
	  'settings'  => 'onepage_parallax_team_subtitle',
	  'type'      => 'textarea',
	  'priority'  => 10,
  ) ) );

	  // Show or Hide this section.
	$wp_customize->add_setting( 'onepage_parallax_team_visible', array(
	  'default' => false,
	  'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_team_visible', array(
	  'label'     => __( 'Make this section visible', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_team_settings',
	  'settings'  => 'onepage_parallax_team_visible',
	  'type'      => 'checkbox',
	  'priority'  => 1,
  ) ) );

  // Addine new team member
  $wp_customize->add_section( 'onepage_parallax_section_team_content' , array(
	  'title'     => esc_html__( 'Team Layout', 'onepage-parallax' ),
	  'priority'  => 10,
	  'panel'   	=> 'onepage_parallax_team_panel',
  ) );

  $wp_customize->add_setting( 'onepage_parallax_team_items', array(
	  'sanitize_callback' => 'onepage_parallax_repeater_sanitize'
	  // 'transport' => 'postMessage'
	) );

  $wp_customize->add_control( new OnePage_Parallax_Repeater_Control( $wp_customize, 'onepage_parallax_team_items', array(
	  'label'   								=> __( 'Team Member','onepage-parallax' ),
	  'section' 								=> 'onepage_parallax_section_team_content',
	  'priority' 								=> 15,
	  'onepage_parallax_subtitle_control' 		=> true,
		'onepage_parallax_pages_control' 				=> true,
		'onepage_parallax_pages_title_control' 	=> true,
		'onepage_parallax_pages_image_control' 	=> true,
	  'onepage_parallax_repeater_control' 		=> true,
	  'onepage_parallax_order'     						=> '4',
  ) ) );

 /*
  * Setting and Control for the Blog Section.
  *
  */

	$wp_customize->add_section( 'onepage_parallax_section_blog' , array(
	  'title'     => esc_html__( 'Section: Blog', 'onepage-parallax' ),
	  'priority'  => 29,
	) );

	$blogLabel = onepage_parallax_default_strings( 'customizer', 'sec_blog_label' );

	$blogText = onepage_parallax_default_strings( 'customizer', 'sec_blog_default' );

	$blogSanitize = array ('onepage_parallax_sanitize_text', 'onepage_parallax_sanitize_text', 'absint', 'absint');

	$blogDiscription = onepage_parallax_default_strings( 'customizer', 'sec_blog_desc' );

	$i = 0;

	while ( $i < 4 ) :

		$i++;

		$wp_customize->add_setting( "onepage_parallax_blog{$i}", array(
			'default' => $blogText[ intval( $i ) - 1 ],
			'sanitize_callback' => $blogSanitize[ intval( $i ) - 1 ],
		) );

		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "onepage_parallax_blog{$i}", array(
			'label'     	=> $blogLabel[intval($i)-1],
			'description' => $blogDiscription[intval($i)-1],
			'section'   	=> 'onepage_parallax_section_blog',
			'settings'  	=> "onepage_parallax_blog{$i}",
			'type'      	=> 'text',
			'priority'  	=> 10,
		) ) );

	endwhile;

	$wp_customize->selective_refresh->add_partial( 'onepage_parallax_blog1', array(
		'selector'            => '.onepage_parallax_blog',
		'container_inclusive' => true,
	) );

	// Show or Hide this section.
	$wp_customize->add_setting( 'onepage_parallax_blog_visible', array(
		'default' 					=> false,
		'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_blog_visible', array(
		'label'       => __( 'Make this section visible', 'onepage-parallax' ),
		'section' 		=> 'onepage_parallax_section_blog',
		'settings'    => 'onepage_parallax_blog_visible',
		'type'        => 'checkbox',
		'priority'    => 1,
	) ) );

	/**
	 * Setting and Control for the Footer Section.
	 *
	 */
	$wp_customize->add_panel( 'onepage_parallax_footer_panel', array(
			'priority' 				=> 30,
			'capability' 			=> 'edit_theme_options',
			'theme_supports'	=> '',
			'title' 					=> esc_html__( 'Section: Footer', 'onepage-parallax' ),
			'description' 		=> esc_html__( 'This panel allows you to customize footer.', 'onepage-parallax' ),
	) );

  //Create Sections for a Contact Form
	$wp_customize->add_section( 'onepage_parallax_section_contact' , array(
		'title'     => esc_html__( 'Contact Us Form', 'onepage-parallax' ),
		'priority'  => 10,
		'panel'   	=> 'onepage_parallax_footer_panel',
	) );

	$wp_customize->add_setting( 'onepage_parallax_contact_title', array(
		'default'	=>	'Get In Touch',
		'sanitize_callback' => 'onepage_parallax_sanitize_text',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_contact_title', array(
		'label'       => __( 'Title', 'onepage-parallax' ),
		'section' 		=> 'onepage_parallax_section_contact',
		'settings'    => 'onepage_parallax_contact_title',
		'type'        => 'text',
		'priority'    => 2,
	) ) );

	$wp_customize->add_setting( 'onepage_parallax_contact_subtitle', array(
		'default'	=>	"Let's Have A Chat",
		'sanitize_callback' => 'onepage_parallax_sanitize_text',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_contact_subtitle', array(
		'label'       => __( 'Subtitle', 'onepage-parallax' ),
		'section' 		=> 'onepage_parallax_section_contact',
		'settings'    => 'onepage_parallax_contact_subtitle',
		'type'        => 'text',
		'priority'    => 3,
	) ) );

	$wp_customize->add_setting( 'onepage_parallax_contact_textarea', array(
		// 'transport' => 'postMessage',
		'default' 	=> __( '
	  <ul class="list-unstyled">
	      <li>
	          <h6>Address:</h6>
	          <p><strong>4699 Harvest Anchor Court, Beaukiss North Carolina, 27070-1683, US,</strong></p>
	      </li>
	      <li>
	          <h6>Phone:</h6>
	          <a href="tel:"><strong>(704) 806-9609</strong></a>
	      </li>
	      <li>
	          <h6>Email:</h6>
	          <a href="mailto:"><strong>hey@aemon.com</strong></a>
	      </li>
	  </ul>' , 'onepage-parallax' ),
		'sanitize_callback' => 'wp_kses_post',
	) );

	$wp_customize->add_control( new OnePage_Parallax_Editor_Control( $wp_customize, 'onepage_parallax_contact_textarea', array(
		'label' 					=> __( 'Contact Editor', 'onepage-parallax' ),
		'section' 				=> 'onepage_parallax_section_contact',
		'settings'  			=> 'onepage_parallax_contact_textarea',
		'editor_settings' => array(
			'quicktags' => true,
			'tinymce'   => true,
		),
			'priority'  		=> 3,
	) ) );

// }

  // Show or Hide this section.
  $wp_customize->add_setting( 'onepage_parallax_contact_visible', array(
	  'default' 					=> false,
	  'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
  ) );

  $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_contact_visible', array(
	  'label'     => __( 'Make this section visible', 'onepage-parallax' ),
	  'section'   => 'onepage_parallax_section_contact',
	  'settings'  => 'onepage_parallax_contact_visible',
	  'type'      => 'checkbox',
	  'priority'  => 1,
  ) ) );

	// Select this section.
	$wp_customize->add_setting( 'onepage_parallax_contact_select', array(
		'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_contact_select', array(
		'section'   => 'onepage_parallax_section_contact',
		'settings'  => 'onepage_parallax_contact_select',
		'type'      => 'hidden',
	) ) );

	$wp_customize->selective_refresh->add_partial( 'onepage_parallax_contact_select', array(
		'selector'            => '.contactForm',
		'container_inclusive' => true,
	) );

	$wp_customize->add_setting( 'onepage_parallax_contact_shortcode', array(
		'sanitize_callback' => 'wp_kses',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_contact_shortcode', array(
		'label'     => __( 'Contact form shortcode', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_contact',
		'settings'  => 'onepage_parallax_contact_shortcode',
		'type'      => 'text',
		'priority'  => 4,
	) ) );

	/**
	 * Add section for Promotion link.
	 *
	 */
	$wp_customize->add_section( 'onepage_parallax_pro', array(
    'title'       => esc_html__( 'Upgrade to Premium', 'onepage-parallax' ),
    'description' => '',
    'priority'    => 1,
  ) );

  $wp_customize->add_setting( 'onepage_parallax_premium_features', array(
    'sanitize_callback' => 'onepage_parallax_sanitize_text',
  ) );

  $wp_customize->add_control( new OnePage_Parallax_Promotion_Control( $wp_customize, 'onepage_parallax_premium_features', array(
    'label'       => esc_html__( 'OnePage Parallax Premium Features', 'onepage-parallax' ),
    'description' => sprintf( __( '
		%1$sPriority Support%2$s
		%1$sDrag & drop section ordering%2$s
		%1$sShowcase your Portfolio%2$s
		%1$sShowcase your Services%2$s
		%1$sAdd Unlimited Team Members%2$s
		%1$sPricing Tables Section%2$s
		%1$sFooter Copyright Editor%2$s
		%1$sRemove Footer Link via Customizer%2$s
		%1$s... and much more %2$s', 'onepage-parallax' ), '<span>', '</span>' ),
    'section'     => 'onepage_parallax_pro',
    'type'        => 'group_heading_message',
  ) ) );

	$wp_customize->add_setting( 'onepage_parallax_premium_links', array(
  	'sanitize_callback' => 'sanitize_text_field',
  ) );

  $wp_customize->add_control( new OnePage_Parallax_Promotion_Control( $wp_customize, 'onepage_parallax_premium_links', array(
    'description' => sprintf( __( '%1$s Buy OnePage Parallax Premium Now %2$s', 'onepage-parallax' ), '<a target="_blank" class="onepage-parallax-premium-buy-button" href="https://wpbrigade.com/wordpress/themes/onepage-parallax/?utm_source=onepage-parallax-lite&utm_medium=customizer-promo&utm_campaign=pro-upgrade">', '</a>' ),
    'onepage-parallax',
    'section'     => 'onepage_parallax_pro',
    'type'        => 'group_heading_message',
  ) ) );

	/*
   * Setting and Control for the Hero Section.
   *
   */

  $wp_customize->add_section( 'onepage_parallax_section_hero' , array(
	  'title'     => esc_html__( 'Section: Hero', 'onepage-parallax' ),
	  'priority'  => 22,
  ) );

	// Show or Hide this section.
	$wp_customize->add_setting( 'onepage_parallax_hero_visible', array(
		'default' => true,
		'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_hero_visible', array(
		'label'     => esc_html__( 'Make this section visible', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_hero',
		'settings'  => 'onepage_parallax_hero_visible',
		'type'      => 'checkbox',
		'priority'  => 1,
	) ) );

	$wp_customize->add_setting( 'onepage_parallax_hero_type', array(
		'default' => 'image',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_hero_type', array(
		'label'       => __( 'Select hero section type', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_hero',
		'settings'    => 'onepage_parallax_hero_type',
		'type'        => 'select',
		'choices'    	=> array(
			'image'   				=> __( 'Use: Header image', 'onepage-parallax' ),
			'gradient-image'  => __( 'Use: Gradient with Header Image', 'onepage-parallax' ),
			'gradient-color'  => __( 'Use: Gradient with Colors Only', 'onepage-parallax' ),
			'shortcode'  			=> __( 'Use: Shortcode', 'onepage-parallax' ) ),
		'priority'    => 2,
	) ) );

	// Show or Hide this section.
	$wp_customize->add_setting( 'onepage_parallax_hero_parallex_visible', array(
		'default' 					=> true,
		'sanitize_callback' => 'onepage_parallax_sanitize_checkbox',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_hero_parallex_visible', array(
	'label'     => __( 'Enable Parallex Effect', 'onepage-parallax' ),
	'section'   => 'onepage_parallax_section_hero',
	'settings'  => 'onepage_parallax_hero_parallex_visible',
	'type'      => 'checkbox',
	'priority'  => 10,
	) ) );

	$wp_customize->add_setting( 'onepage_parallax_hero_color', array(
		'default' 					=> '#000',
		'transport' 				=> 'postMessage',
		'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'onepage_parallax_hero_color', array(
		'label'       => __( 'Header Image Color Overlay', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_hero',
		'settings'    => 'onepage_parallax_hero_color',
		'priority'    => 11,
	) ) );


	$wp_customize->add_setting( 'onepage_parallax_hero_opecity', array(
		'default' 					=> '3',
		'sanitize_callback' => 'onepage_parallax_sanitize_select',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_hero_opecity', array(
		'label'       => __( 'Overlay Opecity', 'onepage-parallax' ),
		'section'     => 'onepage_parallax_section_hero',
		'settings'    => 'onepage_parallax_hero_opecity',
		'type'        => 'select',
		'choices'     => array(
		'0'  			=> __( '0%', 'onepage-parallax' ),
		'1'  			=> __( '10%', 'onepage-parallax' ),
		'2'  			=> __( '20%', 'onepage-parallax' ),
		'3'  			=> __( '30%', 'onepage-parallax' ),
		'4'  			=> __( '40%', 'onepage-parallax' ),
		'5'  			=> __( '50%', 'onepage-parallax' ),
		'6'  			=> __( '60%', 'onepage-parallax' ),
		'7'  			=> __( '70%', 'onepage-parallax' ),
		'8'  			=> __( '80%', 'onepage-parallax' ),
		'9'  			=> __( '90%', 'onepage-parallax' ),
		'10'  		=> __( '100%', 'onepage-parallax' ) ),
		'priority'    => 12,
	) ) );


	$wp_customize->add_setting( 'onepage_parallax_hero_slider_shortcode', array(
		'sanitize_callback' => 'wp_kses',
	) );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'onepage_parallax_hero_slider_shortcode', array(
		'label'     => __( 'Your shortcode', 'onepage-parallax' ),
		'section'   => 'onepage_parallax_section_hero',
		'settings'  => 'onepage_parallax_hero_slider_shortcode',
		'type'      => 'text',
		'priority'  => 14,
	) ) );

	$gradient_default = array( "#9dc02e", "#b75595", "#3498db", "#e7a800" );
	$gradient_label = array( "Gradient Color 1", "Gradient Color 2", "Gradient Color 3", "Gradient Color 4" );

	$gradientClr = 0;

	while ( $gradientClr < 4 ) :

		$wp_customize->add_setting( "onepage_parallax_hero_gradient{$gradientClr}_color", array(
			'default' 					=> $gradient_default[$gradientClr],
			'sanitize_callback' => 'onepage_parallax_sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "onepage_parallax_hero_gradient{$gradientClr}_color", array(
			'label'       => $gradient_label[$gradientClr],
			'section'     => 'onepage_parallax_section_hero',
			'settings'    => "onepage_parallax_hero_gradient{$gradientClr}_color",
			'priority'    => 15 + $gradientClr,
		) ) );

		$gradientClr++;

	endwhile;

	$wp_customize->add_setting( 'onepage_parallax_hero_textarea', array(
		// 'transport' => 'postMessage',
		'default' 	=> __( '<h1>Branding & creative digital solution</h1>
										<p>Our website is under construction. We`ll be here soon with our new awesome site, subscribe to be notified.</p>
										<a href="#" class="action-btn">Action Button</a>
										<a href="#" class="fill-btn">Action Button2</a>', 'onepage-parallax' ),
		'sanitize_callback' => 'wp_kses_post'
	) );

	$wp_customize->add_control( new OnePage_Parallax_Editor_Control( $wp_customize, 'onepage_parallax_hero_textarea', array(
		'label' 					=> __( 'Editor for header', 'onepage-parallax' ),
		'section' 				=> 'onepage_parallax_section_hero',
	  'settings'  			=> 'onepage_parallax_hero_textarea',
		'editor_settings' => array(
			'quicktags' => true,
			'tinymce'   => true,
		),
		  'priority'  		=> 20,
	) ) );

}

add_action( 'customize_register', 'onepage_parallax_theme_customizer', 19 );
