<?php
$this->breadcrumbs = array(
    'Отзывы' => array('index'),
    'Редактировать отзыв'
);

?>
<?php $this->renderPartial('_form', array(
    'model' => $model,
));
?>