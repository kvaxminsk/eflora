<?php
$this->breadcrumbs=array(
	'Меню'         =>  array('index'),
	'Новое'
);
?>

<div class="conteiner">
    <div class="block_title">
	   Добавить меню 
	</div>
 
	<div class="form_pretext">
		Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для
		заполнения
	</div>
    
    <?=$this->renderPartial('_form', array('model' => $model, 'materials' => $materials)); ?>
</div>