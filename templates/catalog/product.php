<? $kurs = $this->kurs; ?>
<li class="product">
    <div class="product_wrap">
        <div class="flower">

            <? if ($data->discount > 0) { ?>
                <div class="discount">
                    <p>-<?= $data->discount ?>%</p>
                </div>
            <? } ?>
            <img class="flower_pic" src="<?= $data->img['medium'] ?>" alt="<?= $data->name ?>"/>
        </div>
<!--        <div class="old_price">-->
<!--            <span class="um">BYN </span>-->
<!--            --><?//= (int)($data->price * $kurs / 1000) ?>
<!--            <div class="line"></div>-->
<!--            <span-->
<!--                class="zero_old_price"> --><?//= (round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000)!=0) ? round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 1000) :'000' ?><!--</span>-->
<!--        </div>-->
        <div class="new_price">
            <span class="um">BYN </span>
            <?= (int)($data->price * $kurs / 1000) ?>
            <span
                class="zero_old_price"><?= round(($data->price * $kurs / 1000 - ((int)($data->price * $kurs / 1000))) * 10) ?>
                коп</span>
        </div>
        <div class="dollar_price">
            <span class="um"> </span>
            $<?= $data->price ?>
        </div>
        <div class="flower_discribe">
            <p><?= $data->name ?></p>
        </div>
        <div class="count_product_selector">
            <div class="decrement">-</div>
            <div class="count_product"><input type="text" value="1" maxlength="4"></div>
            <div class="increment">+</div>
        </div>
        <div class="in_cart_wrap">
            <a href="" class="in_cart"><p> В КОРЗИНУ </p></a>
        </div>
        <div class="hover_description">
            <?= $data->content ?>
        </div>
    </div>
</li>



			
			
			