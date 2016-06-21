
<!-- good -->
<div class="product">
	<div class="image-wrap">
		<a class="image"  href="<?php echo $data->getProductUrl();?>">
			<?php echo	CHtml::image(Yii::app()->request->baseUrl."/images/products/small/".$data->image);?>
		</a>
	</div>
	<div class="name">
		<a href="<?php echo $data->getProductUrl();?>"><?php echo $data->name?></a>
	</div>
	<?php if(Yii::app()->params['shop']==1){?>
	<div class="add_to_cart">
		<?php echo CHtml::ajaxLink(
			'В КОРЗИНУ',
			array('/shop/addtocart/'.$data->id), // Yii URL
			// array('update' => '#box_content_title strong') // jQuery selector
			array('success' => 'js:function(data) { 
									try{
										$("#box_count").html(data);
										$("#msg_success").html("Товар добавлен в корзину");
										$("#msg_success").show();
										setTimeout(function(){
											$("#msg_success").hide();
										},3000);
									}catch(ex){
										alert(ex.description);
									}
								}')
); ?>
</div>
<?php } ?>
<div class="podrobnee">
		<a href="<?php echo $data->getProductUrl();?>">ПОДРОБНЕЕ</a>
	</div>
</div>
<!-- good end -->
