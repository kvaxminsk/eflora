<?php
$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req' => 1, 'placeholder' => 'Введите имя категории'),
            array('type' => FormElems::ELEM_TYPE_SELECT, 'attribute' => 'parent_id', 'datalist' => $categories),
            array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'summary', 'placeholder' => 'Описание категории'),
            array('type' => FormElems::ELEM_TYPE_TEXTEDIT, 'attribute' => 'content', 'placeholder' => 'Содержание категории'),
            array('type' => FormElems::ELEM_TYPE_IMAGE, 'attribute' => 'img', 'htmlOptions' => array('style' => 'width:280px;')),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'order'),
            array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
            array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'is_main'),
        )
    ));

$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model->metatag,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'alias', 'placeholder' => 'Псевдоним (Alias) категории'),
        )
    )
);

?>