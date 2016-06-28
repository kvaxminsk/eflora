<?php
$this->breadcrumbs = array(
    'Слайд-шоу',
);
?>

<?php
$actions = array(
    array('value' => 'save', 'name' => 'Сохранить'),
    array('value' => 'on', 'name' => 'Опубликовать'),
    array('value' => 'off', 'name' => 'Снять с публикации'),
    array('value' => 'del', 'name' => 'Удалить'),
);

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'cmaterial-grid',
    'jqurl' => Yii::app()->baseUrl . '/slider/slide/all',
    'rowCssClassExpression' => '($data->active == 1) ? "row-public":"row-unpublic"',
    'dataProvider' => $model->search(),

    'summaryText' => '',
    'enableSorting' => true,

    'enablePagination' => false,
    'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
    'allActions' => $actions,

    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 3,
            'checkBoxHtmlOptions' => array('class' => 'chboxes'),

        ),
        array(
            'name' => 'order',
            'type' => 'raw',
            'header' => 'Порядок',
            'value' => function ($data) {
                return CHtml::textField('order', $data->order, array('style' => 'width:50px;'));
            },
            'htmlOptions' => array('class' => 'textcolumn'),
            'headerHtmlOptions' => array('class' => 'textcolumn', 'style' => 'width:100px;')
        ),
        array(
            'name' => 'slider_n',
            'type' => 'raw',
            'header' => '№ Слайдера',
            'value' => function ($data) {
                return CHtml::textField('slider_n', $data->slider_n, array('style' => 'width:50px;'));
            },
            'htmlOptions' => array('class' => 'textcolumn'),
            'headerHtmlOptions' => array('class' => 'textcolumn', 'style' => 'width:100px;')
        ),
        array(
            'name' => 'Изображение',
            'type' => 'html',
            'htmlOptions' => array('class' => 'textcolumn'),
            'value' => function ($data) {
                if (isset($data->img['path'])) {
                    return
                        '<a class="fancybox" href="' . $data->img['path'] . '">' .
                        CHtml::image($data->img['small'], $data->name, array('style' => 'height: 100px;')) .
                        '</a>';
                } else {
                    return CHtml::image('/admin/images/no-photo.gif', $data->name, array('style' => 'height: 100px;'));
                }
            },
            'headerHtmlOptions' => array('class' => 'textcolumn', 'style' => 'width:100px;')
        ),
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link("$data->name",array("/slider/slide/update/","id"=>$data->id), array("title"=>"Просмотреть слайд"))',
            'header' => 'Название',
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
));
?> 
					