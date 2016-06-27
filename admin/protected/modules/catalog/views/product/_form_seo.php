<?php
$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model->metatag,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'alias', 'placeholder' => 'Псевдоним (Alias) товара'),
        )
    )
);

$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model->metatag,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'h1', 'placeholder' => 'H1 категории'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'title', 'placeholder' => 'title категории'),
            array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'description', 'placeholder' => 'description категории'),
            array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'keywords', 'placeholder' => 'keywords категории'),
        ),
    )
) ?>
