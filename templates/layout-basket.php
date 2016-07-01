<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 , user-scalable=no">
    <title><?= $this->title; ?></title>
    <meta name="description" content="<?= $this->description; ?>"/>
    <meta name="keywords" content="<?= $this->keywords; ?>"/>


    <link rel="stylesheet" type="text/css" href="/styles/css/cart_page/drop-down-style.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/css/cart_page/slider_style.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/css/main_style.css">
    <link rel="stylesheet" type="text/css" href="/styles/css/cart_page/cart_style.css">

    <link rel="stylesheet" type="text/css" href="/styles/css/cart_page/radio_button_style.css"/>

    <link rel="stylesheet" type="text/css" href="/javascript/eflora/jquery-ui-1.11.4/jquery-ui.css"/>

    <script> var kurs = <?=$this->kurs?></script>
    <!--	<script type="text/javascript" src="/javascript/eflora/modernizr.custom.79639.js"></script>-->
    <script src="/javascript/eflora/jquery-ui-1.11.4/external/jquery/jquery.js"></script>
    <script src="/javascript/eflora/jquery-ui-1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="/javascript/eflora/slick/slick.min.js"></script>
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

            var dd = new DropDown($('#dropDown'));
            var ddd = new DropDown($('#dropDown1'));
            var ddd = new DropDown($('#dropDown2'));
            $(document).click(function () {
                // all dropdowns
                $('.wrapper-dropdown-2').removeClass('active');
                $('.wrapper-dropdown-2.1').removeClass('active');
                $('.wrapper-dropdown-2.2').removeClass('active');
            });

        });

    </script>


    <script>

        $(function () {

            $("#datepicker").datepicker({
                onSelect: function (date) {
                    var date = $(this).val();

                    $('.date_delivery').text(date);
                },
                showWeek: false,
                showAnim: "fadeIn",
                minDate: "0",
                dateFormat: "d M yy"

            });


        });
    </script>
    <script src="/javascript/eflora/common.js"></script>
    <script src="/javascript/eflora/shop.js"></script>

