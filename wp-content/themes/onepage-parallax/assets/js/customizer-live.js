/**
 * This file adds LIVE to the Theme Customizer live preview.
 */

( function( $ ) {

	/**
	 * Updates Textual values in real time.
	 */
			function onepage_parallax_live_text( id, target ) {
				wp.customize( id, function( value ) {
					value.bind( function( newval ) {
						$( target ).html( newval );
					} );
				} );
			}


	/**
	 * Updates background color in real time.
	 */
			function onepage_parallax_live_color_background( id, target ) {
				wp.customize( id, function( value ) {
					value.bind( function( newval ) {
						var append_val = "background:" + newval;
						$( target ).attr('style', append_val);
					} );
				} );
			}


	/**
	 * Updates background color in real time.
	 */
			function onepage_parallax_live_color_text( id, target ) {
				wp.customize( id, function( value ) {
					value.bind( function( newval ) {
						var append_val = "color:" + newval;
						$( target ).attr('style', append_val);
					} );
				} );
			}


	/**
	 * [Changing AboutUs section values]
	 */

	//Textual values
	onepage_parallax_live_text( 'onepage_parallax_about_subtitle','.about_top_h2' );


 /**
  * [Changing Services section values]
  */

 	//Textual values
	onepage_parallax_live_text( 'onepage_parallax_service_subtitle','.onepage_parallax_services_subtitle' );


	/**
	 * [Changing Pricing section values]
	 */

	//Textual and Numaric values
	onepage_parallax_live_text( 'onepage_parallax_pro_offer_subtitle','.onepage_parallax_price_subtitle' );


	/**
	 * [Changing Team section values]
	 */

	//Textual and Numaric values
	onepage_parallax_live_text( 'onepage_parallax_team_subtitle','.onepage_parallax_team_title' );


	/**
	 * [Changing Contact Us section values]
	 */

	//Textual and Numaric values
	onepage_parallax_live_text( 'onepage_parallax_touch_number_2','.onepage_parallax_git_num_2' );
	onepage_parallax_live_text( 'onepage_parallax_touch_number_3','.smallTxt2' );
	onepage_parallax_live_text( 'onepage_parallax_touch_number_4','.phoneNumber' );
	onepage_parallax_live_text( 'onepage_parallax_touch_number_5','.msgBtn' );


	/**
	 * Changing Site colors.
	 */

	 onepage_parallax_live_color_background( 'onepage_parallax_colors_background','body' );
	 onepage_parallax_live_color_background( 'onepage_parallax_colors_footer_bg','.wpb_copy_right' );
	 onepage_parallax_live_color_background( 'onepage_parallax_header_bg_color','.wpb_header' );
	 onepage_parallax_live_color_background( 'onepage_parallax_header_bg_color','.blog-header' );
	 onepage_parallax_live_color_background( 'onepage_parallax_header_nav_bg_color','.wpb_nav' );
	 onepage_parallax_live_color_text( 'onepage_parallax_colors_footer','.wpb_copy_right p' );
	 onepage_parallax_live_color_text( 'onepage_parallax_header_title_color','.blogheader' );
	 onepage_parallax_live_color_text( 'onepage_parallax_header_title_color','.blogtagline' );
	 onepage_parallax_live_color_text( 'onepage_parallax_header_nav_color','#onepage_parallax_menu a' );

} )( jQuery );
