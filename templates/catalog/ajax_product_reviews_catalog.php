<? $kurs = $this->kurs; ?>
<? //
//$imageMain = (isset($product->img['path'])) ? $product->img : '/images/no-photo.gif';
//$imageUrl = image($imageMain['path'], 'resize', '440', false);
//?>
<?
if ($product->discount > 0) {
    $product->price;
    $price_old_us = (int)($product->price);
    $price_old_br = (int)($product->price * $kurs / 10000);
    $price_old_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $product->price = round($product->price - $product->price * $product->discount / 100);

    $price_new_discount_br_big = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($product->price * $kurs / 1000);
    $price_old_discount_br_kop = (round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) != 0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $product->price;
} else {
    $price_old_us = (int)($product->price );
    $price_old_br = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_big = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $price_old_discount_br_big = (int)($product->price * $kurs / 1000);
    $price_old_discount_br_kop = (round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) != 0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $product->price;
}
?>

<li class="product">
    <div class="product_wrap">
        <div class="flower">

            <? if ($product->discount > 0) { ?>
                <div class="discount_upper_price new_price_2">
                    <div class="new_price_1">
                        <span class="um">BR </span>
                        <?= $price_old_br ?>
                        <div class="line"></div>
                        <span   class="zero_new_price_1"> <?= $price_old_br_kop//round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100) ?>
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
                    <p>-<?= $product->discount ?>%</p>
                </div>

            <? } ?>
            <a href="<?= $product->url ?>"><img class="flower_pic" src="<?= $product->img['medium'] ?>"
                                                alt="<?= $product->name ?>"/></a>
        </div>
        <div class="old_price">
            <span class="um">BR </span>
            <?= $price_old_discount_br_big//(int)($product->price * $kurs / 1000) ?>
            <div class="line"></div>
            <span
                class="zero_old_price"> <?= $price_new_discount_br_kop//(round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000)!=0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) :'000' ?></span>
        </div>
        <div class="new_price">
            <span class="um">BR </span>
            <?= $price_new_discount_br_big ?>
            <span
                class="zero_old_price"><?= $price_new_discount_br_kop//round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100) ?>
                коп</span>
        </div>
        <div class="dollar_price">
            <span class="um"> $</span>
            <?= $price_discount_us ?>
            <div class="line"></div>
        </div>
        <div class="flower_discribe">
            <p><?= $product->name ?></p>
        </div>
        <div class="count_product_selector">
            <div class="decrement">-</div>
            <div class="count_product"><input id="count-<?= $product->id ?>" type="text" value="1" maxlength="4"></div>
            <div class="increment">+</div>
        </div>
        <div class="in_cart_wrap">
            <a href="" class="in_cart addtobasket addtocart" data-productid="<?= $product->id ?>"
               data-productprice="<?= $product->price ?>">
                <p> В КОРЗИНУ </p></a>
        </div>
        <div class="hover_description">
            <?= $product->content ?>
        </div>
    </div>
</li>