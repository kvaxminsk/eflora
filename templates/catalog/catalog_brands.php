<? if(!empty($brands)): ?>
<div class="block brands">
    <div class="block-title">
        <strong><span>Брэнды</span></strong>
    </div>
    <div class="block-content">
    
        <ul>
            <? foreach($brands as $i => $br): ?>
                <? 
                    $url = '/' . $urlroot . '/' . $br->metatag->uri . '/' . $br->metatag->alias; 
                    $url = str_replace('//', '/', $url);
                ?>
                <li><a href="<?=$url;?>"><?=$br->name;?></a></li>
            <? endforeach; ?>
        </ul>
    </div>
</div>
<? endif;?>