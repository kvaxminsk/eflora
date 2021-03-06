<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->title; ?></title>
    <meta name="description" content="<?= $this->description; ?>"/>
    <meta name="keywords" content="<?= $this->keywords; ?>"/>
    <script> var kurs = <?=$this->kurs?></script>
    <link rel="stylesheet" type="text/css" href="/styles/css/main_style.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/css/text_page/text_page.css"/>

    <script type="text/javascript" src="/javascript/eflora/jquery-1.12.3.js"></script>
    <script type="text/javascript" src="/javascript/eflora/slick/slick.min.js"></script>


    <script type="text/javascript" src="/javascript/eflora/common.js"></script>
    <script type="text/javascript" src="/javascript/eflora/shop.js"></script>


    <link rel="stylesheet" type="text/css" href="/styles/css/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/css/catalog_page/catalog.css"/>

    <!--	/*********************/-->
<!--    <link rel="stylesheet" type="text/css" href="/styles/css/contact_page/contact_page.css"/>-->
    <script type="text/javascript" src="/javascript/eflora/slick_item/slick.min.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <!--	<script type="text/javascript" charset="utf-8" src="https://api-maps.yandex.ru/1.1/_YMaps.js?v=1.1.21-58"></script>-->
    <script type="text/javascript">
        //		var geocoder = new YMaps.Geocoder(<?//=$this->variables['address']?>//);
        ////		map.addOverlay(geocoder);
        //		alert(geocoder.precision);


        ymaps.ready(function () {
            var myMap = new ymaps.Map('map', {
                    center: [53.866202, 27.670114],
                    zoom: 14,
                    controls: ["zoomControl"]

                }, {
                    searchControlProvider: 'yandex#search'
                }),

                myPlacemark = new ymaps.Placemark(
                    [53.87093016878826, 27.64616492821899], {
                        hintContent: false,
                        balloonContent: false
                    }, {
                        iconLayout: 'default#image',
                        iconImageHref: '/images/eflora/icon_for_map.png',
                        iconImageSize: [135, 150],
                        iconImageOffset: [-60, -70]
                    });

            if ($(window).width() <= 1000) {

                myMap.behaviors.disable('scrollZoom');
                myMap.behaviors.disable('scroll');

            }

            myMap.geoObjects.add(myPlacemark);

        });
    </script>
    <!--	/*************/-->
    <script type="text/javascript">

        function DropDown(el) {
            this.dd = el;
            this.initEvents();
        }
        DropDown.prototype = {
            initEvents: function () {
                var obj = this;

                obj.dd.on('click', function (event) {
                    $(this).toggleClass('active');
                    event.stopPropagation();
                });
            }
        }

        $(function () {
            var dd1 = new DropDown($('#criterion_filter'));
            var dd = new DropDown($('#theme_filter'));

            $(document).click(function () {
                // all dropdowns
                $('.wrapper-dropdown-5').removeClass('active');
            });

        });

    </script>

</head>
<body>
<div id="container">
    <div id="header">
        <div id="logo">
            <a href="/"><img src="/images/eflora/main_logo.png"
                                                                alt="Тут должен быть логотип" class="logo_pic"></a>

            <p id="logo_text">
                Belarus flowers delivery service
            </p>
        </div>
        <div class="column_list">
            <ul class="list">
                <li id="first_column">
                    <div class="menu">
                        <div id="menu_selector">
                            <div id='sandwich' class="active_menu">
                                <div class='sw-topper'></div>
                                <div class='sw-bottom'></div>
                                <div class='sw-footer'></div>
                            </div>
                            <img src="/images/eflora/main_cross.png">
                        </div>
                        <div class="hidden_menu show">
                            <div class="catalog_logo_pic">

                            </div>
                            <div class="menu_panel_close">
                                <img src="/images/eflora/main_cross.png">
                            </div>
                            <div class="hidden_menu_title">
                                Меню
                            </div>
                            <? $this->widget('MenuBlock', array('type' => 'main', 'file' => 'main', 'tree' => true)) ?>

                            <!--							<ul class="hidden_menu_list">-->
                            <!--								<li><a href="#">Главная</a></li>-->
                            <!--								<li><a href="#">Как заказать цветы?</a></li>-->
                            <!--								<li><a href="#">Наши цветочные магазины</a></li>-->
                            <!--								<li><a href="#">Контакт</a></li>-->
                            <!--								<li><a href="#">События и стат</a></li>-->
                            <!--								<li><a href="#">Обратная связь</a></li>-->
                            <!--							</ul>-->
                        </div>
                    </div>

                    <div class="help_menu">
                        <div id="question_icon">
                            <img src="/images/eflora/main_cross.png">
                            <a href="#"><img class="pic_position" src="/images/eflora/question_icon.png" alt="menu"/>
                            </a>

                        </div>
                        <div class="question_panel">
                            <div class="catalog_logo_pic">

                            </div>
                            <div class="help_panel_close">
                                <img src="/images/eflora/main_cross.png">
                            </div>
                            <div class="hidden_menu_title">
                                Помощь
                            </div>
                            <? $this->widget('MenuBlock', array('type' => 'help_menu', 'file' => 'help-menu', 'tree' => true)) ?>
                        </div>
                    </div>
                    <div class="phone_number">
                        <div class="phone">
                            <p class="first_phone">
                                <a href="tel:<?= strip_tags($this->variables['phone']); ?>"><?= $this->variables['phone'] ?> </a>
                            <div id="triangle"></div>
                            </p>
                        </div>
                        <div class="description">
                            <p id="first_description"><?= $this->variables['header_slogan_rus']; ?></p>
                        </div>
                        <p id="logo_text_mobile">
                            <?= $this->variables['header_slogan_en']; ?>
                        </p>
                    </div>
                </li>
                <li id="second_column">
                    <div class="second_column_number">
                        <div class="phone1">
                            <p class="second_phone">
                                <a href="tel:<?= strip_tags($this->variables['phone_mts']); ?>"><?= $this->variables['phone_mts'] ?> </a>
                            </p>
                        </div>
                        <div class="description">
                            <p id="second_description"><?= $this->variables['header_time_work'] ?></p>
                        </div>
                    </div>
                </li>
                <li id="third_column">
                    <div class="third_column_number">
                        <div class="phone1">
                            <p class="third_phone">
                                <a href="tel:<?= strip_tags($this->variables['phone_velcom']); ?>"><?= $this->variables['phone_velcom'] ?> </a>
                            </p>
                        </div>
                        <div class="description">
                            <p id="third_description"><?= $this->variables['header_time_delivery'] ?></p>
                        </div>
                    </div>
                </li>
            </ul>
            <div id="backet_wrap">
                <div id="header_price">
                    <p id="header_price_text_br" class="header_price_text">0</p>
                    <p id="header_price_text_us" class="header_price_text" style="display:none">0</p>
                </div>
                <div id="header_backet">
                    <a href="/korzina"><img class="backet_pic" src="/images/eflora/header_backet.png" alt="menu"/>
                        <div class="backet_circle"><p class="baskettext shop-count">0</p></div>
                    </a>
                </div>
                <div id="header_price_symbol">
                    <p id="symbol">Цены в <span id="dollar">$</span> <span id="delimeter">/</span> <span
                            id="unit">Br</span>
                    <p id="points" style="margin-left: 100px;"> ..... </p>
                </div>
                <div class="header_price_icon">
                    <img src="/images/eflora/header_price.png" alt="">
                    <div class="backet_circle"><p>$</p></div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="clearfix" style="clear:both"></div>

