<?php 
	$this->widget('application.components.formElems', 
		array(
            'form'  =>  $form, 
			'model' =>  $model, 
			'elems' =>  array(
				array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req' => 1, 'placeholder' => 'Введите загаловок материала'),
				array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'content'),
                array('type' => FormElems::ELEM_TYPE_IMAGE, 'attribute' => 'img', 'htmlOptions' => array('style' => 'width: 280px;')),
                array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
                array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'order'),
            )		
        )
    );
    
?>