</head>
<body>
<div id="container">

    <div id="header">
        <div id="logo">
            <a href="/" target="_blank"><img src="/images/eflora/main_logo.png"
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
                            <ul class="help_list">
                                <? $this->widget('MenuBlock', array('type' => 'help_menu', 'file' => 'help-menu', 'tree' => true)) ?>
                            </ul>
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

    <div class="clearfix" style="clear:both"></div>
    <div class="main_content">
        <div class="crt_left_main_content">
            <p class="your_order">Ваш заказ </p>
            <ul class="order_list">

            </ul>
            <div class="clearfix"></div>
            <div class="total_cost_c1">
                <p> ИТОГО</p>
                <div class="order_list_total_describe">
                    <sub class="br1">BR</sub>
                    <p class="order_list_price_old" id="order_list_price_old">
                    </p>
                    <hr>
                    <sub class="br2">BR</sub>
                    <p class="order_list_price_new" id="order_list_price_new">
                        <br>

                    </p>
                    <span id="unit_valuta">$</span>
                    <p class="order_list_price_dollar" id="order_list_price_dollar" style="display:none">

                        <br>

                    </p>
					<span> Стоимость доставки уточнит наш оператор<span>

                </div>

                <div class="clearfix"></div>
            </div>
            <div class="order_list_help_address">
                <p>
                    Пожалуйста, указывайте правильный адрес получателя. <br><br>

                    Не знаете адреса? Мы можем узнать сами, созвонившись с получателем.<br><br>

                    Ввиду цветочных традиций международные флористы с целью обеспечения доставки в назначенный день
                    могут заменить заказанные цветы на свежие цветы, которые есть в наличии. Это считается
                    нормой.<br><br>

                    В случае если Вы не указываете своего имени в поле Сообщение, получатель не сможет узнать, кто дарит
                    цветы.

                </p>
            </div>
        </div>
        <div class="crt_right_main_content">
            <ul class="tabs_list">
                <li class="active"> 1. Заполнение формы</a> </li>
                <li>2. Проверка заказа</a> </li>
                <li>3. Подтверждение заказа</a></li>
                <div class="clearfix"></div>
            </ul>
            <div class="clearfix"></div>
            <div class="tab1">
                <p> Добавить подарки и дополнительные услуги:</p>
                <? $this->widget('GiftBlock', array('file' => 'gift_list')) ?>
                <p> Дата доставки:</p>
                <div class="date_delivery_wrapp">
                    <?
                    switch (date('m')) {
                        case 0:
                            $fMonth = "января";
                            break;
                        case 1:
                            $fMonth = "февраля";
                            break;
                        case 2:
                            $fMonth = "марта";
                            break;
                        case 3:
                            $fMonth = "апреля";
                            break;
                        case 4:
                            $fMonth = "мая";
                            break;
                        case 5:
                            $fMonth = "июня";
                            break;
                        case 6:
                            $fMonth = "июля";
                            break;
                        case 7:
                            $fMonth = "августа";
                            break;
                        case 8:
                            $fMonth = "сентября";
                            break;
                        case 9:
                            $fMonth = "октября";
                            break;
                        case 10:
                            $fMonth = "ноября";
                            break;
                        case 11:
                            $fMonth = "декабря";
                            break;
                    }
                    ?>
                    <p class="date_delivery"> <?= date('d') . ' ' . $fMonth . ' ' . date('Y'); ?> </p>
                    <button class="now_button" name="now_button"><span>Сегодня</span></button>
                    <button class="tomorrow_button" name="now_button"><span>Завтра</span></button>
                    <div class="datepicker_wrapp">
                        <input type="submit" id="datepicker" value="Выбрать дату">
                        <p class="fake_datepicker_title">Выбрать дату</p>
                    </div>
                </div>
                <div class="cart1_contact_block">
                    <div class="cart1_left_contact_block">

                        <h1>Отправитель</h1>
                        <hr>
                        <input type="text" name="name_to" class="cart1_name_input" placeholder="Имя (псевдоним)">
                        <input type="text" name="phone_to" class="cart1_phone_input"
                               placeholder="Телефон (вместе с кодом)">
                        <!-- <input type="text" name="country" class="cart1_country_input" placeholder= "Страна"> -->
                        <div id="dropDown" class="wrapper-dropdown-2" tabindex="1"><span name="country_to">Беларусь</span>
                            <ul class="dropdown">
                                <li>Германия</li>
                                <li>Франция</li>
                                <li>Беларусь</li>
                            </ul>
                        </div>
                        <input type="email" name="email_to" class="cart1_email_input" placeholder="Электронная почта" required>
                        <!--						<div class="add_input_phone">-->
                        <!--							+-->
                        <!--						</div>-->


                    </div>
                    <div class="cart1_right_contact_block">
                        <div class="tab2_white_circle">
                        </div>
                        <h1>Получатель</h1>
                        <hr>
                        <input type="text" name="name_from" class="cart1_name_input" placeholder="Имя (псевдоним)">
                        <input type="text" name="phone_from" class="cart1_phone_input"
                               placeholder="Телефон (вместе с кодом)">
                        <div id="dropDown1" class="wrapper-dropdown-2" tabindex="1"><span
                                name="country_from">Беларусь	</span>
                            <ul class="dropdown">
                                <li>Германия</li>
                                <li>Франция</li>
                                <li>Беларусь</li>
                            </ul>
                        </div>
                        <div id="dropDown2" class="wrapper-dropdown-2" tabindex="1"><span name="city_from">Минск</span>
                            <ul class="dropdown">
                                <li>Вилейка</li>
                                <li>Молодечно</li>
                                <li>Минск</li>
                            </ul>
                        </div>
                        <input type="text" name="address_from" class="cart1_address_input" placeholder="Адрес">
                        <!--						<div class="add_input_phone">-->
                        <!--							+-->
                        <!--						</div>-->
                    </div>
                    <div class="clearfix"></div>


                </div>
                <div class="cart1_note_block">
                    <h1>Текст открытки</h1>
                    <hr>
                    <!-- <p> Текст открытки и ваш комментарий к заказу</p>
                    <input type="text" name="text_postcard" class="text_postcard">  -->

                    <textarea class="text_postcard" name="text_postcard" id="text_postcard" cols="30" rows="3"
                              placeholder="Текст открытки и ваш комментарий к заказу"></textarea>
                    <p class="interval">интервал времени для доставки, пожелания и т. д.</p>
                </div>
                <div class="cart1_comments">
                    <h1>Текст комментария</h1>
                    <hr>
                    <!-- <p> Текст открытки и ваш комментарий к заказу</p>
                    <input type="text" name="text_postcard" class="text_postcard">  -->

                    <textarea class="text_postcard" name="comment_postcard" id="comment_postcard" cols="30" rows="3" placeholder="Текст комментария"></textarea>
                    <p class="interval">коментраии, пожелания и т. д.</p>
                </div>
                <p> Способы оплаты </p>
                <div class="way_pay_wrapp">

                    <input type="radio" name="radiog_dark" id="radio1" value="1" class="css-checkbox"/>
                    <label for="radio1" class="css-label radGroup2">Наличные деньги курьеру</label><br>
                    <input type="radio" name="radiog_dark" id="radio2" value="2" class="css-checkbox"
                           checked="checked"/>
                    <label for="radio2" class="css-label radGroup2">VISA/MasterCard/Белкарт</label><br>
                    <input type="radio" name="radiog_dark" id="radio3" value=" 3" class="css-checkbox" />
                    <label for="radio3" class="css-label radGroup2">Оплата наличными в одном из наших
                        салонов</label><br>
                    <input type="radio" name="radiog_dark" id="radio4" value="4" class="css-checkbox"/>
                    <label for="radio4" class="css-label radGroup2">WebMoney</label><br>
                    <input type="radio" name="radiog_dark" id="radio5" value="5" class="css-checkbox"
                           checked="checked"/>
                    <label for="radio5" class="css-label radGroup2">ЕРИП Расчёт</label><br>
                    <input type="radio" name="radiog_dark" id="radio6" value="6" class="css-checkbox"/>
                    <label for="radio6" class="css-label radGroup7">Оплата по безналичному расчету на наш расчетный счет
                        для юридечиских лиц</label><br>
                    <input type="radio" name="radiog_dark" id="radio7" value="7" class="css-checkbox"/>
                    <label for="radio7" class="css-label radGroup2 last_label">Яндекс Деньги</label><br>
                    <button class="button_continue">ПРОДОЛЖИТЬ</button>
                </div>

            </div>
            <div class="tab2">
                <div class="date_delivery_tab2">
                    Дата доставки: <span>20 мая 2016</span>
                </div>
                <div class="tab2_contact_info">
                    <div class="tab2_contact_info_left">

                        <h1>Отправитель</h1>
                        <hr>
                        <p>Имя (псевдоним): <span id="name_to"></span></p>
                        <p>Телефон: <span id="phone_to"></span></p>
                        <p>Страна: <span id="country_to"></span></p>
                        <p>Электронная почта: <span id="email_to"></span></p>
                    </div>

                    <div class="tab2_contact_info_right">
                        <div class="tab2_white_circle">
                        </div>
                        <h1>Получатель</h1>
                        <hr>
                        <p>Имя (псевдоним): <span id="name_from"></span></p>
                        <p>Телефон: <span id="phone_from"></span></p>
                        <p>Страна: <span id="country_from"></span></p>
                        <p>Город: <span id="city_from"></span></p>
                        <p class="last_tab2_contact_info">Адрес: <span id="address_from"></span></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="tab2_text_note">
                    <h1>Текст открытки</h1>
                    <hr>
                    <p id="text_postcard">
                    </p>
                </div>
                <div class="tab2_text_note">
                    <h1>Текст комметария</h1>
                    <hr>
                    <p id="comment_postcard">
                    </p>
                </div>
                <div class="tab2_way_pay">
                    <img src="/images/eflora/way_pay.png" alt="">
                    <p> Способ оплаты: <br> <span id="method_pay">Наличные деньги курьеру</span></p>
                    <div class="clearfix"></div>
                </div>
                <div class="control_button_wrapp">
                    <button class="return_button">ИЗМЕНИТЬ</button>

                    <button class="submit_button" onclick="addOrder();">ПОДТВЕРДИТЬ</button>
                </div>
                <script>

                </script>
            </div>
            <div class="tab3">
                <div class="thanks_for_order">
                    <p> Спасибо что выбрали нашу службу.<br>
                        Ваш заказ #<span id="order_id"></span> получен </p>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
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
                    <p>Дизайн и разработка-</p>
                    <div class="logo_picture">
                    </div>
                </div>
            </div>
            <div class="up_button">
                <img class="" src="/images/eflora/up_button.png" alt="menu"/>
            </div>
        </div>
    </div>
</div>
</body>
</html>