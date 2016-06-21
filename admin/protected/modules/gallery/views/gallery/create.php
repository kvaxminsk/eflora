<?php
$this->breadcrumbs=array(
	'Примеры работ' => array('index'),
	'Новый пример работ'
);

?>

<?php  echo $this->renderPartial('_form', array('model'=>$model, 'action'=>'create', 'categories' => $categories));  ?>
