<?php
$this->breadcrumbs=array(
	'Новости' => array('index'),
    'Редактировать новость'
);

?>
<?php $this->renderPartial('_form', array(
            'model'       => $model,
));
?>