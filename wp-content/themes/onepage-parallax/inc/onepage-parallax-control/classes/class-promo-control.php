<?php
/**
 * Promotion control class
 *
 * @package OnePage Parallax
 * @since 0.0.2
 */
if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

class OnePage_Parallax_Promotion_Control extends WP_Customize_Control {

    public $settings = 'blogname';
    public $description = '';
    public $title = '';
    public $group = '';
    public $type = '';

    /**
     * Render the description and title for the sections
     */
    public function render_content() {
        switch ( $this->type ) {
            default:

            case 'group_heading_top':
                echo '<h4 class="customizer-group-heading group-heading-top">' . esc_html( $this->title ) . '</h4>';
                if ( $this->description != '' ) {
                    echo '<p class="customizer-group-subheading">' . wp_kses( $this->description, array( 'span' => array() ) ) . '</p>';
                }
                break;

            case 'group_heading':
                echo '<h4 class="customizer-group-heading">' . esc_html( $this->title ) . '</h4>';
                if ( $this->description != '' ) {
                    echo '<p class="customizer-group-subheading">' . wp_kses( $this->description, array( 'span' => array() ) ) . '</p>';
                }
                break;

            case 'group_heading_message':
                echo '<h4 class="customizer-group-heading-message">' . esc_html( $this->title ) . '</h4>';
                if ( $this->description != '' ) {
                    echo '<p class="customizer-group-heading-message">' . wp_kses( $this->description, array(
                      'a' => array(
            						'href'    => array(),
            						'class'   => array(),
            						'target'  => array(),
            					),
                      'span' => array() ) ) . '</p>';
                }
                break;

            case 'hr' :
                echo '<hr />';
                break;
        }
    }
}
