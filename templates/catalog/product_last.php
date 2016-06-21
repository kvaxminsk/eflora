<? if (!empty($products)): ?>
<div class="recommendations">
 	<h1>Рекомендуем ознакомиться</h1>
	<? foreach($products as $i => $pr): ?>
		<? 
			$image = (isset($pr->img['path'])) ? $pr->img['path'] : '/admin/images/no-photo.gif'; 
			$image = image($image, 'crop', '200', '200');
		?>
		<div class="block_recommendations">
			<div>
				<div class="innerImgBlock"><img src="<?=$image?>" alt="<?=$pr->name?>" /></div>
				<p><?=price($pr->price)?></p>
			</div>
			<h6><a href="<?=$pr->url?>"><?=$pr->name?></a></h6>
		</div>
	<? endforeach ?>
</div>
<? endif ?>