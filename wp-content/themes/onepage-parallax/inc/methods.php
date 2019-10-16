<?php
/**
 * OnePage Parallax methods.
 *
 * @package WordPress
 * @subpackage OnePage Parallax
 * @since 0.0.1
 * @version 1.0.6
 */

 /**
  * OnePage Parallax theme core setup.
  *
	* @since 0.0.1
  */
function onepage_parallax_setup() {

	// Make theme available for translation.
	load_theme_textdomain( 'onepage-parallax', ONEPAGE_PARALLAX_DIR . 'languages' );

	// Excerpt for pages.
	add_post_type_support( 'page', 'excerpt' );

	//Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Add Image Size for Widget thumbnail for recent posts.
	add_image_size( 'onepage-parallax-widget-thumb', 70, 70, true );

	// Add Image Size for Home Page Blog thumbnail.
	add_image_size( 'onepage-parallax-blog-thumb', 578, 361, true );

	// Add Image Size for Home Page Team thumbnail.
 	add_image_size( 'onepage-parallax-teamwork', 480, 550, true );

	 // Add Image Size for Home Page Team thumbnail.
 	add_image_size( 'onepage-parallax-blogpost-thumb', 890, 384, true );

	 // Add Image Size for Home Page Aboutus thumbnail.
	add_image_size( 'onepage-parallax-aboutus-thumb', 150, 150, true );

	// Add Image Size for Home Page Services thumbnail.
 add_image_size( 'onepage-parallax-services-thumb', 30, 30 );

	//attachment dropdown img sizes
	add_filter( 'image_size_names_choose', 'onepage_parallax_custom_sizes' );

	/**
	 * Custom size of team member image in media.
	 *
	 * @param  array $sizes array of custom sizes
	 * @since 0.0.1
	 */
	function onepage_parallax_custom_sizes( $sizes ) {
		return array_merge( $sizes, array(
			'onepage-parallax-teamwork' => __( 'Team Member', 'onepage-parallax' ),
		) );
	}

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );


	/*
    * Let WordPress manage the document title.
    * By adding theme support, we declare that this theme does not use a
    * hard-coded <title> tag in the document head, and expect WordPress to
    * provide it for us.
	*/
	   add_theme_support( 'title-tag' );

	/*
    * Enable support for Post Formats.
    *
    * See: https://codex.wordpress.org/Post_Formats
	*/

	add_theme_support(
		'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		)
	);

	/*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
	*/
	add_theme_support(
		'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);


add_theme_support( 'custom-background', array(
		'default-color' => 'fff',
) );

	register_nav_menus(
		array(
			'onepage-parallax-front-menu' => __( 'Front Page Menu', 'onepage-parallax' ),
			'subpage-menu' => __( 'Sub Page Menu', 'onepage-parallax' ),
		)
	);

	/*
    * This theme styles the visual editor to resemble the theme style,
    * specifically font, colors, and column width.
	*/
	add_editor_style( 'assets/css/editor-style.css' );

	$header_img_args = array(
		  'flex-width'    => true,
		  // 'width'         => 1295,
		  // 'height'        => 532,
			'default-text-color'     => '',
		  'default-image' => ONEPAGE_PARALLAX_DIR_URI . 'assets/images/bg_header.jpg',
	 	);

		add_theme_support( 'custom-header', $header_img_args );

		register_default_headers( array(
	    'default-image' => array(
	        'url'           => get_stylesheet_directory_uri() . '/assets/images/bg_header.jpg',
	        'thumbnail_url' => get_stylesheet_directory_uri() . '/assets/images/bg_header.jpg',
	        'description'   => __( 'Default Header Image', 'onepage-parallax' )
	    ),
		) );

		/**
			 * Add support for core custom logo.
			 *
			 * @link https://codex.wordpress.org/Theme_Logo
			 */
			add_theme_support( 'custom-logo', array(
				'height'      => 44,
				'width'       => 203,
				'flex-width'  => true,
				'flex-height' => true,
			) );

}
  add_action( 'after_setup_theme', 'onepage_parallax_setup' );

/**
 * Custom Logo.
 *
 * @return Logo
 * @since 0.0.8
 */

function onepage_parallax_logo() {

	if ( has_custom_logo() ) {
		$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ); ?>

			<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr__( 'OnePage Parallax', 'onepage-parallax' ); ?>" class="navbar-brand"><img src="<?php echo $image[0]; ?>" alt=""></a>
	<?php } else { ?>
		<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_html( get_bloginfo( 'description' ) ); ?>" class="navbar-brand"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
	<?php }

}

