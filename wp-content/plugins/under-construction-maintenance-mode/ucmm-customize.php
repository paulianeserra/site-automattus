<?php
/**
* @var $ucmm_wpbrigade_array get_option
* @since 1.0.0
*/
$ucmm_wpbrigade_array = (array) get_option( 'ucmm_wpbrigade_customization' );


function ucmm_wpbrigade_option_key( $ucmm_key, $ucmm_wpbrigade_array ) {

	if ( array_key_exists( $ucmm_key, $ucmm_wpbrigade_array ) ) {

		return $ucmm_wpbrigade_array[ $ucmm_key ];

	}
	// else {
	//   return false;
	// }
}
/**
* ucmm_wpbrigade_default_option_key
* @since 1.0.2
*/
function ucmm_wpbrigade_default_option_key( $ucmm_key, $ucmm_wpbrigade_array , $default = true ) {

	if ( array_key_exists( $ucmm_key, $ucmm_wpbrigade_array ) ) {

		return $ucmm_wpbrigade_array[ $ucmm_key ];

	}
	else {
		return $default;
	}
}

$ucmm_bg     			= ucmm_wpbrigade_option_key( 'setting_background', $ucmm_wpbrigade_array);
$ucmm_logo   			= ucmm_wpbrigade_option_key( 'ucmm_logo', $ucmm_wpbrigade_array);
$ucmm_header 			= ucmm_wpbrigade_option_key( 'header_text', $ucmm_wpbrigade_array);
$ucmm_footer 			= ucmm_wpbrigade_option_key( 'footer_text', $ucmm_wpbrigade_array);
$ucmm_logo_width 	= ucmm_wpbrigade_option_key( 'ucmm_logo_width', $ucmm_wpbrigade_array);
$ucmm_logo_height = ucmm_wpbrigade_option_key( 'ucmm_logo_height', $ucmm_wpbrigade_array);
$ucmm_seo_title 	= ucmm_wpbrigade_option_key( 'ucmm_seo_title', $ucmm_wpbrigade_array);
$ucmm_seo_description = ucmm_wpbrigade_option_key( 'ucmm_seo_description', $ucmm_wpbrigade_array);
$ucmm_seo_url 	= ucmm_wpbrigade_option_key( 'ucmm_seo_url', $ucmm_wpbrigade_array);
$ucmm_seo_sitename = ucmm_wpbrigade_option_key( 'ucmm_seo_sitename', $ucmm_wpbrigade_array);
$ucmm_seo_admin = ucmm_wpbrigade_option_key( 'ucmm_seo_admin', $ucmm_wpbrigade_array);
$ucmm_seo_keywords = ucmm_wpbrigade_option_key( 'ucmm_seo_keywords', $ucmm_wpbrigade_array);
$ucmm_custom_css  = ucmm_wpbrigade_option_key( 'ucmm_custom_css', $ucmm_wpbrigade_array );
$ucmm_ga_tracking_code  = ucmm_wpbrigade_option_key( 'ucmm_ga_tracking_code', $ucmm_wpbrigade_array );
$ucmm_footer_love = ucmm_wpbrigade_default_option_key( 'ucmm_display_footer_text', $ucmm_wpbrigade_array);


$social_icons  =array( 'ucmm_facebook_c', 'ucmm_twitter_c', 'ucmm_linkedin_c', 'ucmm_google_c', 'ucmm_youtube_c', 'ucmm_instagram_c', 'ucmm_pinterest_c', 'ucmm_codepen_c' );
$social_links = array( 'ucmm_facebook', 'ucmm_twitter', 'ucmm_linkedin', 'ucmm_google', 'ucmm_youtube', 'ucmm_instagram', 'ucmm_pinterest', 'ucmm_codepen' );

$ucmm_social_icons = array();
$ucmm_social_links = array();

