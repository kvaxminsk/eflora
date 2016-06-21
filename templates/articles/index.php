<div class="wrap">
      <div class="wrap_contacts">
        <div class="content">
          <h1><?=$this->h1?></h1>
        </div>
      </div>
      <div class="content">
        <? include HOME . '/templates/blocks/breadcrumbs.php'; ?>
		
		<div class="left_content">
			<?
				$this->widget('SMListView', 
					array(
						'dataProvider'      => $articles,
                		'itemView'          => '_article',
						'ajaxUpdate'        => true,
						'template'          => "{items}\n{pager}",
						'enablePagination'  => false
					)
				);
			?>
			<? $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
		</div>
        

        <div class="right_block">
          <h1>Глушители по маркам автомобилей</h1>
			
		  <? $this->widget('SubjectsBlock', array('file' => 'brand_block_right')) ?>
			
          <h1>ОТБОР ВЫХЛОПНЫХ СИСТЕМ</h1>
          <div class="selection">
            <form action="<? $this->widget('MaterialUrl', array('module' => 'catalog', 'action' => 'index')) ?>" method="GET" id="catalogForm">
				<? $this->widget('catalogIndex', array('file' => 'catalog_filter')) ?>
				<input type="submit" value="ПОИСК >"/>
			</form>
          </div>

           <div id="slider">
			  <? $this->widget('SlideBlock', array('file' => 'slider', 'sliderN' => 2)) ?>
          </div>
        </div>
      </div>
    </div>
