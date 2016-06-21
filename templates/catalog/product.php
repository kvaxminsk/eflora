<div class="wrap">
      <div class="wrap_contacts">
        <div class="content">
          <h1><?=$this->h1?></h1>
        </div>
      </div>
      <div class="content content_contacts">
        <? include HOME . '/templates/blocks/breadcrumbs.php'; ?>
		  
        <div class="discription_glush">
          <h1><?=$this->h1?></h1>
          <div id="jcl-demo">
            <div class="custom-container widget">
                <div class="mid">
                    <? 
						$image = (isset($model->img['path'])) ? $model->img['path'] : '/images/no-photo.gif';
						$image = image($image, 'resize', '440', false);
					?>
					<img src="<?=$image?>" />
                </div>
				<? if ($model->images): ?>
                <a href="#" class="prev">&lsaquo;</a>
                <div class="carousel">
                    <ul>
						<li>
							<img src="<?=$image?>"/>
						</li>
						<? foreach($model->images as $i => $img): ?>
							<? 
								$image = (isset($img->photo['path'])) ? $img->photo['path'] : '/images/no-photo.gif';
								$image = image($image, 'resize', '440', false);
							?>
							<li>
								<img src="<?=$image?>" title="<?=$img->name?>" alt="<?=$img->name?>"/>
							</li>
						<? endforeach; ?>
					</ul>
                </div>
                <a href="#" class="next">&rsaquo;</a>
				<? endif; ?>
                <div class="clear"></div>
            </div>
          </div>
          <div class="text_description">
            <div>
              <h6><?=price($model->price)?></h6>
              <input class="changeNumInProduct" data-productid="<?=$model->id?>" type="number" value="1" min="1" />
              <a data-productid="<?=$model->id?>" data-productname="<?=$model->name?>" data-productcount="1" data-proucturl="<?=$model->url?>" data-productimg="<?=$image?>" data-productprice="<?=$model->price?>" class="addtobasket"><img src="/images/basket.png" alt=""/><span class="basketButtonText">В корзину</span></a>
            </div>  
              <? if(!empty($model['brand']['name'])): ?><p>Марка автомобиля: <span><?=$model['brand']['name']?></span></p><? endif; ?>
			  <? if(!empty($model->brand_model)): ?><p>Модель автомобиля: <span><?=$model->brand_model?></span></p><? endif; ?>
			  <? if(!empty($model->manufacturer)): ?><p>Объем двигателя: <span><?=$model->manufacturer?></span></p><? endif; ?>
			  <? if(!empty($model->original)): ?><p>Год выпуска: <span><?=$model->original?></span></p><? endif; ?>
              <div style="margin-top:40px;">
                <h6>Описание</h6>
                <?=$model->content?>
              </div>
          </div>
        </div>
		<? $this->widget('ProductLastBlock', array('file' => 'product_last')) ?>
      </div>
</div>