for( $i = 0;  $i < count( $social_icons ) ; $i++ ){

	 $ucmm_social_icons[ $social_icons[$i]] = ucmm_wpbrigade_default_option_key( $social_icons[$i], $ucmm_wpbrigade_array, '');
	 $ucmm_social_links[ $social_links[$i]] = ucmm_wpbrigade_default_option_key( $social_links[$i], $ucmm_wpbrigade_array, '');

}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- <link rel="icon" href="<?php //echo site_icon_url();?>" sizes="32x32" /> -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="title" content="<?php echo $ucmm_seo_title;?>" />
	<meta name="description" content="<?php echo $ucmm_seo_description;?>" />
	<meta name="url" content="<?php echo $ucmm_seo_url;?>" />
	<meta name="site_name" content="<?php echo $ucmm_seo_sitename;?>" />
	<meta name="author" content="<?php echo $ucmm_seo_admin;?>">
	<meta name="keywords" content="<?php echo $ucmm_seo_keywords;?>">
	<title><?php echo get_bloginfo('name'); ?></title>
	
	<link href="<?php echo  plugins_url( 'assets/css/fa-brands.min.css', __FILE__ ) ?>" rel="stylesheet">
	<link href="<?php echo  plugins_url( 'assets/css/fontawesome.min.css', __FILE__ ) ?>" rel="stylesheet">
	
	<!--Adding Google analytics code-->
	<?php if ( ! empty( $ucmm_ga_tracking_code ) ) : ?>
  <?php echo $ucmm_ga_tracking_code; ?>
  <?php endif; ?>

	<style media="screen">
	html{
		height: 100%;
	}
	body{
		display: table;
		min-height: 100%;
		margin: 0;
		text-align: center;
		width: 100%;
		background-image: url(<?php echo null != $ucmm_bg ? $ucmm_bg : plugins_url( 'img/coming-soon.png', __FILE__ ); ?>);
		background-size: cover;
		background-position: center;
		
	}
	h1{
		font-size: 60px;
		color: #fff;
		text-transform: uppercase;
		margin: 0;
	}
	.ucmm-logo{
		<?php if ( '' == $ucmm_logo ): ?>
		padding-top: 70px;
		<?php else : ?>
		padding-top: 20px;
		<?php endif; ?>
		vertical-align: middle;
		text-align: center; 
		width: 100%;
		font-size: 50px;
		font-weight: bold;
		color: #fff;
	}
	.ucmm-logo img{
		width: <?php echo empty( $ucmm_logo_width )? '100px' : $ucmm_logo_width ; ?>;
		height: <?php echo empty( $ucmm_logo_height )? '100px' : $ucmm_logo_height; ?>;
	}
	h2{
		font-size: 20px;
		color: #fff;
		margin: 0;
		font-family: inherit;
	}
	.footer-love {
		position: absolute;
		color: #fff;
		right: 0;
		bottom: 0;
		padding-right: 20px;
		padding-bottom: 5px;
	}
	.footer-love a{
		text-decoration: none;
		color: #fff;
	}
	.footer-love a:hover{
		color: #3BB9FF;
	}
	/* Icons style start here */
	.ucmm-social-icons{
		position: absolute;
		bottom: 30px;
		width: 100%;
		left: 0;
	}
	.ucmm-icon{
		width: 40px;
		height: 40px;
		display: inline-block;
		line-height: 40px;
		border-radius: 50%;
		margin: 5px;
	}
	.ucmm-icon .fab{
		color: #fff;
		vertical-align: middle;
		font-size: 18px;
		line-height: 40px;
	}
	.ucmm-facebook-icon{
		background: #3b5998;
	}
	.ucmm-twitter-icon{
		background: #0084b4;
	}
	.ucmm-linkedin-icon{
		background: #0077B5;
	}
	.ucmm-google-icon{
		background: #d34836;
	}
	.ucmm-youtube-icon{
		background: #FF0000;
	}
	.ucmm-instagram-icon{
		background: #3f729b;
	}
	.ucmm-pinterest-icon{
		background: #C92228;
	}
	.ucmm-codepen-icon{
		background: #000;
	}
	/* Icons style end here */

	<?php if ( ! empty( $ucmm_custom_css ) ) : ?>
	<?php echo $ucmm_custom_css; ?>
	<?php endif; ?>
	</style>

