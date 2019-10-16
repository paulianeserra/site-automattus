<?php
/**
 * Repeater control class
 *
 * @package OnePage Parallax
 * @since 0.0.2
 * @version 1.0.0
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Custom control class for customizer to repeate fields.
 */
class OnePage_Parallax_Repeater_Control extends WP_Customize_Control {

/**
 * Declaring data members for class.
 */
	public $id;
	private $boxtitle = array();
	private $onepage_parallax_image_control = false;
	private $onepage_parallax_icon_control = false;
	private $onepage_parallax_title_control = false;
	private $onepage_parallax_subtitle_control = false;
	private $onepage_parallax_text_control = false;
	private $onepage_parallax_link_control = false;
	private $onepage_parallax_shortcode_control = false;
	//	Pages controls.
	private $onepage_parallax_pages_control = false;
	private $onepage_parallax_pages_title_control = false;
	private $onepage_parallax_pages_link_control = false;
	private $onepage_parallax_pages_image_control = false;

	private $onepage_parallax_repeater_control = false;
	private $onepage_parallax_order = 0;
	// Controls button labels array.
	private $onepage_parallax_repeater_button;
	// Controls button classes.
	private $onepage_parallax_repeater_button_class;
	// Controls button text.
	private $onepage_parallax_repeater_promo_text;
	// Title control labels array.
	private $onepage_parallax_repeater_title_label;
	// Subtitle control labels array.
	private $onepage_parallax_repeater_subtitle_label;
	// Textfield control labels array.
	private $onepage_parallax_repeater_textfiled_label;
	// Link control labels array.
	private $onepage_parallax_repeater_link_label;
	// Shortcode control labels array.
	private $onepage_parallax_repeater_shortcode_label;
	// For Post Type.
	private $onepage_parallax_post_type_control = 'page';

	/**
	 * Cunstructor for class.
	 * @param $manager
	 * @param int $id
	 * @param array  $args
	 */
	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		/*Get options from customizer.php*/
		$this->boxtitle   = esc_html__( 'Cusomizer Repeater', 'onepage-parallax' );
		if ( ! empty( $this->label ) ) {
			$this->boxtitle = $this->label;
		}

		if ( ! empty( $args['onepage_parallax_image_control'] ) ) {
			$this->onepage_parallax_image_control = $args['onepage_parallax_image_control'];
		}

		if ( ! empty( $args['onepage_parallax_icon_control'] ) ) {
			$this->onepage_parallax_icon_control = $args['onepage_parallax_icon_control'];
		}

		if ( ! empty( $args['onepage_parallax_title_control'] ) ) {
			$this->onepage_parallax_title_control = $args['onepage_parallax_title_control'];
		}

		if ( ! empty( $args['onepage_parallax_subtitle_control'] ) ) {
			$this->onepage_parallax_subtitle_control = $args['onepage_parallax_subtitle_control'];
		}

		if ( ! empty( $args['onepage_parallax_text_control'] ) ) {
			$this->onepage_parallax_text_control = $args['onepage_parallax_text_control'];
		}

		if ( ! empty( $args['onepage_parallax_link_control'] ) ) {
			$this->onepage_parallax_link_control = $args['onepage_parallax_link_control'];
		}

		if ( ! empty( $args['onepage_parallax_shortcode_control'] ) ) {
			$this->onepage_parallax_shortcode_control = $args['onepage_parallax_shortcode_control'];
		}

		if ( ! empty( $args['onepage_parallax_pages_control'] ) ) {
			$this->onepage_parallax_pages_control = $args['onepage_parallax_pages_control'];
		}

		if ( ! empty( $args['onepage_parallax_pages_title_control'] ) ) {
			$this->onepage_parallax_pages_title_control = $args['onepage_parallax_pages_title_control'];
		}

		if ( ! empty( $args['onepage_parallax_pages_link_control'] ) ) {
			$this->onepage_parallax_pages_link_control = $args['onepage_parallax_pages_link_control'];
		}

		if ( ! empty( $args['onepage_parallax_pages_image_control'] ) ) {
			$this->onepage_parallax_pages_image_control = $args['onepage_parallax_pages_image_control'];
		}

