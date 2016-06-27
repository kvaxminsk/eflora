<?php
$this->breadcrumbs = array(
    'Системные переменные'
);


$actions = array(
    array('value' => 'on', 'name' => 'Опубликовать'),
    array('value' => 'off', 'name' => 'Снять с публикации'),
    array('value' => 'del', 'name' => 'Удалить'),
);

$template = '{public} {update} {delete}';


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cmaterial-grid',
    'jqurl' => Yii::app()->baseUrl . '/variables/variable/all',
    'rowCssClassExpression' => '($data->active == 1) ? "row-public":"row-unpublic"',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'summaryText' => '',
    'enableSorting' => true,

    'enablePagination' => true,
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'allActions' => $actions,
    'columns' =>
        array(
            array(
                'class' => 'CCheckBoxColumn',
                'selectableRows' => 3,
                'checkBoxHtmlOptions' => array('class' => 'chboxes'),

            ),

            array(
                'name' => 'label',
                'type' => 'html',
                'value' => 'CHtml::link("$data->label",array("/variables/variable/update/","id"=>$data->id), array("title"=>"Просмотреть переменную"))',
                'header' => 'Название',
                'htmlOptions' => array('class' => 'textcolumn'),
                'headerHtmlOptions' => array('class' => 'textcolumn')
            ),
            array(
                'name' => 'name',
                'type' => 'html',
                'value' => 'CHtml::link("$data->name",array("/variables/variable/update/","id"=>$data->id), array("title"=>"Просмотреть переменную"))',
                'header' => 'Переменная',
                'htmlOptions' => array('class' => 'textcolumn'),
                'headerHtmlOptions' => array('class' => 'textcolumn')
            ),

            array(
                'class' => 'CButtonColumn',
                'template' => $template,
                'buttons' => array(
                    'public' => CGridView::getPublicButton(),
                    'update' => CGridView::getEditButton(),
                    'delete' => CGridView::getDeleteButton('id', '$data->delete_allow==1'),
                ),
            ),
        )
)); ?> 
