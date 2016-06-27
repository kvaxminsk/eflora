<?php
$this->breadcrumbs = array(
    'Вопросы' => array('index'),
    'Редактировать вопросы'
);

?>
<?php $this->renderPartial('_form', array(
    'model' => $model,
));
?>