		if ( ! empty( $args['onepage_parallax_repeater_control'] ) ) {
			$this->onepage_parallax_repeater_control = $args['onepage_parallax_repeater_control'];
		}

		if ( ! empty( $args['onepage_parallax_order'] ) ) {
			$this->onepage_parallax_order = $args['onepage_parallax_order'];
		}

		if ( ! empty( $args['onepage_parallax_post_type_control'] ) ) {
			$this->onepage_parallax_post_type_control = $args['onepage_parallax_post_type_control'];
		}

		if ( ! empty( $args['id'] ) ) {
			$this->id = $args['id'];
		}

		$this->onepage_parallax_repeater_button 					= onepage_parallax_default_strings( 'repeater', 'button_text' );
		$this->onepage_parallax_repeater_button_class			= onepage_parallax_default_strings( 'repeater', 'button_class' );
		$this->onepage_parallax_repeater_promo_text 			= onepage_parallax_default_strings( 'repeater', 'button_promo_text' );
		$this->onepage_parallax_repeater_title_label 			= onepage_parallax_default_strings( 'repeater', 'label_title' );
		$this->onepage_parallax_repeater_subtitle_label 	= onepage_parallax_default_strings( 'repeater', 'label_subtitle' );
		$this->onepage_parallax_repeater_textfiled_label 	= onepage_parallax_default_strings( 'repeater', 'label_textfield' );
		$this->onepage_parallax_repeater_link_label 			= onepage_parallax_default_strings( 'repeater', 'label_link' );
		$this->onepage_parallax_repeater_shortcode_label 	= onepage_parallax_default_strings( 'repeater', 'label_shortcode' );

	}

/**
 * Enqueuing scripts and stylesheets.
 */
	public function enqueue() {

		wp_enqueue_style( 'fa-brands', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fa-brands.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'fa-solid', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fa-solid.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'fa-regular', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fa-regular.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'font-awesome', ONEPAGE_PARALLAX_DIR_URI . 'assets/css/fontawesome.min.css', array(), onepage_parallax_version() );

		wp_enqueue_style( 'onepage-parallax-repeater-admin-stylesheet', ONEPAGE_PARALLAX_DIR_URI . 'inc/onepage-parallax-control/includes/css/admin-style.css', array(), onepage_parallax_version() );

		wp_enqueue_script( 'onepage-parallax-repeater-script', ONEPAGE_PARALLAX_DIR_URI . 'inc/onepage-parallax-control/includes/js/customizer_repeater.js', array( 'jquery', 'jquery-ui-draggable' ), onepage_parallax_version(), true );

		wp_enqueue_script( 'onepage-parallax-repeater-fontawesome-iconpicker', ONEPAGE_PARALLAX_DIR_URI . 'inc/onepage-parallax-control/includes/js/fontawesome-iconpicker.min.js', array( 'jquery' ), onepage_parallax_version(), true );

		wp_enqueue_script( 'onepage-parallax-repeater-iconpicker-control', ONEPAGE_PARALLAX_DIR_URI . 'inc/onepage-parallax-control/includes/js/iconpicker-control.js', array( 'jquery' ), onepage_parallax_version(), true );

		wp_enqueue_style( 'onepage-parallax-repeater-fontawesome-iconpicker-style', ONEPAGE_PARALLAX_DIR_URI . 'inc/onepage-parallax-control/includes/css/fontawesome-iconpicker.min.css', array(), onepage_parallax_version() );
	}

