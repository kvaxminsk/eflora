<?
$date = explode('-', $data->date);
$image = (isset($data->img['path'])) ? $data->img['path'] : '/images/no-photo.gif';
$image = image($image, 'resize', '260', false);
?>

<div class="action">
    <div class="img_action">
        <a href="<?= $data->url ?>">
            <img src="<?= $image ?>" alt="<?= $data->name ?>" title="<?= $data->name ?>"/>
            <? if (!empty($data->precent)): ?>
                <div class="procent">-<?= $data->precent ?> %</div><? endif ?>
            <p class="data"><?= $date[2] ?>.<span class="dateM"><?= $date[1] ?></span>.<span
                    class="dateY"><?= $date[0] ?></span></p>
        </a>
    </div>
    <div class="text_action">
        <h2><a href="<?= $data->url ?>"><?= $data->name ?></a></h2>
        <p><?= $data->summary ?></p>
    </div>
</div>
			
			
			