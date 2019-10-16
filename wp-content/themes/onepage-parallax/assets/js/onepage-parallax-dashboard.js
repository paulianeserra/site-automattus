jQuery(document).ready(function($){

  $('.nav-tab-wrapper a').on('click',function(e){
    e.preventDefault();
    var target = $(this).attr('href');
    $(this).addClass('nav-tab-active').siblings().removeClass('nav-tab-active');
    $(target).show().siblings('.theme_info').hide();
  } );
} );
