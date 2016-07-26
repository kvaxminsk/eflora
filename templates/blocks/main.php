<? if (!empty($menu)): ?>
    <ul class="hidden_menu_list">
        <? foreach ($menu as $item): ?>
            <? if (!empty($item['children'])): ?>
            <? else: ?>
                <li class="<?=($_SERVER['REQUEST_URI'] == $item['url']) ? 'active_hidden_menu':'';?>">
                    <a href="<?= $item['url'] ?>"><?= $item['name'] ?></a>
                </li>
            <? endif; ?>
        <? endforeach; ?>
    </ul>
<? endif; ?>
