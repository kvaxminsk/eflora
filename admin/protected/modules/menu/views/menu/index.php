<?php
$this->breadcrumbs = array(
    'Меню'
);
?>

<?php $this->widget('zii.widgets.gridAdmin.CGridView',
    array(
        'id' => 'cmaterial-grid',
        'rowCssClassExpression' => '($data->active == 1) ? "row-public":"row-unpublic"',
        'dataProvider' => $model->search(),

        'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',

        'columns' => array(
            array(
                'header' => 'Название',
                'class' => 'CLinkColumn',
                'labelExpression' => '$data->name',
                'urlExpression' => '"/admin/menu/menu/update?id=".$data->id',
                'htmlOptions' => array('class' => 'textcolumn', 'style' => 'width: 300px'),
                'headerHtmlOptions' => array('class' => 'textcolumn')
            ),
            array(
                'header' => 'Переменная',
                'class' => 'CLinkColumn',
                'labelExpression' => '$data->alias',
                'htmlOptions' => array('class' => 'textcolumn'),
                'headerHtmlOptions' => array('class' => 'textcolumn')
            ),

            array(
                'class' => 'CButtonColumn',
                'template' => '{public} {update} {delete}',
                'buttons' => array(
                    'public' => CGridView::getPublicButton(),
                    'update' => CGridView::getEditButton(),
                    'delete' => CGridView::getDeleteButton(),

                ),
            ),
        ),
    )
); 