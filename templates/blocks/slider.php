<? if (!empty($slides)): ?>
    <div id="mask">
        <ul id="image_container">
            <? foreach ($slides as $k => $v): ?>
                <?
                $image = (isset($v->img['path'])) ? $v->img['path'] : '/admin/images/no-photo.gif';
                $image = image($image, 'resize', '1000', '383');
                ?>

                <li><img src="<?= $image ?>"/></li>
            <? endforeach; ?>
        </ul>
    </div>

    <ul id="dots">
        <? $i = 0; ?>
        <? foreach ($slides as $v) : ?>
            <? $i++; ?>
            <li class="button<?= $i ?>" onClick="changeImage(<?= $i ?>)"></li>
        <? endforeach; ?>
    </ul>
<? endif; ?>