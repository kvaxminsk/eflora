<? $kurs = $this->kurs; ?>
<?
$imageMain = (isset($product->img['path'])) ? $product->img : '/images/no-photo.gif';
$imageUrl = image($imageMain['path'], 'resize', '440', false);
?>
<?
if ($product->discount > 0) {
    $price_old_us = (int)($product->price);
    $price_old_br = (int)($product->price * $kurs / 10000);
    $price_old_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $product->price = round($product->price - $product->price*$product->discount/100);

    $price_new_discount_br_big = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($product->price * $kurs / 1000);
    $price_old_discount_br_kop =  (round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) != 0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $product->price;
}
else {
    $price_old_us = (int)($product->price);
    $price_old_br = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_big = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($product->price * $kurs / 1000);
    $price_old_discount_br_kop =  (round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) != 0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $product->price;
}
?>
<li data-productid="<?= $product->id ?>">
    <? if ((((int)$product->discount) != 0)) { ?>
        <div class="discount">
            <p>-<?= $product->discount ?>%</p>
        </div>
    <? } ?>
    <img src="<?= $imageUrl ?>" alt="">
    <div class="order_list_describe">
        <p class="order_list_title"><a href="<?= $product->url ?>"><?= $product->name ?></a></p>
<!--        <p class="order_list_price_old old_price"><sub class="price"> BYN </sub> --><?//= $price_old_discount_br_big ?>
<!--            <sup>--><?//= $price_old_discount_br_kop ?><!--</sup>-->
<!--        </p>-->
        <hr>
        <p class="order_list_price_new new_price"><sub> BYN </sub> <?= $price_new_discount_br_big ?>
            <sup><?= $price_new_discount_br_kop ?>
                коп.</sup>
        </p>
        <div class="dollar_price_cart dollar_price">
            <span class="um">$ </span>
            <?= $price_discount_us ?>
            <div class="line"></div>
        </div>
    </div>
    <div class="order_list_count_wrapper">
        <div class="order_list_count_symbols">
            <div class="order_count_increment addtobasket" data-productid="<?= $product->id ?>"
                 data-productprice="<?= $price_discount_us ?>"></div>
            <input id="count-<?= $product->id ?>" type="text" class="order_count" name="order_count" maxlength="3"
                   value="4">
            <div class="order_count_decrement addtobasket" data-productid="<?= $product->id ?>"
                 data-productprice="<?= $price_discount_us ?>"></div>
        </div>
        <div class="delete_order" data-productid="<?= $product->id ?>"></div>
    </div>
    <div class="clearfix"></div>

</li>