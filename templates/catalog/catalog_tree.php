<? foreach($categories as $item): ?>
	<? if (!empty($item['children'])): ?>
		<li class="click_list_categ <? if ($item['url_current']):?>active_list_categ<? endif; ?>">
			<a href="<?=$item['url']?>" style="text-transform: uppercase;"><?=$item['name']?></a>
			<div class="list_arrow"></div>
			<ul>
				<? foreach ($item['children'] as $item2): ?>
					<li><a href="<?=$item2['url']?>"><?=$item2['name']?></a></li>
				<? endforeach; ?>
			</ul>
		</li>
	<? else: ?>
		<li>
			<a href="<?=$item['url']?>"><?=$item['name']?></a>          
		</li>
	<? endif; ?>
<? endforeach; ?>