<?php
$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req' => 1, 'placeholder' => 'Название акции'),
            array('type' => FormElems::ELEM_TYPE_IMAGE, 'attribute' => 'img', 'htmlOptions' => array('style' => 'width:280px;')),
            //array('type' => FormElems::ELEM_TYPE_SELECT, 'attribute' => 'category_id', 'datalist' => $categories),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'precent', 'placeholder' => 'Скидка в процентах'),
            array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'summary', 'placeholder' => 'Краткое содержание'),
            array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'content', 'placeholder' => 'Полное содержание'),
            array('type' => FormElems::ELEM_TYPE_DATE, 'attribute' => 'date', 'class' => 'datepicker'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'order'),
            array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
            //array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'is_main'),
        )
    ));

$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model->metatag,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'alias', 'placeholder' => 'Псевдоним (Alias) товара'),
        )
    )
);

?>