/**
 * Rendering the content.
 */
	public function render_content() {

		// Get default options.
		$this_default = json_decode( $this->setting->default );

		// Get values in json format.
		$values = $this->value();
		do_action('onepage_parallax_json_labels');
		?>
		<input type="hidden" class="json_render_aplha" name="" value="<?php echo esc_html('5'); ?>">
		<?php

		// Decode values.
		$json = json_decode( $values );

		if ( ! is_array( $json ) ) {
			$json = array( $values );
		} ?>

		<span class="onepage-parallax-control-title"><?php echo esc_html( $this->label ); ?></span>
		<div class="onepage-parallax-repeater-general-control-repeater customizer-repeater-general-control-droppable">
			<?php
			if ( ( count( $json ) == 1 && '' === $json[0] ) || empty( $json ) ) {
				if ( ! empty( $this_default ) ) {
					$this->iterate_array( $this_default );
					?>
					<input type="hidden"
						   id="customizer-repeater-<?php echo esc_html( $this->id ); ?>-colector" <?php $this->link(); ?>
						   class="onepage-parallax-repeater-colector"
						   value="<?php echo esc_textarea( json_encode( $this_default ) ); ?>"/>
					<?php
				} else {
					$this->iterate_array();
					?>
					<input type="hidden" id="customizer-repeater-<?php echo esc_html( $this->id ); ?>-colector" <?php $this->link(); ?> class="onepage-parallax-repeater-colector"/>
					<?php
				}
			} else {
				$this->iterate_array( $json );
				?>
				<input type="hidden" id="customizer-repeater-<?php echo esc_html( $this->id ); ?>-colector" <?php $this->link(); ?> class="onepage-parallax-repeater-colector" value="<?php echo esc_textarea( $this->value() ); ?>"/>
				<?php
			}
			?>
			</div>
		<button type="button" class="button add_field customizer-repeater-new-field" value="1">
			<?php echo esc_html( $this->onepage_parallax_repeater_button[ "$this->onepage_parallax_order" ] ); ?>
		</button>
		<p class="onepage-parallax-pro_msg <?php echo esc_html( $this->onepage_parallax_repeater_button_class[ "$this->onepage_parallax_order" ] ); ?>" style="display:none;"> <?php echo esc_html( $this->onepage_parallax_repeater_promo_text[ "$this->onepage_parallax_order" ] ); ?> </p>
		<?php
		}

