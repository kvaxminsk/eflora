<?php
$this->breadcrumbs=array(
	'Товары' => array('index'),
	'Редактировать товар'
);
?>

<?php $this->renderPartial('_form', array(
            'model'       => $model, 
            'categories'  => $categories, 
            'brands' => $brands,
));
?>