</head>
<body>
	<div class="ucmm-logo">

 	<img src="<?php echo $ucmm_logo?>" style="<?php echo ( '' == $ucmm_logo )? 'display:none' : '';?>"  >

		<h1><?php if ( $ucmm_header ) {
			echo $ucmm_header;
		} else {
			echo __("UNDER CONSTRUCTION", 'ucmm-wpbrigade');
		} ?></h1>
		<h2> <?php if ( $ucmm_footer ) {
			echo $ucmm_footer;
		} else {
			echo __( 'We are working hard to bring you new experience', 'ucmm-wpbrigade' );
		} ?> </h2>

	</div>
	
	<div class="ucmm-social-icons">
	<?php
 /*	
   $social_icons  =array( 'ucmm_facebook_c', 'ucmm_twitter_c', 'ucmm_linkedin_c', 'ucmm_google_c', 'ucmm_youtube_c', 'ucmm_instagram_c', 'ucmm_pinterest_c', 'ucmm_codepen_c' );
  $social_links = array( 'ucmm_facebook', 'ucmm_twitter', 'ucmm_linkedin', 'ucmm_google', 'ucmm_youtube', 'ucmm_instagram', 'ucmm_pinterest', 'ucmm_codepen' );
 */


	if ( true == $ucmm_social_icons['ucmm_facebook_c'] ) {
		
   echo '<a class="ucmm-facebook-icon ucmm-icon" href="'. $ucmm_social_links['ucmm_facebook'] . '"><i class="fab fa-facebook-f"></i></a>';
	 
	}
	if ( true == $ucmm_social_icons['ucmm_twitter_c'] ) {
	 
		echo '<a class="ucmm-twitter-icon ucmm-icon" href="' . $ucmm_social_links['ucmm_twitter'] . '"><i class="fab fa-twitter"></i></a>';
   
	}
	if ( true == $ucmm_social_icons['ucmm_linkedin_c'] ) {
	 
		echo '<a class="ucmm-linkedin-icon ucmm-icon" href="' . $ucmm_social_links['ucmm_linkedin'] . '"><i class="fab fa-linkedin"></i></a>';
	 
	}
	if ( true == $ucmm_social_icons['ucmm_google_c'] ) {
	 
		echo '<a class="ucmm-google-icon ucmm-icon" href="' .$ucmm_social_links['ucmm_google']. '"><i class="fab fa-google-plus-g"></i></a>';
	 
	}
	if( true == $ucmm_social_icons['ucmm_youtube_c'] ) {
	 
		echo '<a class="ucmm-youtube-icon ucmm-icon" href="' . $ucmm_social_links['ucmm_youtube'] . '"><i class="fab fa-youtube"></i></a>';
	 
	}
	if( true == $ucmm_social_icons['ucmm_instagram_c'] ) {
	 
		echo '<a class="ucmm-instagram-icon ucmm-icon" href="' . $ucmm_social_links['ucmm_instagram'] . '"><i class="fab fa-instagram"></i></a>';
	 
	}
	if( true == $ucmm_social_icons['ucmm_pinterest_c'] ) {
	 
		echo '<a class="ucmm-pinterest-icon ucmm-icon" href="'. $ucmm_social_links['ucmm_pinterest'] .'"><i class="fab fa-pinterest"></i></a>';
	 
	}
	if( true == $ucmm_social_icons['ucmm_codepen_c'] ) {
	 
		echo '<a class="ucmm-codepen-icon ucmm-icon" href="' . $ucmm_social_links['ucmm_codepen'] . '"><i class="fab fa-codepen"></i></a>';
	 
	} 
	 
	 
	?>

	</div>
	<?php if ( $ucmm_footer_love ) : ?>
		<div class="footer-love">
			<?php _e( 'Powered by:', 'ucmm-wpbrigade' ); ?> <a href="https://wordpress.org/plugins/under-construction-maintenance-mode/" target="_blank">WPBrigade</a>
		</div>
	<?php endif; ?>

</body>
</html>
