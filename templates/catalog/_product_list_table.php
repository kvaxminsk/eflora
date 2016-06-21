<? 
	$image = (isset($data->img['path'])) ? $data->img['path'] : '/images/no-photo.gif';
	$image = image($image, 'crop', '200', '200');
?>

<div class="block_product2">
	<div class="block_img2">
		<img src="<?=$image?>" alt="" />
		<p><?=price($data->price)?></p>
	</div>
	<div class="text_product2">
		<h3><a href="<?=$data->url?>"><?=$data->name?></a></h3>
		<p class="price2"><?=price($data->price)?></span></p>
		<a href="" class="basket2"><img src="/images/basket2.png" alt=""/></a>
		<a data-productid="<?=$data->id?>" data-productname="<?=$data->name?>" data-productcount="1" data-proucturl="<?=$data->url?>" data-productimg="<?=$image?>" data-productprice="<?=$data->price?>" class="basket_product addtobasket"><img src="/images/basket.png" alt=""/><span class="basketButtonText">В корзину</span></a>
	</div>
</div>