jQuery(document).ready(function($) {

	$('#customize-control-onepage_parallax_hero_type select').on('change',function(){
    $('#customize-control-onepage_parallax_hero_type').nextAll().hide();
    if($(this).val() == 'image'){
      $('#customize-control-onepage_parallax_hero_color,#customize-control-header_image,#customize-control-onepage_parallax_hero_opecity,#customize-control-onepage_parallax_hero_textarea').show();
    }
    if($(this).val() == 'gradient-image'){
      $('#customize-control-header_image,#customize-control-onepage_parallax_hero_gradient0_color,#customize-control-onepage_parallax_hero_gradient1_color,#customize-control-onepage_parallax_hero_gradient2_color,#customize-control-onepage_parallax_hero_gradient3_color,#customize-control-onepage_parallax_hero_textarea').show();
    }
    if($(this).val() == 'gradient-color'){
      $('#customize-control-onepage_parallax_hero_gradient0_color,#customize-control-onepage_parallax_hero_gradient1_color,#customize-control-onepage_parallax_hero_gradient2_color,#customize-control-onepage_parallax_hero_gradient3_color,#customize-control-onepage_parallax_hero_textarea').show();
    }
    if($(this).val() == 'shortcode'){
      $('#customize-control-onepage_parallax_hero_slider_shortcode').show();
    }
  }).change();
	$('#sub-accordion-section-onepage_parallax_section_about_content #subtitle').each(function(){
		if ( $('#sub-accordion-section-onepage_parallax_section_about_content #title').prev('#subtitle').length == 0 ) {
		$(this).insertBefore($('#sub-accordion-section-onepage_parallax_section_about_content #title'));
		$('#sub-accordion-section-onepage_parallax_section_about_content #title').next('#subtitle').remove();
		}
	});
});