/**
 * Iterating array for repeating input fields.
 * @param  array  $array
 */
	private function iterate_array( $array = array() ) {
		/*Counter that helps checking if the box is first and should have the delete button disabled*/
		$it = 0;
		if ( ! empty( $array ) ) {
			foreach ( $array as $icon ) {
				?>
				<div class="onepage-parallax-repeater-general-control-repeater-container customizer-repeater-draggable">
					<div class="customizer-repeater-customize-control-title">
						<?php echo esc_html( $this->boxtitle ); ?>
					</div>
					<div class="onepage-parallax-repeater-box-content-hidden">
						<?php
						$choice = $image_url = $icon_value = $title = $subtitle = $text = $link = $shortcode = $pages = $pages_title = $pages_link = $pages_image = $repeater = '';
						if ( ! empty( $icon->choice ) ) {
							$choice = $icon->choice;
						}
						if ( ! empty( $icon->image_url ) ) {
							$image_url = $icon->image_url;
						}
						if ( ! empty( $icon->icon_value ) ) {
							$icon_value = $icon->icon_value;
						}
						if ( ! empty( $icon->title ) ) {
							$title = $icon->title;
						}
						if ( ! empty( $icon->subtitle ) ) {
							$subtitle = $icon->subtitle;
						}
						if ( ! empty( $icon->text ) ) {
							$text = $icon->text;
						}
						if ( ! empty( $icon->link ) ) {
							$link = $icon->link;
						}
						if ( ! empty( $icon->shortcode ) ) {
							$shortcode = $icon->shortcode;
						}
						if ( ! empty( $icon->pages ) ) {
							$pages = $icon->pages;
						}
						if ( ! empty( $icon->pages_title ) ) {
							$pages_title = $icon->pages_title;
						}
						if ( ! empty( $icon->pages_link ) ) {
							$pages_link = $icon->pages_link;
						}
						if ( ! empty( $icon->pages_image ) ) {
							$pages_image = $icon->pages_image;
						}
						if ( ! empty( $icon->social_repeater ) ) {
							$repeater = $icon->social_repeater;
						}

						if ( $this->onepage_parallax_image_control == true && $this->onepage_parallax_icon_control == true ) {
							$this->icon_type_choice( $choice );
						}
						if ( $this->onepage_parallax_image_control == true ) {
							$this->image_control( $image_url, $choice );
						}
						if ( $this->onepage_parallax_icon_control == true ) {
							$this->icon_picker_control( $icon_value, $choice );
						}
						if ( $this->onepage_parallax_title_control == true ) {
							$this->input_control(
								array(
									'label' => $this->onepage_parallax_repeater_title_label[ "$this->onepage_parallax_order" ],
									'class' => 'onepage-parallax-repeater-title-control',
								), $title
							);
						}
						if ( $this->onepage_parallax_subtitle_control == true ) {
							$this->input_control(
								array(
									'label' => $this->onepage_parallax_repeater_subtitle_label[ "$this->onepage_parallax_order" ],
									'class' => 'onepage-parallax-repeater-subtitle-control',
								), $subtitle
							);
						}
						if ( $this->onepage_parallax_text_control == true ) {
							$this->input_control(
								array(
									'label' => $this->onepage_parallax_repeater_textfiled_label[ "$this->onepage_parallax_order" ],
									'class' => 'onepage-parallax-repeater-text-control',
									'type'  => 'textarea',
									'sanitize_callback' => 'wp_kses_post'
								), $text
							);
						}
						if ( $this->onepage_parallax_link_control ) {
							$this->input_control(
								array(
									'label' => $this->onepage_parallax_repeater_link_label[ "$this->onepage_parallax_order" ],
									'class' => 'onepage-parallax-repeater-link-control',
									'sanitize_callback' => 'esc_url_raw',
								), $link
							);
						}
						if ( $this->onepage_parallax_shortcode_control == true ) {
							$this->input_control(
								array(
									'label' => $this->onepage_parallax_repeater_shortcode_label[ "$this->onepage_parallax_order" ],
									'class' => 'onepage-parallax-repeater-shortcode-control',
								), $shortcode
							);
						}
						if ( $this->onepage_parallax_pages_control == true ) {
							$this->pages_control(
								array(
									'label' =>	__( 'Content Page', 'onepage-parallax' ),
									'class' => 'onepage-parallax-repeater-pages-control',
								), $pages
							);
						}
						if ( $this->onepage_parallax_pages_title_control == true ) {
							$this->checkbox_control(
								array(
									'label' =>	__( 'Show Title', 'onepage-parallax' ),
									'class' => 'onepage-parallax-repeater-pages-title-control',
								), $pages_title
							);
						}
						if ( $this->onepage_parallax_pages_link_control == true ) {
							$this->checkbox_control(
								array(
									'label' =>	__( 'Show Link', 'onepage-parallax' ),
									'class' => 'onepage-parallax-repeater-pages-link-control',
								), $pages_link
							);
						}
						if ( $this->onepage_parallax_pages_image_control == true ) {
							$this->checkbox_control(
								array(
									'label' =>	__( 'Use Feature Image', 'onepage-parallax' ),
									'class' => 'onepage-parallax-repeater-pages-image-control',
								), $pages_image
							);
						}
						if ( $this->onepage_parallax_repeater_control == true ) {
							$this->repeater_control( $repeater );
						}
						?>

						<input type="hidden" class="social-repeater-box-id" value=" <?php if ( ! empty( $this->id ) ) { echo esc_attr( $this->id ); } ?> ">
						<button type="button" class="social-repeater-general-control-remove-field button"
						<?php
						if ( $it == 0 ) {
							echo 'style="display:none;"';
						}
						?>
						>
							<?php esc_html_e( 'Delete field', 'onepage-parallax' ); ?>
						</button>

					</div>
				</div>

				<?php
				$it++;
			}
		} else {
		?>
			<div class="onepage-parallax-repeater-general-control-repeater-container">
				<div class="customizer-repeater-customize-control-title">
					<?php echo esc_html( $this->boxtitle ); ?>
				</div>
				<div class="onepage-parallax-repeater-box-content-hidden">
					<?php
					if ( $this->onepage_parallax_image_control == true && $this->onepage_parallax_icon_control == true ) {
						$this->icon_type_choice();
					}
					if ( $this->onepage_parallax_image_control == true ) {
						$this->image_control();
					}
					if ( $this->onepage_parallax_icon_control == true ) {
						$this->icon_picker_control();
					}
					if ( $this->onepage_parallax_title_control == true ) {
						$this->input_control(
							array(
								'label' => $this->onepage_parallax_repeater_title_label[ "$this->onepage_parallax_order" ],
								'class' => 'onepage-parallax-repeater-title-control',
							)
						);
					}
					if ( $this->onepage_parallax_subtitle_control == true ) {
						$this->input_control(
							array(
								'label' => $this->onepage_parallax_repeater_subtitle_label[ "$this->onepage_parallax_order" ],
								'class' => 'onepage-parallax-repeater-subtitle-control',
							)
						);
					}
					if ( $this->onepage_parallax_text_control == true ) {
						$this->input_control(
							array(
								'label' => $this->onepage_parallax_repeater_textfiled_label[ "$this->onepage_parallax_order" ],
								'class' => 'onepage-parallax-repeater-text-control',
								'type'  => 'textarea',
								'sanitize_callback' => 'wp_kses_post'
							)
						);
					}
					if ( $this->onepage_parallax_link_control == true ) {
						$this->input_control(
							array(
								'label' => $this->onepage_parallax_repeater_link_label[ "$this->onepage_parallax_order" ],
								'class' => 'onepage-parallax-repeater-link-control',
								'sanitize_callback' => 'esc_url_raw',
							)
						);
					}
					if ( $this->onepage_parallax_shortcode_control == true ) {
						$this->input_control(
							array(
								'label' => $this->onepage_parallax_repeater_shortcode_label[ "$this->onepage_parallax_order" ],
								'class' => 'onepage-parallax-repeater-shortcode-control',
							)
						);
					}
					if ( $this->onepage_parallax_pages_control == true ) {
						$this->pages_control(
							array(
								'label' => __( 'Content Page', 'onepage-parallax' ),
								'class' => 'onepage-parallax-repeater-pages-control',
							)
						);
					}
					if ( $this->onepage_parallax_pages_title_control == true ) {
						$this->checkbox_control(
							array(
								'label' =>	__( 'Show Title', 'onepage-parallax' ),
								'class' => 'onepage-parallax-repeater-pages-title-control',
							)
						);
					}
					if ( $this->onepage_parallax_pages_link_control == true ) {
						$this->checkbox_control(
							array(
								'label' =>	__( 'Show link', 'onepage-parallax'),
								'class' => 'onepage-parallax-repeater-pages-link-control',
							)
						);
					}
					if ( $this->onepage_parallax_pages_image_control == true ) {
						$this->checkbox_control(
							array(
								'label' =>	__( 'Use Feature Image', 'onepage-parallax' ),
								'class' => 'onepage-parallax-repeater-pages-image-control',
							)
						);
					}
					if ( $this->onepage_parallax_repeater_control == true ) {
						$this->repeater_control();
					}
					?>
					<input type="hidden" class="social-repeater-box-id">
					<button type="button" class="social-repeater-general-control-remove-field button" style="display:none;">
						<?php esc_html_e( 'Delete field', 'onepage-parallax' ); ?>
					</button>
				</div>
			</div>
			<?php
		}
	}

