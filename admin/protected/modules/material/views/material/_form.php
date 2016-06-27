<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'cmaterial-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>

<div class="form">
    <?php
    $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Общие' => $this->renderPartial("_form_main", array('form' => $form, 'model' => $model), $this),
            'Структура' => $this->renderPartial("_form_structure", array('form' => $form, 'model' => $model, 'menu' => $menu, 'types' => $types, 'materials' => $materials), $this),
            'Коды' => $this->renderPartial("_form_code", array('form' => $form, 'model' => $model), $this),
            'Фото' => $this->renderPartial("_form_photo", array('form' => $form, 'model' => $model), $this),
            'SEO' => $this->renderPartial("_form_seo", array('form' => $form, 'model' => $model), $this),
        ),
        'options' => array(
            'collapsible' => true,
        ),
    ));
    ?>

    <?
    $this->widget('application.components.formElems',
        array(
            'form' => $form,
            'model' => $model,
            'buttons' => true
        )) ?>


    <?php $this->endWidget(); ?>
</div>

