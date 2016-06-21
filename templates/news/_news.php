<? 
	$date = explode('-', $data->date);
	$image = (isset($data->img['path'])) ? $data->img['path'] : '/images/no-photo.gif';
	$image = image($image, 'resize', '260', false);
?>

<div class="action">
	<div class="img_action">
		<a href="<?=$data->url?>">
			<img src="<?=$image?>" alt="<?=$data->name?>" title="<?=$data->name?>"/>
			<p class="data"><?=$date[2]?>.<span class="dateM"><?=$date[1]?></span>.<span class="dateY"><?=$date[0]?></span></p>
		</a>
	</div>
	<div class="text_action">
		<h1><a href="<?=$data->url?>"><?=$data->name?></a></h1>
		<p><?=$data->summary?></p>
	</div>
</div>
			
			
			