/**
 * Input control for repeater field.
 * @param  array $options
 * @param  string $value
 */
	private function input_control( $options, $value = '' ) {
	?>
	<div id="<?php echo str_replace( " ", "-", strtolower($options['label'] ) ) ?>">
		<span class="onepage-parallax-control-title"><?php echo esc_html( $options['label'] ); ?></span>
		<?php
		if ( ! empty( $options['type'] ) && $options['type'] === 'textarea' ) :
		?>
			<textarea class="<?php echo esc_attr( $options['class'] ); ?>" placeholder="<?php echo esc_attr( $options['label'] ); ?>"><?php echo ( ! empty( $options['sanitize_callback'] ) ? call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr( $value ) ); ?></textarea>
			<?php
		else :
		?>
			<input type="text" value="<?php echo ( ! empty( $options['sanitize_callback'] ) ? call_user_func_array( $options['sanitize_callback'], array( $value ) ) : esc_attr( $value ) ); ?>" class="<?php echo esc_attr( $options['class'] ); ?>" placeholder="<?php echo $options['label']; ?>"/>
			<?php
		endif; ?>

	</div> <?php
	}

	/**
	 * Pages control for repeater field.
	 * @param  array $options
	 * @param  string $value
	 */
		private function pages_control( $options, $value = '' ) {
			$old_value = $value;
			?>
			<div>
				<span class="onepage-parallax-control-title" > <?php echo esc_html( $options['label'] ); ?> </span>
				<select class="page_options">
					<option value="NULL"> </option>
			    <?php
					if ( 'page' == $this->onepage_parallax_post_type_control ) {
						$site_pages = get_pages();
					} else {
						$site_pages = get_posts( array( 'post_type' => $this->onepage_parallax_post_type_control, 'numberposts' => 99 ) );
					}
			     foreach ( $site_pages as $site_page ) {
						 $value = $site_page->ID;
						 ?>
						  <option value="<?php echo esc_attr( $value ); ?>" <?php if($old_value == $value) { echo "selected"; } ?> > <?php echo esc_html( $site_page->post_title ); ?> </option> <?php
			     }
			    ?>
				</select>
			</div>
			<?php
		}

		/**
		 * Checkbox control for repeater field.
		 * @param  array $options
		 * @param  string $value
		 */
			private function checkbox_control( $options, $value = '' ) {
			?>
			<div>
				<input type="checkbox" class="<?php echo esc_attr( $options['class'] ); ?>" value="<?php echo esc_attr( $value ); ?>">
				<span class="onepage-parallax-control-title onepage-parallax-control-title-uni"> <?php echo esc_html( $options['label'] ); ?> </span>
			</div> <?php
			}

