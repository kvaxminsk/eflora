function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}

function changeCurrency() {
    var shopArr = getBasketInfo();
    var shopProductCount = 0;
    var price_us = 0;
    var price_br = 0;
    for (var key in shopArr) {
        shopProductCount = shopProductCount+ parseInt(shopArr[key]['count']);
        //$().first().text('<p>В корзине</p>');
        //alert(shopArr[key]['id']);
        $('#count-' + shopArr[key]['id']).val(shopArr[key]['count']);
        $('.in_cart[data-productid=' + shopArr[key]['id'] + ']').find('p').text('В КОРЗИНЕ');
        $('.in_cart[data-productid=' + shopArr[key]['id'] + ']').addClass("style_in_cart");
        price_us = price_us + parseInt(shopArr[key]['price']) * parseInt(shopArr[key]['count']);
        var currency = '';
        if (localStorage['currency']) {
            currency = JSON.parse(localStorage['currency']);
        }
        if (currency != 'us') {
            currency = 'br';
            price_br = kurs * price_us;
            //price_br = number_format(price_br, 0, ',', ' ');
        }
        else {
            price_br = kurs * price_us;
            //price_br = number_format(price_br, 0, ',', ' ');
        }
        //alert(shopArr[key]['price']);
        //alert(shopProductCount);
        //alert(price_us);
    }
    if (shopProductCount == 0) {
        $('.baskettext').text(lang.basketTextNull);
        $('#header_price_text_br').html("<sub> " + parseInt(price_us * kurs / 10000)  + "</sub>" + "<sup>" +
            Math.round(((price_us * kurs / 10000) -  (parseInt(price_us * kurs / 10000)))*100) +" коп</sup>" );
        $('#header_price_text_us').text(price_us);
    }
    else {
        $('.baskettext').text(shopProductCount + ' ' + lang.basketText);
        $('#header_price_text_br').html("<sub> " + parseInt(price_us * kurs / 10000)  + "</sub>" + "<sup>" +
            Math.round(((price_us * kurs / 10000) -  (parseInt(price_us * kurs / 10000)))*100) +" коп</sup>");
        $('#header_price_text_us').text(price_us);
    }

    $('#header_price_text_br').html("<sub> " + parseInt(price_us * kurs / 10000)  + "</sub>" + "<sup>" +
        Math.round(((price_us * kurs / 10000) -  (parseInt(price_us * kurs / 10000)))*100) +" коп</sup>" );
    $('#header_price_text_us').text(price_us);

    var currency = '';
    if (localStorage['currency']) {
        currency = JSON.parse(localStorage['currency']);
    }
    if (currency == 'us') {
        //alert(currency);
        $('.old_price').hide();
        $('.old_price_1').hide();
        $('.new_price_2').hide();
        $('.new_price').hide();
        $('.dollar_price').show();
        $('.dollar_price_1').show();
        $('.dollar_price_2').show();

        $('#order_list_price_old').hide();
        $('#order_list_price_new').hide();
        $('#order_list_price_dollar').show();
        $('#unit_valuta').show();
        $('.br1').hide();
        $('.br2').hide();
    }
    else if (currency == 'br') {
        $('.dollar_price').hide();
        $('.dollar_price_1').hide();
        $('.dollar_price_2').hide();
        $('.old_price_1').show();
        $('.new_price_2').show();
        $('.old_price').show();
        $('.new_price').show();

        $('#order_list_price_old').show();
        $('#order_list_price_new').show();
        $('#order_list_price_dollar').hide();
        $('.br1').show();
        $('.br2').show();
    }
}
function renderBlockCart() {
    var shopArr = getBasketInfo();
    var shopProductCount = 0;
    var price_us = 0;
    var price_br = 0;
    var id = 0;
    $('.order_list').text('');
    for (var key in shopArr) {
        //shopProductCount = shopProductCount + parseInt(shopArr[key]['count']);
        //price_us = price_us + parseInt(shopArr[key]['price']) * shopProductCount;
        id = parseInt(shopArr[key]['id']);
        //alert($('.cart1_item li[data-productid=' + id+']').find('.niceCheck').find('input').attr('checked'));
        //alert('.cart1_item li[data-productid=' + id+']');
        $.ajax({
            type: 'get',
            data: 'id=' + id,
            url: '/ajax-product-cart',
            success: function (data) {
                //document.write();

                $('.order_list').append(data);
                changeCurrency();

                //if($('.cart1_item li[data-productid=' + id+']').find('.niceCheck').hasClass('active')) {
                    $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').addClass('active');
                    $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').find('input').attr('checked',true);
                //}
                //else {
                //    $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').removeClass('active');
                //    $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').find('input').attr('checked',false);
                //}


                    //$('.cart1_item li').each(function () {
                    //    var dataProductId2 = $(this).attr('data-productid');
                    //    if (dataProductId == dataProductId2) {
                    //        $(this).find('.niceCheck').addClass('active')
                    //        $(this).find('.niceCheck').find('input').attr('checked',true)
                    //
                    //    }
                    //});
                }
            });
    }
    //for (var key in shopArr) {
    //    if(!$('.cart1_item li[data-productid=' + id+']').find('.niceCheck').hasClass('active')) {
    //        $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').addClass('active');
    //        $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').find('input').attr('checked',true);
    //    }
    //    else {
    //        $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').removeClass('active');
    //        $('.cart1_item li[data-productid=' + id+']').find('.niceCheck').find('input').attr('checked',false);
    //    }
    //}
    if (shopProductCount == 0) {
        $('.baskettext').text(lang.basketTextNull);
        $('#header_price_text_br').html("<sub> " + parseInt(price_us * kurs / 10000)  + "</sub>" + "<sup>" +
            Math.round(((price_us * kurs / 10000) -  (parseInt(price_us * kurs / 10000)))*100) +" коп</sup>" );
        $('#header_price_text_us').text(price_us);
    }
    else {
        $('.baskettext').text(shopProductCount + ' ' + lang.basketText);
        $('#header_price_text_br').html("<sub> " + parseInt(price_us * kurs / 10000)  + "</sub>" + "<sup>" +
            Math.round(((price_us * kurs / 10000) -  (parseInt(price_us * kurs / 10000)))*100) +" коп</sup>" );
        $('#header_price_text_us').text(price_us);
    }
}

function renderBlockReviews() {
    if (localStorage['reviews']) {
        var reviewsArr = JSON.parse(localStorage['reviews']);
        $('.reviews_product').text('');
        for (var i = reviewsArr.length - 1; i >= 0; i--) {
            if (i == (reviewsArr.length - 4)) {
                break;
            }
            $.ajax({
                type: 'get',
                data: 'id=' + reviewsArr[i],
                url: '/ajax-product-reviews',
                success: function (data) {
                    //document.write();

                    $('.reviews_product').append(data);
                    // changeCurrency();
                }
            });
        }
    }
}


