<? if (!empty($categories)): ?>

<div class="left_column">
   <div class="category_menu_block">
      <ul class="category-ul">
        <? foreach ($categories as $i => $item): ?>
            
			    <? if ($item['url_active']):?>
                   <li class="active"><span><?=$item['name']; ?></span>
                <? elseif($item['url_current']):?>   
                   <li class="active"><a href="<?= $item['url']; ?>"><?=$item['name']; ?></a>
                <? else: ?>
                   <li><a href="<?= $item['url']; ?>"><?=$item['name']; ?></a>
                <? endif; ?>
        <? endforeach; ?>
      </ul>    
   </div>  
</div>
<? endif; ?>
      