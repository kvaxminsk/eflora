<?php
$this->breadcrumbs=array(
	'Акции'
);
if($this->h1!='Все акции'){
	$this->breadcrumbs=array(
	'Акции'=>array('index'),
	$model->name
);
}


?>
<?php $this->renderPartial('_form', array(
            'model'       => $model, 
            'categories'  => $categories, 
));
?>