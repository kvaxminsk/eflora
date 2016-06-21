<?php
$this->breadcrumbs=array(
	'Меню'         =>  array('index'),
	'Обновить'
);
?>
<div class="conteiner">
    <div class="block_title">
	   Обновить меню - <?=$model->name;?> 
	</div>
 
	<div class="form_pretext">
		Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для
		заполнения
	</div>
    
    <?=$this->renderPartial('_form', array('model' => $model, 'materials' => $materials)); ?>
</div>
