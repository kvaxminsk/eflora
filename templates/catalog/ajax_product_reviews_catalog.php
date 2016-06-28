<? $kurs = $this->kurs; ?>
<? //
//$imageMain = (isset($product->img['path'])) ? $product->img : '/images/no-photo.gif';
//$imageUrl = image($imageMain['path'], 'resize', '440', false);
//?>


<li class="product">
    <div class="product_wrap">
        <div class="flower">

            <? if ($product->discount > 0) { ?>
                <div class="discount">
                    <p>-<?= $product->discount ?>%</p>
                </div>
            <? } ?>
            <a href="<?= $product->url ?>"><img class="flower_pic" src="<?= $product->img['medium'] ?>"
                                                alt="<?= $product->name ?>"/></a>
        </div>
        <div class="old_price">
            <span class="um">BR </span>
            <?= (int)($product->price * $kurs / 1000) ?>
            <div class="line"></div>
            <span
                class="zero_old_price"> <?= round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) ?></span>
        </div>
        <div class="new_price">
            <span class="um">BR </span>
            <?= (int)($product->price * $kurs / 10000) ?>
            <span
                class="zero_old_price"><?= round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100) ?>
                коп</span>
        </div>
        <div class="dollar_price">
            <span class="um"> $</span>
            <?= $product->price ?>
            <div class="line"></div>
        </div>
        <div class="flower_discribe">
            <p><?= $product->name ?></p>
        </div>
        <div class="count_product_selector">
            <div class="decrement">-</div>
            <div class="count_product"><input id="count-<?= $product->id ?>" type="text" value="0" maxlength="4"></div>
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