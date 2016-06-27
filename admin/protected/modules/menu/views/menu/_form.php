<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cmaterial-form',
    'enableAjaxValidation' => false,
)); ?>
<?
$datalistselect = array();
if (!empty($model->material)) {
    foreach ($model->material as $key => $val) {
        $datalistselect[] = $val->id;
    }
}

?>
<div class="form">
    <?php
    $this->widget('application.components.formElems',
        array(
            'form' => $form,
            'model' => $model,
            'elems' => array(
                array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'name', 'req' => 1, 'placeholder' => 'Введите название меню'),
                array('type' => FormElems::ELEM_TYPE_TEXT, 'attribute' => 'alias', 'placeholder' => 'Укажите переменную для меню'),
                array('type' => FormElems::ELEM_TYPE_CHECKBOX, 'attribute' => 'active'),
            )
        ));

    $this->widget('application.components.formElems',
        array(
            'form' => $form,
            'model' => $model,
            'elems' => array(
                array('type' => FormElems::ELEM_TYPE_MULTISELECT, 'attribute' => 'material_id', 'lable' => 'Страницы', 'datalist' => $materials, 'datalistselect' => $datalistselect, 'htmlOptions' => array('multiple' => 'multiple', 'size' => 10)),
            ),
            'buttons' => true
        ));
    ?>

    <?php $this->endWidget(); ?>
</div>


