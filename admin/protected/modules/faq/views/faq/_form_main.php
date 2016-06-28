<?php
$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'question', 'placeholder' => 'Вопрос'),
            array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'answer', 'placeholder' => 'Введите ответ на отзыв'),
            array('type' => FormElems::ELEM_TYPE_IMAGE, 'attribute' => 'img', 'htmlOptions' => array('style' => 'width:280px;')),
            array('type' => FormElems::ELEM_TYPE_DATE, 'attribute' => 'date', 'class' => 'datepicker'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'order'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'phone'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'email'),
            array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
        )
    ));


?>