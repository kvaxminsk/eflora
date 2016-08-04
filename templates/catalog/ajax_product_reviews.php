<? $kurs = $this->kurs; ?>
<?
$imageMain = (isset($product->img['path'])) ? $product->img : '/images/no-photo.gif';
$imageUrl = image($imageMain['path'], 'resize', '440', false);
?>
<?
if ($product->discount > 0) {
    $product->price;
    $price_old_us = (int)($product->price);
    $price_old_br = (int)($product->price * $kurs / 10000);
    $price_old_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $product->price = round($product->price - $product->price * $product->discount / 100);

    $price_new_discount_br_big = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $price_new_discount_br_kop = ($price_new_discount_br_kop != 0) ? $price_new_discount_br_kop : '00';
    $price_old_discount_br_big = (int)($product->price * $kurs / 1000);
    $price_old_discount_br_kop = (round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) != 0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $product->price;
} else {
    $price_old_us = (int)($product->price);
    $price_old_br = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_big = (int)($product->price * $kurs / 10000);
    $price_new_discount_br_kop = round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100);
    $price_new_discount_br_kop = ($price_new_discount_br_kop != 0) ? $price_new_discount_br_kop : '00';
    $price_old_discount_br_big = (int)($product->price * $kurs / 1000);
    $price_old_discount_br_kop = (round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) != 0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) : '000';
    $price_discount_us = $product->price;
}
?>

<ul class="flower_view">
    <li><a href="<?= $product->url ?>">
            <div class="product_wrap">
                <div class="flower">
                    <? if ((((int)$product->discount) != 0)) { ?>
                        <div class="discount_upper_price new_price_2">
                            <div class="new_price_1">
                                <span class="um">BYN </span>
                                <?= $price_old_br ?>

                        <span   class="zero_new_price_1"> <?=$price_old_br_kop ?>
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

                    <img class="flower_pic" src="<?= $imageUrl ?>" alt="<?= $product->name ?>"/>
                </div>
<!--                <div class="old_price">-->
<!--                    <span class="um">BYN </span>-->
<!--                    --><?//= $price_old_discount_br_big ?>
<!--                    <div class="line"></div>-->
<!--                    <span-->
<!--                        class="zero_old_price">--><?//= $price_old_discount_br_kop//(round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000)!=0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) :'000' ?><!--</span>-->
<!--                </div>-->
                <div class="new_price">
                    <span class="um">BYN </span>
                    <?= $price_new_discount_br_big ?>
                    <span
                        class="zero_old_price"><?= $price_new_discount_br_kop//round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100) ?>
                        коп.</span>
                </div>
                <div class="dollar_price" style="display:none">
                    <span class="um"> </span>
                    $
                    <?= $price_discount_us ?>
                </div>
                <div class="flower_discribe">
                    <p><?= $product->name ?></p>
                </div>
            </div>
        </a>
    </li>