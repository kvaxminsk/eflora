<?php
$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user_name'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user_phone'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user_email'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user_city'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user_address'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user_come'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'user_time'),
            array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'user_comment'),
            //array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'comment'),
            array('type' => FormElems::ELEM_TYPE_DATE, 'attribute' => 'date', 'class' => 'datepicker'),
            array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
        )
    ));
?>