$(document).ready(function () {
    ////******удаляем лишний элемент на главной странице в меню**/
    var lastElement = $('.slick-dots li').last();
    lastElement.remove();
    ///******/
    $('.button_continue').on('click', function () {
        // alert($('input[name=name_to]').val());
        $('#name_to').append($('input[name=name_to]').val());
        // alert($('span #name_to').text);

        $('#phone_to').text($('input[name=phone_to]').val());
        $('#country_to').text($('span[name=country_to]').text());
        $('#email_to').text($('input[name=email_to]').val());

        $('#name_from').text($('input[name=name_from]').val());
        $('#phone_from').text($('input[name=phone_from]').val());
        $('#country_from').text($('span[name=country_from]').text());
        $('#city_from').text($('span[name=city_from]').text());
        $('#address_from').text($('input[name=address_from]').val());
        $('#text_postcard_confirm').text($('textarea[name=text_postcard]').val());
        $('#comment_postcard_confirm').text($('textarea[name=comment_postcard]').val());

        var methodPay = '';
        switch ($('input[name=radiog_dark]:checked').val()) {
            case '1':
                methodPay = 'Наличные деньги курьеру';
                break;
            case '2':
                methodPay = 'VISA/MasterCard/Белкарт';
                break;
            case '3':
                methodPay = 'Оплата наличными в одном из наших салонов';
                break;
            case '4':
                methodPay = 'WebMoney';
                break;
            case '5':
                methodPay = 'ЕРИП Расчёт';
                break;
            case '6':
                methodPay = 'Оплата по безналичному расчету на наш расчетный счет для юридических лиц';
                break;
            case '7':
                methodPay = 'Яндекс Деньги';
                break;
        }
        ;
        $('#method_pay').text(methodPay);
    });
    renderBlockCart();
    /// main js
    if (localStorage['currency']) {
        var currency = JSON.parse(localStorage['currency'])
        if (currency == 'us') {
            $('.header_price_icon>.backet_circle>p').text("$");
            $('#points').css('margin-left', '36px');
            $('#header_price_text_us').show();
            $('#header_price_text_br').hide();
        }
        else {
            currency = 'br';
            localStorage['currency'] = JSON.stringify(currency);
            $('.header_price_icon>.backet_circle>p').text("Br");
            $('#points').css('margin-left', '100px');
            $('#header_price_text_us').hide();
            $('#header_price_text_br').show();
        }
    }
    else {
        currency = 'br';
        localStorage['currency'] = JSON.stringify(currency);
        $('#points').css('margin-left', '100px');
        $('#header_price_text_us').hide();
        $('#header_price_text_br').show();
    }


    var window_width = $(window).width() + 17;
    var window_type;         ///  keep a type of screen default - desctop
    var instheightMenu;
    var instheightQuestion;
    var instheightCatalog;
    var left_sibar_pos;
    var stop_animate = false;

    $('.cart1_item li').click(function () {
        var input = $(this).find('.niceCheck').find('input').eq(0);

        if ($(this).find('.niceCheck').hasClass('active')) {
            $(this).find('.niceCheck').removeClass("active");
            input.attr("checked", false);
        }
        else {
            $(this).find('.niceCheck').addClass("active");
            input.attr("checked", true);
        }
    })
    //$('.cart1_item li').find('.niceCheck').click(function () {
    //
    //    event.stopPropagation();
    //    var input = $(this).find('input').eq(0);
    //    if (!$(this).hasClass('active')) {
    //        $(this).removeClass("active");
    //        input.attr("checked", false);
    //    }
    //    else {
    //        $(this).addClass("active");
    //        input.attr("checked", true);
    //    }
    //});

    if ($('.left_sidebar').length) {
        left_sibar_pos = $('.left_sidebar').offset().top;
    }

    switch (true) {
        case window_width <= 1000 :
            window_type = "mobile";
            break;
        case window_width <= 1280:
            window_type = "tablet";
            break;
        default:
            window_type = "desctop";
    }

    $(window).resize(function () {
        window_width = $(window).width() + 17;
        switch (true) {
            case window_width <= 1000 :
                window_type = "mobile";
                break;
            case window_width <= 1280:
                window_type = "tablet";
                break;
            default:
                window_type = "desctop";
        }

        /*	var pic_width= $('.item_under_slider').height()*2.14;
         $('.circle_pic').css("width", pic_width);
         $('.under_slider_left_box').children('img').width(pic_width);*/

        /*	var fre_pos = $('.fre').offset().top;
         var circle_pos = $('.circle_pic').offset().top;
         var margin_top = circle_pos - fre_pos;
         if ( margin_top < 70 ){
         margin_top = '70px';
         }*/
        //$('.item_under_slider_pic').animate({ 'marginTop': -margin_top}, 1);

        /*var height = $('.slick-active p').width()/1.22;
         if ($("body").width() == 1263 ) {
         height = 595;
         }
         $('.slider-for').find('.slick-slide, .slick-current, .slick-active p').height(height);*/
        var pic_width = $('.fre').width();
        var pic_height = $('.fre').height();
        $('.circle_pic').css('width', pic_width);
        $('.circle_pic').css('height', pic_height);
    });

    $(window).scroll(function () {

        if (window_type == 'tablet' || window_type == "desctop") {
            if ($(document).scrollTop() >= 140 && $('#question_icon').hasClass('active_menu')) {
                $('#question_icon').css('position', 'fixed');
                $('#question_icon').css('left', '445px');
                /*           $('#question_icon').css('top', '-80px');*/
                $('#question_icon').css('top', '-80px');
            }
            else {
                $('#question_icon').css('position', 'absolute');
                $('#question_icon').css('left', '80px');
                $('#question_icon').css('top', '0px');
            }
        }

        if (window_type == 'tablet' || window_type == "mobile") {
            if (instheightMenu && $('#sandwich').hasClass('active_menu')) {
                $(".hidden_menu").css('position', 'fixed');
                $(".hidden_menu").css('z-index', '9999');
                return;
            }


            if (instheightQuestion && $('#question_icon').hasClass('active_menu')) {
                $(".question_panel").css('position', 'fixed');
                $(".question_panel").css('z-index', '9999');
                $(".question_panel").css('top', '0');
            }
            if ($('.mob_list_wrapp').hasClass('show')) {

                $(".slick-dots").css('position', 'fixed');
                $(".slick-dots").css('z-index', '9999');
                $(".slick-dots").css('top', '239px');
                $('.slick-dots').css('padding-top', '0');
                $('.mobile_list').css('background-color', 'rgba(158, 77,105, 1)');
            }
        }
        if ($('.left_sidebar').length && ($('.mp_left_main_content').height() < $('.mp_right_main_content').height() )) {
            if (($(window).scrollTop() + $(window).height()) >= (left_sibar_pos + $('.left_sidebar').height() + 30)) {
                $(".left_sidebar").css('position', 'fixed');
                $(".left_sidebar").css('bottom', '0px');
                if ($(window).scrollTop() + $(window).height() >= $(".footer").offset().top) {
                    $(".left_sidebar").css('position', 'absolute');
                    $(".left_sidebar").css('top', "auto");
                    $(".left_sidebar").css('bottom', "0");
                    //alert($(".footer").offset().top);
                }
            }
            else {
                if ($('.left_sidebar').offset().top <= left_sibar_pos) {
                    $(".left_sidebar").css('position', 'relative');

                }

            }
        }


        if (window_type == 'tablet' || window_type == "desctop") {
            if ($(document).scrollTop() >= 60 && $('#sandwich').hasClass('active_menu')) {
                $('#menu_selector').css('position', 'fixed');
                $('#menu_selector').css('left', '365px');
                /*           $('#question_icon').css('top', '-80px');*/
                $('#menu_selector').css('top', '0px');
            }
            else {
                $('#menu_selector').css('position', 'absolute');
                $('#menu_selector').css('left', '0px');
                $('#menu_selector').css('top', '0px');
            }
        }

        if (window_type == 'tablet' || window_type == "mobile") {
            if (instheightMenu && $('#sandwich').hasClass('active_menu')) {
                $(".hidden_menu").css('position', 'fixed');
                $(".hidden_menu").css('z-index', '9999');
                return;
            }


            if (instheightQuestion && $('#question_icon').hasClass('active_menu')) {
                $(".question_panel").css('position', 'fixed');
                $(".question_panel").css('z-index', '9999');
                $(".question_panel").css('top', '0');
            }
            if ($('.mob_list_wrapp').hasClass('show')) {

                $(".slick-dots").css('position', 'fixed');
                $(".slick-dots").css('z-index', '9999');
                $(".slick-dots").css('top', '239px');
                $('.slick-dots').css('padding-top', '0');
                $('.mobile_list').css('background-color', 'rgba(158, 77,105, 1)');
            }
        }


    });

    var time_out = false;

    if (window_type == 'tablet' || window_type == "mobile") {
        $('#sandwich').removeClass('active_menu');
        //$('#menu_selector').find('img').hide();


    }


    $('#menu_selector').click(function () {


        console.log("errror");

        if ($('#question_icon').attr('class') == 'active_menu') {

            $('#question_icon').click();
        }

        if ($('.mob_list_wrapp').hasClass('show')) {
            $('.catalog_close').click();
        }


        if (time_out != false) {

            clearTimeout(time_out);

            console.log('timer is destroy');
            time_out = false;
        }
        if (!$(document).find('.page1')) {
            return;

        }

        switch (window_type) {
            case 'desctop' :
                helpmenuShow(0);
                instheightMenu = installHeight($('.hidden_menu'));
                break;
            case 'tablet' :
                helpmenuShow(0);
                instheightMenu = installHeight($('.hidden_menu'));
                break;
            case 'mobile' :
                helpmenuShow(0);
                instheightMenu = installHeight($('.hidden_menu'));
                break;
        }
    });

    $("#question_icon").click(function () {

        if ($('#sandwich').attr('class') == 'active_menu') {
            $('#sandwich').click();
        }
        if ($('.mob_list_wrapp').hasClass('show')) {
            $('.catalog_close').click();
        }
        switch (window_type) {
            case 'desctop' :
                instheightQuestion = installHeight($('.question_panel'));
                questionmenuShow(0);
                break;
            case 'tablet' :
                instheightQuestion = installHeight($('.question_panel'));
                questionmenuShow(0);
                break;
            case 'mobile' :
                instheightQuestion = installHeight($('.question_panel'));
                questionmenuShow(0);
                break;

        }
    });
    if (window_type == 'desctop') {
        instheightMenu = installHeight($('.hidden_menu'));
        console.log('timer is run', window_type);
        time_out = setTimeout(function () {
            $('#sandwich').click();
        }, 1500); // время в мс
    }

    $('.menu_panel_close').click(function () {
        switch (window_type) {
            case 'tablet' :
                helpmenuShow(-365);
                break;
            case 'mobile' :
                helpmenuShow(-160);
                break;
        }
    })

    $('.help_panel_close').click(function () {
        switch (window_type) {
            case 'tablet' :
                questionmenuShow(-365);
                break;
            case 'mobile' :
                questionmenuShow(-160);
                break;
        }
    })
    $('.catalog_close').click(function () {
        $('.mobile_list').click();
    });

///// insertjs

//$('.fade').slick({
//	dots: true,
//	infinite: true,
//	speed: 500,
//	fade: true,
//	arrows: false,
//
//	cssEase: 'linear',
//	customPaging: function(slick,index) {
//		var title ="";
//		switch(index){
//			case  0:
//			title = "Акции"
//			break;
//			case  1:
//			title = "Подарочные букеты"
//			break;
//			case  2:
//			title = "Букеты из роз"
//			break;
//			case  3:
//			title = "Корзины цветов"
//			break;
//			case  4:
//			title = "Люкс-буеты"
//			break;
//			case  5:
//			title = "Свадебные букеты"
//			break;
//			case  6:
//			title = "Экзотические букеты"
//			break;
//			case  7:
//			title = "Горшечные растения"
//			break;
//			case 8:
//			title = "Бизнес-букет"
//			break;
//			case 9:
//			title = "8 марта"
//			break;
//			case 10:
//			title = "День св. Валентина"
//			break;
//			case 11:
//			title = "Мягкие игрушки"
//			break;
//			case 12:
//			title = "Подарки"
//			break;
//			case 13:
//			title = "Ритуальные"
//			break;
//		}
//		if ( index == 0 ) {
//			return '<span class="reason_link" > ' + title + '</span>';
//
//		}else{
//			return '<span class="reason_link" > ' + title + '</span>';
//
//
//		}
//
//	}
//});
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
        speed: 400,
        adaptiveHeight: true,
        cssEase: 'ease',
        asNavFor: '.slider-nav'
    });

    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: true,
        speed: 400,
        cssEase: 'ease',
        variableWidth: true,
        focusOnSelect: true

    });

   /* $('.slick-track').css('left', '0px;');*/


    $('.slick-dots').children('li').click(function () {
        var data = $(this).find('span').text();
        $('.left_box p ').eq(0).text(data);
        $('.mobile_categoria').text(data);

        var title = $(this).find('span').attr('data-title');
        $('.right_box_title ').eq(0).text(title);

        var describe = $(this).find('span').attr('data-description');


        $('.rb_discribe ').eq(0).text(describe);
        $('#theme_text').text(data);

        $('#theme_text').attr('data-category', $(this).find('span').attr('data-category'));

    })

    ///// drop_down phone number

    $(".phone_number").click(function () {

        if ($(window).width() <= 360) {
            if ($('.list').hasClass('show')) {
                $('.list').removeClass('show');
                $('#second_column').animate({height: "0px"}, 1000);
                $('#third_column').animate({height: "0px"}, 1000, function () {
                    $('.list').css('z-index', '9996');
                });

            }
            else {
                $('#second_column').animate({height: "230px"}, 1000);
                $('#third_column').animate({height: "200px"}, 1000);
                $('.list').addClass('show');
                $('.list').css('z-index', '9999');
            }

            return;
        }


        if ($(window).width() <= 400) {
            if ($('.list').hasClass('show')) {
                $('.list').removeClass('show');
                $('#second_column').animate({height: "0px"}, 1000);
                $('#third_column').animate({height: "0px"}, 1000, function () {
                    $('.list').css('z-index', '9996');
                });


            }
            else {
                $('#second_column').animate({height: "170px"}, 1000);
                $('#third_column').animate({height: "170px"}, 1000);
                $('.list').addClass('show');
                $('.list').css('z-index', '9999');
            }

            return;
        }

        if ($(window).width() + 17 <= 480) {
            if ($('.list').hasClass('show')) {
                $('.list').removeClass('show');
                $('#second_column').animate({height: "0px"}, 1000);
                $('#third_column').animate({height: "0px"}, 1000, function () {
                    $('.list').css('z-index', '9996');
                });
            }
            else {
                $('#second_column').animate({height: "220px"}, 1000);
                $('#third_column').animate({height: "220px"}, 1000);
                $('.list').addClass('show');
                $('.list').css('z-index', '9999');
            }


            return;
        }

        if ($(window).width() + 17 <= 1280) {
            if ($('.list').hasClass('show')) {
                $('.list').removeClass('show');
                //$('.list').css('z-index', '9996');
                $('#second_column').animate({height: "0px"}, 1000);
                $('#third_column').animate({height: "0px"}, 1000, function () {
                    $('.list').css('z-index', '9996');
                });


            }
            else {
                $('#second_column').animate({height: "180px"}, 1000);
                $('#third_column').animate({height: "180px"}, 1000);
                $('.list').addClass('show');
                $('.list').css('z-index', '9999');

            }
        }
    });


    //// slider_box_panel


    $('.left_box').click(function () {
        if ($(".left_box").hasClass("show")) {
            $('.left_box').animate({left: "50%"}, 1000);
            $('.right_box').animate({left: "100%"}, 1000);
            $('.right_box').animate({width: "hide"}, 1);

            $('.left_box').removeClass("show");
        }
        else {
            $('.right_box').animate({width: "show"}, 0.0001);
            $('.right_box').animate({left: "50%"}, 1000);
            $('.left_box').animate({left: "0"}, 1000);

            $(".left_box").addClass("show");
        }
        return false;
    });


    $(".up_button").click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    })
    //var category = $('.slick-active a').attr('data-category');
    if ($('.slick-active a').attr('data-category')) {
        var category = $('.slick-active a').attr('data-category');
        $.ajax({
            type: 'get',
            data: 'category=' + category,
            url: '/ajax-products',
            success: function (data) {
                ;
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);


                changeCurrency();

            }
        });
    }
    else {
        var category = $('.slick-active-catalog a').attr('data-category');
        $.ajax({
            type: 'get',
            data: 'category=' + category,
            url: '/ajax-products',
            success: function (data) {
                ;
                //document.write();
                $('.flower_products').text('');
                //alert(data);
                $('.flower_products').append(data);
                changeCurrency();

            }
        });
    }
    //$("div").first()





    $(document).on('click', ".in_cart", function (e) {
        if ($(this).parent().parent().find('count_product').children('input').val() != '0') {
            $(this).find('p').text('В КОРЗИНЕ');
            $(this).addClass("style_in_cart");

        }

        e.preventDefault();

    });
    var pageCount = 1;
    //$("#show_more_item").click(function(){
    //	var pageCount = 1;
    //	alert(category);
    //	//alert($(this).attr('data-category'));
    //	var category = $(this).attr('data-category');
    //	//alert(category);
    //	//$(this).text('Загрузка');
    //	//setTimeout(1000);alert('fff');
    //	$.ajax({
    //		type: 'POST',
    //		data:'page=' + pageCount++,
    //		url: '/ajax-products',
    //		success: function(data){
    //			//document.write();
    //			$('.flower_products:last-child').remove();
    //			$('.flower_products').append(data);
    //		}
    //	});
    //});
    var globalCategory;
    $(".reason_link_a").click(function () {
        //alert($(this).attr('data-category'));
        var category = $(this).attr('data-category');
        //alert(globalCategory);
        //alert($(this).attr('data-url'));
        if(globalCategory == category) {
            //alert($(this).attr('data-url'));
            window.location.href = $(this).attr('data-url');
        }
        else {
            globalCategory = category;
        }

        //$(this).text('Загрузка');
        //setTimeout(1000);alert('fff');
        $.ajax({
            type: 'get',
            data: 'category=' + category,
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                //$("#show_more_item").before();
                //$("#show_more_item").before(data);
                changeCurrency();
            }
        });
    });
    $(document).on("click", ".increment", function () {
        var new_val = parseInt($(".count_product").children('input').val());
        var element = $(this).parent().children(".count_product").children("input");
        element.val(parseInt(element.val()) + 1);
        $('.in_cart_count').text('В корзине ' + element.val() + ' шт.');


        $(this).parent().parent().find($('.in_cart')).find('p').text('В КОРЗИНУ');
        $(this).parent().parent().find($('.in_cart')).removeClass("style_in_cart");

    });
    $(document).on("click", ".decrement", function () {
        var new_val = parseInt($(".count_product").children('input').val());
        var element = $(this).parent().children(".count_product").children("input");
        if (parseInt(element.val()) > 0) {
            element.val(parseInt(element.val()) - 1);
            $('.in_cart>p').text('В КОРЗИНУ');
            $(this).parent().parent().find($('.in_cart')).removeClass("style_in_cart");
        }
        $('.in_cart_count').text('В корзине ' + element.val() + ' шт.');
    });
    $(".flower_car").hover(function () {

        showCirclePicture($(this))
    });
    $(".flower_smile").hover(function () {

        showCirclePicture($(this))
    });

    $(document).on('click', '.delete_order', function () {
        $(this).parent().parent().addClass('delete');
        $(this).parent().parent().animate({height: '0'}, 300);
        var datacategory_id= $(this).attr('data-productid') ;

        var input = $('.niceCheck[data-productid='+datacategory_id+']').eq(0);
        deleteShopId($(this).attr('data-productid'));
        if ($('.niceCheck[data-productid='+datacategory_id+']').hasClass('active')) {
            $('.niceCheck[data-productid='+datacategory_id+']').removeClass("active");
            input.attr("checked", false);
        }
        else {
            $('.niceCheck[data-productid='+datacategory_id+']').addClass("active");
            input.attr("checked", true);
        }

    })


    var heightmobile_list = $('.slick-dots').height() + 240;
    if ($(window).width() + 17 <= 840) {
        ;
        if ($(window).height() <= heightmobile_list) {
            $('.slick-dots').css('height', $(window).height() - 240);
            $('.slick-dots').css('overflow-y', 'scroll');
        }
    }

    $('.mobile_list').click(function () {


        if ($(this).parent().hasClass('show')) {
            $(this).parent().removeClass('show');
            $('.slick-dots').animate({left: '-365px'}, 600);
            $('.catalog_logo').animate({left: '-365px'}, 600);
            $('.mobile_list').css('background-color', 'rgba(158, 77,105, 0.88)');
        }
        else {
            $(this).parent().addClass('show');
            $('.slick-dots').animate({left: '0px'}, 600);
            $('.catalog_logo').animate({left: '0px'}, 600);
            $(".slick-dots").css('top', '239px');
            $('.slick-dots').css('padding-top', '0');
            $('.mobile_list').css('background-color', 'rgba(158, 77,105, 1)');


        }
    });
    $('#dropdown1>li>a').click(function (event) {
        event.preventDefault();
        var val = $(this).text();
        $('#theme_text').text(val);
        $('#theme_text').attr('data-category', $(this).parent().attr('data-category'));


        $('#theme_filter').removeClass('active');
        var category = $(this).parent().attr('data-category');

        $('#theme_text').text(val);
        $('#theme_text').attr('data-category', $(this).parent().attr('data-category'));





        $('.catalog_list ul  li').each(function () {
            var attr = $(this).find('a').attr('data-category');
            $(this).removeClass('slick-active-catalog');
            if (category == attr) {
                $(this).addClass('slick-active-catalog');

            }
        });
        /*$('.catalog_list ul  li').each(function () {
            var attr = $(this).find('a').attr('data-category');
            $(this).removeClass('slick-active-catalog');
            if (category == attr) {
                $(this).addClass('slick-active-catalog');

            }
        });*/


        $('.slick-dots li').each(function () {
            var attr = $(this).find('a').attr('data-category');
            if (category == attr) {
                $(this).click();
            }
        });



        $.ajax({
            type: 'get',
            data: 'category=' + category,
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                //$("#show_more_item").before(data);
                changeCurrency();
                $('#theme_filter').removeClass('active');
            }
        });


    });

    $('#dropdown2>li>a').click(function (event) {
        event.preventDefault();
        var val = $(this).text();

        if (val == "По цене:") {

            return
        }
        else {
            $('#criterion_filter_text').text(val);
        }


    });
