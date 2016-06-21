<?php

$datalistselect = array();
if (!empty($model->menu)) {
    foreach ($model->menu as $key => $val) {
        $datalistselect[] = $val->id;
    }
}
?>
<?php

$this->widget('application.components.formElems', array(
    'form' => $form,
    'model' => $model->metatag,
    'elems' => array(
        array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'alias', 'placeholder' => 'Псевдоним (Alias) Страницы'),
    )
        )
);

$this->widget('application.components.formElems', array(
    'form' => $form,
    'model' => $model,
    'elems' => array(
        array('type' => FormElems::ELEM_TYPE_SELECT, 'attribute' => 'parent_id', 'datalist' => $materials),
        array('type' => FormElems::ELEM_TYPE_SELECT, 'attribute' => 'type_id', 'datalist' => $types),
        array('type' => FormElems::ELEM_TYPE_MULTISELECT, 'attribute' => 'menu_id', 'lable' => 'Меню', 'datalist' => $menu, 'datalistselect' => $datalistselect, 'class' => 'multiselect', 'htmlOptions' => array('multiple' => 'multiple', 'size' => 5)),
    )
        )
);
?>