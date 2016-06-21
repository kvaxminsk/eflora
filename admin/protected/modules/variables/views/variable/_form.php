<?php 
$elems = '';
if($model->smart_edit==1){
	$elems = array(
						array('type'=>FormElems::ELEM_TYPE_TEXT, 'attribute' => 'label', 'req'=>1, 'placeholder' => 'Введите название'),
						array('type'=>FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req'=>1, 'placeholder' => 'Введите переменную'),
						array('type'=>FormElems::ELEM_TYPE_TEXTEDIT, 'attribute'=>'text', 'req'=>1, 'placeholder' => 'Введите значение переменной'),
                        array('type'=>FormElems::ELEM_TYPE_CHECKBOX,'attribute' => 'active'),
						array('type'=>FormElems::ELEM_TYPE_CHECKBOX,'attribute' => 'delete_allow'),
						array('type'=>FormElems::ELEM_TYPE_CHECKBOX,'attribute' => 'smart_edit'),

				);
}else{
	$elems = array(
						array('type'=>FormElems::ELEM_TYPE_TEXT, 'attribute' => 'label', 'req'=>1, 'placeholder' => 'Введите название'),
						array('type'=>FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req'=>1, 'placeholder' => 'Введите переменную'),
						array('type'=>FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'text', 'placeholder' => 'Введите значение переменной'),
                        array('type'=>FormElems::ELEM_TYPE_CHECKBOX,'attribute' => 'active'),
						array('type'=>FormElems::ELEM_TYPE_CHECKBOX,'attribute' => 'delete_allow'),
						array('type'=>FormElems::ELEM_TYPE_CHECKBOX,'attribute' => 'smart_edit'),

				);
} ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="form">
	<?		
		$this->widget('application.components.formElems', array(
			'form'          =>  $form, 
			'model'         =>  $model, 
			'elems'         =>  $elems	
		));
		
		$this->widget('application.components.formElems', array(
            'form'          => $form, 
    		'model'         => $model, 
    		'buttons'       => true 		
        ))
	?>
</div>
<?php $this->endWidget(); ?>