/// Это что такое???    а это выбор стран!!!!
    $('.wrapper-dropdown-2>.dropdown>li').click(function () {

        /*   	/!*if (val == "По цене:"){
         return
         }*!/
         alert($(this).text());*/
        $(this).parent().parent().find('span').text($(this).text());
    });


    $(".count_product").children("input").keydown(function (event) {
        // Разрешаем нажатие клавиш backspace, Del, Tab и Esc
        var zero = $(this).val();
        if (zero[0] == "0") {

            zero = zero.replace(zero[0], '');
            $(this).val(zero);
        }
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
                // Разрешаем выделение: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
                // Разрешаем клавиши навигации: Home, End, Left, Right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            return;
        }
        else {
            // Запрещаем всё, кроме клавиш цифр на основной клавиатуре, а также Num-клавиатуре
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });
    $(".hidden_menu_list").children('li').hover(function () {
        $('.hidden_menu_list').children('li').each(function () {
            $('.hidden_menu_list').children('li').removeClass('active_hidden_menu');
        });
        $(this).addClass('active_hidden_menu');
    }, function () {
        $('.hidden_menu_list').children('li').each(function () {
            $('.hidden_menu_list').children('li').removeClass('active_hidden_menu');
        });
    });


    $(".help_list").children('li').hover(function () {
        $('.help_list').children('li').each(function () {
            $('.help_list').children('li').removeClass('active_help_menu');
        });
        $(this).addClass('active_help_menu');
    }, function () {
        $('.help_list').children('li').each(function () {
            $('.help_list').children('li').removeClass('active_help_menu');
        });
    });

    $('.in_cart_count').text('В корзине ' + $(".count_product").children('input').val() + ' шт.');

    $('.under_slider_right_box').hover(function () {


        $('.item_right_text').find('p').stop().animate({color: "#ffffff"}, 500);
        $('.item_right_text h1').stop().animate({color: "#ffffff"}, 500);
        $('.item_right_text_line').stop().animate({borderColor: "#fff"}, 500);

        $('.under_slider_right_box').find('.fre').stop().animate({'opacity': 1}, 1000);
        $(this).find('.circle_pic').animate({'opacity': 0}, 100);


    }, function () {
        $('.item_right_text p').stop().animate({color: "#6b6b6b"}, 500);
        $('.item_right_text h1').stop().animate({color: "#715254"}, 500);
        $('.item_right_text_line').stop().animate({borderColor: "#c3c9cc"}, 500);

        $('.under_slider_right_box').children('div').eq(0).stop().animate({'opacity': 0}, 1000);
        $(this).find('.circle_pic').animate({'opacity': 1}, 1000);

    })
    $('.under_slider_left_box').hover(function () {
        $('.item_left_text p').stop().animate({color: "#ffffff"}, 500);
        $('.item_left_text h1').stop().animate({color: "#ffffff"}, 500);
        $('.item_left_text_line').stop().animate({borderColor: "#fff"}, 500);
        $('.under_slider_left_box').children('.fre').stop().animate({'opacity': 1}, 1000);
        $(this).find('.circle_pic').animate({'opacity': 0}, 100);


    }, function () {

        $('.item_left_text p').stop().animate({color: "#6b6b6b"}, 500);
        $('.item_left_text h1').stop().animate({color: "#715254"}, 500);
        $('.item_left_text_line').stop().animate({borderColor: "#c3c9cc"}, 500);
        $('.under_slider_left_box').children('.fre').stop().animate({'opacity': 0}, 1000);
        $(this).find('.circle_pic').animate({'opacity': 1}, 1000);
    })

    initialItemCartPicture();


    var feedback_width = $('.feedback').width();
    $('.feedback').css('right', -feedback_width);
    $('.message_icon_wrap, .map_info_wrap').click(function () {
        var feedback_width = $('.feedback').width();
        showFeedback(feedback_width);

    })
    $('.close_feedback_cross').click(function () {
        var feedback_width = $('.feedback').width();
        showFeedback(feedback_width);
    });

    $('.tomorrow_button').click(function () {

        var date = new Date();
        Data = new Date();
        Year = Data.getFullYear();
        Month = Data.getMonth();
        Day = Data.getDate() + 1;

// Преобразуем месяца
        switch (Month) {
            case 0:
                fMonth = "января";
                break;
            case 1:
                fMonth = "февраля";
                break;
            case 2:
                fMonth = "марта";
                break;
            case 3:
                fMonth = "апреля";
                break;
            case 4:
                fMonth = "мая";
                break;
            case 5:
                fMonth = "июня";
                break;
            case 6:
                fMonth = "июля";
                break;
            case 7:
                fMonth = "августа";
                break;
            case 8:
                fMonth = "сентября";
                break;
            case 9:
                fMonth = "октября";
                break;
            case 10:
                fMonth = "ноября";
                break;
            case 11:
                fMonth = "декабря";
                break;
        }

// Вывод
        date = Day + " " + fMonth + " " + Year;
        $('.date_delivery').text(date);
        var now = new Date();



            $(this).addClass("tomorrow_button_active");
        $(".now_button").addClass("now_button_disabled");
    })
    $('.now_button').click(function () {
        var date = new Date();
        Data = new Date();
        Year = Data.getFullYear();
        Month = Data.getMonth();
        Day = Data.getDate();

// Преобразуем месяца
        switch (Month) {
            case 0:
                fMonth = "января";
                break;
            case 1:
                fMonth = "февраля";
                break;
            case 2:
                fMonth = "марта";
                break;
            case 3:
                fMonth = "апреля";
                break;
            case 4:
                fMonth = "мая";
                break;
            case 5:
                fMonth = "июня";
                break;
            case 6:
                fMonth = "июля";
                break;
            case 7:
                fMonth = "августа";
                break;
            case 8:
                fMonth = "сентября";
                break;
            case 9:
                fMonth = "октября";
                break;
            case 10:
                fMonth = "ноября";
                break;
            case 11:
                fMonth = "декабря";
                break;
        }

// Вывод
        date = Day + " " + fMonth + " " + Year;
        $('.date_delivery').text(date);



        $(this).removeClass("now_button_disabled");
        $(".tomorrow_button").removeClass("tomorrow_button_active");
    })

    $(document).on('click', ".order_count_increment", function () {

        var element = $(this).parent().children("input");
        element.val(parseInt(element.val()) + 1);
    });
    $(document).on('click', ".order_count_decrement", function () {

        var element = $(this).parent().children("input");
        if (parseInt(element.val()) > 0) {
            element.val(parseInt(element.val()) - 1);
        }
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }


    $(".button_continue").click(function () {
        //eere
        //var error = false;
        //
        //if ($('input[name = name_to ]').val() == "") {
        //
        //    $('input[name = name_to ]').addClass('error');
        //
        //    error = true;
        //
        //}
        //if ($('input[name = email_to ]').val() == "") {
        //    if (!IsEmail($('input[name = email_to ]'))) {
        //        $('input[name = email_to ]').addClass('error');
        //
        //        error = true;
        //    }
        //
        //    error = true;
        //
        //}
        //if ($('input[name = phone_to ]').val() == "") {
        //
        //    $('input[name = phone_to ]').addClass('error');
        //
        //    error = true;
        //
        //}
        //if ($('input[name = phone_from ]').val() == "") {
        //
        //    $('input[name = phone_from ]').addClass('error');
        //
        //    error = true;
        //
        //}
        //if ($('input[name = name_from ]').val() == "") {
        //
        //    $('input[name = name_from ]').addClass('error');
        //
        //    error = true;
        //
        //}
        //if ($('input[name = address_from ]').val() == "") {
        //
        //    $('input[name = address_from ]').addClass('error');
        //
        //    error = true;
        //
        //}
        //if ($('input[name = email_from ]').val() == "") {
        //    if (!IsEmail($('input[name = email_from ]'))) {
        //        $('input[name = email_from ]').addClass('error');
        //
        //        error = true;
        //    }
        //
        //    error = true;
        //
        //}
        //if (error) {
        //    $('html, body').animate({scrollTop: $('.cart1_left_contact_block').offset().top + 30}, 1000);
        //    return false;
        //}


        $('.tabs_list li').eq(0).removeClass('active');
        $('.tabs_list li').eq(1).addClass('active');
        $('.tab1').animate({opacity: 0}, 400, function () {
            $('.tab1').hide();

        });

        $('.tab2').show();
        // анимируем скроолинг к элементу scroll_el
        $('.tab2').animate({opacity: 1}, 400);
        $('.order_list_count_wrapper').css('opacity', '1');
        $('html, body').animate({scrollTop: $('.tabs_list').offset().top}, 1000);

        $('.delete_order').hide();
        $('.order_count_increment').hide();
        $('.order_count_decrement').hide();

        $('.order_count').attr('readonly', true);

    });

    $('.submit_button').click(function () {
        addOrder();
        $('.tabs_list li').eq(1).removeClass('active');
        $('.tabs_list li').eq(2).addClass('active');
        $('.tab2').animate({opacity: 0}, 400, function () {
            $('.tab2').hide();
        });
        $('.tab3').show();
        stop_animate = false;
        $('html, body').animate({scrollTop: $('.tabs_list').offset().top}, 1000, function () {
            stop_animate = true;
        });
        $('.tab3').animate({opacity: 1}, 400);
        /* $('.order_list_count_wrapper').css('opacity', '0');*/
    });

    $('.return_button').click(function () {
        $('.tabs_list li').eq(1).removeClass('active');
        $('.tabs_list li').eq(0).addClass('active');
        $('.tab2').animate({opacity: 0}, 400, function () {
            $('.tab2').hide();
        });
        $('.tab1').show();
        $('.order_list_count_wrapper').css('opacity', '1');
        $('html, body').animate({scrollTop: $('.tabs_list').offset().top}, 1000);
        $('.tab1').animate({opacity: 1}, 400);
        $('.delete_order').show();
        $('.order_count_increment').show();
        $('.order_count_decrement').show();
        $('.order_count').attr('readonly', false);

    });
    $(".add_input_phone").click(function () {
        var tel_input = $(this).parent().find('.cart1_phone_input').eq(0);
        var ind = $(".cart1_phone_input").length;
        $("<input type='text' id='" + ind + " ' name='telephone' class='cart1_phone_input' placeholder='Телефон (вместе с кодом)'> <div class='del_phone' id='" + ind + " '   onclick='delPhone(this)'>-</div>").insertAfter(tel_input);
    });


    $('.map_contact_icons').find('ul').find('li').find('img').hover(function () {
        var src = $(this).attr('class');
        var path;
        switch (src) {
            case 'h_facebook':
                path = '/images/eflora/h_facebook.png';
                break;
            case 'h_twitter':
                path = '/images/eflora/h_twitter.png';
                break;
            case 'h_vk':
                path = '/images/eflora/h_vk.png';
                break;
            case 'h_inst':
                path = '/images/eflora/h_inst.png';
                break;
            case 'h_gmail':
                path = '/images/eflora/h_gmail.png';
                break;
            case 'h_ri':
                path = '/images/eflora/h_rist.png';
                break;

        }
        $(this).attr('src', path);
    }, function () {
        var src = $(this).attr('class');
        var path;
        switch (src) {
            case 'h_facebook':
                path = '/images/eflora/map_facebook.png';
                break;
            case 'h_twitter':
                path = '/images/eflora/contact_twitter.png';
                break;
            case 'h_vk':
                path = '/images/eflora/contact_vk.png';
                break;
            case 'h_inst':
                path = '/images/eflora/contact_inst.png';
                break;
            case 'h_gmail':
                path = '/images/eflora/contact_gmail.png';
                break;
            case 'h_ri':
                path = '/images/eflora/contact_ri.png';
                break;

        }
        $(this).attr('src', path);
    });
    $('.upper_social_icons>p').hover(function () {

        var icon_type = $(this).attr('class');

        switch (icon_type) {
            case 'facebook':
                $(this).css('background-image', 'url(../../images/eflora/h_upper_facebook.png)');
                break;
            case 'twitter':
                $(this).css('background-image', 'url(../../images/eflora/h_upper_twitter.png) ');
                break;
            case 'vk':
                $(this).css('background-image', 'url(../../images/eflora/h_upper_vk.png)');
                break;
        }

    }, function () {
        var icon_type = $(this).attr('class');

        switch (icon_type) {
            case 'facebook':
                $(this).css('background-image', 'url(../../images/eflora/upper_facebook.png) ');
                break;
            case 'twitter':
                $(this).css('background-image', 'url(../../images/eflora/upper_twitter.png) ');
                break;
            case 'vk':
                $(this).css('background-image', 'url(../../images/eflora/upper_vk.png) ');
                break;
                $(this).css('background-size', 'auto 17px');
        }
    })
    $('#dollar').click(function () {
        $('.header_price_icon>.backet_circle>p').text("$");

        $('.order_list_describe hr').css('opacity', '0');
        $('#points').css('margin-left', '36px');
        $('.dollar_price').show();
        $('.dollar_price_1').show();
        $('.dollar_price_2').show();
        $('#unit_valuta').css('display', 'inline-block');

        $('#header_price_text_us').show();
        $('#header_price_text_br').hide();
        $('.old_price').hide();
        $('.old_price_1').hide();
        $('.new_price_2').hide();
        $('.new_price').hide();

        $('#order_list_price_old').hide();
        $('#order_list_price_new').hide();
        $('#order_list_price_dollar').show();
        $('#unit_valuta').show();
        $('.br1').hide();
        $('.br2').hide();

        var currency = 'us';
        localStorage['currency'] = JSON.stringify(currency);
    })

    $('#unit').click(function () {
        $('.header_price_icon>.backet_circle>p').text("Br");
        $('.order_list_describe hr').css('opacity', '1');
        $('#points').css('margin-left', '100px');
        $('.dollar_price').hide();
        $('.dollar_price_1').hide();
        $('.dollar_price_2').hide();
        $('#unit_valuta').css('display', 'none');
        $('#header_price_text_us').hide();
        $('#header_price_text_br').show();
        $('.old_price').show();
        $('.old_price_1').show();
        $('.new_price_2').show();
        $('.new_price').show();

        $('#order_list_price_old').show();
        $('#order_list_price_new').show();
        $('#order_list_price_dollar').hide();
        $('.br1').show();
        $('.br2').show();
        var currency = 'br';
        localStorage['currency'] = JSON.stringify(currency);
    });

    if ($('.header_price_icon>.backet_circle>p').text() == "$") {
        $('.order_list_describe hr').css('opacity', '1');
    }
    else {
        $('.order_list_describe hr').css('opacity', '1');
    }


    $('.header_price_icon').click(function () {

        if ($('.header_price_icon>.backet_circle>p').text() == "$") {
            $('.header_price_icon>.backet_circle>p').text("Br");
            $('#points').css('margin-left', '100px');
            $('#unit_valuta').css('display', 'none');
            $('.order_list_describe hr').css('opacity', '0');
            $('.dollar_price').hide();
            $('.dollar_price_1').hide();
            $('.dollar_price_2').hide();
            $('#header_price_text_us').hide();
            $('#header_price_text_br').show();
            $('.old_price_1').show();
            $('.new_price_2').show();
            $('.old_price').show();
            $('.new_price').show();

            $('#order_list_price_old').show();
            $('#order_list_price_new').show();
            $('#order_list_price_dollar').hide();
            $('.br1').show();
            $('.br2').show();
            var currency = 'br';
            localStorage['currency'] = JSON.stringify(currency);
            return;
        }
        if ($('.header_price_icon>.backet_circle>p').text() == "Br") {
            $('#points').css('margin-left', '36px');
            $('.header_price_icon>.backet_circle>p').text("$");
            $('#unit_valuta').css('display', 'inline-block');
            $('.order_list_describe hr').css('opacity', '1');

            $('.dollar_price_1').show();
            $('.dollar_price_2').show();
            $('.dollar_price').show();
            $('#header_price_text_us').show();
            $('#header_price_text_br').hide();
            $('.old_price_1').hide();
            $('.new_price_2').hide();
            $('.old_price').hide();
            $('.new_price').hide();


            $('#order_list_price_old').hide();
            $('#order_list_price_new').hide();
            $('#order_list_price_dollar').show();
            $('#unit_valuta').show();
            $('.br1').hide();
            $('.br2').hide();

            var currency = 'us';
            localStorage['currency'] = JSON.stringify(currency);
            return;
        }
    });
    function changeColorChoiceLink(choiceLink) {
        $('.choice_link').each(function () {
            $(this).css('color', '#898787');
            $(this).css('border-bottom', '1px dotted #898787');
        });
        $(choiceLink).css('color', '#ff8b4e');
        $(choiceLink).css('border-bottom', '1px dotted #ff8b4e');

    }

    $('.choice_link').eq(0).click(function () {

        changeColorChoiceLink(this);

        $(this).parent().find('.popular').show();
        $(this).parent().find('.price_link').hide();
        var atr = $(this).parent().find('.popular').attr('src');
        $('.price_link').attr('src', '');
        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }

        if (atr == '../../images/eflora/select_icon.png') {
            atr = '../../images/eflora/select_icon1.png';
            $(this).parent().find('.popular').attr('src', atr);

            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&popular=1&type=DESC" + "&price=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });
        }
        else {
            atr = '../../images/eflora/select_icon.png';
            $(this).parent().find('.popular').attr('src', atr);
            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&popular=1&type=ASC" + "&price=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });
        }


    })
    $('.choice_link').eq(1).click(function () {
        changeColorChoiceLink(this);

        $(this).parent().find('.popular').hide();
        $(this).parent().find('.price_link').show();
        var atr = $(this).parent().find('.price_link').attr('src');
        $('.popular').attr('src', '');
        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }

        if (atr == '../../images/eflora/select_icon.png') {
            atr = '../../images/eflora/select_icon1.png';
            $(this).parent().find('.price_link').attr('src', atr);

            /*****/

            //alert($('.slick-active a').attr('data-category'));
            //$("div").first()
            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&price=1&type=DESC" + "&popular=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });


            /****/
        }
        else {
            atr = '../../images/eflora/select_icon.png';
            $(this).parent().find(".price_link").attr('src', atr);


            /******/

            //alert($('.slick-active a').attr('data-category'));
            //$("div").first()
            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&price=1&type=ASC" + "&popular=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });


            /***/
        }
    })

    $('.choice_link').eq(2).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=9",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link').eq(3).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=15",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link').eq(4).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=30",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link').eq(5).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=50",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link').eq(6).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=100",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link').eq(7).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=200",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link_1').eq(0).click(function () {

        changeColorChoiceLink(this);

        $(this).parent().find('.popular').show();
        $(this).parent().find('.price_link').hide();
        var atr = $(this).parent().find('.popular').attr('src');
        $('.price_link').attr('src', '');
        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }

        if (atr == '../../images/eflora/select_icon.png') {
            atr = '../../images/eflora/select_icon1.png';
            $(this).parent().find('.popular').attr('src', atr);

            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&popular=1&type=DESC" + "&price=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });
        }
        else {
            atr = '../../images/eflora/select_icon.png';
            $(this).parent().find('.popular').attr('src', atr);
            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&popular=1&type=ASC" + "&price=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });
        }


    })
    $('.choice_link_1').eq(1).click(function () {
        changeColorChoiceLink(this);

        $(this).parent().find('.popular').hide();
        $(this).parent().find('.price_link').show();
        var atr = $(this).parent().find('.price_link').attr('src');
        $('.popular').attr('src', '');
        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }

        if (atr == '../../images/eflora/select_icon.png') {
            atr = '../../images/eflora/select_icon1.png';
            $(this).parent().find('.price_link').attr('src', atr);

            /*****/

            //alert($('.slick-active a').attr('data-category'));
            //$("div").first()
            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&price=1&type=DESC" + "&popular=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });


            /****/
        }
        else {
            atr = '../../images/eflora/select_icon.png';
            $(this).parent().find(".price_link").attr('src', atr);


            /******/

            //alert($('.slick-active a').attr('data-category'));
            //$("div").first()
            $.ajax({
                type: 'get',
                data: 'page=' + 1 + '&category=' + category + "&price=1&type=ASC" + "&popular=0",
                url: '/ajax-products',
                success: function (data) {
                    //document.write();
                    $('.flower_products').text('');
                    $('.flower_products').append(data);
                    changeCurrency();
                }
            });


            /***/
        }
    })

    $('.choice_link_1').eq(2).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=9",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link_1').eq(3).click(function () {
        changeColorChoiceLink(this);
        //alert('fsafs');
        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=15",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link_1').eq(4).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=30",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link_1').eq(5).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=50",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link_1').eq(6).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=100",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });
    $('.choice_link_1').eq(7).click(function () {
        changeColorChoiceLink(this);

        if ($('.slick-active a').attr('data-category')) {
            var category = $('.slick-active a').attr('data-category');
        }
        else {
            var category = $('.slick-active-catalog a').attr('data-category');
        }
        $.ajax({
            type: 'get',
            data: 'page=' + 1 + '&category=' + category + "&summa=200",
            url: '/ajax-products',
            success: function (data) {
                //document.write();
                $('.flower_products').text('');
                $('.flower_products').append(data);
                changeCurrency();
            }
        });
    });


});

