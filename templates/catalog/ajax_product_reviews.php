<? $kurs = 20100;?>
<?
$imageMain = (isset($product->img['path'])) ? $product->img : '/images/no-photo.gif';
$imageUrl = image($imageMain['path'], 'resize', '440', false);
?>



<ul class="flower_view">
    <li ><a href="<?=$product->url?>">
            <div class="product_wrap">
                <div class="flower">
                    <? if ((((int)$product->discount) != 0)){ ?>
                        <div class="discount">
                            <p>-<?=$product->discount?>%</p>
                        </div>
                    <? } ?>

                    <img class ="flower_pic"  src="<?=$imageUrl?>" alt="<?=$product->name?>"/>
                </div>
                <div class="old_price">
                    <span class="um">BR </span>
                    <?= (int)($product->price * $kurs / 1000) ?>
                    <div class = "line"></div>
                    <span class="zero_old_price"><?=  round (($product->price * $kurs / 1000 -  ((int)($product->price * $kurs / 1000))) *1000) ?></span>
                </div>
                <div class="new_price">
                    <span class="um">BR </span>
                    <?= (int)($product->price * $kurs / 10000) ?>
                    <span class="zero_old_price"><?= round (($product->price * $kurs / 10000 -  ( (int)($product->price * $kurs / 10000))) *100 ) ?>  коп.</span>
                </div>
                <div class="dollar_price" style="display:none">
                    <span class="um"> </span>
                    $
                    <?=$product->price?>
                </div>
                <div class="flower_discribe">
                    <p><?=$product->name?></p>
                </div>
            </div>
        </a>
    </li>