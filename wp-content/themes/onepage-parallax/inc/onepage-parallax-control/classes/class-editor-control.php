<?php
/**
 * Editor control class
 *
 * @package OnePage Parallax
 * @since 0.0.2
 * @version 0.0.7
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class OnePage_Parallax_Editor_Control extends WP_Customize_Control {

    public $type = 'editor';
    /**
    ** Render the content on the theme customizer page
    */
    public function render_content() { ?>
        <label>
          <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
          <?php
            $settings = array(
              'media_buttons' => false,
              'quicktags' => true,
              );
            $this->filter_editor_setting_link();
            wp_editor( $this->value(), $this->id, $settings );
          ?>
        </label>
    <?php
        do_action('admin_footer');
        do_action('admin_print_footer_scripts');
    }
    private function filter_editor_setting_link() {

				add_filter( 'mce_buttons', 				array( $this, 'remove_tiny_mce_buttons' ) );
				add_filter( 'quicktags_settings', array( $this, 'allowed_quicktags_buttons' ) );
        add_filter( 'the_editor', 				array( $this, 'textarea_replace' ), 10, 1 );
    }

		public function remove_tiny_mce_buttons( $buttons ) {

		    $remove_buttons = array(
		        // 'bold',
		        // 'italic',
		        'strikethrough',
		        // 'bullist',
		        // 'numlist',
		        'blockquote',
		        'hr',
		        'alignleft',
		        'aligncenter',
		        'alignright',
		        // 'link',
		        // 'unlink',
		        'wp_more',
		        'spellchecker',
		        'dfw',
		        'wp_adv',
						'formatselect',
						'fullscreen'

		    );
		    foreach ( $buttons as $button_key => $button_value ) {

		        if ( in_array( $button_value, $remove_buttons ) ) {
		            unset( $buttons[ $button_key ] );
		        }
		    }
		    return $buttons;
		}

		function allowed_quicktags_buttons( $qtInit ) {

	    $qtInit['buttons'] = 'strong,em,link,ul,ol,li,code'; //,block,del,ins,img,close
	    return $qtInit;
		}

		public function textarea_replace( $output ) {
			return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 );
		}

}

function onepage_parallax_editor_control_script() {

		wp_enqueue_editor();
    wp_enqueue_script( 'onepage-parallax-wp-editor-customizer', get_template_directory_uri() . '/inc/onepage-parallax-control/includes/js/customizer_editor.js', array( 'jquery' ), rand(), true );
}

add_action( 'customize_controls_enqueue_scripts', 'onepage_parallax_editor_control_script' );
