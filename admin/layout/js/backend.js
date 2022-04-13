$(function (){
  'use strict';
 // Calls the selectBoxIt 
  $("select").selectBoxIt({
    autoWidth: false
  });

// Dashboard Latest Toggle Hide 
$(".toggle-info").click(function(){
  $(this).toggleClass('selected').parent().next('.panel-body').slideToggle(400);
  if ($(this).hasClass('selected')) {
    $(this).html('<i class="fa fa-plus"></i>');
  }else
  $(this).html('<i class="fa fa-minus"></i>');

});


// add Asterisk *
 $('input').each(function(){

   if ($(this).attr('required') ==='required') {

     $(this).after('<span class="asterisk"><i class="fa fa-asterisk"></i></span>');

   }
 });

$('.show-pass').hover(function(){
$('.password').attr('type', 'text');
$(this).css('color','green');

},function(){
$('.password').attr('type','password');
$(this).css('color','red');
});

// confermation Message  on DELETE
$('.confirm').click(function(){

	return confirm('Are You Sure ?');
});

$('.cat h3').click(	function(){
    
    $(this).next('.full-view').fadeToggle(0);

	});
$('.ordering span').click(	function(){
    
    $(this).addClass("active").siblings('span').removeClass("active");
    if ($(this).data('view')==='full') {
    	$('.cat .full-view').fadeIn(500);
    }else{
    	$('.cat .full-view').fadeOut(500);
    

    }

	});


});
