/* global jQuery */
/* global wp */
function media_upload(button_class) {
    'use strict';
    jQuery('body').on('click', button_class, function () {
        var button_id = '#' + jQuery(this).attr('id');
        var display_field = jQuery(this).parent().children('input:text');
        var _custom_media = true;

        wp.media.editor.send.attachment = function (props, attachment) {

            if (_custom_media) {
                if (typeof display_field !== 'undefined') {
                    switch (props.size) {
                        case 'full':
                            display_field.val(attachment.sizes.full.url);
                            display_field.trigger('change');
                            break;
                        case 'medium':
                            display_field.val(attachment.sizes.medium.url);
                            display_field.trigger('change');
                            break;
                        case 'thumbnail':
                            display_field.val(attachment.sizes.thumbnail.url);
                            display_field.trigger('change');
                            break;
                        default:
                            display_field.val(attachment.url);
                            display_field.trigger('change');
                    }
                }
                _custom_media = false;
            } else {
                return wp.media.editor.send.attachment(button_id, [props, attachment]);
            }
        };
        wp.media.editor.open(button_class);
        window.send_to_editor = function (html) {

        };
        return false;
    });
}

/********************************************
 *** Generate unique id ***
 *********************************************/
function customizer_repeater_uniqid(prefix, more_entropy) {
    'use strict';
    if (typeof prefix === 'undefined') {
        prefix = '';
    }

    var retId;
    var php_js;
    var formatSeed = function (seed, reqWidth) {
        seed = parseInt(seed, 10)
            .toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
            return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) { // so short we pad
            return new Array(1 + (reqWidth - seed.length))
                    .join('0') + seed;
        }
        return seed;
    };

    // BEGIN REDUNDANT
    if (!php_js) {
        php_js = {};
    }
    // END REDUNDANT
    if (!php_js.uniqidSeed) { // init seed with big random int
        php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    php_js.uniqidSeed++;

    retId = prefix; // start with prefix, add current milliseconds hex string
    retId += formatSeed(parseInt(new Date()
            .getTime() / 1000, 10), 8);
    retId += formatSeed(php_js.uniqidSeed, 5); // add seed hex string
    if (more_entropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10)
            .toFixed(8)
            .toString();
    }

    return retId;
}


/********************************************
 *** General Repeater ***
 *********************************************/
function customizer_repeater_refresh_social_icons(th) {
    'use strict';
    var icons_repeater_values = [];
    th.find('.customizer-repeater-social-repeater-container').each(function () {
        var icon = jQuery(this).find('.icp').val();
        var link = jQuery(this).find('.onepage-parallax-repeater-social-repeater-link').val();
        var id = jQuery(this).find('.onepage-parallax-repeater-social-repeater-id').val();

        if (!id) {
            id = 'customizer-repeater-social-repeater-' + customizer_repeater_uniqid();
            jQuery(this).find('.onepage-parallax-repeater-social-repeater-id').val(id);
        }

        if (icon !== '' && link !== '') {
            icons_repeater_values.push({
                'icon': icon,
                'link': link,
                'id': id
            });
        }
    });

    th.find('.onepage-parallax-social-repeater-socials-repeater-colector').val(JSON.stringify(icons_repeater_values));
    customizer_repeater_refresh_general_control_values();
}


function customizer_repeater_refresh_general_control_values() {
    'use strict';
    jQuery('.onepage-parallax-repeater-general-control-repeater').each(function () {
        var values = [];
        var th = jQuery(this);
        th.find('.onepage-parallax-repeater-general-control-repeater-container').each(function () {

            var icon_value = jQuery(this).find('.icp').val();
            var text = jQuery(this).find('.onepage-parallax-repeater-text-control').val();
            var link = jQuery(this).find('.onepage-parallax-repeater-link-control').val();
            var image_url = jQuery(this).find('.custom-media-url').val();
            var image_box = jQuery(this).find('.custom-media-box');
            var choice = jQuery(this).find('.customizer-repeater-image-choice').val();
            var title = jQuery(this).find('.onepage-parallax-repeater-title-control').val();
            var subtitle = jQuery(this).find('.onepage-parallax-repeater-subtitle-control').val();
            var id = jQuery(this).find('.social-repeater-box-id').val();
            if (!id) {
                id = 'social-repeater-' + customizer_repeater_uniqid();
                jQuery(this).find('.social-repeater-box-id').val(id);
            }
            var social_repeater = jQuery(this).find('.onepage-parallax-social-repeater-socials-repeater-colector').val();
            var shortcode = jQuery(this).find('.onepage-parallax-repeater-shortcode-control').val();
            var pages = jQuery(this).find('.onepage-parallax-repeater-pages-control').val();
            var pages_title = jQuery(this).find('.onepage-parallax-repeater-pages-title-control').val();
            var pages_link = jQuery(this).find('.onepage-parallax-repeater-pages-link-control').val();
            var pages_image = jQuery(this).find('.onepage-parallax-repeater-pages-image-control').val();


            if (text !== '' || image_url !== '' || title !== '' || subtitle !== '' || icon_value !== '' || link !== '' || choice !== '' || social_repeater !== '' || shortcode !== '' || pages !== '' || pages_title !== '' || pages_link !== '' || pages_image !== '' ) {
                image_box.attr('src', image_url);
                values.push({
                    'icon_value': (choice === 'customizer_repeater_none' ? '' : icon_value),
                    'text': (text),
                    'link': link,
                    'image_url': (choice === 'customizer_repeater_none' ? '' : image_url),
                    'choice': choice,
                    'title': (title),
                    'subtitle': (subtitle),
                    'social_repeater': (social_repeater),
                    'id': id,
                    'shortcode': (shortcode),
                    'pages': (pages),
                    'pages_title': (pages_title),
                    'pages_link': (pages_link),
                    'pages_image': (pages_image),
                });
            }

        });
        th.find('.onepage-parallax-repeater-colector').val(JSON.stringify(values));
        th.find('.onepage-parallax-repeater-colector').trigger('change');
    });
}


