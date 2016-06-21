<?php
$this->breadcrumbs=array(
	'Новости' => array('index'),
    'Добавить новость'
);
?>
<div class="conteiner">
<?php $this->renderPartial('_form', array(
    'model'       => $model, 
         
));?>
</div>