function delPhone(element) {

    $(".del_phone").each(function (index) {

        if ($(element).attr('id') == $(this).attr('id')) {
            var ind = $(element).attr('id');
            console.log(ind);
            $(this).parent().find('.cart1_phone_input').each(function (index) {
                if (ind == $(this).attr('id')) {
                    $(this).remove();
                    element.remove();
                    return;
                }
            })
        }
    })


}

function helpmenuShow(left) {

    if ($('#sandwich').hasClass('active_menu')) {
        $('#sandwich').removeClass('active_menu');    ///// we hide menu

        $('#menu_selector').find('img').animate({opacity: 0}, 400, function () {
            $('#menu_selector').find('img').hide();
        });
        $('#sandwich').stop().animate({opacity: 1}, 800);

        $('.hidden_menu').stop().animate({left: '-720'}, 1000);
        if ($(window).width() + 17 > 1000) {
            $('#menu_selector').css('position', 'absolute');
            $('#menu_selector').css('left', '0');
            $('#menu_selector').css('top', '0px');
        }
    }
    else {
        $('#sandwich').addClass('active_menu');
        $('#menu_selector').find('img').show();
        $('#menu_selector').find('img').animate({opacity: 1}, 800);
        $('#sandwich').stop().animate({opacity: 0}, 400);
        $('.hidden_menu').show();
        $('.hidden_menu').stop().animate({left: left}, 1000);

        if ($(window).width() + 17 > 1000) {
            /// $('#menu_selector').css('position', 'fixed');
            //  $('#menu_selector').css('left', '365px');
            //   $('#menu_selector').css('top', '60px');
        }

    }
}
function questionmenuShow(left) {
    if ($("#question_icon").hasClass('active_menu')) {
        $("#question_icon").removeClass('active_menu');
        $("#question_icon").children('a').find('img').stop().animate({opacity: 1}, 800);
        $("#question_icon").children('img').animate({opacity: 0}, 400);
        $('.question_panel').stop().animate({left: '-1920px'}, 1000);
        /*$('#question_icon').css('position', 'absolute');
         $('#question_icon').css('left', '80px');*/

    }
    else {
        $("#question_icon").addClass('active_menu');
        $("#question_icon").children('a').find('img').stop().animate({opacity: 0}, 400);
        $("#question_icon").children('img').stop().animate({opacity: 1}, 800);
        $('.question_panel').stop().animate({left: left}, 1000);
        /*$('#question_icon').css('position', 'fixed');
         $('#question_icon').css('left', '445px');*/

    }
}

