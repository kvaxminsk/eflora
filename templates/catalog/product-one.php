<?// var_dump($model->content);die();?>
<? $kurs =20100;?>
<div class="right_main_content">
    <div class="last_view">
        <p class="view_erlier"> <a href="">Вы просматривали</a></p>
        <div class= "view_erlier_cross">
            <a href="">+</a>
        </div>
        <div class="clearfix" style="clear:both"></div>
    </div>

    <ul class="flower_view">
        <li ><a href="">
                <div class="product_wrap">
                    <div class="flower">
                        <div class="discount">
                            <p>-15%</p>
                        </div>
                        <img class ="flower_pic"  src="/images/eflora/flower1.png" />
                    </div>
                    <div class="old_price">
                        <span class="um">BR </span>
                        116
                        <div class = "line"></div>
                        <span class="zero_old_price">000</span>
                    </div>
                    <div class="new_price">
                        <span class="um">BR </span>
                        11
                        <span class="zero_old_price">16 коп</span>
                    </div>
                    <div class="flower_discribe">
                        <p>asdfsadfasdf</p>
                    </div>
                </div>
            </a>


        </li>
        <li >
            <a href="">
                <div class="product_wrap">
                    <div class="flower">
                        <div class="discount">
                            <p>-15%</p>
                        </div>
                        <img class ="flower_pic"  src="/images/eflora/flower2.png" alt="menu" />
                    </div>
                    <div class="dollar_price">
                        <span class="um"> </span>
                        $
                        25
                    </div>

                    <!-- <div class="old_price">
                        <span class="um">BR </span>
                        116
                        <div class = "line"></div>
                        <span class="zero_old_price">000</span>
                    </div>
                    <div class="new_price">
                        <span class="um">BR </span>
                        11
                        <span class="zero_old_price">16 коп</span>
                    </div> -->
                    <div class="flower_discribe">
                        <p>«25 роз РБ.»</p>
                    </div>

                </div>

            </a>

        </li>
    </ul>
    <div class="search_area">
        <input type="text" placeholder="Поиск...">
        <div class="go_find"></div>
    </div>
    <div class="twitter_comment">
        <p> Твиты от <a href="">@eFlora.by</a></p>
        <div class="twitter_comment_block">
            here a twitter block
        </div>
    </div>

</div>
<div class="left_main_content">
    <p class="return_to_catalog"> <a href=""> <span>&lsaquo;</span>  Вернуться в каталог</a> </p>
    <div class="flower_slider">
        <div id ="reason_list">
            <? if($model->discount > 0) {?>
<!--                <div class="discount">-->
<!--                    <p>---><?//= $model->discount ?><!--%</p>-->
<!--                </div>-->
                <div class="discount_wrapp">
                    <div class="discount_symbol">
                        <img src="/images/eflora/discount_symbol.png" alt="">
                        <div class="discount_circle"></div>
                    </div>

                    <div class="discount_procent">
                        -<?= $model->discount ?>%
                    </div>
                </div>
            <?}?>



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
                    <p  class = "first_slide" style="background: url(<?=$imageUrl?>)  no-repeat;background-position:center; background-size: 75%"></p>
                </div>
                <? foreach($model->images as $i => $img): ?>
                    <?
//                    var_dump($img->photo['name']);continue;
                    $image = (isset($img->photo['path'])) ? $img->photo['path'] : '/images/no-photo.gif';
                    $image = image($image, 'resize', '440', false);
                    ?>
                    <div>
                        <p style="background: url(<?=$image?>)  no-repeat;background-size: 75%; background-position:center; "></p>
                    </div>
                <? endforeach; ?>
            </div>
            <div class="slider-nav">
                <div>
                    <p>  <img src="<?=$imageUrl?>" alt=""></p>
                </div>
                <? foreach($model->images as $i => $img): ?>
                    <?
//                    var_dump($img->photo['name']);continue;
                    $image = (isset($img->photo['path'])) ? $img->photo['path'] : '/images/no-photo.gif';
                    $image = image($image, 'resize', '440', false);
                    ?>
                    <div>
                        <p>  <img src="<?=$image?>" alt="<?=$img->photo['name']?>"></p>
                    </div>

                <? endforeach; ?>
            </div>
        </div>

    </div>
    <div class="right_slider">
        <div class="upper_social_icons_wrapp">
            <div class="upper_social_icons">
                <p class="facebook"><a href="">Я рекомендую</a></p>
                <p class="twitter"><a href="">Twitter</a></p>
                <p class="vk"><a href="">Сохранить</a></p>
                <div class="clearfix" style="clear:both"></div>
            </div>
            <div class="clearfix" style="clear:both"></div>
        </div>
        <p class="item_flower_title"><?= $model->name; ?></p>
        <p class="item_flower_describe">
            <?= $model->content; ?>
        </p>
        <!-- <div class="dollar_price_second">
                <span class="um"> </span>
                    $
                    25
                </div> -->
        <div class="item_price">

            <div class="old_price">
                <span class="um">BR </span>
                <?= (int)($model->price * $kurs / 1000) ?>
                <div class = "line"></div>
                <span class="zero_old_price"> <?=  round (($model->price * $kurs / 1000 -  ((int)($model->price * $kurs / 1000)) ) *1000) ?></span>
            </div>
            <div class="new_price">
                <span class="um">BR </span>
                <?= (int)($model->price * $kurs / 1000) ?>
                <span class="zero_old_price"><?= round (($model->price * $kurs / 1000 -  ((int)($model->price * $kurs / 1000)) ) *10) ?> коп</span>
            </div>
            <div class="dollar_price">
                <span class="um"> </span>
                $<?=$model->price?>
            </div>
            <div class="clearfix" style="clear:both"></div>
        </div>
        <div class="item_selector" >
            <div class="count_product_selector">
                <div class="decrement">-</div>
                <div class="count_product"><input id="count-<?=$model->id?>"  type="text" value="0" maxlength="4"> </div>
                <div class="increment">+</div>
            </div>
            <div class="in_cart_wrap">
                <a href="" class="in_cart addtobasket addtocart" data-productid="<?=$model->id?>" data-productprice="<?=$model->price?>">
                    <p> В КОРЗИНУ </p>
                </a>
            </div>
            <p class="in_cart_count" >В корзине  </p>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="item_under_slider">
        <div class="under_slider_left_box" >
            <img class="fre" src="/images/eflora/item-us-pic1.jpg">
            <div class="item_circle_left">

                <div class="item_under_slider_pic">
                    <img class="circle_pic" src="/images/eflora/item-us-pic1.jpg">
                </div>
                <img class="into_circle_icon" src="/images/eflora/icon2.png">
            </div>
            <div class="item_left_text" >
                <h1> Куда доставить?</h1>
                <p class="item_left_text_line"> </p>
                <p><?=$this->variables['item_where_delivery'];?></p>
            </div>
        </div>
        <div class="under_slider_right_box" >

            <img  class="fre"  src="/images/eflora/item_us_pic2.png">
            <div class="item_circle_right">
                <div class="item_under_slider_pic">
                    <img class="circle_pic" src="/images/eflora/item_us_pic2.png">

                </div>
                <img class="into_circle_icon" src="/images/eflora/into_circle_icon.png">
            </div>
            <div class="item_right_text" >
                <h1> Подарочки !</h1>
                <p class="item_right_text_line"> </p>
                <p><?=$this->variables['item_gift'];?></p>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
</div>
<div class="clearfix" style="clear:both"></div>
