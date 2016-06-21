<div class="form">
<? 
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'slide-form',
		'enableAjaxValidation' => false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
	)); 

	$this->widget('application.components.formElems', array(
        'form' => $form, 
		'model' => $model, 
		'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req'=>1),
			array('type' => FormElems::ELEM_TYPE_IMAGE, 'attribute' => 'img'),
			array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'order'),
			array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'slider_n', 'placeholder' => 'Для какого слайдера изображение'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'url', 'placeholder'=>'Ссылка при нажатии на изображение'),
            //array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'text1'),
            //array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'text2'),
            //array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'text3'),
			array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
		)
	));
	
    $this->widget('application.components.formElems', array(
        'form'          => $form, 
  		'model'         => $model, 
   		'buttons'       => true 		
    ));
	
	$this->endWidget(); 
?>
</div>