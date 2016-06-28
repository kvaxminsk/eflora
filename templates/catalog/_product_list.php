<?
$image = (isset($data->img['path'])) ? $data->img['path'] : '/images/no-photo.gif';
$image = image($image, 'crop', '200', '200');
?>

<div class="block_product">
    <div class="img_product">
        <img src="<?= $image ?>" alt=""/>
        <p><?= price($data->price) ?></p>
    </div>
    <h1><a href="<?= $data->url ?>"><?= $data->name ?></a></h1>
    <? if (!empty($data['brand']['name'])): ?><p>Марка автомобиля: <span><?= $data['brand']['name'] ?></span>
        </p><? endif; ?>
    <? if (!empty($data->brand_model)): ?><p>Модель автомобиля: <span><?= $data->brand_model ?></span></p><? endif; ?>
    <? if (!empty($data->manufacturer)): ?><p>Объем двигателя: <span><?= $data->manufacturer ?></span></p><? endif; ?>
    <? if (!empty($data->original)): ?><p>Год выпуска: <span><?= $data->original ?></span></p><? endif; ?>
    <a data-productid="<?= $data->id ?>" data-productname="<?= $data->name ?>" data-productcount="1"
       data-proucturl="<?= $data->url ?>" data-productimg="<?= $image ?>" data-productprice="<?= $data->price ?>"
       class="addtocard addtobasket"><img src="/images/basket.png" alt=""/><span
            class="basketButtonText">В корзину</span></a>
</div>