<div class="conteiner">
    <div class="form_pretext">
        Поля отмеченные <sup class="form_title_marker">*</sup> обязательны для заполнения
    </div>
    <div class="block_title">
        <?php if (empty($model->name)): ?>
            Добавить категорию
        <?php else: ?>
            Редактировать категорию - <?= $model->name; ?>
        <?php endif; ?>
    </div>

    <?
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'category-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));

    ?>

    <div class="form">
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Общие' => $this->renderPartial("_form_main", array('form' => $form, 'model' => $model, 'categories' => $categories), $this),
//                    'Фото'        => $this->renderPartial("_form_photo", array('form' => $form, 'model' => $model), $this),
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


    </div>
</div>
<?php $this->endWidget(); ?>



