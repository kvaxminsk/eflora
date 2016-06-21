<div class="wrap">
      <div class="wrap_contacts">
        <div class="content">
          <h1><?=$this->h1?></h1>
        </div>
      </div>
      <div class="content">
        <? include HOME . '/templates/blocks/breadcrumbs.php'; ?>

        <div class="left_content">
			<?php 
            	$this->widget('SMListView', 
            		array(
                    	'dataProvider'      => $testimonials,
                        'itemView'          => '_testimonial',
                        'ajaxUpdate'        => true,
                        'template'          => "{items}",
                        'enablePagination'  => false
                    )
                );
            ?>
			
			<?php $this->widget('SMLinkPager', array('pages' => $pages, 'file' => 'pager')); ?>
			
          	<div class="comment">
				<h1>Оставить отзыв</h1>
				<? if (!empty($_GET['result'])):?>
					<? if ($_GET['result'] == 'yes'): ?>
						<font color="green">Спасибо за сообщение, мы свяжимся с Вами в ближайшее время.</font><br /><br />
					<? elseif($_GET['result'] == 'no'): ?>
						<font  color="red">Извините, сообщение не отправлено, свяжитесь с нами по телефону.</font><br /><br />
					<? endif; ?>
				<? endif; ?>
				<form action="" method="POST">
				  <input type="text" name="name" value="" placeholder="Имя" required />
				  <input type="email" name="mail" value="" placeholder="Электронная почта" required />
				  <textarea name="message" placeholder="Сообщение" required></textarea><br>
				  <input type="submit" name="" value="ОТПРАВИТЬ"/>
				</form>
			</div>
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
