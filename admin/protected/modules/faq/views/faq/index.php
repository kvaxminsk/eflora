<?php
$this->breadcrumbs = array(
    'Вопросы'
);


$actions = array(
    array('value' => 'save', 'name' => 'Сохранить'),
    array('value' => 'on', 'name' => 'Опубликовать'),
    array('value' => 'off', 'name' => 'Снять с публикации'),
    array('value' => 'del', 'name' => 'Удалить'),
);

$template = '{public} {update} {delete}';


$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cmaterial-grid',
    'jqurl' => Yii::app()->baseUrl . '/faq/faq/all',
    'rowCssClassExpression' => '($data->active == 1) ? "row-public":"row-unpublic"',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'summaryText' => '',
    'enableSorting' => true,

    'enablePagination' => false,
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
                'name' => 'order',
                'type' => 'raw',
                'header' => 'Порядок',
                'filter' => '',
                'value' => function ($data) {
                    return CHtml::textField('order', $data->order, array('style' => 'width:50px;'));
                },
                'htmlOptions' => array('class' => 'textcolumn'),
                'headerHtmlOptions' => array('class' => 'textcolumn', 'style' => 'width:100px;')
            ),

            array(
                'name' => 'question',
                'type' => 'html',
                'value' => 'CHtml::link("$data->question",array("/faq/faq/update/","id"=>$data->id), array("title"=>"Просмотреть вопрос"))',
                'header' => 'Вопрос',
                'htmlOptions' => array('class' => 'textcolumn'),
                'headerHtmlOptions' => array('class' => 'textcolumn')
            ),

            array(
                'name' => 'name',
                'header' => 'Имя',
                'htmlOptions' => array('class' => 'textcolumn'),
                'headerHtmlOptions' => array('class' => 'textcolumn')
            ),

            array(
                'class' => 'CButtonColumn',
                'template' => $template,
                'buttons' => array(
                    'public' => CGridView::getPublicButton(),
                    'update' => CGridView::getEditButton(),
                    'delete' => CGridView::getDeleteButton(),
                ),
            ),
        )
)); ?> 
