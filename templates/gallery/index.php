<div class="grid_3">
    <? $this->widget('GalleryBlock', array('file' => 'gallery_left_tree'));?>
</div>         
	
<div class="grid_9">

    <h1 class="h1title"><?=$this->h1;?></h1>
    <div class="content-tpl"><?=$model->content;?></div> 
    
    <div class="gallery-block">
    <? foreach($albums as $i => $alb): ?>
        <div class="row gallery-row">
            <div>
            
                <div class="grid_3">
                    <div class="product-image-container">
                        <a class="product_img_link" href="<?=$alb['url'];?>" title="<?=$alb->name;?>">
                            <img class="replace-2x img-responsive" src="<?=image($alb->img['path'], 'resize', '270', '270');?>" alt="<?=$alb->name;?>" title="<?=$alb->name;?>"/>
                        </a>
                    </div>
                </div>
                <div class="grid_6">
                    <span class="spanh4">
                        <a class="product-name" href="<?=$alb['url'];?>" title="<?=$alb->name;?>">
                            <span class="grid-name"><?=$alb->name;?></span>
                        </a>
                    </span>
                    
                    <div class="product-desc">
                        <?=$alb->summary;?>
                    </div>
                </div>
            </div>
        </div> 
    <? endforeach; ?>
    
    
</div>





