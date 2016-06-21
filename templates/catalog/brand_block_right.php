<div class="car_brand">
	<div>
		<div class="block_car_brand">
            <? for($i = 0; $i <= 1; $i++): ?>
				<?
					$image = (isset($brands[$i]['img']['path'])) ? $brands[$i]['img']['path'] : '/images/no-photo.gif';
					$image = image($image, 'resize', false, '58');
				?>
				<a href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>?brand_id=<?=$brands[$i]['id']?>"><img src="<?=$image?>"/></a>
			<? endfor; ?>
			<? if (count($brands) > 3): ?>
                <div class="click_car">
                  <img src="/images/arrow.png" alt=""/>
                  <p>Все марки</p>
                </div>
			<? endif ?>
			<? if (count($brands) > 2): ?>
                <?
					$image = (isset($brands[3]['img']['path'])) ? $brands[3]['img']['path'] : '/images/no-photo.gif';
					$image = image($image, 'resize', false, '58');
				?>
				<a href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>?brand_id=<?=$brands[$i]['id']?>"><img src="<?=$image?>"/></a>
			<? endif ?>
		</div>
		<? if (count($brands) > 3): ?>
			<div class="block_car_brand2">
				<? for($i = 4; $i <= count($brands) - 1; $i++): ?>
					<?
						$image = (isset($brands[$i]['img']['path'])) ? $brands[$i]['img']['path'] : '/images/no-photo.gif';
						$image = image($image, 'resize', false, '58');
					?>
					<a href="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>?brand_id=<?=$brands[$i]['id']?>"><img src="<?=$image?>"/></a>
				<? endfor; ?>
			</div>
		<? endif ?>
    </div>
</div>