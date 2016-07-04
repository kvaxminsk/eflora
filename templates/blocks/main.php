<? if (!empty($menu)): ?>
    <ul class="hidden_menu_list">
        <? foreach ($menu as $item): ?>
            <? if (!empty($item['children'])): ?>
            <? else: ?>
                <li>
                    <a data-menu="<?=$item[id];?>" href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
                </li>
            <? endif; ?>
        <? endforeach; ?>
    </ul>
<? endif; ?>
