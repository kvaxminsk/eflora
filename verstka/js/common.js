$(document).ready(function () {
    /// main js

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
        }
        else {
            $(this).find('.niceCheck').addClass("active");
            input.attr("checked", true);
        }
    })
    $('.cart1_item li').find('.niceCheck').click(function () {

        event.stopPropagation();
        var input = $(this).find('input').eq(0);
        if ($(this).hasClass('active')) {
            $(this).removeClass("active");
            input.attr("checked", false);
        }
        else {
            $(this).addClass("active");
            input.attr("checked", true);
        }
    });

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
            if ($(document).scrollTop() >= 80 && $('#question_icon').hasClass('active_menu')) {
                $('#question_icon').css('position', 'fixed');
                $('#question_icon').css('left', '445px');
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
            }
            if ($('.mob_list_wrapp').hasClass('show')) {

                $(".slick-dots").css('position', 'fixed');
                $(".slick-dots").css('z-index', '9999');
                $(".slick-dots").css('top', '239px');
                $('.slick-dots').css('padding-top', '0');
                $('.mobile_list').css('background-color', 'rgba(158, 77,105, 1)');
            }
        }


        if ($('.left_sidebar').length) {
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
        /*var rolheight = initiallHeightContent();
         var right_content= $('.right_main_content').width();

         if (!rolheight && window_type== "desctop"){
         if (($(window).scrollTop()+$(window).height()) >=
         ($('#header').offset().top + $('#header').height()+ $('.left_main_content').height())){
         $('.left_main_content').css('position' , 'fixed');
         $('.left_main_content').css('bottom' , '0');
         $('.left_main_content').css('left' , right_content);

         if ($(window).scrollTop()+$(window).height()  >= $(".footer").offset().top ){
         $(".left_main_content").css('position' , 'absolute');
         $('.left_main_content').css('top' , 'auto');
         $('.left_main_content').css('bottom' , '0');


         }
         }
         else{
         if ($('.left_main_content').offset().top <= $('#header').offset().top + $('#header').height()){
         $(".left_main_content").css('position' , 'relative');
         $('.left_main_content').css('left' , '0');
         }
         }


         }
         else{
         ///// here a code left content ( besouce right its a left damn )
         }*/

        /*if ($(window).width()+17>480 && $('.tabs_list').find('li').eq(2).attr('class') == 'active' && stop_animate ){
         if ( ($(window).scrollTop()+$(window).height() ) >( $('.crt_right_main_content' ).offset().top + 55 + $('.tab3').height()+130 ) ) {
         console.log('wind',$(window).scrollTop()+$(window).height());
         console.log('hhh', $('.crt_right_main_content' ).offset().top + 55 + $('.tab3').height() );
         $('.tab3').css('position', 'fixed');
         $('.tab3').css('width', 'calc(100% - 241px');
         $('.tab3').css('bottom', '0');
         if ( $('.tab3').offset().top + $('.tab3').height()+130 >= $('.footer').offset().top ){
         console.log('44');
         $('.tab3').css('position', 'relative');
         $('.tab3').css('bottom', '0');
         }
         }
         }  */


    });

    var time_out = false;


    if (window_type == 'tablet' || window_type == "mobile") {
        $('#sandwich').removeClass('active_menu');
        //$('#menu_selector').find('img').hide();


    }


    $('#sandwich').click(function showToogle() {

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

    $('.fade').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        arrows: false,

        cssEase: 'linear',
        customPaging: function (slick, index) {
            var title = "";
            var rb_title = "";
            var rb_description = "";


            switch (index) {
                case  0:
                    title = "Акции";
                    rb_title = "Королевские цветы";
                    rb_description = "У нас можно заказать доста635вку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case  1:
                    title = "Подарочные букеты";
                    rb_title = "Просто  цветы";
                    rb_description = "У нас можно заказать635466353 доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case  2:
                    title = "Букеты из роз";
                    rb_title = "Еще  цветы";
                    rb_description = "У нас можно заказать д665363оставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case  3:
                    title = "Корзины цветов";
                    rb_title = "Королевские цветы";
                    rb_description = "У нас можно заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case  4:
                    title = "Люкс-буеты";
                    rb_title = "Везде  цветы";
                    rb_description = "У нас можно заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case  5:
                    title = "Свадебные букеты";
                    rb_title = "Опять цветы";
                    rb_description = "У нас можно заказать  653 доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case  6:
                    title = "Экзотические букеты";
                    rb_title = "Надоели цветы";
                    rb_description = "У нас можно 5363 заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case  7:
                    title = "Горшечные растения";
                    rb_title = "Эх цветы";
                    rb_description = " 523 У нас можно заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case 8:
                    title = "Бизнес-букет";
                    rb_title = "дд цветы";
                    rb_description = "У нас можно  43522 заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case 9:
                    title = "8 марта";
                    rb_title = "5555 цветы";
                    rb_description = "У нас можно 345346542 заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case 10:
                    title = "День св. Валентина";
                    rb_title = "Упс цветы";
                    rb_description = "У нас можно 3453 заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case 11:
                    title = "Мягкие игрушки";
                    rb_title = "неее цветы";
                    rb_description = "У нас 3534 можно заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case 12:
                    title = "Подарки";
                    rb_title = "пав цветы";
                    rb_description = "У нас 3534 можно заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
                case 13:
                    title = "Ритуальные";
                    rb_title = "пав цветы";
                    rb_description = "У нас 66 можно заказать доставку роз! Только самые свежие цветы. Особое внимание обращают на себя букеты из 25 роз, 51 го отношения, а 101 роза не оставит равнодушным ни одного человека. Купить розы беспроигрышный вариант.";

                    break;
            }
            /*if ( index == 0 ) {
             return '<span class="reason_link"     data-title="'+rb_title+'"   data-description =  "'+rb_description+'"  > ' + title + '</span>';


             }else{*/
            return '<span class="reason_link"     data-title="' + rb_title + '  "  data-description  = "' + rb_description + '"  >' + title + '</span>';


            /*}*/

        }
    });
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


    $('.slick-dots').children('li').click(function () {
        var data = $(this).find('span').text();
        $('.left_box p ').eq(0).text(data);

        var title = $(this).find('span').attr('data-title');
        $('.right_box_title ').eq(0).text(title);

        var describe = $(this).find('span').attr('data-description');


        $('.rb_discribe ').eq(0).text(describe);


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
    $(".in_cart").click(function (e) {
        if ($(this).parent().parent().find('count_product').children('input').val() != '0') {
            $(this).find('p').text('В КОРЗИНЕ');
            $(this).addClass("style_in_cart");

        }

        e.preventDefault();

    });

    $(".increment").click(function () {
        var new_val = parseInt($(".count_product").children('input').val());
        var element = $(this).parent().children(".count_product").children("input");
        element.val(parseInt(element.val()) + 1);
        $('.in_cart_count').text('В корзине ' + element.val() + ' шт.');


        $(this).parent().parent().find($('.in_cart')).find('p').text('В КОРЗИНУ');
        $(this).parent().parent().find($('.in_cart')).removeClass("style_in_cart");

    });


    $(".decrement").click(function () {
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

    $('.delete_order').click(function () {
        $(this).parent().parent().addClass('delete');
        $(this).parent().parent().animate({height: '0'}, 300);

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

    $('.dropdown>li').click(function () {
        var val = $(this).text();
        if (val == "По цене:") {

            return
        }
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

        $('.under_slider_right_box').children('img').stop().animate({'opacity': 1}, 1000);
        $(this).find('.circle_pic').animate({'opacity': 0}, 100);


    }, function () {
        $('.item_right_text p').stop().animate({color: "#6b6b6b"}, 500);
        $('.item_right_text h1').stop().animate({color: "#715254"}, 500);
        $('.item_right_text_line').stop().animate({borderColor: "#c3c9cc"}, 500);

        $('.under_slider_right_box').children('img').stop().animate({'opacity': 0}, 1000);
        $(this).find('.circle_pic').animate({'opacity': 1}, 1000);

    })
    $('.under_slider_left_box').hover(function () {
        $('.item_left_text p').stop().animate({color: "#ffffff"}, 500);
        $('.item_left_text h1').stop().animate({color: "#ffffff"}, 500);
        $('.item_left_text_line').stop().animate({borderColor: "#fff"}, 500);
        $('.under_slider_left_box').children('img').stop().animate({'opacity': 1}, 1000);
        $(this).find('.circle_pic').animate({'opacity': 0}, 100);


    }, function () {

        $('.item_left_text p').stop().animate({color: "#6b6b6b"}, 500);
        $('.item_left_text h1').stop().animate({color: "#715254"}, 500);
        $('.item_left_text_line').stop().animate({borderColor: "#c3c9cc"}, 500);
        $('.under_slider_left_box').children('img').stop().animate({'opacity': 0}, 1000);
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

    $(".order_count_increment").click(function () {

        var element = $(this).parent().children("input");
        element.val(parseInt(element.val()) + 1);
    });
    $(".order_count_decrement").click(function () {

        var element = $(this).parent().children("input");
        if (parseInt(element.val()) > 0) {
            element.val(parseInt(element.val()) - 1);
        }
    });

    $(".button_continue").click(function () {

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
    });

    $('.submit_button').click(function () {
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
        $('.order_list_count_wrapper').css('opacity', '0');
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
                path = 'img/h_facebook.png';
                break;
            case 'h_twitter':
                path = 'img/h_twitter.png';
                break;
            case 'h_vk':
                path = 'img/h_vk.png';
                break;
            case 'h_inst':
                path = 'img/h_inst.png';
                break;
            case 'h_gmail':
                path = 'img/h_gmail.png';
                break;
            case 'h_ri':
                path = 'img/h_rist.png';
                break;

        }
        $(this).attr('src', path);
    }, function () {
        var src = $(this).attr('class');
        var path;
        switch (src) {
            case 'h_facebook':
                path = 'img/map_facebook.png';
                break;
            case 'h_twitter':
                path = 'img/contact_twitter.png';
                break;
            case 'h_vk':
                path = 'img/contact_vk.png';
                break;
            case 'h_inst':
                path = 'img/contact_inst.png';
                break;
            case 'h_gmail':
                path = 'img/contact_gmail.png';
                break;
            case 'h_ri':
                path = 'img/contact_ri.png';
                break;

        }
        $(this).attr('src', path);
    });
    $('.upper_social_icons>p').hover(function () {

        var icon_type = $(this).attr('class');

        switch (icon_type) {
            case 'facebook':
                $(this).css('background-image', 'url(img/h_upper_facebook.png)');
                break;
            case 'twitter':
                $(this).css('background-image', 'url(img/h_upper_twitter.png) ');
                break;
            case 'vk':
                $(this).css('background-image', 'url(img/h_upper_vk.png)');
                break;
        }

    }, function () {
        var icon_type = $(this).attr('class');

        switch (icon_type) {
            case 'facebook':
                $(this).css('background-image', 'url(img/upper_facebook.png) ');
                break;
            case 'twitter':
                $(this).css('background-image', 'url(img/upper_twitter.png) ');
                break;
            case 'vk':
                $(this).css('background-image', 'url(img/upper_vk.png) ');
                break;
                $(this).css('background-size', 'auto 17px');
        }
    })
    $('#dollar').click(function () {
        $('.header_price_icon>.backet_circle>p').text("$");
        $('#points').css('margin-left', '36px');
    })

    $('#unit').click(function () {
        $('.header_price_icon>.backet_circle>p').text("Br");
        $('#points').css('margin-left', '100px');
    });

    $('.header_price_icon').click(function () {

        if ($('.header_price_icon>.backet_circle>p').text() == "$") {
            $('.header_price_icon>.backet_circle>p').text("Br");
            $('#points').css('margin-left', '100px');
            return;
        }
        if ($('.header_price_icon>.backet_circle>p').text() == "Br") {
            $('#points').css('margin-left', '36px');
            $('.header_price_icon>.backet_circle>p').text("$");
            return;
        }
    });

    $('.choice_link').eq(0).click(function () {

        $(this).parent().find('img').show();
        var atr = $(this).parent().find('.popular').attr('src');

        if (atr == 'img/select_icon.png') {
            atr = 'img/select_icon1.png';
            $(this).parent().find('.popular').attr('src', atr);
        }
        else {
            atr = 'img/select_icon.png';
            $(this).parent().find('.popular').attr('src', atr);
        }


    })
    $('.choice_link').eq(1).click(function () {
        $(this).parent().find('.price_link').show();
        var atr = $(this).parent().find('.price_link').attr('src');

        if (atr == 'img/select_icon.png') {
            atr = 'img/select_icon1.png';
            $(this).parent().find('.price_link').attr('src', atr);
        }
        else {
            atr = 'img/select_icon.png';
            $(this).parent().find(".price_link").attr('src', atr);
        }
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
            $('#menu_selector').css('position', 'fixed');
            $('#menu_selector').css('left', '365px');
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
    $('.fre').css('width', '100%');
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
