<?php
$this->breadcrumbs = array(
    'Категории' => array('index'),
    'Новая категория'
);

?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'action' => 'create', 'categories' => $categories)); ?>
