<div class="markaavto">
	<div class="avto_top">
		<? for($i = 0; $i <= 4; $i++): ?>
			<?
				$image = (isset($brands[$i]['img']['path'])) ? $brands[$i]['img']['path'] : '/images/no-photo.gif';
				$image = image($image, 'resize', false, '58');
			?>
			<a href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>?brand_id=<?=$brands[$i]['id']?>"><img src="<?=$image?>"/></a>
		<? endfor; ?>
		<? if (count($brands) > 6): ?>
			<div><p>Все марки</p><img src="/images/arrow.png"/></div>
		<? endif ?>
	</div>
	<? if (count($brands) > 6): ?>
		<div class="avto_bottom">
			<? for($i = 5; $i <= count($brands) - 1; $i++): ?>
				<?
					$image = (isset($brands[$i]['img']['path'])) ? $brands[$i]['img']['path'] : '/images/no-photo.gif';
					$image = image($image, 'resize', false, '58');
				?>
				<a href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>?brand_id=<?=$brands[$i]['id']?>"><img src="<?=$image?>"/></a>
			<? endfor; ?>
		</div>
	<? endif ?>
</div>