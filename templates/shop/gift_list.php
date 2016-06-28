<ul class="cart1_item">

    <? $i = 0;
    $kurs = 20100;
    foreach ($products as $product): ?>
        <!--	--><? // var_dump($item); ?>
        <?
        $image = ($product['img']['path']) ? $product['img']['path'] : '/images/no-photo.gif';
        $image = image($image, 'resize', '1500', '986');
        ?>
        <li>
            <img src="<?= $image ?>" alt="">
		<span class="niceCheck" data-productid="<?= $product->id ?>" data-productprice="<?= $product->price ?>">
			<input type="checkbox" name="cart1_checkbox" class="cart1_checkbox" value="<?= $product->id ?>"/>
		</span>
            <div class="cart1_name"><?= $product->name ?></div>
            <!--		--><? //var_dump((int)($product->price * $kurs / 1000));die();?>


            <div class="cart1_item_old_price old_price">
                <span> BR </span> <?= (int)($product->price * $kurs / 1000) ?>
                <sup><?= round(($product->price * $kurs / 1000 - ((int)($product->price * $kurs / 1000))) * 1000) ?></sup>
                <hr>
            </div>

            <div class="cart1_item_new_price new_price">
                <span> BR </span> <?= (int)($product->price * $kurs / 10000) ?>
                <sup><?= round(($product->price * $kurs / 10000 - ((int)($product->price * $kurs / 10000))) * 100) ?>
                    коп</sup>
            </div>
            <!--	<div class="old_price_cart">
                    <span class="um">$ </span>
                    25
                    <div class="line"> </div>
                </div>-->
            <!---->
            <div class="dollar_price_cart2 dollar_price">
                <span class="um"> $</span>
                <?= $product->price ?>
                <div class="line"></div>
            </div>

        </li>
    <? endforeach; ?>
</ul>