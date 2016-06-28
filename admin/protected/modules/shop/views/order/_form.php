<div class="conteiner">

    <div class="block_title">
        <?php if (empty($model->id)): ?>
            Добавить заказ
        <?php else: ?>
            Заказ №-<?= $model->id; ?> от <?= date('d.m.Y', strtotime($model->date)); ?>
        <?php endif; ?>
    </div>

    <?
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'order-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));

    ?>


    <div class="form">
        <?php
        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'Общие' => $this->renderPartial("_form_main", array('form' => $form, 'model' => $model), $this),
                'Товары' => $this->renderPartial("_form_products", array('form' => $form, 'model' => $model), $this),

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




