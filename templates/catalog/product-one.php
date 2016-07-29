<? // var_dump($model->content);die();?>
<? $kurs = $this->kurs; ?>
<script>
    renderBlockReviews();
    if (localStorage['reviews']) {
        var reviewsArr = JSON.parse(localStorage['reviews']);
        if (reviewsArr.indexOf(<?=$model->id?>) == -1) {
            reviewsArr.push(<?=$model->id?>);
            localStorage['reviews'] = JSON.stringify(reviewsArr);
        }

    }
    else {
        var reviewsArr = [];
        reviewsArr.push(<?=$model->id?>);
        localStorage['reviews'] = JSON.stringify(reviewsArr);
    }

</script>
<?
if ($model->discount > 0) {
    $price_old_us = (int)($model->price);
    $price_old_br = (int)($model->price * $kurs / 10000);
    $price_old_br_kop = round(($model->price * $kurs / 10000 - ((int)($model->price * $kurs / 10000))) * 100);
    $model->price = round($model->price - $model->price * $model->discount / 100);

    $price_new_discount_br_big = (int)($model->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($model->price * $kurs / 10000 - ((int)($model->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($model->price * $kurs / 1000);
    $price_old_discount_br_kop = (round(($model->price * $kurs / 1000 - ((int)($model->price * $kurs / 1000))) * 1000) != 0) ? round(($model->price * $kurs / 1000 - ((int)($model->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $model->price;
} else {
    $price_old_us = (int)($model->price);
    $price_old_br = (int)($model->price * $kurs / 10000);
    $price_new_discount_br_big = (int)($model->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($model->price * $kurs / 10000 - ((int)($model->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($model->price * $kurs / 1000);
    $price_old_discount_br_kop = (round(($model->price * $kurs / 1000 - ((int)($model->price * $kurs / 1000))) * 1000) != 0) ? round(($model->price * $kurs / 1000 - ((int)($model->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $model->price;
}
?>
<div class="right_main_content">
    <div class="last_view">
        <p class="view_erlier"><a
                href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'reviews')) ?>">Вы
                просматривали</a></p>
        <div class="view_erlier_cross">
            <a href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'reviews')) ?>">+</a>
        </div>
        <div class="clearfix" style="clear:both"></div>
    </div>
    <ul class="flower_view reviews_product">

    </ul>

    <div class="search_area">
        <form method="get"
              action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'search')) ?>">
            <input type="text" name="query" value="<?= $_GET['query'] ?>" id="search" placeholder="Поиск...">
            <button class="go_find"></button>
        </form>
    </div>
    <div class="twitter_comment">
        <p> Твиты от <a href="">@eFlora.by</a></p>
        <div class="twitter_comment_block">
            <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true"
                    class="twitter-timeline twitter-timeline-rendered"
                    style="position: static; visibility: visible; display: inline-block; width: 520px; height: 350px; padding: 0px; border: none; max-width: 100%; min-width: 180px; margin-top: 0px; margin-bottom: 0px; min-height: 200px;"
                    data-widget-id="275273175225483264" title="Twitter Timeline"></iframe>
            <script>!function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");</script>
        </div>
    </div>

</div>
<div class="left_main_content">
    <p class="return_to_catalog"><a href="<?= $urlCategory ?>"> Вернуться в каталог</a></p>
    <div class="flower_slider">
        <div id="reason_list">
            <? if ($model->discount > 0) { ?>
                <div class="discount_wrapp">
                    <div class="discount_symbol">
                        <img src="/images/eflora/discount_symbol.png" alt="">
                        <div class="discount_circle"></div>
                    </div>

                    <div class="discount_procent">
                        -<?= $model->discount ?>%
                    </div>
                </div>

            <? } ?>



            <?
            //            var_dump(isset($model->img));
            //            die();
            $imageMain = (isset($model->img['path'])) ? $model->img : '/images/no-photo.gif';
            //            var_dump($imageMain);
            //            die();
            $imageUrl = image($imageMain['path'], 'resize', '440', false);
            //            $imageUrl =$imageMain;
            ?>
            <div class="slider-for">
                <div>
                    <p class="first_slide"
                       style="background: url(<?= $imageUrl ?>)  no-repeat;background-position:center; background-size: 75%"></p>
                </div>
                <? foreach ($model->images as $i => $img): ?>
                    <?
//                    var_dump($img->photo['name']);continue;
                    $image = (isset($img->photo['path'])) ? $img->photo['path'] : '/images/no-photo.gif';
                    $image = image($image, 'resize', '440', false);
                    ?>
                    <div>
                        <p style="background: url(<?= $image ?>)  no-repeat;background-size: 75%; background-position:center; "></p>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="slider-nav">
                <div>
                    <p><img src="<?= $imageUrl ?>" alt=""></p>
                </div>
                <? foreach ($model->images as $i => $img): ?>
                    <?
//                    var_dump($img->photo['name']);continue;
                    $image = (isset($img->photo['path'])) ? $img->photo['path'] : '/images/no-photo.gif';
                    $image = image($image, 'resize', '440', false);
                    ?>
                    <div>
                        <p><img src="<?= $image ?>" alt="<?= $img->photo['name'] ?>"></p>
                    </div>

                <? endforeach; ?>
            </div>
        </div>

    </div>
    <div class="right_slider">
        <div class="upper_social_icons_wrapp">

            <div class="upper_social_icons">
                <p class="facebook"><a href="#">Я рекомендую</a>


                </p>

                <!-- <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>-->
                <p class="twitter"><a href="https://twitter.com/share"">Twitter</a>
                    <!--<a href="https://twitter.com/share" class="twitter-share-button" data-via="eFloraby" data-related="eFloraby">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>-->
                </p>
                <p class="vk"><!-- Put this script tag to the <head> of your page -->
                    <script type="text/javascript" src="http://vk.com/js/api/share.js?93"
                            charset="windows-1251"></script>

                    <!-- Put this script tag to the place, where the Share button will be -->
                    <script type="text/javascript"><!--
                        document.write(VK.Share.button(false, {type: "custom", text: "Сохранить"}));
                        --></script>
                </p>
                <!-- Put this script tag to the <head> of your page -->

                <div class="clearfix" style="clear:both"></div>
            </div>
            <div class="clearfix" style="clear:both"></div>
        </div>
        <p class="item_flower_title"><?= $model->name; ?></p>
        <div class="item_flower_describe">
            <?= $model->content; ?>
        </div>
        <!-- <div class="dollar_price_second">
                <span class="um"> </span>
                    $
                    25
                </div> -->

        <!--        <div class="discount_upper_price_dollar">-->
        <!--             <div class="old_discount_price">-->
        <!--                <div class="price_wrapp">-->
        <!--                    <span class="um_discount">$</span>-->
        <!--                    12344-->
        <!--                    <span class="kop">70 коп </span>-->
        <!--                </div>-->
        <!---->
        <!--            </div>-->
        <!--        </div>-->


        <div class="item_price">
            <? if ($model->discount > 0) { ?>
                <div class="discount_upper_price_2 new_price_2">
                    <div class="new_price_1">
                        <span class="um">BYN </span>
                        <?= $price_old_br ?>

                        <span
                            class="zero_new_price_1"> <?= $price_old_br_kop// round(($model->price * $kurs / 10000 - ((int)($model->price * $kurs / 10000))) * 100)  ?>
                            коп</span>
                    </div>
                </div>
                <div class="discount_upper_price dollar_price_2">
                    <div class="new_price_1">
                        <span class="um">$ </span>
                        <?= $price_old_us; ?>
                    </div>
                </div>
            <? } ?>
<!--            <div class="old_price">-->
<!--                <span class="um">BYN </span>-->
<!--                --><?//= $price_old_discount_br_big ?>
<!--                <div class="line"></div>-->
<!--                <span-->
<!--                    class="zero_old_price"> --><?//= $price_old_discount_br_kop// (round(($model->price * $kurs / 1000 - ((int)($model->price * $kurs / 1000))) * 1000)!=0) ? round(($model->price * $kurs / 1000 - ((int)($model->price * $kurs / 1000))) * 1000) :'000'  ?><!--</span>-->
<!--            </div>-->

            <div class="new_price">
                <span class="um">BYN </span>
                <?= $price_new_discount_br_big ?>
                <span
                    class="zero_old_price"><?= $price_new_discount_br_kop// round(($model->price * $kurs / 10000 - ((int)($model->price * $kurs / 10000))) * 100)  ?>
                    коп</span>
            </div>
            <div class="dollar_price">
                <span class="um"> </span>
                $ <?= $price_discount_us ?>
            </div>
            <div class="clearfix" style="clear:both"></div>
        </div>
        <div class="item_selector">
            <div class="count_product_selector">
                <div class="decrement">-</div>
                <div class="count_product"><input id="count-<?= $model->id ?>" type="text" value="1" maxlength="4">
                </div>
                <div class="increment">+</div>
            </div>
            <div class="in_cart_wrap">
                <a href="" class="in_cart addtobasket addtocart" data-productid="<?= $model->id ?>"
                   data-productprice="<?= $model->price ?>">
                    <p> В КОРЗИНУ </p>
                </a>
            </div>
            <p class="in_cart_count">В корзине </p>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="item_under_slider">
        <div class="under_slider_left_box">
            <!-- <img class="fre" src="/images/eflora/item-us-pic1.jpg">-->
            <div class="fre"></div>
            <div class="item_circle_left">

                <div class="item_under_slider_pic">
                    <img class="circle_pic" src="/images/eflora/item-us-pic1.jpg">
                </div>
                <img class="into_circle_icon" src="/images/eflora/icon2.png">
            </div>
            <div class="item_left_text">
                <h1> Куда доставить?</h1>
                <p class="item_left_text_line"></p>
                <p><?= $this->variables['item_where_delivery']; ?></p>
            </div>
        </div>
        <div class="under_slider_right_box">

            <div class="fre"></div>
            <div class="item_circle_right">
                <div class="item_under_slider_pic">
                    <img class="circle_pic" src="/images/eflora/item_us_pic2.png">

                </div>
                <img class="into_circle_icon" src="/images/eflora/into_circle_icon.png">
            </div>
            <div class="item_right_text">
                <h1> Подарочки !</h1>
                <p class="item_right_text_line"></p>
                <p><?= $this->variables['item_gift']; ?></p>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
<div class="clearfix" style="clear:both"></div>
<script type="text/javascript">(function() {
        if (window.pluso)if (typeof window.pluso.start == "function") return;
        if (window.ifpluso==undefined) { window.ifpluso = 1;
            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
            s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
            var h=d[g]('body')[0];
            h.appendChild(s);
        }})();</script>
<div class="pluso" data-background="#ebebeb" data-options="big,square,multiline,vertical,nocounter,theme=04" data-services="facebook"></div>
<script>
    $('.facebook a').click(function(){
       $('.pluso-facebook').click();
    });
</script>