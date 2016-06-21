<!DOCTYPE html>
<html>
<head>
    <title><?=$this->title;?></title>
    <meta name="description" content="<?=$this->description;?>"/>
    <meta name="keywords" content="<?=$this->keywords;?>"/>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="/styles/reset.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/main.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/fonts.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/slider.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/style-demo.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/jquery.formstyler.css"/>

    <script src="/javascript/jquery-2.1.4.min.js"></script>
    <script src="/javascript/shop.js"></script>
    <script src="/javascript/jquery.jcarousellite.min.js"></script>
    <script src="/javascript/jquery.easing-1.3.js"></script>
    <script type="text/javascript">
        $(function() {
            $(".widget .carousel").jCarouselLite({
                btnNext: ".widget .next",
                btnPrev: ".widget .prev",
                speed: 800,
                easing: "easeOutBack"
            });
            $(".widget img").click(function() {
                $(".widget .mid img").attr("src", $(this).attr("src"));
            });
        });
    </script>
    <script src="/javascript/jquery.formstyler.min.js"></script>
    <script src="/javascript/script.js"></script>
</head>
<body>
<div class="wrap wrap_header">
    <div class="green"></div>
    <div class="content header">
        <div><img src="/images/phone.png"/><span><?=$this->variables['phone']?></span></div>
        <div><img src="/images/mts.png"/><span><?=$this->variables['phone_mts']?></span></div>
        <div><img src="/images/vel.png"/><span><?=$this->variables['phone_velcom']?></span></div>
        <div><img src="/images/clock.png"/><span><?=$this->variables['work_time']?></span></div>
        <div class="basket"><img src="/images/basket.png"/> <snan class="baskettext">Корзина пуста</snan></div>
    </div>
</div>

<div class="wrap wrap_logo">
    <div class="content content_logo">
        <div class="logo"><a href="<?=mainPageLink()?>"><p>GLUSHITELY</p></a></div>
        <div class="text"><p><?=$this->variables['slogan']?></p></div>
        <div class="repair">
            <a href="">
                <img src="/images/bgdetail.jpg" alt=""/>
                <div><p>Ремонт глушителей</p></div>
                <span>ПОДРОБНЕЕ >></span>
            </a>
        </div>
    </div>
</div>

<div class="wrap wrap_menu">
    <div class="content content_menu">
        <div class="menu">
            <? $this->widget('MenuBlock', array('type' => 'main', 'file' => 'main', 'tree' => true)) ?>
        </div>
        <form method="get" action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'search')) ?>">
            <input type="search" name="query" placeholder="Поиск"/>
            <input type="button" />
        </form>
    </div>
</div>
<?=$content?>
<div class="wrap wrap_footer">
    <div class="content content_footer">
        <table>
            <tr>
                <td>
                    <p>&copy; 2014 «Глушители». Все права защищены</p>
                    <div style="text-align:left;">
                        <a href=""><img src="/images/vk.jpg" /></a>
                        <a href=""><img src="/images/twitter.jpg" /></a>
                        <a href=""><img src="/images/facebook.jpg" /></a>
                    </div>
                </td>
                <td>
                    <div>
                        <a href=""><img src="/images/home.png" /></a>
                        <a href=""><img src="/images/konvert.png" /></a>
                        <a href=""><img src="/images/search2.png" /></a>
                    </div>
                </td>
                <td>
                    <a href=""><span>Дизайн и разработка</span><em> - </em><img src="/images/reactive.png" /></a>
                    <p>«Реактивные технологии»</p>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="fon"></div>
<form name="shopPost" method="post" action="<? $this->widget('MaterialUrl', array('module' => 'shop', 'action' => 'index')) ?>">
    <div class="ordering ">
        <div class="formShop">
            <img class="close_mod closeSecondShopModal" src="/images/close_mod.png" alt="" />
            <h1>оформление заказа</h1>
            <div>
                <input type="text" name="data[order][user_name]" value="" placeholder="Ваше имя*" required />
                <input type="email" name="data[order][user_email]" value="" placeholder="Электронная почта*" required />
                <input type="phone" name="data[order][user_phone]" value="" placeholder="Контактный телефон*" required />
                <label>
                    <input type="radio" name="data[order][user_come]" value="Доставка" /><span>Доставка</span>
                </label>
                <label>
                    <input type="radio" name="data[order][user_come]" value="Самовывоз" /><span>Самовывоз</span>
                </label><br>
                <a href="/dostavka">Условия доставки</a>
                <a href="/samovyvoz">Пункты самовывоза</a>
                <input type="text" name="data[order][user_city]" value="" placeholder="Город доставки" />
                <input type="text" name="data[order][user_address]" value="" placeholder="Адрес доставки" />
            </div>
            <textarea name="data[order][user_comment]" placeholder="Ваше комментарий к заказу"></textarea>
            <label>Предпочитаемое время заказа:<br>
                <select name="data[order][user_time_s]">
                    <option value="8:00">8:00</option>
                </select>
                <span style="margin:0 10px;">-</span>
                <select name="data[order][user_time_e]">
                    <option value="14:00">14:00</option>
                </select>
            </label>
            <div class="button">
                <button type="button" class="closeSecondShopModal">НАЗАД</button>
                <button type="submit">ОФОРМИТЬ</button>
            </div>
        </div>
    </div>

    <div class="shopping_basket">
        <img class="close_mod closeFirsShopModal" src="/images/close_mod.png" alt="" />
        <h1>корзина покупок</h1>
        <div class="table_shopping">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr class="shopTableHead">
                    <th>Наименование</th>
                    <th>Кол-во</th>
                    <th>Цена, руб</th>
                    <th>Сумма, руб</th>
                    <th></th>
                </tr>
            </table>
        </div>
        <div class="total">
            <p>Количество единиц: <span class="countMainProduct"></span></p>
            <p>Итого: <span class="priceMainProduct">0</span></p>
        </div>
        <div class="button">
            <button type="button" class="openSecondShopModal">ПРОДОЛЖИТЬ</button>
        </div>
    </div>
</form>

</body>
</html>