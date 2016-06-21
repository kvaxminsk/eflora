<div class="wrap">
	<form action="" method="GET" id="catalogForm">
      <div class="wrap_contacts">
        <div class="content">
          <h1><?=$this->h1?></h1>
          <div class="sorting">
          <label>Сортировать по 
            <select name="sort">
              <option value="0">Выберите вариант</option>
              <option <? if ($_GET['sort'] == 'name'): ?>selected<? endif ?> value="name">Наименованию</option>
              <option <? if ($_GET['sort'] == 'price'): ?>selected<? endif ?> value="price">Цене</option>
              <option <? if ($_GET['sort'] == 'original'): ?>selected<? endif ?> value="original">Году выпуска</option>
            </select>
          </label>
          <label>Отображать по
            <select name="page_list">
              <option <? if ($_GET['page_list'] == 10): ?>selected<? endif ?> value="10">10</option>
              <option <? if ($_GET['page_list'] == 20): ?>selected<? endif ?> value="20">20</option>
              <option <? if ($_GET['page_list'] == 30): ?>selected<? endif ?> value="30">30</option>
              <option <? if ($_GET['page_list'] == 40): ?>selected<? endif ?> value="40">40</option>
              <option <? if ($_GET['page_list'] == 50): ?>selected<? endif ?> value="50">50</option>
            </select>
          </label>
		  <button class="sortButton" type="submit">Показать</button>
          <div class="show">
            <div class="show2 active_show"><span></span><span></span><span></span></div>
            <div class="show1"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></div>
          </div>
          </div>
        </div>
      </div>
      <div class="content">
        <? include HOME . '/templates/blocks/breadcrumbs.php'; ?>
		 
		<div class="categories">
			<h1>Категории</h1>
			<ul class="list_categories">
				<? $this->widget('CatalogCategoryBlock', array('file' => 'catalog_tree')) ?>
			</ul>
          <h1>Фильтры</h1>
          	<? $this->widget('catalogIndex', array('file' => 'catalog_filter')) ?>
            <button type="submit">ПОДОБРАТЬ</button>
        </div>
	</form>
		  
        <div class="list_product">
			<? if(!empty($products->data)): ?> 
				<div class="show_list">
					<?
						$this->widget('SMListView', 
							array(
								'dataProvider'      => $products,
								'itemView'          => '_product_list',
								'ajaxUpdate'        => true,
								'template'          => "{items}\n{pager}",
								'enablePagination'  => false
							)
						);
					?>
				</div>
			<? else: ?>
				Категория в стадии заполнения.
			<? endif; ?>
			
          	<div class="show_tile">
					<?
						$this->widget('SMListView', 
							array(
								'dataProvider'      => $products,
								'itemView'          => '_product_list_table',
								'ajaxUpdate'        => true,
								'template'          => "{items}\n{pager}",
								'enablePagination'  => false
							)
						);
					?>
			</div>
			
			
			<? $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
			<br />
			<br />
		</div>
      </div>
</div>