/**
 * icon control for repeater field.
 * @param  string $value
 * @param  string $show
 */
	private function icon_picker_control( $value = '', $show = '' ) {
	?>
		<div class="onepage-parallax-social-repeater-general-control-icon" <?php if ( $show === 'customizer_repeater_image' || $show === 'customizer_repeater_none' ) { echo 'style="display:none;"'; } ?> >
			<span class="onepage-parallax-control-title">
				<?php esc_html_e( 'Icon', 'onepage-parallax' ); ?>
			</span>
			<span class="description customize-control-description">
				<?php
				echo sprintf(
					esc_html__( 'Note: Some icons may not be displayed here. You can see the full list of icons at %1$s', 'onepage-parallax' ),
					sprintf( '<a href="http://fontawesome.io/icons/" rel="nofollow">%s</a>', esc_html__( 'http://fontawesome.io/icons/', 'onepage-parallax' ) )
				);
				?>
			</span>
			<div class="input-group icp-container">
				<input data-placement="bottomRight" class="icp icp-auto" value="<?php if ( ! empty( $value ) ) { echo esc_attr( $value );} else { echo esc_html('Pick an icon'); } ?>" type="button">
				<span class="input-group-addon"><i class="fas fa-plus-circle" aria-hidden="true"></i></span>
			</div>
		</div>
		<?php
	}

/**
 * Image control for repeater field.
 * @param  string $value
 * @param  string $show
 */
	private function image_control( $value = '', $show = '' ) {
	?>
		<div class="onepage-parallax-repeater-image-control" <?php if ( $show === 'customizer_repeater_icon' || $show === 'customizer_repeater_none' ) { echo 'style="display:none;"'; } ?> >
			<span class="onepage-parallax-control-title">
				<?php esc_html_e( 'Image', 'onepage-parallax' ); ?>
			</span>
			<input type="text" class="widefat custom-media-url" value="<?php echo esc_attr( $value ); ?>">
			<img src="<?php echo esc_attr( $value ); ?>" class="custom-media-box">
			<input type="button" class="button button-primary customizer-repeater-custom-media-button" value="<?php esc_html_e( 'Upload Image', 'onepage-parallax' ); ?>" />
		</div>
		<?php
	}

/**
 * icon type (image or small icon) control for repeater field.
 * @param  string $value
 */
	private function icon_type_choice( $value = 'customizer_repeater_icon' ) {
	?>
		<span class="onepage-parallax-control-title">
			<?php esc_html_e( 'Image type', 'onepage-parallax' ); ?>
		</span>
		<select class="customizer-repeater-image-choice">
			<option value="customizer_repeater_icon" <?php selected( $value,'customizer_repeater_icon' ); ?>><?php esc_html_e( 'Icon', 'onepage-parallax' ); ?></option>
			<option value="customizer_repeater_image" <?php selected( $value,'customizer_repeater_image' ); ?>><?php esc_html_e( 'Image', 'onepage-parallax' ); ?></option>
			<option value="customizer_repeater_none" <?php selected( $value,'customizer_repeater_none' ); ?>><?php esc_html_e( 'None', 'onepage-parallax' ); ?></option>
		</select>
		<?php
	}

