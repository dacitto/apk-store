$(function (){
  'use strict';
 // Calls the selectBoxIt 
  $("select").selectBoxIt({
    autoWidth: false
  });
//to top
$('.up').click(function(){
  $('html , body').animate({
    scrollTop: 0
  }, 1500);
});


// add Asterisk *
 $('input').each(function(){

   if ($(this).attr('required') ==='required') {

     $(this).after('<span class="asterisk"><i class="fa fa-asterisk"></i></span>');

   }
 });


// confermation Message  on DELETE
$('.confirm').click(function(){

	return confirm('Are You Sure ?');
});

$('.cat h3').click(	function(){
    
    $(this).next('.full-view').fadeToggle(0);

	});


// placeHolder Trick 
$('[placeholder]').focus(function(){
$(this).attr('data-text',$(this).attr('placeholder'));
$(this).attr('placeholder','');
}).blur(function(){
  $(this).attr('placeholder',$(this).attr('data-text'));
});

$('.login-page form').hide();
$("form.login").fadeIn(2500);


$('.login-page h1 span').click(function(){
  $(this).addClass('selected').siblings().removeClass('selected');
  $('.login-page form').hide();
  $("."+$(this).data('class')).fadeIn(2500);

});


$('.live').keyup(function(){
$($(this).data('class')).text($(this).val());
});

// Trigger NiceScroll

$('html').niceScroll({
        
        cursorcolor: '#a4c639',
        
        cursorwidth: '15px',
        
        cursorborder: '1px solid #a4c639',
        
        cursorborderradius: 0
        
    });
 $(window).on('scroll',function(){
  if ($(window).scrollTop()>50)
     $(".up").fadeIn(500);
 else
  $(".up").fadeOut(500);
     
  });


});
