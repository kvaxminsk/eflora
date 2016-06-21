<div class="content_scene_cat">
    <!-- Category image -->
    <div class="content_scene_cat_bg row">
        <div class="cat_desc  col-xs-12 col-sm-7 col-md-8 col-lg-12">
            <span class="category-name"><?=$this->h1;?></span>
            <div id="category_description_short" class="rte text-tpl"><?=$model->content;?></div>
        </div>
    </div>
</div>

<? if(!empty($subalbums)): ?>
<h2>Подгалереи</h2>
<ul class="product_list grid row"> 
    <? foreach($subalbums as $i => $alb): ?>
        <li class="ajax_block_product col-xs-12 col-sm-6 col-md-4 first-item-of-tablet-line first-item-of-mobile-line" style="height: 300px;">
            <div class="product-container">
                <? if (!empty($alb->img['path'])): ?>
                <div class="left-block">
                    <div class="product-image-container">
                        <a class="product_img_link" href="<?=$alb['url'];?>" title="<?=$alb->name;?>">
                            <img class="replace-2x img-responsive" src="<?=image($alb->img['path'], 'resize', '230', '230');?>" alt="<?=$alb->name;?>" title="<?=$alb->name;?>"/>
                        </a>
                    </div>
                </div>
                <? endif; ?>
                <div class="right-block">
                    <h5>
                        <a class="product-name" href="<?=$alb['url'];?>" title="<?=$alb->name;?>">
                            <span class="grid-name"><?=$alb->name;?></span>
                        </a>
                    </h5>
                    
                    <div class="product-desc">
                        <?=$alb->summary;?>
                    </div>
                </div>
               
            </div>
        </li> 
    <? endforeach; ?>
</ul>
<? endif; ?>

<? if(!empty($images)): ?>
<h2>Изображения галереи</h2>
<ul class="product_list grid row"> 
    <? foreach($images as $i => $img): ?>
        <li class="ajax_block_product col-xs-12 col-sm-6 col-md-4 first-item-of-tablet-line first-item-of-mobile-line" style="height: 270px;">
            <div class="product-container">
                <? if (!empty($img->image['path'])): ?>
                <div class="left-block">
                    <div class="product-image-container">
                        <a class="product_img_link lightbox-image" data-gal="prettyPhoto[gallery]" href="<?=$img->image['path'];?>" title="<?=$img->name;?>">
                            <img class="replace-2x img-responsive" src="<?=image($img->image['path'], 'resize', '230', '230');?>" alt="<?=$img->name;?>" title="<?=$img->name;?>"/>
                        </a>
                    </div>
                </div>
                <? endif; ?>
                <div class="right-block">
                    <h5 style="text-align: center;">
                        <a class="product-name lightbox-image" data-gal="prettyPhoto[gallery2]" href="<?=$img->image['path'];?>" title="<?=$img->name;?>">
                            <span class="grid-name"><?=$img->name;?></span>
                        </a>
                    </h5>
                </div>
               
            </div>
        </li> 
    <? endforeach; ?>
</ul>
<? endif; ?>
