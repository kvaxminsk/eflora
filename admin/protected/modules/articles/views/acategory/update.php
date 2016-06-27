<?php
$this->breadcrumbs = array(
    'Категории' => array('index'),
    'Редактировать категорию'
);

?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'action' => 'update', 'categories' => $categories)); ?>
