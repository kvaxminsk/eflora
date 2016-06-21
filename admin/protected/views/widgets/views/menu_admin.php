<ul class="left_menu">
    <? foreach($menu as $i => $mod):?>
    <li class="l1_li<? if ($mod['current']): ?> active <? if (!empty($mod['children'])): ?>open<? endif;?><? endif; ?>">
        <? if (!empty($mod['children'])): ?><span class="openhide"></span><? endif;?>
        <a class="l1_a" href="/admin<?=$mod['default_action'];?>">
            <span class="ico"><img src="/admin/images/ico/<?=$mod['create_button_ico'];?>"/></span>
            <span class="title"><?=$mod['name'];?></span>
        </a>
        <? if (!empty($mod['children'])): ?>
            <ul class="children">
                <? foreach($mod['children'] as $j => $mod_sub):?>
                    <li class="<? if ($mod_sub['current']): ?>active<? endif; ?>"><a href="/admin<?=$mod_sub['default_action'];?>"><?=$mod_sub['name'];?></a></li>
                    <? if($mod['module'] == 'catalog'):?>
                    <? endif;?>
                <? endforeach;?>
            </ul>
        <? endif; ?>
    </li>
    <? endforeach;?>
</ul>