<?php
$this->breadcrumbs=array(
	'Тематика' => array('index'),
	'Редактировать тематику'
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'action'=>'update')); ?>
