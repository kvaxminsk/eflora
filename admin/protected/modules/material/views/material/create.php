<?php
$this->breadcrumbs=array(
	'Страницы'=>array('index'),
	'Новая страница'
);
?>
<div class="conteiner">
    <div class="block_title">
	   Добавить страницу 
	</div>
 
	<div class="form_pretext">
		Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для
		заполнения
	</div>
    
    <?php echo $this->renderPartial('_form', array('model'=>$model, 'types' => $types, 'menu' => $menu, 'materials' => $materials)); ?>
</div>