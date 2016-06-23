<div class="catalog_list_wrapper">
	<div class="catalog_list">
		<ul>
			<? $i=0;
			foreach($categories as $item): ?>
				<li><a href="<?=$item['url'];?>" data-category="<?=$item['id']?>"><?=$item['name']?></a></li>
			<? endforeach; ?>
		</ul>
	</div>
</div>


