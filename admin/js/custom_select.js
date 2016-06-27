$('.select_custom .openhide').click(function(){
	//$(this).next().next().slideToggle('slow');


	$(this).parent().next().slideToggle('fast');

});

$('.select_custom .close').mouseleave(function(){
	var menu = $('.close');
	if($('.close').css('display')=='block')
    	menu.slideToggle('fast');
});
