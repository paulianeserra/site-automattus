<?php
/**
 *
 */
class UCMM_WPBrigade_Entities {

  function __construct()
  {
    $this->_hooks();
  }

  public function _hooks() {

    add_action( 'customize_register', array( $this, 'customize_ucmm_wpbrigade' ) );
  }

  /**
  * Register plugin settings Panel in WP Customizer
  *
  * @param	$wp_customize
  * @since	1.0.0
  */
  public function customize_ucmm_wpbrigade( $wp_customize ) {

    //	=============================
    //	= Panel for UCMM WPBrigade  =
    //	=============================
    $wp_customize->add_panel( 'ucmm_wpbrigade_panel', array(
      'title'						=> __( 'Under Construction', 'ucmm-wpbrigade' ),
      'description'			=> __( 'Customize Your WordPress Under Construction Page :)', 'ucmm-wpbrigade' ),
      'priority'				=> 30,
    ) );

    //	=============================
    //	= Section for Logo		      =
    //	=============================
    $wp_customize->add_section(
    'ucmm_wpbrigade_logo_section',
    array(
      'title'				 => __( 'Logo', 'ucmm-wpbrigade' ),
      'description'	 => __( 'Customize Your Logo', 'ucmm-wpbrigade' ),
      'priority'		 => 5,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );

    $wp_customize->add_setting(
    'ucmm_wpbrigade_customization[ucmm_logo]',
    array(
      'type'					=> 'option',
      'capability'		=> 'manage_options',
      'transport'      => 'postMessage'
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ucmm_wpbrigade_customization[ucmm_logo]', array(
      'label'		 => __( 'Logo Image:', 'ucmm-wpbrigade' ),
      'section'	 => 'ucmm_wpbrigade_logo_section',
      'priority'	=> 5,
      'settings'	=> 'ucmm_wpbrigade_customization[ucmm_logo]'
    ) ) );

    $logo_control = array( 'ucmm_logo_width', 'ucmm_logo_height', 'ucmm_logo_padding', 'ucmm_logo_hover', 'ucmm_logo_hover_title' );
    $logo_default = array( '100px', '100px', '200px', '', '' );
    $logo_label   = array(
      __( 'Logo Width:', 'ucmm-wpbrigade' ),
      __( 'Logo Height:', 'ucmm-wpbrigade' ),
      __( 'Padding Bottom:', 'ucmm-wpbrigade' ),
      __( 'Logo URL:', 'ucmm-wpbrigade' ),
      __( 'Logo Hover Title:', 'ucmm-wpbrigade' )
    );

    $logo = 0;
    while ( $logo < 2 ) :

      $wp_customize->add_setting( "ucmm_wpbrigade_customization[{$logo_control[$logo]}]", array(
        'default'					=> $logo_default[$logo],
        'type'						=> 'option',
        'capability'			=> 'manage_options',
        'transport'       => 'postMessage'
      ));

      $wp_customize->add_control( $logo_control[$logo], array(
        'label'						 => $logo_label[$logo],
        'section'					 => 'ucmm_wpbrigade_logo_section',
        'priority'				 => 10,
        'settings'				 => "ucmm_wpbrigade_customization[{$logo_control[$logo]}]"
      ));

      $logo++;
    endwhile;

    //	=============================
    //	= Section for Background		=
    //	=============================
    $wp_customize->add_section( 'ucmm_wpbrigade_background_section', array(
      'title'				 => __( 'Background', 'ucmm-wpbrigade' ),
      'description'	 => '',
      'priority'		 => 10,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );
  
   $wp_customize->add_setting( 'ucmm_wpbrigade_customization[setting_background]', array(
      'default'        =>  UCMM_WPBRIGADE_DIR_URL . 'img/coming-soon.png',
      'type'					 => 'option',
      'capability'		 => 'manage_options',
      'transport'      => 'postMessage'
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ucmm_wpbrigade_customization[setting_background]', array(
      'label'		   => __( 'Background Image:', 'ucmm-wpbrigade' ),
      'section'	   => 'ucmm_wpbrigade_background_section',
      'priority'	 => 15,
      'settings'	 => 'ucmm_wpbrigade_customization[setting_background]',
    ) ) );

    //	=============================
    //	= Section for Text          =
    //	=============================
    $wp_customize->add_section( 'ucmm_wpbrigade_text_section', array(
      'title'				 => __( 'Text Section', 'ucmm-wpbrigade' ),
      'description'	 => '',
      'priority'			=> 15,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );

    $wp_customize->add_setting( "ucmm_wpbrigade_customization[header_text]", array(
      'default'				=> __("UNDER CONSTRUCTION", 'ucmm-wpbrigade'),
      'type'					=> 'option',
      'capability'		=> 'manage_options',
      'transport'     => 'postMessage'
    ) );

    $wp_customize->add_control( 'ucmm_wpbrigade_customization[header_text]', array(
      'label'						 => __('Header Text', 'ucmm-wpbrigade'),
      'section'					 => 'ucmm_wpbrigade_text_section',
      'priority'					=> 5,
      'settings'				 => "ucmm_wpbrigade_customization[header_text]"
    ) );

    $wp_customize->add_setting( "ucmm_wpbrigade_customization[footer_text]", array(
      'default'				=> __( 'We are working hard to bring you new experience', 'ucmm-wpbrigade' ),
      'type'					=> 'option',
      'capability'		=> 'manage_options',
      'transport'     => 'postMessage'
    ) );

    $wp_customize->add_control( 'ucmm_wpbrigade_customization[footer_text]', array(
      'label'						 => __('Footer Text', 'ucmm-wpbrigade'),
      'section'					 => 'ucmm_wpbrigade_text_section',
      'priority'				 => 10,
      'settings'				 => "ucmm_wpbrigade_customization[footer_text]"
    ) );

    //	=============================
    //	= Section for Footer Love   =
    //	=============================

    $wp_customize->add_section( 'section_footer_love', array(
      'title'				 => __( 'Show Some Love', 'ucmm-wpbrigade' ),
      // 'description'	 => __( 'Show some love', 'ucmm-wpbrigade' ),
      'priority'		 => 20,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );

    $wp_customize->add_setting( 'ucmm_wpbrigade_customization[ucmm_display_footer_text]', array(
      'default'        => true,
      'type'           => 'option',
      'capability'		 => 'manage_options',
      'transport'      => 'postMessage'
    ) );

    $wp_customize->add_control( 'ucmm_wpbrigade_customization[ucmm_display_footer_text]', array(
      'settings' => 'ucmm_wpbrigade_customization[ucmm_display_footer_text]',
      'label'		=> __( 'Please help other learn about this free plugin by placing a small link in the footer. Thank you very much!', 'ucmm-wpbrigade'),
      'section'	=> 'section_footer_love',
      'priority' => 5,
      'type'		 => 'checkbox',
    ) );

    //	=============================
    //	= Section for Social Links  =
    //	=============================

    $social_control_c = array( 'ucmm_facebook_c', 'ucmm_twitter_c', 'ucmm_linkedin_c', 'ucmm_google_c', 'ucmm_youtube_c', 'ucmm_instagram_c', 'ucmm_pinterest_c', 'ucmm_codepen_c' );
    $social_label_c   = array(
      __( 'Show Facebook Icon:', 'ucmm-wpbrigade' ),
      __( 'Show Twitter Icon:', 'ucmm-wpbrigade' ),
      __( 'Show Linkedin Icon:', 'ucmm-wpbrigade' ),
      __( 'Show Google Plus Icon:', 'ucmm-wpbrigade' ),
      __( 'Show Youtube Icon:', 'ucmm-wpbrigade' ),
      __( 'Show Instagram Icon:', 'ucmm-wpbrigade' ),
      __( 'Show Pinterest Icon:', 'ucmm-wpbrigade' ),
      __( 'Show Codepen Icon:', 'ucmm-wpbrigade' )
    );
    $social_control = array( 'ucmm_facebook', 'ucmm_twitter', 'ucmm_linkedin', 'ucmm_google', 'ucmm_youtube', 'ucmm_instagram', 'ucmm_pinterest', 'ucmm_codepen' );
    $social_default = array( "https://www.facebook.com/", "https://twitter.com/", "https://www.linkedin.com/", "https://plus.google.com/", "https://www.youtube.com/", "https://www.instagram.com/", "https://www.pinterest.com/", "https://codepen.io/" );
    $social_label   = array(
      __( 'Facebook Link:', 'ucmm-wpbrigade' ),
      __( 'Twitter Link:', 'ucmm-wpbrigade' ),
      __( 'Linkedin Link:', 'ucmm-wpbrigade' ),
      __( 'Google Plus Link:', 'ucmm-wpbrigade' ),
      __( 'YouTube Link:', 'ucmm-wpbrigade' ),
      __( 'Instagram Link:', 'ucmm-wpbrigade' ),
      __( 'Pinterest Link:', 'ucmm-wpbrigade' ),
      __( 'Codepen Link:', 'ucmm-wpbrigade' )
    );

    $wp_customize->add_section( 'ucmm_social_icon_section', array(
      'title'				 => __( 'Add Social Icons', 'ucmm-wpbrigade' ),
      'priority'		 => 25,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );

    $social = 0;
    while ( $social < 8 ) :

      $wp_customize->add_setting( "ucmm_wpbrigade_customization[{$social_control_c[$social]}]", array(
        'default'        => false,
        'type'           => 'option',
        'capability'		 => 'manage_options',
        // 'transport'      => 'postMessage'
      ) );

      $wp_customize->add_control( $social_control_c[$social], array(
        'settings' => "ucmm_wpbrigade_customization[{$social_control_c[$social]}]",
        'label'		=> $social_label_c[$social],
        'section'	=> 'ucmm_social_icon_section',
        // 'priority' => 5,
        'type'		 => 'checkbox',
      ) );

      $wp_customize->add_setting(
        "ucmm_wpbrigade_customization[{$social_control[$social]}]", array(
        'default'					=> $social_default[$social],
        'type'						=> 'option',
        'capability'			=> 'manage_options',
        // 'transport'       => 'postMessage'
      ) );

      $wp_customize->add_control( $social_control[$social], array(
        'label'						 => $social_label[$social],
        'section'					 => 'ucmm_social_icon_section',
        // 'priority'				 => 10,
        'settings'				 => "ucmm_wpbrigade_customization[{$social_control[$social]}]"
      ));

      $social++;
    endwhile;

    //	=============================
    //	= Section for Custom CSS		=
    //	=============================
    $wp_customize->add_section(
    'ucmm_section_css',
    array(
      'title'				 => __( 'Custom CSS', 'ucmm-wpbrigade' ),
      'description'	 => '',
      'priority'		 => 30,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );

    $wp_customize->add_setting( 'ucmm_wpbrigade_customization[ucmm_custom_css]', array(
      //'default'         => "/* You can add your custom CSS here. */",
      'type'						=> 'option',
      'capability'			=> 'manage_options',
      'transport'       => 'postMessage'
    ) );

    $wp_customize->add_control( 'ucmm_wpbrigade_customization[ucmm_custom_css]', array(
      'label'						 => __( 'Customize CSS', 'ucmm-wpbrigade' ),
      'type'						 => 'textarea',
      'section'					 => 'ucmm_section_css',
      'input_attrs' => array(
      'placeholder' => __( 'You can add your custom CSS here.', 'ucmm-wpbrigade' ) ),
      'priority'				 => 5,
      'settings'				 => 'ucmm_wpbrigade_customization[ucmm_custom_css]'
    ) );

    //	=============================
    //	= Section for SEO Configuration
    //	=============================

    $seo_control = array( 'ucmm_seo_title', 'ucmm_seo_description', 'ucmm_seo_url', 'ucmm_seo_sitename', 'ucmm_seo_admin', 'ucmm_seo_keywords' );
    $seo_default = array( "", "", get_bloginfo( 'url' ), get_bloginfo( 'name' ), "", "" );
    $seo_label   = array(
      __( 'SEO Title:', 'ucmm-wpbrigade' ),
      __( 'SEO Description:', 'ucmm-wpbrigade' ),
      __( 'SEO URL:', 'ucmm-wpbrigade' ),
      __( 'SEO Site Name:', 'ucmm-wpbrigade' ),
      __( 'SEO Author Name:', 'ucmm-wpbrigade' ),
      __( 'SEO Keywords:', 'ucmm-wpbrigade' )
    );

    $wp_customize->add_section(
    'ucmm_seo_section',
    array(
      'title'				 => __( 'SEO Configuration', 'ucmm-wpbrigade' ),
      'description'	 => '',
      'priority'		 => 35,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );

    $seo = 0;
    while ( $seo < 6 ) :

      $wp_customize->add_setting(
        "ucmm_wpbrigade_customization[{$seo_control[$seo]}]", array(
        'default'					=> $seo_default[$seo],
        'type'						=> 'option',
        'capability'			=> 'manage_options',
        // 'transport'       => 'postMessage'
      ) );

      $wp_customize->add_control( $seo_control[$seo], array(
        'label'						 => $seo_label[$seo],
        'section'					 => 'ucmm_seo_section',
        'settings'				 => "ucmm_wpbrigade_customization[{$seo_control[$seo]}]"
      ));

      $seo++;
    endwhile;

    //	=============================
    //	= Section for Google Analytics
    //	=============================
    $wp_customize->add_section(
    'ucmm_ga_tracking_section',
    array(
      'title'				 => __( 'Google Analytics Tracking Code', 'ucmm-wpbrigade' ),
      'description'	 => '',
      'priority'		 => 40,
      'panel'				 => 'ucmm_wpbrigade_panel',
    ) );

    $wp_customize->add_setting( 'ucmm_wpbrigade_customization[ucmm_ga_tracking_code]', array(
      //'default'         => "/* Google Analytics Tracking Code here. */",
      'type'						=> 'option',
      'capability'			=> 'manage_options',
      'transport'       => 'postMessage'
    ) );

    $wp_customize->add_control( 'ucmm_wpbrigade_customization[ucmm_ga_tracking_code]', array(
      'label'						 => __( 'Google Analytics Tracking Code', 'ucmm-wpbrigade' ),
      'type'						 => 'textarea',
      'section'					 => 'ucmm_ga_tracking_section',
      'priority'				 => 5,
      'input_attrs' => array(
        'placeholder' => __( 'Google Analytics Tracking Code here.', 'ucmm-wpbrigade' ) ),
      'settings'				 => 'ucmm_wpbrigade_customization[ucmm_ga_tracking_code]'
    ) );
  }
}
?>
