<?php
    $this->widget('application.components.formElems', 
    	array(
            'form'  => $form, 
    		'model' => $model, 
    		'elems' => array(
    			array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req'=>1, 'placeholder' => 'Введите имя товара'),
                array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'price', 'placeholder' => 'Введите стоимость товара'),
                //array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'discount', 'placeholder' => 'Введите скидку в процентах'),
                array('type' => FormElems::ELEM_TYPE_IMAGE, 'attribute' => 'img', 'htmlOptions' => array('style' => 'width:280px;')),
    			array('type' => FormElems::ELEM_TYPE_SELECT, 'attribute' => 'category_id', 'datalist' => $categories),
//                array('type' => FormElems::ELEM_TYPE_SELECT, 'attribute' => 'brand_id', 'datalist' => $brands),
//				array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'brand_model', 'placeholder' => 'Модель автомобиля'),
//				array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'manufacturer', 'placeholder' => 'Объем двигателя'),
				//array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'specifications', 'placeholder' => 'Алюминизированность'),
				//array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'articul', 'placeholder' => 'Артикул'),
//				array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'original', 'placeholder' => 'Год выпуска'),
                //array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'desc', 'placeholder' => 'Краткое описание товара'),
                //array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'summary', 'placeholder' => 'Описание товара'),
                array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'content', 'placeholder' => 'Содержание товара'),
                //array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'count', 'placeholder' => 'Остаток'),
                array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'order', 'placeholder' => 'Порядок вывода'),
    			array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
    			array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'stock'),
                //array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'is_top'),
                //array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'is_main'),
                //array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'is_new'),
                //array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'is_pop'),
                //array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'is_sale'),
    		)
    ));
    
?>