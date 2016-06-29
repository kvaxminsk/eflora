<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->title; ?></title>
    <meta name="description" content="<?= $this->description; ?>"/>
    <meta name="keywords" content="<?= $this->keywords; ?>"/>


    <link rel="stylesheet" type="text/css" href="/styles/css/main_style.css"/>
    <link rel="stylesheet" type="text/css" href="/styles/css/404/404.css"/>
    <script> var kurs = <?=$this->kurs?></script>
    <script type="text/javascript" src="/javascript/eflora/jquery-1.12.3.js"></script>
    <!--	<script type="text/javascript" src="/javascript/eflora/slick_item/slick.min.js"></script>-->
    <script type="text/javascript" src="/javascript/eflora/slick/slick.min.js"></script>

    <script type="text/javascript" src="javascript/eflora/shop.js"></script>
    <script src="/javascript/eflora/common.js"></script>

    <link rel="stylesheet" type="text/css" href="/styles/css/slick/slick.css"/>

</head>
<body>
<div id="container">
    <div class="main_foto">
        <div class="not_found_logo">
            <img src="/images/eflora/white_logo.png" alt="">
            <p class="logo_describe"><?= $this->variables['header_slogan_rus'] ?></p>
            <h1><?= $this->variables['header_slogan_en'] ?></h1>
        </div>
        <div class="oops">
            <p> К сожалению, такой страницы не существует
                или она была удалена </p>
        </div>
        <button class="to_main" onclick="window.location.href = '/'">На главную</button>
        <div class="search_area">
            <form method="get"
                  action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'search')) ?>">
                <input type="text" name="query" value="<?= $_GET['query'] ?>" id="search" placeholder="Поиск...">
                <button  class="go_find"></button>
            </form>
        </div>


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
                    <p><a href="">Наши магазины</a></p>
                </div>

            </div>
        </div>
        <div class="footer_down_part">
            <div class="text_author">
                <p>&#169;2006-2016</p>
                <p> eFlora.by</p>
                <p id="t_author_3"> flowers delivery service</p>
            </div>
            <div class="social_icons">
                <div class="social_icons_wrap">
                    <ul>
                        <!--					<li><a href=""><img src="/images/eflora/facebook_icon.png" alt=""></a></li>-->
                        <!--					<li><a href=""><img src="/images/eflora/twitter_icon.png" alt=""></a></li>-->
                        <!--					<li><a href=""><img src="/images/eflora/vk_icon.png" alt=""></a></li>-->
                        <!--					<li><a href=""><img src="/images/eflora/instagram_icon.png" alt=""></a></li>-->
                        <!--					<li><a href=""><img src="/images/eflora/gmail_icon.png" alt=""></a></li>-->
                        <!--					<li><a href=""><img src="/images/eflora/R-icon.png" alt=	""></a></li>-->
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