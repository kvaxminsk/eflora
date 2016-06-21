<div class="page-title category-title">
    <h1><?=$this->h1;?></h1>
</div>

<div class="category-products">
   <div class="text">
        <?=$model->content;?>
   </div>
   <? if (!empty($brands)): ?>
        <ul>
            <? foreach($brands as $i => $br): ?>
                <li><a href="<?=$urlbrand . '/' . $br->metatag->alias;?>"><?=$br->name;?></a></li>
            <? endforeach; ?>
        </ul>      
   <? endif; ?>
     
</div>

