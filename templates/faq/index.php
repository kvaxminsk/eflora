<?php $this->breadcrumbs = array(
    'Вопросы'
);
?>
<div class="box">

    <div class="box_head">
        Вопросы
    </div>
    <div class="box_body">
        <div style="font-size: 16px;">
            <?php $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_link',
                'template' => "{items}",
            )); ?>
        </div>
        <?php $model = new Faq;
        $this->renderPartial('_form', array('model' => $model));
        ?>
        <?php $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
            'template' => "{items}\n{pager}",
        )); ?>
    </div>
</div>
























