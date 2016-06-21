<div class="left_button">
    <div class="select_custom">
        <div class="open">
            <span class="openhide"></span>
            <a class="button" href="/admin<?=$modules[0]['create_action'];?>">
                <span class="ico add"></span>
                <span class="btn_title">Добавить <?=$modules[0]['create_action_text'];?></span>
            </a>
        </div>
        <div class="close" style="">
            <? unset($modules[0]); ?>
            <? foreach($modules as $i => $mod): ?>
            <a class="button" href="/admin<?=$mod['create_action'];?>">
                <span class="cb_ico">
                    <? if (is_file(HOME . '/admin/images/ico/' . $mod['create_button_ico'])):?>
                        <img src="/admin/images/ico/<?=$mod['create_button_ico'];?>"/>
                    <? else: ?>
                        <img src="/admin/images/ico/pages.png"/>
                    <? endif; ?>
                </span>
                <span class="btn_title"><?=$mod['create_action_text'];?></span>
            </a>
            <? endforeach; ?>
        </div>
    </div>
</div>