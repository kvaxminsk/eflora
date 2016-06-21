		<div class="wrap wrap_slider">
			<div class="content content_slider">
				<div id="slider">
				  <? $this->widget('SlideBlock', array('file' => 'slider', 'sliderN' => 1)) ?>
				</div>
			</div>
		</div>
		
		<div class="wrap wrap_avto">
			<div class="content content_avto">
			<h1>ГЛУШИТЕЛИ ПО МАРКАМ АВТОМОБИЛЕЙ</h1>
				<? $this->widget('SubjectsBlock', array('file' => 'brand_block_is_main')) ?>
				<div class="search2">
					<p>ДОПОЛНИТЕЛЬНЫЙ ОТБОР<br> ВЫХЛОПНЫХ СИСТЕМ</p>
					<form action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>" method="GET" id="catalogForm">
						<? $this->widget('catalogIndex', array('file' => 'catalog_filter')) ?>
						<input type="submit" value="ПОИСК >"/>
					</form>
				</div>
				<? $this->widget('CatalogCategoryBlock', array('file' => 'catalog_main_tree')) ?>
			</div>
		</div>
		
		<div class="wrap wrap_news">
		<hr noshade color="#ebebeb"/>
			<div class="content content_news">
				<div class="news_article"><span class="active_news">НОВОСТИ</span> <span>АКЦИИ</span></div>
				<? $this->widget('NewsBlock', array('file' => 'block_is_main')) ?>
				<? $this->widget('ArticleBlock', array('file' => 'block_is_main')) ?>
			</div>
		</div>