/**
	* Sets the content width in pixels, based on the theme's design and stylesheet.
	*
	* Priority 0 to make it available to lower priority callbacks.
	*
	* @global int $content_width
	*
	* @since 0.0.1
	*/
	function onepage_parallax_content_width() {

		$GLOBALS['content_width'] = apply_filters( 'onepage_parallax_content_width', 900 );
	}
	add_action( 'after_setup_theme', 'onepage_parallax_content_width', 0 );

	if ( ! function_exists( 'onepage_parallax_meta_author' ) ) {

		/**
		 * Displays author information.
		 * @return string Author's information
		 * @since 0.0.1
		 */
		function onepage_parallax_meta_author() {

			$author_fname = get_the_author_meta( 'first_name' );
			$author_lname = get_the_author_meta( 'last_name' );
			if ( ! empty( $author_fname ) || ! empty ( $author_lname ) ) {
				$author_fullname = $author_fname . ' ' . $author_lname;
			} else {
				 $author_fullname = get_the_author();
			}

			$auth_avat = get_avatar( get_the_author_meta( 'user_email' ), 64 );

			$author_string = sprintf(
				'<div class="author-img">%4$s</div><h3 class="author-name"><a href="%1$s" title="%2$s" rel="author">%3$s</a><span>Admin</span></h3>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( esc_html__( 'View all posts by %s', 'onepage-parallax' ), get_the_author() ) ),
				esc_html( ucfirst( $author_fullname ) ),
				$auth_avat
			);

			echo wp_kses( $author_string, array(
			    'div' => array(
			    	'class' => array(),
			    	'title' => array()
			    ),
					'a' =>array(
						'href' => array(),
						'title'	=> array(),
						'rel' => array()
					),
					'img' => array(
						'alt' => array(),
						'src' => array(),
						'srcset' => array(),
						'class' => array(),
						'height' => array(),
						'width' => array()
					),
					'span' => array(),
			    'h3' => array(
						'class' => array(),
					)
			) );

		}
	}

	if ( ! function_exists( 'onepage_parallax_post_date' ) ) {

	/**
	 * onepage_parallax_post_date Displays the post date.
	 * @return string
	 * @since 0.0.1
	 */
		function onepage_parallax_post_date() {

			$time_string = '';

			if ( is_single() ) {
				$SPPDate_check = get_theme_mod( 'onepage_parallax_SPPDate_visible', true );
				$SPMDate_check = get_theme_mod( 'onepage_parallax_SPMDate_visible', true );

				$time_string .= '<div class="single-posted-on">';
				if ( $SPPDate_check ) {
					$time_string .= sprintf(
						'<span class="post-date">Posted %1$s</span>',
						esc_html( get_the_date() )
					);
				}
				if ( $SPPDate_check && $SPMDate_check ) {
					$time_string .= ' - ';
				}
				if ( $SPMDate_check ) {
					$time_string .= sprintf( '<span class="post-updated">Updated %1$s</span>', esc_html( get_the_modified_date() ) );
				}
				$time_string .= '</div>';
				echo $time_string;
			} else {
				$BPPDate_check = get_theme_mod( 'onepage_parallax_BPPDate_visible', true );
				$BPMDate_check = get_theme_mod( 'onepage_parallax_BPMDate_visible', true );

				if ( $BPPDate_check ) {
					$time_string .= sprintf(
						'<span class="post-date">Posted %1$s</span>',
						esc_html( get_the_date() )
					);
				}
				if ( $BPPDate_check && $BPMDate_check ) {
					$time_string .= ' - ';
				}
				if ( $BPMDate_check ) {
					$time_string .= sprintf( '<span class="post-updated">Updated %1$s</span>', esc_html( get_the_modified_date() ) );
				}
				echo $time_string;
			}
		}
	}


	if ( ! function_exists( 'onepage_parallax_post_comment_count' ) ) :
		 /**
		  * OnePage Parallax Post Comments Count.
		  * @since 0.0.1
		  */
		function onepage_parallax_post_comment_count() {
			echo comments_number( esc_html__( 'Be the First to comment.', 'onepage-parallax' ), esc_html__( '1 comment', 'onepage-parallax' ), esc_html__( '% comments', 'onepage-parallax' ) );
		}
	 endif;


	if ( ! function_exists( 'onepage_parallax_tags' ) ) {

		/**
		 * Displays OnePage Parallax tags.
		 * @since 0.0.1
		 * @version 1.0.0
		 * @return string
		 */
		function onepage_parallax_tags() {
			$tag = '';
			if ( checked( get_theme_mod( 'onepage_parallax_SPTags_visible', true ), true, false ) ) :

				$posttags = get_the_tags();
				if ( $posttags ) {
					$tag .= '  <div class="post_tags mb-5">';
					$tag .= '<h3 class="mb-4">' . __( 'Tags', 'onepage-parallax' ) . '</h3>';
					$tag .= '<div class="cat_tags">';
					$tag .= get_the_tag_list();
					$tag .= '</div></div>';
				}
			endif;

		echo wp_kses_post( $tag );

		}
	}


	if ( ! function_exists( 'onepage_parallax_categories' ) ) {

		/**
		 * Displays OnePage Parallax catagories.
		 * @since 0.0.1
		 * @version 1.0.0
		 * @return string
		 */
		function onepage_parallax_categories() {

				if ( checked( get_theme_mod( 'onepage_parallax_SPCategoies_visible', true ), true, false ) ) :
					$onepage_parallax_categories = '<span class="single-cat">' . get_the_category_list( ', ' ) . '</span>';
					echo wp_kses( $onepage_parallax_categories, array(
						'span' => array(
					    	'class' => array(),
					    	'title' => array()
							),
							'a' => array(
						    'href' => array(),
						    'rel' => array()
							),
					) );
				endif;
		}
	}


	if ( ! function_exists( 'onepage_parallax_widgets_init' ) ) :

		/**
		 * Register widget areas and custom widgets.
		 * @since 0.0.1
		 */
		function onepage_parallax_widgets_init() {

			register_sidebar(
				array(
					'name' => __( 'Sidebar', 'onepage-parallax' ),
					'id' => 'sidebar-widget-area',
					'description' => __( 'The primary widget area', 'onepage-parallax' ),
					'before_widget' => '<div id="%1$s">',
					'after_widget' => '</div>',
					'before_title' => '<h2 class="onepage-parallax-sidebar-title">',
					'after_title' => '</h2>',
				)
			);

		}
	endif;

	add_action( 'widgets_init', 'onepage_parallax_widgets_init' );


	if ( ! function_exists( 'onepage_parallax_pagination' ) ) :

		/**
		 * OnePage Parallax pagination function displays the pagination.
		 * @since 0.0.1
		 **/
		function onepage_parallax_pagination() { ?>

			 <div class="onepage-parallax-pagination">
						<?php the_posts_pagination( array(
						 'prev_text' => esc_attr__( '&laquo;', 'onepage-parallax' ),
						 'next_text' => esc_attr__( '&raquo;', 'onepage-parallax' ),
						) ); ?>
			 </div>	<?php
		}
	 endif;

	if ( ! function_exists( 'onepage_parallax_pagination_labels' ) ) :

		/**
		 * OnePage Parallax pagination function displays the pagination.
		 * @since 0.0.1
		 * @return string
		 **/
		function onepage_parallax_pagination_labels() {

			$check = get_theme_mod( 'onepage_parallax_SPNPLink_visible', true );
			if ( $check ) :
				?>
			  <ul class="post-prev-next-links">
			  <li class="prev"><?php previous_post_link( '%link' , 'Previous Post' ); ?></li>
			<li class="next"><?php next_post_link( '%link' , 'Next Post' ); ?></li>
			</ul>
			<?php
		   endif;
		}

	 endif;

	if ( ! function_exists( 'onepage_parallax_read_more_link' ) ) :

		 /**
		  * OnePage Parallax Read More Link.
		  * @since 0.0.1
		  * @return string
		  */
		function onepage_parallax_read_more_link() {

			$check = get_theme_mod( 'onepage_parallax_BPRMore_visible', true );

			$postlink = '<a href="' . esc_url( get_permalink() ) . '" class="post-link">' . esc_html__( 'Read More', 'onepage-parallax' ) . '</a>';

			if ( $check ) {
				echo wp_kses(
					$postlink, array(
						'a' => array(
							'href' => array(),
							'class' => array(),
					) ) );
			}
		}
	endif;

	if ( ! function_exists( 'onepage_parallax_author_fullname' ) ) :

		 /**
		  * Display author's full name.
		  * @since 0.0.1
		  * @return string
		  */
		function onepage_parallax_author_fullname() {

			$author_fname = strtoupper( get_the_author_meta( 'first_name' ) );
			$author_lname = strtoupper( get_the_author_meta( 'last_name' ) );
			if ( ! empty( $author_fname ) || ! empty( $author_lname ) ) {
				$author_fullname = esc_html( $author_fname ) . ' ' .  esc_html( $author_lname );
			} else {
				$author_fullname = strtoupper( esc_html( get_the_author_meta( 'display_name' ) ) );
			}
			echo '<h2>' . $author_fullname . '</h2>';
		}
	endif;

	if ( ! function_exists( 'onepage_parallax_short_about_author' ) ) :

		 /**
		  * Display some Information about author on author.php.
		  *  @since 0.0.1
		  *  @return string
		  */
		function onepage_parallax_short_about_author() {
			$author_image   = get_avatar( get_the_author_meta( 'user_email' ), 64 );
			$author_shabout     = get_the_author_meta( 'description' ) ? get_the_author_meta( 'description' ) : '';
				$author_about = '<div class="authorinfo">';
				$author_about .= '<div class="authorimg">';
				$author_about .= $author_image;
				$author_about .= '</div>';
				$author_about .= '<p>' . $author_shabout . '</p>';
				$author_about .= '</div>';
				echo wp_kses( $author_about , array(
				    'div' => array(
				        'class' => array(),
					   ),
					  'p' => array(),
						'img' => array(
							'class' => array(),
							'src' => array(),
							'srcet' => array(),
							'height' => array(),
							'width' => array(),
						),
					 )
				);

		}
	endif;


	if ( ! function_exists( 'onepage_parallax_author_bio_for_single' ) ) :

		/**
		 * Displays author's bio on single page.
		 *
		 * @return string
		 * @since 0.0.1
		 * @version 0.0.8
		 **/
		function onepage_parallax_author_bio_for_single() {

			$check = get_theme_mod( 'onepage_parallax_SPAuthor_visible', true );

			if ( $check ) {

				$author_fname  = get_the_author_meta( 'first_name' );
				$author_lname  = get_the_author_meta( 'last_name' );
				if ( ! empty( $author_fname ) || ! empty ( $author_lname ) ) {
					$author_fullname = $author_fname . ' ' . $author_lname;
				} else {
					$author_fullname = get_the_author_meta( 'display_name' );
				}

				$author_image = get_avatar( get_the_author_meta( 'user_email' ), 60 );
				$author_ID 		= get_the_author_meta( 'ID' );
				$user_info 		= get_userdata( $author_ID );

				$author_shabout    = get_the_author_meta( 'description' ) ? get_the_author_meta( 'description' ) : '';

				$author_about = '<div class="post_author py-4 px-3 my-md-5 my-3">';
				$author_about .= '<div class="clearfix">';
				$author_about .= '<div class="author_avatar float-md-left mr-4">';
				$author_about .= $author_image;
				$author_about .= '</div>'; // .author-img

				$author_about .= '<div class="author_stats mb-4">';
				$author_about .= '<h4 class="author_name mb-0"><a href="' . esc_url( get_author_posts_url( $author_ID ) ) . '">' . ucfirst( $author_fullname ) . ',</a> <small>' . ucfirst( implode( ', ', $user_info->roles ) ) . '</small></h4>';
				$author_about .= '<span class="user_article_count">' . count_user_posts( $author_ID ) . ' articals</span>';
				$author_about .= '</div>';
				$author_about .= '</div>'; // .author-block-header

				$author_about .= '<div class="author-text">';
				$author_about .= '<p>' . $author_shabout . '</p>';
				$author_about .= '</div>';
				$author_about .= '</div>'; // .author-block

				$author_about_res = wp_kses_post( $author_about );

				echo $author_about_res;

			}
		}

	 endif;

	/**
	 * Thumbnail Widget.
	 */
	require( ONEPAGE_PARALLAX_DIR . 'inc/widgets/recent-post.php' );


	/**
	 * Registering widget.
	 * @since 0.0.1
	 */
	function onepage_parallax_register_widget() {
		register_widget( 'OnePage_Parallax_Recent_Posts_Widget' );
	}
	add_action( 'widgets_init', 'onepage_parallax_register_widget' );

	/**
	 * Move the comment textarea in bottom of the form.
	 *
	 * @param array $fields
	 * @since 0.0.1
	 * @return array $fields
	 */
	function onepage_parallax_move_comment_field( $fields ) {

		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;

		return $fields;
	}

	add_filter( 'comment_form_fields', 'onepage_parallax_move_comment_field' );


	/**
	 * Make a Placeholder in Comment Form Textarea.
	 *
	 * @param  array $args
	 * @since  0.0.1
	 * @return array
	 */
	function onepage_parallax_comment_textarea_placeholder( $args ) {
		$onepage_parallax_comment = esc_attr__( 'Your Message', 'onepage-parallax');
		$args['comment_field'] = str_replace( 'textarea', "textarea placeholder='$onepage_parallax_comment' ", $args['comment_field'] );
		return $args;
	}

	add_filter( 'comment_form_defaults', 'onepage_parallax_comment_textarea_placeholder' );

	/**
	 *  Make a Placeholder in Comment Form Fields.
	 *
	 * @param array $fields
	 * @since 0.0.1
	 * @return array $fields
	 */
	function onepage_parallax_comment_form_placeholder( $fields ) {
		$onepage_parallax_name = esc_attr__( 'Your Name*', 'onepage-parallax');
		$onepage_parallax_email = esc_attr__( 'Your Email*', 'onepage-parallax');
		$onepage_parallax_web = esc_attr__( 'Your Website', 'onepage-parallax');
		foreach ( $fields as &$field ) {

			$field = str_replace( 'id="author"', "id='author' placeholder='$onepage_parallax_name'", $field );
			$field = str_replace( 'id="email"', "id='email' placeholder='$onepage_parallax_email'", $field );
			$field = str_replace( 'id="url"', "id='url' placeholder='$onepage_parallax_web'", $field );
		}

		return $fields;
	}
	add_filter( 'comment_form_default_fields', 'onepage_parallax_comment_form_placeholder' );

	/**
	 * Return the right side footer string.
	 *
	 * @since 0.0.6
	 * @var [type]
	 */
	if ( ! function_exists( 'onepage_parallax_footer_right' ) ) {

		function onepage_parallax_footer_right() {

			$footer_str_array = onepage_parallax_default_strings( 'footer', 'string' );
			$footer_string = $footer_str_array['0'];
			 return $footer_string;
		}
	}

	/**
	 * Retrun the left side footer string.
	 *
	 * @since 0.0.6
	 * @return string
	 */
	if ( ! function_exists( 'onepage_parallax_footer_left' ) ) {

		function onepage_parallax_footer_left() {

			$footer_str_array = onepage_parallax_default_strings( 'footer', 'string_left' );
			$footer_string = $footer_str_array['0'];
			 return $footer_string;
		}
	}

	/**
	* Returns the footer text.
	*
	* @since 0.0.6
	* @return string
	*/
	function onepage_parallax_footer() {

	  $footer_text_color = esc_html( get_theme_mod( 'onepage_parallax_colors_footer' ) );

		$footer_string = '<div class="col-md-6"><p style="color:' . $footer_text_color . '">' . apply_filters( 'onepage_parallax_footer_left', onepage_parallax_footer_left() ) . '</p></div>';

		$footer_string .= '<div class="col-md-6"><p class="text-right" style="color:' . $footer_text_color . '">' . apply_filters( 'onepage_parallax_footer_right', onepage_parallax_footer_right() ) . '</p></div>';

		echo wp_kses( $footer_string, array(
			 'div' => array(
				 'class' => array()
			 ),
			 'p' => array(
				 'class' => array(),
				 'style' => array()
			 ),
			 'a' => array(
				 'href'  => array(),
				 'class' => array()
			 ),
			 'img' => array(
				 'class' => array(),
				 'draggable' => array(),
				 'alt' => array(),
				 'src' => array()
			 ),
	 ) );

	}
	add_action( 'onepage_parallax_footer', 'onepage_parallax_footer' );

	if ( checked( get_theme_mod( 'onepage_parallax_team_visible', true ), true, false ) ) {
		add_action( 'admin_init', 'onepage_parallax_admin_notice' );
	}

	/**
	 * Ask users to review our plugin on wordpress.org
	 *
	 * @since 1.0.4
	 * @return boolean false
	 */
	function onepage_parallax_admin_notice() {

		onepage_parallax_fontawesome_dismissal();
		onepage_parallax_fontawesome_pending();

		$activation_time 	= get_site_option( 'onepage_parallax_fontawesome_notice_time' );
		$review_dismissal	= get_site_option( 'onepage_parallax_fontawesome_dismiss' );

		if ( 'yes' == $review_dismissal ) return;

		if ( ! $activation_time || time() - $activation_time > 604800 ) : // 648000 = 7 Days in seconds.
			wp_enqueue_style( 'onepage-parallax-admin-notice', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/admin-notice.css', array(), onepage_parallax_version() );
			add_action( 'admin_notices' , 'onepage_parallax_fontawesome5_notice' );
		endif;

	}

	/**
	 *	Check and Dismiss review message.
	 *
	 *	@since 1.0.4
	 */
	function onepage_parallax_fontawesome_dismissal() {

		if ( ! is_admin() ||
			! current_user_can( 'manage_options' ) ||
			! isset( $_GET['_wpnonce'] ) ||
			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'onepage-parallax-fontawesome-nonce' ) ||
			! isset( $_GET['onepage_parallax_fontawesome_dismiss'] ) ) :

			return;
		endif;

		add_site_option( 'onepage_parallax_fontawesome_dismiss', 'yes' );
	}

	/**
	 * Set time to current so review notice will popup after 7 days
	 *
	 * @since 1.0.4
	 */
	function onepage_parallax_fontawesome_pending() {

		if ( ! is_admin() ||
			! current_user_can( 'manage_options' ) ||
			! isset( $_GET['_wpnonce'] ) ||
			! wp_verify_nonce( sanitize_key( wp_unslash( $_GET['_wpnonce'] ) ), 'onepage-parallax-fontawesome-nonce' ) ||
			! isset( $_GET['onepage_parallax_fontawesome_later'] ) ) :

			return;
		endif;

		// Add current time.
		add_site_option( 'onepage_parallax_fontawesome_notice_time', time() );
	}

