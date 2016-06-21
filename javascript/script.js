(function($) {
	$(function() {
		changeSelect($('select[name=brand_id]'));
		$('select,input[type="radio"]').styler();
	});
})(jQuery);

$(function(){

	$('div.avto_top div').click(function(){
		$('div.avto_bottom').slideToggle();
	});

	var color = 0;
	$('div.avto_top div').click(function(){
		if(color === 0){
			$('div.avto_top div').css('background','#025c8a');
			$('div.avto_top div p').css('color','#fff');
			$('div.avto_top div img').attr('src', '/images/arrow2.png')
			color = 1;
		} else if(color === 1){
			$('div.avto_top div').css('background','none');
			$('div.avto_top div p').css('color','#025c8a');
			$('div.avto_top div img').attr('src', '/images/arrow.png')
			color = 0;
		}
	});

  var num = 0;
  $('div.click_car').click(function(){
    
    if(num === 0){
      $(this).css('background','#025c8a');
      $('div.click_car p').css('color','#fff');
      $('div.click_car img').attr('src', '/images/arrow2.png');
      $('div.car_brand > div').animate({left: "-506px"},{duration: 500});
      num = 1;
    } else if(num = 1){
      $(this).css('background','');
      $('div.click_car p').css('color','');
      $('div.click_car img').attr('src', '/images/arrow.png');
      $('div.car_brand > div').animate({left: "0px"},{duration: 500});
      num = 0;
    }

  });

  $('.click_list_categ').click(function(){
    $('.click_list_categ').removeClass('active_list_categ');
    $(this).addClass('active_list_categ');
  });

  $('.show2').click(function(){
    $('.show_list').css('display','');
    $('.show_tile').css('display','');
  });
  $('.show1').click(function(){
    $('.show_list').css('display','none');
    $('.show_tile').css('display','block');
  });

  $('div.show div').click(function(){
    $('div.show div').removeClass('active_show');
    $(this).addClass('active_show');
  });

	/*hover*/
	$('div.glushitel ul li div').mouseover( function() {
		$(this).css('background', '#fff');
		$(this).css('border', '1px solid #8ec30c');
		$(this).children(1).css('border-bottom', '3px solid transparent');
	});
	$('div.glushitel ul li div').mouseout( function() {
		$(this).css('background', 'none');
		$(this).css('border', '1px solid transparent');
		$('div.glushitel ul li img').css('border-bottom', '3px solid #00aec7');
	});

	/*smenaimg*/
	$(".smenaimg").each(function(){
    var x=$(this);x.attr('save', x.attr('src'));
  })
	.mouseover( function() {
		var x=$(this);
		x.attr('src', x.attr('oversrc'));
	})
	.mouseout( function() {
		var x=$(this);
		x.attr('src', x.attr('save'));
	});
	
	/*active-news*/
	$('.news_article span').click(function(){
		$('.news_article span').removeClass("active_news");
		$(this).addClass("active_news");
		if ($('.articles').css('display') == 'none') {
			$('.articles').show();
			$('.news').hide();
		} else {
			$('.articles').hide();
			$('.news').show();
		}
	});
	
	$('#catalogForm select').each(function() {
    	if ($(this).val() != 0) {
			$(this).parent().css('box-shadow', '0 0 5px #20E3FF');
		}
	});
	
	$('select[name=brand_id]').change(function () {
		changeSelect($(this));
		setTimeout(function() {$('input, select').trigger('refresh');}, 1);
	});	
});

function changeSelect(t) {
	var v = t.val();
	if (v != 0) {
		$('select[name=brand_model]').find('option').each(function () {
			if ($(this).attr('data-brandid') != v && $(this).attr('value') != 0) $(this).addClass('selNone');
			else $(this).removeClass('selNone');
		});
	} else {
		$('select[name=brand_model]').find('option').each(function () {
			if ($(this).attr('value') != 0) $(this).addClass('selNone');
		});
	}
}

var secDuration = 5;
var image = 1;
var maxImages = 3;
var timeout;

function changeImage(requiredImage) {
  var slider = document.getElementById('slider');

  if (slider) {
	  if (!requiredImage && requiredImage != 0){ 
		if(image < maxImages){
		  image++;
		}
		else{
		  image = 1;
		}
	  } else { 
		if(requiredImage > maxImages){
		  image = 1;
		}
		else if(requiredImage < 1){ 
		  image = maxImages;
		}
		else{
		  image = requiredImage; 
		}
	  }
	  slider.className = "image" + image;
	  clearTimeout(timeout)
	  timeout = setTimeout("changeImage()",secDuration*1000);
  }
}
function nextImage(){
  changeImage(image+1);
}
function prevImage(){
  changeImage(image-1);
}

$(document).ready(function () {
	changeImage(1);
});