function showCirclePicture(elem) {

    var element = elem.parent();

    if ($(window).width() + 17 <= 1000) {
        if (!element.hasClass('visible')) {
            //element.css('overflow' , 'visible');
            element.css('border-radius', '0%');
            element.css('width', '100%');
            element.css('margin-left', '0px');
            element.addClass('visible');
            elem.css('margin-left', '0px');
            element.css('transition', '1s');

        }
        else {
            //element.css('overflow' , 'hidden');
            elem.css('margin-left', '-30px');
            element.css('width', '166px');
            element.css('margin-left', '40px');
            element.css('border-radius', '50%');
            element.removeClass('visible');
            element.css('transition', '0.7s');

        }


        return;
    }


    if (!element.hasClass('visible')) {
        //element.css('overflow' , 'visible');
        element.css('border-radius', '0%');
        element.css('width', '100%');
        element.css('margin-left', '0px');
        element.addClass('visible');
        elem.css('margin-left', '0px');
        element.css('transition', '1s');

    }
    else {
        //element.css('overflow' , 'hidden');
        elem.css('margin-left', '-100px');
        element.css('width', '166px');
        element.css('margin-left', '100px');
        element.css('border-radius', '50%');
        element.removeClass('visible');
        element.css('transition', '0.7s');

    }
}