jQuery(document).ready(function ($) {
    'use strict';
    var theme_conrols = jQuery('#customize-theme-controls');

    $('.page_options').each(function(){
      var getVal = $(this).val();
      $(this).find(' option[value='+getVal+']').addClass('onepage-parallax-repeater-pages-control').siblings('option').removeClass('onepage-parallax-repeater-pages-control');
      $(this).find(' option[value='+getVal+']').attr('selected','').siblings('option').removeAttr( 'selected' );
    });

    theme_conrols.on('change','.page_options',function(){
      var getVal = $(this).val();
      $(this).find(' option[value='+getVal+']').addClass('onepage-parallax-repeater-pages-control').siblings('option').removeClass('onepage-parallax-repeater-pages-control');
      $(this).find(' option[value='+getVal+']').attr('selected','').siblings('option').removeAttr( 'selected' );
      customizer_repeater_refresh_general_control_values();
      return false;
    });

    if( $('.onepage-parallax-repeater-pages-title-control').val() == 'on' ) {
      $('.onepage-parallax-repeater-pages-title-control').prop('checked',true);
    }

    if( $('.onepage-parallax-repeater-pages-link-control').val() == 'on' ) {
      $('.onepage-parallax-repeater-pages-link-control').prop('checked',true);
    }

    if( $('.onepage-parallax-repeater-pages-image-control').val() == 'on' ) {
      $('.onepage-parallax-repeater-pages-image-control').prop('checked',true);
    }

    theme_conrols.on('change','.onepage-parallax-repeater-pages-title-control',function(){
      if (this.checked) {
        $(this).attr('value', 'on');
      } else {
        $(this).attr('value', 'off');
      }
      customizer_repeater_refresh_general_control_values();
      // return false;
    });

    theme_conrols.on('change','.onepage-parallax-repeater-pages-link-control',function(){
      if (this.checked) {
        $(this).attr('value', 'on');
      } else {
        $(this).attr('value', 'off');
      }
      customizer_repeater_refresh_general_control_values();
      console.log(theme_conrols.length);
      // return false;
    });

    theme_conrols.on('change','.onepage-parallax-repeater-pages-image-control',function(){
      if (this.checked) {
        $(this).attr('value', 'on');
      } else {
        $(this).attr('value', 'off');
      }
      customizer_repeater_refresh_general_control_values();
      // return false;
    });

    theme_conrols.on('click', '.customizer-repeater-customize-control-title', function () {
        jQuery(this).next().slideToggle('medium', function () {
            if (jQuery(this).is(':visible')){
                jQuery(this).css('display', 'block');
            }
        });
    });

    theme_conrols.on('change', '.icp',function(){
        customizer_repeater_refresh_general_control_values();
        return false;
    });

    theme_conrols.on('change', '.customizer-repeater-image-choice', function () {
        if (jQuery(this).val() === 'customizer_repeater_image') {
            jQuery(this).parent().parent().find('.onepage-parallax-social-repeater-general-control-icon').hide();
            jQuery(this).parent().parent().find('.onepage-parallax-repeater-image-control').show();
        }
        if (jQuery(this).val() === 'customizer_repeater_icon') {
            jQuery(this).parent().parent().find('.onepage-parallax-social-repeater-general-control-icon').show();
            jQuery(this).parent().parent().find('.onepage-parallax-repeater-image-control').hide();
        }
        if (jQuery(this).val() === 'customizer_repeater_none') {
            jQuery(this).parent().parent().find('.onepage-parallax-social-repeater-general-control-icon').hide();
            jQuery(this).parent().parent().find('.onepage-parallax-repeater-image-control').hide();
        }

        customizer_repeater_refresh_general_control_values();
        return false;
    });
    media_upload('.customizer-repeater-custom-media-button');
    jQuery('.custom-media-url').live('change', function () {
        customizer_repeater_refresh_general_control_values();
        return false;
    });

    /**
     * This adds a new box to repeater
     *
     */

    theme_conrols.on('click', '.customizer-repeater-new-field', function () {

      var add_btn = jQuery('.customizer-repeater-new-field');

      var pro_msg = jQuery('.onepage-parallax-pro_msg');

      var count_obsolete = jQuery('.json_render_obsolete');
      var count_alpha = jQuery('.json_render_aplha');

      var count_obsolete_value = count_obsolete.attr('value');
      var count_alpha_value = count_alpha.attr('value');

      if(typeof(count_obsolete_value) != "undefined" && count_obsolete_value !== null) {
      var count_final = count_obsolete_value;
      } else {
        var count_final = count_alpha_value;
      }
      var count_lim_num = count_final;

      var btn_count = jQuery(this).prev(".onepage-parallax-repeater-general-control-repeater").children(".onepage-parallax-repeater-general-control-repeater-container").length;

      if ( btn_count < count_lim_num ) {
        var count_pls = ++btn_count;
        add_btn.attr( 'value', count_pls );
      }

      var onepage_parallax_new_val =  add_btn.attr('value');

        var th = jQuery(this).parent();
        var id = 'customizer-repeater-' + customizer_repeater_uniqid();
        if ( typeof th !== 'undefined' ) {

          /* Clone the first box*/
          if ( count_pls < count_lim_num ) {
            var field = th.find('.onepage-parallax-repeater-general-control-repeater-container:first').clone();
          }
          else {
            jQuery(this).next(pro_msg).show()
            // pro_msg.show();
          }

            if ( typeof field !== 'undefined' ) {
                /*Set the default value for choice between image and icon to icon*/
                field.find('.customizer-repeater-image-choice').val('customizer_repeater_icon');

                /*Show icon selector*/
                field.find('.onepage-parallax-social-repeater-general-control-icon').show();

                /*Hide image selector*/
                if (field.find('.onepage-parallax-social-repeater-general-control-icon').length > 0) {
                    field.find('.onepage-parallax-repeater-image-control').hide();
                }

                /*Show delete box button because it's not the first box*/
                field.find('.social-repeater-general-control-remove-field').show();

                /* Empty control for icon */
                field.find( '.icp' ).iconpicker().on( 'iconpickerUpdated', function() {
                    jQuery( this ).trigger( 'change' );
                } );
                field.find( '.input-group-addon' ).find('.fa').attr('class','fas fa-plus-circle');

                /*Remove all repeater fields except first one*/

                field.find('.onepage-parallax-repeater-social-repeater').find('.customizer-repeater-social-repeater-container').not(':first').remove();
                field.find('.onepage-parallax-repeater-social-repeater-link').val('');
                field.find('.onepage-parallax-social-repeater-socials-repeater-colector').val('');

                // /*Remove value from icon field*/
                // field.find('.icp').val('');

                /*Remove value from text field*/
                field.find('.onepage-parallax-repeater-text-control').val('');

                /*Remove value from link field*/
                field.find('.onepage-parallax-repeater-link-control').val('');

                /*Set box id*/
                field.find('.social-repeater-box-id').val(id);

                /*Remove value from media field*/
                field.find('.custom-media-url').val('');

                /*Remove value from title field*/
                field.find('.onepage-parallax-repeater-title-control').val('');

                /*Remove value from subtitle field*/
                field.find('.onepage-parallax-repeater-subtitle-control').val('');

                /*Remove value from shortcode field*/
                field.find('.onepage-parallax-repeater-shortcode-control').val('');

                /*Remove value from pages field*/
                field.find('.onepage-parallax-repeater-pages-control').removeClass('onepage-parallax-repeater-pages-control').removeAttr('selected');

                /*Remove value from pages control field*/
                field.find('.onepage-parallax-repeater-pages-title-control').val('').attr('checked', false);
                field.find('.onepage-parallax-repeater-pages-link-control').val('').attr('checked', false);
                field.find('.onepage-parallax-repeater-pages-image-control').val('').attr('checked', false);

                /*Append new box*/
                th.find('.onepage-parallax-repeater-general-control-repeater-container:first').parent().append(field);

                /*Refresh values*/
                customizer_repeater_refresh_general_control_values();
            }

        }
        return false;

    });


    theme_conrols.on('click', '.social-repeater-general-control-remove-field', function () {

      var count_obsolete = jQuery('.json_render_obsolete');
      var count_alpha = jQuery('.json_render_aplha');

      var count_obsolete_value = count_obsolete.attr('value');
      var count_alpha_value = count_alpha.attr('value');

      if(typeof(count_obsolete_value) != "undefined" && count_obsolete_value !== null) {
      var count_final = count_obsolete_value;
      } else {
        var count_final = count_alpha_value;
      }
      var count_lim_num = count_final;

      var add_btn = jQuery('.customizer-repeater-new-field');
      var pro_msg = jQuery('.onepage-parallax-pro_msg');

      var btn_count = jQuery(this).prev(".onepage-parallax-repeater-general-control-repeater").children(".onepage-parallax-repeater-general-control-repeater-container").length;
      // console.log(btn_count);

      var count_mins = --btn_count;
      add_btn.attr( 'value', count_mins );

      var onepage_parallax_new_val = add_btn.attr('value');
      // console.log(onepage_parallax_new_val);

      if ( add_btn < count_lim_num ) {
        pro_msg.hide();
      }

        if (typeof    jQuery(this).parent() !== 'undefined') {
            jQuery(this).parent().parent().remove();
            customizer_repeater_refresh_general_control_values();
        }
        return false;
    });


    theme_conrols.on( 'keyup', '.onepage-parallax-repeater-title-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on( 'keyup', '.onepage-parallax-repeater-subtitle-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on( 'keyup', '.onepage-parallax-repeater-shortcode-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on( 'change', '.onepage-parallax-repeater-pages-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on( 'change', '.onepage-parallax-repeater-pages-title-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on( 'keyup', '.onepage-parallax-repeater-text-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    theme_conrols.on( 'keyup', '.onepage-parallax-repeater-link-control', function () {
        customizer_repeater_refresh_general_control_values();
    });

    /*Drag and drop to change icons order*/

    jQuery('.customizer-repeater-general-control-droppable').sortable({
        update: function () {
            customizer_repeater_refresh_general_control_values();
        }
    });


    /*----------------- Socials Repeater ---------------------*/
    theme_conrols.on( 'click', '.social-repeater-add-social-item', function (event) {
        event.preventDefault();
        var th = jQuery(this).parent();
        var id = 'customizer-repeater-social-repeater-' + customizer_repeater_uniqid();

        var add_btn = jQuery('.social-repeater-add-social-item');

        var count_obsolete = jQuery('.json_render_obsolete');
        var count_alpha = jQuery('.json_render_aplha');

        var count_obsolete_value = count_obsolete.attr('value');
        var count_alpha_value = count_alpha.attr('value');

        if(typeof(count_obsolete_value) != "undefined" && count_obsolete_value !== null) {
        var count_final = count_obsolete_value;
        } else {
          var count_final = count_alpha_value;
        }
        var count_lim_num = count_final;

        var btn_count = jQuery(this).prev(".onepage-parallax-repeater-social-repeater").children(".customizer-repeater-social-repeater-container").length;

        if ( btn_count < count_lim_num ) {
          var count_pls = ++btn_count;
          add_btn.attr( 'value', count_pls );
        }

        console.log(count_pls);
        console.log(add_btn.attr( 'value'));


        if (typeof th !== 'undefined') {

          if ( count_pls < count_lim_num ) {
            var field = th.find('.customizer-repeater-social-repeater-container:first').clone();
          }

            if (typeof field !== 'undefined') {
                field.find( '.icp' ).iconpicker();
                field.find( '.icp' ).val('Pick and icon');
                field.find( '.input-group-addon' ).find('.fa').attr('class','fas fa-plus-circle');
                field.find('.onepage-parallax-social-repeater-remove-social-item').show();
                field.find('.onepage-parallax-repeater-social-repeater-link').val('');
                field.find('.onepage-parallax-repeater-social-repeater-id').val(id);
                th.find('.customizer-repeater-social-repeater-container:first').parent().append(field);
            }
        }
        return false;
    });

    theme_conrols.on('click', '.onepage-parallax-social-repeater-remove-social-item', function (event) {

      var add_btn = jQuery('.social-repeater-add-social-item');

      var btn_count = add_btn.attr('value');

      var count_mins = --btn_count;
      add_btn.attr('value', count_mins);

      console.log(count_mins);
      console.log(add_btn.attr('value'));

        event.preventDefault();
        var th = jQuery(this).parent();
        var repeater = jQuery(this).parent().parent();
        th.remove();
        customizer_repeater_refresh_social_icons(repeater);
        return false;
    });

    theme_conrols.on('keyup', '.onepage-parallax-repeater-social-repeater-link', function (event) {
        event.preventDefault();
        var repeater = jQuery(this).parent().parent();
        customizer_repeater_refresh_social_icons(repeater);
        return false;
    });

    theme_conrols.on( 'iconpickerSelected', '.icp', function(event) {
        event.preventDefault();
        var th = jQuery(this).parent().parent().parent();
        customizer_repeater_refresh_social_icons(th);
        return false;
    } );

});
