<?php 

	$this->widget('application.components.formElems', 
		array(
            'form'  =>  $form, 
			'model' =>  $model, 
			'elems' =>  array(
				array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'code1'),
                array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'code2'),
            )		
        )
    );
    
?>