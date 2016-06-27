<?php

$this->breadcrumbs = array(
    'Заказы' => array('index'),
    'Заказ №' . $model->id,
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
