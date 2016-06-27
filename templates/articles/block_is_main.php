<div class="articles" style="display: none">
    <? foreach ($articles as $item): ?>
        <?
        $date = explode('-', $item['date']);
        $image = (isset($item['img']['path'])) ? $item['img']['path'] : '/images/no-photo.gif';
        $image = image($image, 'resize', '260', false);
        ?>
        <div>
            <a href="<?= $item['url'] ?>"><img src="<?= $image ?>"/></a>
            <span><a href="<?= $item['url'] ?>"><?= $item['name'] ?></a></span>
            <p><?= $item['summary'] ?></p>
            <? if (!empty($item['precent'])): ?>
                <div class="procent">-<?= $item['precent'] ?> %</div><? endif ?>
            <p class="data"><?= $date[2] ?>.<?= $date[1] ?>.<?= $date[0] ?></p>
        </div>
    <? endforeach; ?>
</div>