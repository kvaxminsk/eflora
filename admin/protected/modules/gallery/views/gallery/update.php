<?php
$this->breadcrumbs = array(
    'Примеры работ' => array('index'),
    'Редактировать пример работ'
);

?>

<?php echo $this->renderPartial('_form', array('model' => $model, 'action' => 'update', 'categories' => $categories)); ?>
