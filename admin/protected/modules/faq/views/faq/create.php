<?php
$this->breadcrumbs=array(
	'Вопросы' => array('index'),
    'Добавить вопрос'
);
?>
<div class="conteiner">
<?php $this->renderPartial('_form', array(
    'model'       => $model, 
         
));?>
</div>
