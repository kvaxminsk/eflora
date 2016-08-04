<? $i = 0;
?>
<? foreach ($categories as $item): ?>
<? if ($i == 0) {
$i++; ?>
<div id="theme_filter" class="wrapper-dropdown-5 select_theme" tabindex="1"><span
        id="theme_text"><?= $item['name'] ?></span>
    <?
    } else {
        break;
    } ?>
    <? endforeach; ?>
    <ul class="dropdown" id="dropdown1">
        <? foreach ($categories as $item): ?>

            <li data-category="<?= $item['id'] ?>"><a href="<?= $item['url'] ?>" data-category="<?= $item['id'] ?>"
                                                      ><i><?= $item['name'] ?></i></a></li>
        <? endforeach; ?>
    </ul>
