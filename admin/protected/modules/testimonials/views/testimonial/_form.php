<div class="conteiner">
    <div class="form_pretext">
        Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для заполнения
    </div>
    <div class="block_title">
        <?php if (empty($model->id)): ?>
            Добавить отзыв
        <?php else: ?>
            Редактировать отзыв
        <?php endif; ?>
    </div>

    <?
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'testimonial-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));

    ?>

    <div class="form">
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Общие' => $this->renderPartial("_form_main", array('form' => $form, 'model' => $model), $this),
                'Фото' => $this->renderPartial("_form_photo", array('form' => $form, 'model' => $model), $this),
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


    </div>
    <?php $this->endWidget(); ?>
</div>




