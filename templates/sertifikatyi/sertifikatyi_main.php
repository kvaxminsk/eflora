<? if (!empty($news)): ?>
<div class="col-xs-4 news-main">
    <h3><a href="<? $this->widget('MaterialUrl', array('module' => 'news', 'action' => 'index'));?>" class="h3-title">Новости</a></h3>
    <ul>
        <? foreach($news as $i => $n): ?>
        <li>
            <div class="type-text">
                <h3 class="news-main-title"><a href="<?=$n['url'];?>"><?=$n->name;?></a></h3>
                <div class="news-main-date"><?=rusdate($n->date);?></div>
                <div class="clear"></div>
                <p><?=$n->summary;?> <br /><a href="<?=$n['url'];?>">подробнее...</a></p>
            </div>
        </li>
        <? endforeach; ?>
    </ul>
</div>
<? endif; ?>