function installHeight(element) {
    var windows_height = $(window).height();
    if (windows_height >= element.height()) {
        element.css('height', windows_height);
        return true;
    }
    else {
        element.css('height', windows_height);
        element.css('overflow-y', 'scroll');
    }


    return false;
}

function initialItemCartPicture() {
    $('.fre').css('height', '100%');
    var pic_width = $('.fre').width();
    var pic_height = $('.fre').height();
    $('.circle_pic').css('width', pic_width);
    $('.circle_pic').css('height', pic_height);

}
function initiallHeightContent() {
    if ($('.right_content').height() > $('.left_content').height()) {
        return true;
    }
    return false;
}
function showFeedback(feedback_width) {
    if ($('.feedback').hasClass('show')) {
        $('.feedback').animate({right: -feedback_width}, 1000, function () {
            $('.feedback').stop().hide();
        });
        $('.feedback').removeClass('show');
        /*$('.map_info_icon').css('z-index', '0');*/
        $('.message_icon_wrap').animate({'opacity': 1}, 1500);
        $('.map_info_wrap').animate({'opacity': 0}, 1500);
        $('.map_info_wrap').hide();


    }
    else {
        $('.feedback').show();
        $('.feedback').animate({right: "80px"}, 1000);
        $('.feedback').addClass('show');
        //$('.map_info_icon').css('z-index', '2');
        $('.message_icon_wrap').animate({'opacity': 0}, 1500);
        $('.map_info_wrap').animate({'opacity': 1}, 1500);
        $('.map_info_wrap').show();
    }
}
function enableKeyPress(el) {
    // Разрешаем нажатие клавиш backspace, Del, Tab и Esc
    var zero = $(el).val();
    if (zero[0] == "0") {
        zero = zero.replace(zero[0], '');
        $(el).val(zero);
    }
    if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
            // Разрешаем выделение: Ctrl+A
        (event.keyCode == 65 && event.ctrlKey === true) ||
            // Разрешаем клавиши навигации: Home, End, Left, Right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
        return;
    }
    else {
        // Запрещаем всё, кроме клавиш цифр на основной клавиатуре, а также Num-клавиатуре
        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
            event.preventDefault();
        }
    }
}
function search() {
    var searchText = $('#search').val();
    window.location.href = '/search/?query' + searchText;
}
function addOrder() {
    var data = {};
    data['name_to'] = $('input[name=name_to]').val();
    data['phone_to'] = $('input[name=phone_to]').val();
    data['country_to'] = $('span[name=country_to]').text();
    data['email_to'] = $('input[name=email_to]').val();

    data['name_from'] = $('input[name=name_from]').val();
    data['phone_from'] = $('input[name=phone_from]').val();
    data['country_from'] = $('span[name=country_from]').text();
    data['city_from'] = $('span[name=city_from]').text();
    data['address_from'] = $('input[name=address_from]').val();
    data['text_postcard'] = $('textarea[name=text_postcard]').val();
    data['comment_postcard'] = $('textarea[name=comment_postcard]').val();

    var methodPay = '';
    switch ($('input[name=radiog_dark]:checked').val()) {
        case '1':
            methodPay = 'Наличные деньги курьеру';
            break;
        case '2':
            methodPay = 'VISA/MasterCard/Белкарт';
            break;
        case '3':
            methodPay = 'Оплата наличными в одном из наших салонов';
            break;
        case '4':
            methodPay = 'WebMoney';
            break;
        case '5':
            methodPay = 'ЕРИП Расчёт';
            break;
        case '6':
            methodPay = 'Оплата по безналичному расчету на наш расчетный счет для юридических лиц';
            break;
        case '7':
            methodPay = 'Яндекс Деньги';
            break;
    }
    ;

    var shopArr = getBasketInfo();
    var shopProductCount = 0;
    var price_us = 0;
    var price_br = 0;
    var products = {};
    var i = 0;
    for (var key in shopArr) {
        products[i] = [shopArr[key]['id'], shopArr[key]['count']];
        i++;
    }

    $('#method_pay').text(methodPay);

    data['method_pay'] = methodPay;
    data['products'] = products;
    if (localStorage['currency']) {
        data['currency'] = JSON.parse(localStorage['currency']);
    }

    data['date_delivery'] = $('.date_delivery').text();

    $.ajax({
        type: 'post',
        data: 'data=' + JSON.stringify(data),
        url: '/ajax-create-order',
        success: function (data) {
            //alert(data);
            $('#thanks_for_order').html(data);
            localStorage.clear();
        }
    });
}