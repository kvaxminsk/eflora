<div class="glushitel">
	<ul>
		<? foreach($categories as $item): ?>
			<?
			$image = (isset($item['img']['path'])) ? $item['img']['path'] : '/images/no-photo.gif';
			$image = image($image, 'resize', '100', false);
			?>
			<a href="<?=$item['url']?>">
				<li>
					<div>
						<img src="<?=$image?>"/>
						<p><?=$item['name']?></p>
					</div>
				</li>
			</a>
		<? endforeach; ?>
	</ul>
</div>