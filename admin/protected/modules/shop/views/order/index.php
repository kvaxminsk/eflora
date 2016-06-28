<?php
$this->breadcrumbs = array(
    'Заказы',
);
?>

<?php
$actions = array(
    array('value' => 'on', 'name' => 'Обработан'),
    array('value' => 'off', 'name' => 'Не обработан'),
    array('value' => 'del', 'name' => 'Удалить'),
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cmaterial-grid',
    'jqurl' => Yii::app()->baseUrl . '/shop/order/all',
    'dataProvider' => $model->search(),
    'summaryText' => '',
    'enableSorting' => true,
    'filter' => $model,
    'enablePagination' => true,
    'pager' => array('nextPageLabel' => '>>', 'prevPageLabel' => '<<',),
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'allActions' => $actions,
    'columns' => array(

        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('class' => 'chboxes'),
        ),
        array(
            'name' => 'id',
            'type' => 'html',

            'htmlOptions' => array('class' => 'textcolumn'),
            'htmlOptions' => array('class' => 'textcolumn'),
            'headerHtmlOptions' => array('class' => 'textcolumn')
        ),
        array(
            'name' => 'active',
            'type' => 'html',
            'filter' => '',
            'htmlOptions' => array('class' => 'textcolumn'),
            'headerHtmlOptions' => array('class' => 'textcolumn'),
            'value' => function ($data) {
                if ($data->active) {
                    return 'Обработан';
                } else {
                    return 'Не обработан';
                }
            }
        ),
        array(
            'name' => 'user_name',
            'type' => 'html',
            'htmlOptions' => array('class' => 'textcolumn'),
            'headerHtmlOptions' => array('class' => 'textcolumn')
        ),
        array(
            'name' => 'date',
            'type' => 'html',
            'htmlOptions' => array('class' => 'textcolumn'),
            'headerHtmlOptions' => array('class' => 'textcolumn')
        ),
        array(
            'name' => 'price',
            'type' => 'html',
            'filter' => '',
            'htmlOptions' => array('class' => 'textcolumn'),
            'htmlOptions' => array('class' => 'textcolumn'),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
            'buttons' => array(
                'update' => CGridView::getEditButton(),
                'delete' => CGridView::getDeleteButton(),

            ),
        ),


    ),
)); 