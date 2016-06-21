<? if (!empty($products)): ?>
	<ul>
		<? foreach($products as $i => $pr): ?>
			<? 
				$image = (isset($pr->img['path'])) ? $pr->img['path'] : '/admin/images/no-photo.gif'; 
				$image = image($image, 'resize', '30', '30');
			?>
			<li>
				<a href="<?=$pr['url']?>" title="<?=$pr->name?>"><img src="<?=$image?>" alt="<?=$pr->name?>" /></a>
				<a href="<?=$pr['url']?>" title="<?=$pr->name?>"><?=$pr->name?></a>
				<? if ($pr->price > 0): ?>
					<span>(Цена: <?=price($pr->price)?>)</span>
				<? endif ?>
			</li>
		<? endforeach ?>
    </ul>
<? endif ?>
<!-- ADD TO CARD BLOCK -->
<!--
<a 
	class="addtocart tc<?=$pr->id;?>" 
	href="#" rel="nofollow" 
	title="Купить" 
	show=".ic<?=$pr->id;?>" 
	hide=".tc<?=$pr->id;?>" 
	productprice="<?=$pr->price;?>" 
	productid="<?=$pr->id;?>" 
	<? if ((!empty($shop['ids'])) && in_array($pr->id, $shop['ids'])): ?>
		style="display: none;"
	<? endif; ?>
>
    <span>Купить</span>
</a>
                
<a 
	href="<? $this->widget('MaterialUrl', array('module' => 'shop', 'action' => 'index'));?>" 
	title="В корзине" 
	class="incart ic<?=$pr->id;?>" 
	<? if ((empty($shop['ids'])) || !in_array($pr->id, $shop['ids'])): ?>
		style="display: none;"
	<? endif; ?>
>
    <span>В корзине</span>
</a>
-->