/**
 * Social icons repeter control for social repeater field.
 * @param  string $value
 */
	private function repeater_control( $value = '' ) {
		$social_repeater = array();
		$show_del        = 0;
		?>
		<span class="onepage-parallax-control-title"><?php esc_html_e( 'Social icons', 'onepage-parallax' ); ?></span>
		<?php
		if ( ! empty( $value ) ) {
			$social_repeater = json_decode( html_entity_decode( $value ), true );
		}
		if ( ( count( $social_repeater ) == 1 && '' === $social_repeater[0] ) || empty( $social_repeater ) ) {
		?>
			<div class="onepage-parallax-repeater-social-repeater">
				<div class="customizer-repeater-social-repeater-container">
					<div class="customizer-repeater-rc input-group icp-container">
						<input data-placement="bottomRight" class="icp icp-auto" type="button"
						value="<?php
							if ( '[]' == $value OR '' == $value ) {
								echo esc_html('Pick an icon');
							} else {
								echo esc_html($value);
							}
							?>" >
						<span class="input-group-addon"><i class="fas fa-plus-circle" aria-hidden="true"></i></span>
					</div>

					<input type="text" class="onepage-parallax-repeater-social-repeater-link"
						   placeholder="<?php esc_html_e( 'Link', 'onepage-parallax' ); ?>">
					<input type="hidden" class="onepage-parallax-repeater-social-repeater-id" value="">
					<button class="onepage-parallax-social-repeater-remove-social-item" style="display:none">
						<?php esc_html_e( 'X', 'onepage-parallax' ); ?>
					</button>
				</div>
				<input type="hidden" id="social-repeater-socials-repeater-colector" class="onepage-parallax-social-repeater-socials-repeater-colector" value=""/>
			</div>
			<button class="social-repeater-add-social-item" value="1"><?php esc_html_e( 'Add icon', 'onepage-parallax' ); ?></button>
			<p class="pro_msg_social" style="display:none"> <?php echo esc_html( 'Buy Pro version to add more.' ); ?> </p>
			<input type="hidden" class="count_lim_social" value=" <?php echo esc_html( '5' ); ?> ">
			<?php
		} else {
		?>
			<div class="onepage-parallax-repeater-social-repeater">
				<?php
				foreach ( $social_repeater as $social_icon ) {
					$show_del ++;
					?>
					<div class="customizer-repeater-social-repeater-container">
						<div class="customizer-repeater-rc input-group icp-container">
							<input data-placement="bottomRight" class="icp icp-auto" value="<?php if ( ! empty( $social_icon['icon'] ) ) { echo esc_attr( $social_icon['icon'] ); } else { echo esc_html('Pick an icon'); } ?>" type="button">
							<span class="input-group-addon"><i class="fas fa-plus-circle" aria-hidden="true"></i></span>
						</div>
						<input type="text" class="onepage-parallax-repeater-social-repeater-link"
							   placeholder="<?php esc_html_e( 'Link', 'onepage-parallax' ); ?>"
							   value=" <?php if ( ! empty( $social_icon['link'] ) ) { echo esc_url( $social_icon['link'] ); } ?> ">
						<input type="hidden" class="onepage-parallax-repeater-social-repeater-id" value=" <?php if ( ! empty( $social_icon['id'] ) ) { echo esc_attr( $social_icon['id'] ); } ?> ">
						<button class="onepage-parallax-social-repeater-remove-social-item"
								style=" <?php if ( $show_del == 1 ) { echo 'display:none'; } ?> ">
								<?php esc_html_e( 'X', 'onepage-parallax' ); ?></button>
					</div>
					<?php
				}
				?>
				<input type="hidden" id="social-repeater-socials-repeater-colector"
					   class="onepage-parallax-social-repeater-socials-repeater-colector"
					   value="<?php echo esc_textarea( html_entity_decode( $value ) ); ?>" />
			</div>
			<button class="social-repeater-add-social-item"><?php esc_html_e( 'Add icon', 'onepage-parallax' ); ?></button>
			<?php
		}
	}
}
