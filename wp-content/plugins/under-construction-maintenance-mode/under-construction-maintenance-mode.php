<?php
/**
 * Plugin Name: Under Construction & Maintenance Mode
 * Plugin URI: https://wpbrigade.com/wordpress/plugins/under-construction-maintenance-mode/
 * Description: This plugin will Display an Under Construction, Maintenance Mode or Coming Soon landing Page that takes 5 seconds to setup, while you're doing maintenance work on your site.
 * Version: 1.0.5
 * Author: WPBrigade
 * Author URI: https://www.WPBrigade.com/
 * Requires at least: 4.0
 * Tested up to: 4.9
 * Text Domain: ucmm-wpbrigade
 * Domain Path: /languages
 *
 * @package ucmm-wpbrigade
 * @category Core
 * @author WPBrigade
 */

/**
 *
 */

if ( ! class_exists( 'UCMM_WPBrigade' ) ) :

	class UCMM_WPBrigade {

		/**
		 * @var string
		 */
		public $version = '1.0.5';

    /**
     * @var array
     * @since 1.0.5
     */
    public $ucmm_settings;

		function __construct() {

			$this->define_constants();
			$this->_hooks();
      $this->includes();
		}

		public function define_constants() {

			$this->define( 'UCMM_WPBRIGADE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'UCMM_WPBRIGADE_DIR_PATH', plugin_dir_path( __FILE__ ) );
			$this->define( 'UCMM_WPBRIGADE_DIR_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'UCMM_WPBRIGADE_ROOT_PATH', dirname( __FILE__ ) . '/' );
			$this->define( 'UCMM_WPBRIGADE_VERSION', $this->version );
			$this->define( 'UCMM_WPBRIGADE_FEEDBACK_SERVER', 'https://wpbrigade.com/' );
			$this->define( 'UCMM_WPBRIGADE_MAIN_FILE', 'under-construction-maintenance-mode.php' );
		}

		public function _hooks() {

			register_activation_hook( __FILE__, array( $this, 'ucmm_activation' ) );
			register_deactivation_hook( __FILE__, array( $this, 'ucmm_deactivation' ) );

			add_action( 'init', array( $this, 'ucmm_redirect_customizer' ) );
			add_action( 'init', array( $this, 'ucmm_set_setting' ) );
			add_action( 'plugins_loaded', array( $this, 'ucmm_textdomain' ) );
			add_filter( 'plugin_row_meta', array( $this, 'ucmm_row_meta' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'ucmm_admin_scripts' ) );
			add_action( 'parse_request', array( $this, 'ucmm_parse_request' ), 10, 1 );
			add_action( 'admin_menu', array( $this, 'ucmm_callback_url' ), 99 );
			add_action( 'admin_footer', array( $this, 'ucmm_add_deactive_modal' ) );
			add_action( 'admin_init', array( $this, 'ucmm_review_notice' ) );
			add_action( 'wp_ajax_ucmm_deactivate', array( $this, 'ucmm_deactivate' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'loginpress_customizer_js' ) );
			add_action( 'wp_ajax_ucmm_mc_api', array( $this, 'ucmm_mc_api_function' ) );
			add_action( 'wp_ajax_nopriv_ucmm_mc_api', array( $this, 'ucmm_mc_api_function' ) );
			add_action( 'admin_bar_menu', array( $this, 'ucmm_admin_top_menu' ), 100 );
			add_action( 'admin_footer', array( $this, 'ucmm_admin_css' ), 11);
		}

		public function includes() {

			include_once UCMM_WPBRIGADE_DIR_PATH . 'classes/customizer.php';
			new UCMM_WPBrigade_Entities();
			include_once UCMM_WPBRIGADE_DIR_PATH . 'classes/ucmm-wpbrigade-setup.php';
			new UCMM_WPBrigade_Setting();
		}

		/**
		 * Load Languages
		 *
		 * @since 1.0.0
		 */
		public function ucmm_textdomain() {

			$plugin_dir = dirname( plugin_basename( __FILE__ ) );
			load_plugin_textdomain( 'ucmm-wpbrigade', false, $plugin_dir . '/languages/' );
		}

		public function ucmm_activation() {

			/*Activation Plugin*/
			$this::ucmm_remove_cache();

		}

		public function ucmm_deactivation() {

			/*Deactivation Plugin*/
			$this::ucmm_remove_cache();
		}

		public static function ucmm_remove_cache() {

			global $file_prefix;
			if ( function_exists( 'w3tc_pgcache_flush' ) ) {
				w3tc_pgcache_flush();
			}
			if ( function_exists( 'wp_cache_clean_cache' ) ) {
				wp_cache_clean_cache( $file_prefix, true );
			}
		}

		function ucmm_redirect_customizer() {

			if ( ! empty( $_GET['page'] ) ) {
				if ( $_GET['page'] == 'under-construction-maintenance-mode' ) {

					wp_redirect( admin_url() . 'customize.php?autofocus[panel]=ucmm_wpbrigade_panel&url=' . home_url() . '/ucmm-customize.php?watch=ucmm-customizer' );

					// wp_redirect(get_admin_url()."customize.php?url=".home_url()."/ucmm-customize.php?watch=ucmm-customizer");
				}
			}
		}

		function ucmm_parse_request( $wp ) {

			global $wp_customize, $current_user;
			$current_user_role = current( $current_user->roles );

			// For front page.
			$ucmm_settings = get_option( 'ucmm_wpbrigade_setting' );

			if ( isset( $ucmm_settings['ucmm-status'] ) && 'on' == $ucmm_settings['ucmm-status'] && ! $wp_customize ) {

				if ( ! isset( $ucmm_settings['ucmm-enable'][ 'ucmm-wpbrigade_role_' . $current_user_role ] ) ) {

					include UCMM_WPBRIGADE_DIR_PATH . 'ucmm-customize.php';
					exit();
				}

				return;
			}

			// For customizer.
			if ( isset( $wp_customize ) && isset( $_GET['watch'] ) && $_GET['watch'] == 'ucmm-customizer' ) {

				include UCMM_WPBRIGADE_DIR_PATH . 'ucmm-customize.php';
				exit();
				return;
			}

		}

		/**
		 * Enqueue jQuery and use wp_localize_script.
		 *
		 * @since 1.0.9
		 */
		function loginpress_customizer_js() {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'ucmm-customize-control', plugins_url( 'assets/js/customize-controls.js', __FILE__ ), array( 'jquery', 'customize-preview' ), UCMM_WPBRIGADE_VERSION, true );
			wp_localize_script( 'ucmm-customize-control', 'UCMM', array( 'url_path' => plugin_dir_url( __FILE__ ) ) );
		}
		/**
		 * Define constant if not already set
		 *
		 * @param  string      $name
		 * @param  string|bool $value
		 * @since 1.0.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}


		public function ucmm_row_meta( $links, $file ) {

			if ( strpos( $file, UCMM_WPBRIGADE_MAIN_FILE ) !== false ) {

				// Set link for Reviews.
				$new_links = array(
					'<a href="https://wordpress.org/support/view/plugin-reviews/under-construction-maintenance-mode/" target="_blank"><span class="dashicons dashicons-thumbs-up"></span> ' . __( 'Vote!', 'ucmm-wpbrigade' ) . '</a>',
				);

				$links = array_merge( $links, $new_links );
			}

			return $links;
		}

		public function ucmm_admin_scripts() {
			wp_enqueue_style( 'ucmm_stlye', plugins_url( 'assets/css/style.css', __FILE__ ), array(), UCMM_WPBRIGADE_VERSION );
			wp_enqueue_script( 'ucmm-js', plugins_url( 'assets/js/main.js', __FILE__ ), array( 'jquery' ), '1.0.1', true );

			/**
			*  Localizes a registered script with data for a JavaScript variable.
			*
			*  1st Attribute is the Handle that is same as our enqueue js file.
			*  2nd Attribute is the Name that is use in ajax => url.
			*  3rd Attribute is the Data itself in which we pass the admin-ajax path in array.
			*/
			wp_localize_script(
				'ucmm-js', 'mc_api', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'loader'  => admin_url( '/images/spinner.gif' ),
				)
			);
		}

		/**
		 * Ask users to review our plugin on wordpress.org
		 *
		 * @since 1.0.1
		 * @return boolean false
		 */
		public function ucmm_review_notice() {

			$this->ucmm_review_dismissal();
			$this->ucmm_review_pending();

			$activation_time  = get_site_option( 'ucmm_active_time' );
			$review_dismissal = get_site_option( 'ucmm_review_dismiss' );

			if ( 'yes' == $review_dismissal ) {
				return;
			}

			if ( ! $activation_time ) :

				$activation_time = time();
				add_site_option( 'ucmm_active_time', $activation_time );
			endif;

			// 1296000 = 15 Days in seconds.
			if ( time() - $activation_time > 1296000 ) :
				add_action( 'admin_notices', array( $this, 'ucmm_review_notice_message' ) );
			endif;
		}

		/**
		 *  Check and Dismiss review message.
		 *
		 *  @since 1.0.1
		 */
		private function ucmm_review_dismissal() {

			if ( ! is_admin() ||
			! current_user_can( 'manage_options' ) ||
			! isset( $_GET['_wpnonce'] ) ||
			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'ucmm-review-nonce' ) ||
			! isset( $_GET['ucmm_review_dismiss'] ) ) :

				return;
			endif;

			add_site_option( 'ucmm_review_dismiss', 'yes' );
		}

		/**
		 * Set time to current so review notice will popup after 14 days
		 *
		 * @since 1.0.1
		 */
		function ucmm_review_pending() {

			if ( ! is_admin() ||
			! current_user_can( 'manage_options' ) ||
			! isset( $_GET['_wpnonce'] ) ||
			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'ucmm-review-nonce' ) ||
			! isset( $_GET['ucmm_review_later'] ) ) :

				return;
		  endif;

			// Reset Time to current time.
			update_site_option( 'ucmm_active_time', time() );
		}

		/**
		 * Review notice message
		 *
		 * @since  1.0.11
		 */
		public function ucmm_review_notice_message() {

			$scheme      = ( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ) ) ? '&' : '?';
			$url         = $_SERVER['REQUEST_URI'] . $scheme . 'ucmm_review_dismiss=yes';
			$dismiss_url = wp_nonce_url( $url, 'ucmm-review-nonce' );

			$_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'ucmm_review_later=yes';
			$later_url   = wp_nonce_url( $_later_link, 'ucmm-review-nonce' );

			?>
		  <div class="ucmm-review-notice">
			  <div class="ucmm-review-thumbnail">
				  <img src="<?php echo plugins_url( 'img/review-icon.png', __FILE__ ); ?>" alt="">
			  </div>
			  <div class="ucmm-review-text">
				  <h3><?php _e( 'Leave A Review?', 'ucmm-wpbrigade' ); ?></h3>
				  <p><?php _e( 'We hope you\'ve enjoyed using Under Construction & Maintenance Mode! Would you consider leaving us a review on WordPress.org?', 'ucmm-wpbrigade' ); ?></p>
				  <ul class="ucmm-review-ul">
			<li><a href="https://wordpress.org/support/view/plugin-reviews/under-construction-maintenance-mode?rate=5#postform" target="_blank"><span class="dashicons dashicons-external"></span><?php _e( 'Sure! I\'d love to!', 'ucmm-wpbrigade' ); ?></a></li>
			<li><a href="<?php echo $dismiss_url; ?>"><span class="dashicons dashicons-smiley"></span><?php _e( 'I\'ve already left a review', 'ucmm-wpbrigade' ); ?></a></li>
			<li><a href="<?php echo $later_url; ?>"><span class="dashicons dashicons-calendar-alt"></span><?php _e( 'Maybe Later', 'ucmm-wpbrigade' ); ?></a></li>
			<li><a href="<?php echo $dismiss_url; ?>"><span class="dashicons dashicons-dismiss"></span><?php _e( 'Never show again', 'ucmm-wpbrigade' ); ?></a></li></ul>
			  </div>
		  </div>
			<?php
		}

		public function ucmm_mc_api_function() {

			include UCMM_WPBRIGADE_DIR_PATH . 'includes/mc-get_lists.php';
			wp_die();
		}

		/**
		 * Add deactivate modal layout.
		 */
		public function ucmm_add_deactive_modal() {
			global $pagenow;

			if ( 'plugins.php' !== $pagenow ) {
				return;
			}

			include UCMM_WPBRIGADE_DIR_PATH . 'includes/deactivate_modal.php';
		}

		function ucmm_deactivate() {

			$email         = get_option( 'admin_email' );
			$_reason       = sanitize_text_field( wp_unslash( $_POST['reason'] ) );
			$reason_detail = sanitize_text_field( wp_unslash( $_POST['reason_detail'] ) );
			$reason        = '';

			if ( '1' == $_reason ) {
				$reason = 'I only needed the plugin for a short period';
			} elseif ( '2' == $_reason ) {
				$reason = 'I found a better plugin';
			} elseif ( '3' == $_reason ) {
				$reason = 'The plugin broke my site';
			} elseif ( '4' == $_reason ) {
				$reason = 'The plugin suddenly stopped working';
			} elseif ( '5' == $_reason ) {
				$reason = 'I no longer need the plugin';
			} elseif ( '6' == $_reason ) {
				$reason = 'It\'s a temporary deactivation. I\'m just debugging an issue.';
			} elseif ( '7' == $_reason ) {
				$reason = 'Other';
			}
			$fields = array(
				'email'             => $email,
				'website'           => get_site_url(),
				'action'            => 'Deactivate',
				'reason'            => $reason,
				'reason_detail'     => $reason_detail,
				'blog_language'     => get_bloginfo( 'language' ),
				'wordpress_version' => get_bloginfo( 'version' ),
				'plugin_version'    => UCMM_WPBRIGADE_VERSION,
				'plugin_name'       => 'Under Construction Free',
			);

			$response = wp_remote_post(
				UCMM_WPBRIGADE_FEEDBACK_SERVER, array(
					'method'      => 'POST',
					'timeout'     => 5,
					'httpversion' => '1.0',
					'blocking'    => false,
					'headers'     => array(),
					'body'        => $fields,
				)
			);

			wp_die();
		}

		public function ucmm_callback_url() {

			global $submenu;

			$parent = 'index.php';
			$page   = 'under-construction-maintenance-mode';

			// Create specific url for login view
			$login_url = wp_login_url();
			$url       = add_query_arg(
				array(
					'url'    => urlencode( $login_url ),
					'return' => admin_url( 'themes.php' ),
				),
				admin_url( 'customize.php' )
			);

			// If is Not Design Menu, return
			if ( ! isset( $submenu[ $parent ] ) ) :
				return null;
		  endif;

			foreach ( $submenu[ $parent ] as $key => $value ) :
				// Set new URL for menu item
				if ( $page === $value[2] ) :
					$submenu[ $parent ][ $key ][2] = $url;
					break;
				endif;
		  endforeach;
		}
    /**
     * @since 1.0.5
     */
		public function ucmm_admin_top_menu() {
			global $wp_admin_bar;
			$value = $this->ucmm_get_options( 'ucmm-status', 'off' );
			if ( $value == 'on' ) {
				$argsParent = array(
					'id'    => 'ucmm_top_menu',
					'title' => 'Under Construction mode Enabled',
					'href'  => admin_url( '?page=ucmm_settings' ),
					'meta'  => array( 'class' => 'ucmm_top_menu' ),

				);
				$wp_admin_bar->add_menu( $argsParent );
			}

    }
    
    /**
     * custom css for admin.
     * @since 1.0.5
     */
    public function ucmm_admin_css(){
    echo  '<style>
     #wp-admin-bar-ucmm_top_menu a{
      background: #9522ce;
     }
      #wp-admin-bar-ucmm_top_menu a:hover{
      background: #731f9c !important;
      color:#fff!important;
     }  
    
      </style>';

    }
    /**
     * Get setting option uccm options
     * @since 1.0.5
     * @param string $ucmm_key option key in options.
     * @param mixed    $default_value default value of the option.
     * 
     * @return mixed  any type will me return.
     */
    public    function ucmm_get_options( $ucmm_key, $default_value = false ) {
      
      $ucmm_wpbrigade_array = $this->ucmm_settings;
      if ( array_key_exists( $ucmm_key, $ucmm_wpbrigade_array ) ) {

        return $ucmm_wpbrigade_array[ $ucmm_key ];

      }
      else {
        return $default_value;
      }
      }
      /**
       * set setting of ucmm.
       * @since 1.0.5
       */
      public function ucmm_set_setting(){
        $this->ucmm_settings =  (array)get_option( 'ucmm_wpbrigade_setting' );
      }
}

endif;

new UCMM_WPBrigade();
 