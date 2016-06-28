<?php
$this->widget('application.components.formElems',
    array(
        'form' => $form,
        'model' => $model->metatag,
        'elems' => array(
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'h1', 'placeholder' => 'H1 страницы'),
            array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'title', 'placeholder' => 'title страницы'),
            array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'description', 'placeholder' => 'description страницы'),
            array('type' => FormElems::ELEM_TYPE_TEXTAREA, 'attribute' => 'keywords', 'placeholder' => 'keywords страницы'),
        ),
    )
) ?>
