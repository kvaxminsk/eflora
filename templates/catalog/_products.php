<? $kurs = 20100; ?>
<li class="product">
    <div class="product_wrap">
        <div class="flower">

            <? if ($data->discount > 0) { ?>
                <div class="discount">
                    <p>-<?= $data->discount ?>%</p>
                </div>
            <? } ?>
            <a href="<?= $data->url ?>"><img class="flower_pic" src="<?= $data->img['medium'] ?>"
                                             alt="<?= $data->name ?>"/></a>
        </div>
        <div class="old_price">
            <span class="um">BR </span>
            <?= (int)($data->price * $kurs / 1000) ?>
            <div class="line"></div>
            <span
                class="zero_old_price"> <?= round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) ?></span>
        </div>
        <div class="new_price">
            <span class="um">BR </span>
            <?= (int)($data->price * $kurs / 10000) ?>
            <span
                class="zero_old_price"><?= round(($data->price * $kurs / 10000 - ((int)($data->price * $kurs / 10000))) * 100) ?>
                коп</span>
        </div>
        <div class="dollar_price">
            <span class="um"> $</span>
            <?= $data->price ?>
            <div class="line"></div>
        </div>
        <div class="flower_discribe">
            <p><?= $data->name ?></p>
        </div>
        <div class="count_product_selector">
            <div class="decrement">-</div>
            <div class="count_product"><input id="count-<?= $data->id ?>" type="text" value="0" maxlength="4"></div>
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





