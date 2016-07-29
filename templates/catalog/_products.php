<? $kurs = $this->kurs; ?>

<?
if ($data->discount > 0) {
    $price_old_us = (int)($data->price);
    $price_old_br = (int)($data->price * $kurs / 10000);
    $price_old_br_kop = round(($data->price * $kurs / 10000 - ((int)($data->price * $kurs / 10000))) * 100);
    $data->price = round($data->price - $data->price*$data->discount/100);

    $price_new_discount_br_big = (int)($data->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($data->price * $kurs / 10000 - ((int)($data->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($data->price * $kurs / 1000);
    $price_old_discount_br_kop =  (round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) != 0) ? round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $data->price;
}
else {
    $price_old_us = (int)($data->price);
    $price_old_br = (int)($data->price * $kurs / 10000);
    $price_new_discount_br_big = (int)($data->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($data->price * $kurs / 10000 - ((int)($data->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($data->price * $kurs / 1000);
    $price_old_discount_br_kop =  (round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) != 0) ? round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $data->price;
}
?>
<li class="product">
    <div class="product_wrap">
        <div class="flower">

            <? if ($data->discount > 0) { ?>
                <div class="discount_upper_price new_price_2">
                    <div class="new_price_1">
                        <span class="um">BYN </span>
                        <?=$price_old_br?>
                        <div class="line"></div>
                        <span   class="zero_new_price_1"> <?=$price_old_br_kop?>
                            коп</span>
                    </div>
                </div>
                <div class="discount_upper_price dollar_price_2">
                    <div class="new_price_1">
                        <span class="um">$ </span>
                        <?= $price_old_us; ?>
                    </div>
                </div>
                <div class="discount">
                    <p>-<?= $data->discount ?>%</p>
                </div>
            <? } ?>
            <a href="<?= $data->url ?>"><img class="flower_pic" src="<?= $data->img['medium'] ?>"
                                             alt="<?= $data->name ?>"/></a>
        </div>
<!--        <div class="old_price">-->
<!--            <span class="um">BYN </span>-->
<!--            --><?//=$price_old_discount_br_big  ?>
<!--            <div class="line"></div>-->
<!--            <span-->
<!--                class="zero_old_price"> --><?//= $price_old_discount_br_kop;//(round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) != 0) ? round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) : '000' ?><!--</span>-->
<!--        </div>-->
        <div class="new_price">
            <span class="um">BYN </span>
            <?= $price_new_discount_br_big ?>
            <span
                class="zero_old_price"><?= $price_new_discount_br_kop//round(($data->price * $kurs / 10000 - ((int)($data->price * $kurs / 10000))) * 100) ?>
                коп</span>
        </div>
        <div class="dollar_price">
            <span class="um">$ </span>
            <?= $price_discount_us ?>
            <div class="line"></div>
        </div>
        <div class="flower_discribe">
            <p><?= $data->name ?></p>
        </div>
        <div class="count_product_selector">
            <div class="decrement">-</div>
            <div class="count_product"><input id="count-<?= $data->id ?>" type="text" value="1" maxlength="4"></div>
            <div class="increment">+</div>
        </div>
        <div class="in_cart_wrap">
            <a href="" class="in_cart addtobasket addtocart" data-productid="<?= $data->id ?>"
               data-productprice="<?= $data->price ?>">
                <p> В КОРЗИНУ </p></a>
        </div>
        <div class="hover_description">
            <?= $data->content ?>
        </div>
    </div>
</li>