<div class="main_content">
    <div class="cp_left_main_content">
        <? $this->widget('CatalogCategoryBlock', array('file' => 'catalog_internal_tree')) ?>

    </div>
    <?= $content; ?>

</div>
<div class="footer">
    <div class="footer_logo">
        <div class="footer_logo_describe">
            <p><?= $this->variables['header_slogan_rus'] ?></p>
        </div>
    </div>
    <div class="footer_contact_info">
        <div class="first_contact_column">
            <div class="col1_wrapp">
                <div class="phone_icon">
                </div>
                <div class="phones">
                    <p class="fotter_phone">
                        <a href="tel:<?= strip_tags($this->variables['phone']) ?>">     <?= $this->variables['phone'] ?> </a>
                    </p>
                    <p class="fotter_phone">
                        <a href="tel:<?= strip_tags($this->variables['phone_mts']) ?>">     <?= $this->variables['phone_mts'] ?> </a>
                    </p>
                    <p class="fotter_phone">
                        <a href="tel:<?= strip_tags($this->variables['phone_velcom']) ?>">     <?= $this->variables['phone_velcom'] ?> </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="second_contact_column">
            <div class="col2_wrapp">
                <div class="adress_icon">
                </div>
                <div class="adress_info">
                    <p id="our_adress">Наш адрес:</p>
                    <p>
                        <?= $this->variables['address'] ?> <?= $this->variables['time_work'] ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="third_contact_column">
            <div class="col3_wrapp">
                <div class="shop_icon">
                </div>
                <p><a href="/shops">Наши магазины </a></p>
            </div>

        </div>
    </div>
    <div class="footer_down_part">
        <div class="text_author">
            <p>&#169;2006-<?= Date('Y'); ?></p>
            <p> eFlora.by</p>
            <p id="t_author_3"> flowers delivery service</p>
        </div>
        <div class="social_icons">
            <div class="social_icons_wrap">
                <ul>
                    <li><a href="<?= $this->variables['social_fb'] ?>"><img src="/images/eflora/facebook_icon.png"
                                                                            alt=""></a></li>
                    <li><a href="<?= $this->variables['social_tw'] ?>"><img src="/images/eflora/twitter_icon.png"
                                                                            alt=""></a></li>
                    <li><a href="<?= $this->variables['social_vk'] ?>"><img src="/images/eflora/vk_icon.png" alt=""></a>
                    </li>
                    <li><a href="<?= $this->variables['social_in'] ?>"><img src="/images/eflora/instagram_icon.png"
                                                                            alt=""></a></li>
                    <li><a href="<?= $this->variables['social_google'] ?>"><img src="/images/eflora/gmail_icon.png"
                                                                                alt=""></a></li>
                    <li><a href="<?= $this->variables['social_pinterest'] ?>"><img src="/images/eflora/R-icon.png"
                                                                                   alt=""></a></li>
                </ul>
            </div>
        </div>
        <div class="reactive_logo">
            <div class="reactive_logo_wrap">
                <a href="http://reactive.by" nofollow="">
                <p>Дизайн и разработка-</p>
                <div class="logo_picture">
                </div></a>
            </div>
        </div>
        <div class="up_button">
            <img class="" src="/images/eflora/up_button.png" alt="menu"/>
        </div>
    </div>
    <div class="footer_img_address"></div>
</div>
</div>

</body>
</html>