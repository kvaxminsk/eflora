<div class="wrap">
      <div class="wrap_contacts">
        <div class="content">
          <h1><?=$this->h1?></h1>
        </div>
      </div>
    <div class="content">
        <? include HOME . '/templates/blocks/breadcrumbs.php'; ?>
          <div class="search_site">
			<form method="get" action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'search')) ?>">
            	<input type="search" name="query" value="<?=$_GET['query']?>" placeholder="Поиск"/>
            	<button><img src="/images/click_search.png" alt=""/></button>
			</form>
            <!--<label><input type="radio" name="" value="" />
            по всему сайту</label>
            <label><input type="radio" name="" value="" />
            по каталогу</label>-->
          </div>
          <div class="rezalt">
			<? if($_GET['query']): ?>
              <h1>Вы искали <span>«<?=$_GET['query']?>»</span></h1>
			  <ol>
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
              </ol>
			  <? $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
			  <br />
			  <br />
			  <br />
			<? else: ?>
			  <h1>По вашему запросу ничего не найдено</h1>
			  <br />
			  <br />
			  <br />
			  <br />
			  <br />
			  <br />
			  <br />
			  <br />
			<? endif ?>
          </div>
    </div>
</div>  