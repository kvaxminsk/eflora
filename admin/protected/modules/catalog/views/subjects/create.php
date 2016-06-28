<?php
$this->breadcrumbs = array(
    'Тематика' => array('index'),
    'Новая тематика'
);

?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'action' => 'create')); ?>
