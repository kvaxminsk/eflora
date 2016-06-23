<div class="under_slider">
	<div class = "mobile_categoria">
		Акции
	</div>
	<div class="mobile_filter">
		<div class="filter_wrapper">
			<div id="criterion_filter" class="wrapper-dropdown-5 select_filter" tabindex="1">
									<span id='criterion_filter_text'>
									Фильтр</span>
				<ul class="dropdown " id="dropdown2">
					<li><a href=""><i class="icon-user"></i>По популярности</a><img class="orrange_arrow popular" src=""></li>
					<li><a href=""><i class="icon-cog"></i>По цене:</a><img class="orrange_arrow  price_link" src=""></li>
					<li><a href=""><i class="icon-remove"></i>До 100</a></li>
					<li><a href=""><i class="icon-remove"></i> До 200</a></li>
				</ul>
			</div>
		</div>
	</div>
	<p class="theme"> Тематика: </p>
	<div class="select_theme_wrapp">
		<? $this->widget('CatalogCategoryBlock', array('file' => 'catalog_select_tree')) ?>
	</div>
</div>
<div class= "clearfix" style="clear:both"> </div>

<div class ="sort_criterion" >
	<p class = "choice">
		Сортировать по:
		<a class="choice_link" href="#">Популярности</a><img class="orrange_arrow popular" src="">
		<a class="choice_link" href="#">Цене</a><img class="orrange_arrow  price_link" src="">
		<a class="choice_link" href="#">До 50</a>
		<a class="choice_link" href="#">До 100</a>
		<a class="choice_link" href="#">До 200</a>
	</p>
</div>
</div>
<div class="list_product">
	<? if(!empty($products->data)): ?>
		<ul class="flower_products_catalog">
			<?
			$this->widget('SMListView',
				array(
					'dataProvider'      => $products,
					'itemView'          => '_products',
					'ajaxUpdate'        => true,
					'template'          => "{items}\n{pager}",
					'enablePagination'  => false
				)
			);
			?>
		</ul>
	<? else: ?>
<!--		По вашим параметрам ничего не найдено-->
	<? endif; ?>

<!--	<div class="show_tile">-->
<!--		--><?//
//		$this->widget('SMListView',
//			array(
//				'dataProvider'      => $products,
//				'itemView'          => '_product_list_table',
//				'ajaxUpdate'        => true,
//				'template'          => "{items}\n{pager}",
//				'enablePagination'  => false
//			)
//		);
//		?>
<!--	</div>-->

<!--	--><?// $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
	<br />
	<br />
</div>