<? $kurs = $this->kurs; ?>
<?
$imageMain = (isset($product->img['path'])) ? $product->img : '/images/no-photo.gif';
$imageUrl = image($imageMain['path'], 'resize', '440', false);
?>

<li>
    <? if ((((int)$product->discount) != 0)) { ?>
        <div class="discount">
            <p>-<?= $product->discount ?>%</p>
        </div>
    <? } ?>
    <img src="<?= $imageUrl ?>" alt="">
    <div class="order_list_describe">

        <p class="order_list_title"><a href=""><?= $product->name ?></a></p>
        <p class="order_list_price_old old_price"><sub class="price"> BR </sub> <?= (int)($product->price * $kurs / 1000) ?>
            <sup><?= (round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000)!=0) ? round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) :'000' ?></sup>
        </p>
        <hr>
        <p class="order_list_price_new new_price"><sub> BR </sub> <?= (int)($product->price * $kurs / 10000) ?>
            <sup><?= round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100) ?>
                коп.</sup>
        </p>
        <div class="dollar_price_cart dollar_price">
            <span class="um">$ </span>
            <?= (int)($product->price) ?>
            <div class="line"></div>
        </div>
    </div>
    <div class="order_list_count_wrapper">
        <div class="order_list_count_symbols">
            <div class="order_count_increment addtobasket" data-productid="<?= $product->id ?>"
                 data-productprice="<?= $product->price ?>"></div>
            <input id="count-<?= $product->id ?>" type="text" class="order_count" name="order_count" maxlength="3"
                   value="4">
            <div class="order_count_decrement addtobasket" data-productid="<?= $product->id ?>"
                 data-productprice="<?= $product->price ?>"></div>
        </div>
        <div class="delete_order" data-productid="<?= $product->id ?>"></div>
    </div>
    <div class="clearfix"></div>

</li>