<? if(!empty($buttons)): ?>                
	<ul class="pagination">
		<? if(!$buttons['prev']['hidden']): ?>
			<a href="<?=$buttons['prev']['url'];?>"><li>&laquo;</li></a>
		<? endif; ?>

		<? foreach ($buttons['pages'] as $num => $val):?>
			<? if($val['selected']):?>
				<li class="active"><?=$num;?></li>
			<? else: ?> 
				<a href="<?=$val['url'];?>"><li><?=$num;?></li></a>
			<? endif; ?>
		<? endforeach; ?>

		<? if(!$buttons['next']['hidden']): ?>
			<a href="<?=$buttons['next']['url'];?>"><li>&raquo;</li></a>
		<? endif; ?>        
	</ul>
<? endif; ?>