/**
 * Change the length of the excerpt.
 * @param  int 			$charlength
 * @return string   $excerpt
 * @since 1.0.6
 */
	function onepage_parallax_excerpt_max_charlength( $charlength ) {
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo $subex;
			}
			echo '[...]';
		} else {
			echo $excerpt;
		}
	}

	/**
	 * FontAwesome notice message
	 *
	 * @since  1.0.4
	 */
	function onepage_parallax_fontawesome5_notice() {

		$scheme      = ( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY ) ) ? '&' : '?';
		$url         = $_SERVER['REQUEST_URI'] . $scheme . 'onepage_parallax_fontawesome_dismiss=yes';
		$dismiss_url = wp_nonce_url( $url, 'onepage-parallax-fontawesome-nonce' );

		$_later_link = $_SERVER['REQUEST_URI'] . $scheme . 'onepage_parallax_fontawesome_later=yes';
		$later_url   = wp_nonce_url( $_later_link, 'onepage-parallax-fontawesome-nonce' );

		// Generate the redirect url.
		$customizer_url = add_query_arg(
			array(
				'autofocus[section]'	=> 'onepage_parallax_section_team_content',
				'url'									=> home_url(),
			),
			admin_url( 'customize.php' )
		);
		?>

		<div class="onepage-parallax-admin-notice">
			<div class="onepage-parallax-notice-thumbnail">
				<img src="<?php echo ONEPAGE_PARALLAX_DIR_URI . 'screenshot.png'; ?>" alt="">
			</div>
			<div class="onepage-parallax-notice-text">
				<h3><?php _e( 'OnePage Parallax: Important Announcement', 'onepage-parallax' ) ?></h3>
				<p><?php echo sprintf( __( 'Hello! OnePage Parallax is updated to Font Awesome 5. You just need to update your Social Media Icon from %1$sCustomizer%2$s at least one time to use them. Thank you.', 'onepage-parallax' ), '<a href="' .  $customizer_url  . '">', '</a>' );  ?></p>
				<ul class="onepage-parallax-notice-ul">
					<li><a href="<?php echo $dismiss_url ?>"><span class="dashicons dashicons-smiley"></span><?php _e( 'I\'ve already done', 'onepage-parallax' ) ?></a></li>
					<li><a href="<?php echo $later_url ?>"><span class="dashicons dashicons-calendar-alt"></span><?php _e( 'Later', 'onepage-parallax' ) ?></a></li>
					<li><a href="<?php echo $dismiss_url ?>"><span class="dashicons dashicons-dismiss"></span><?php _e( 'Never show again', 'onepage-parallax' ) ?></a></li></ul>
			</div>
		</div>
	<?php
	}
