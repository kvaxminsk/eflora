<?
$criteria = new CDbCriteria;

$criteria->addCondition('object_id = :object_id');
$criteria->addCondition('model = :model');
$criteria->params[':object_id'] = $model->id;
$criteria->params[':model'] = $model->imagefolder;
$criteria->order = 't.order ASC, t.name ASC';

$images = new CActiveDataProvider('Image', array(
    'criteria' => $criteria,
    'pagination' => array(
        'pageSize' => 100000,
    ),
));

$actions = array(
    array('value' => 'save', 'name' => 'Сохранить'),
    array('value' => 'on', 'name' => 'Опубликовать'),
    array('value' => 'off', 'name' => 'Снять с публикации'),
    array('value' => 'del', 'name' => 'Удалить'),
);

if (!empty($images)):
    $this->widget('zii.widgets.gridAdmin.CGridView', array(
        'id' => 'cmaterial-grid',
        'jqurl' => Yii::app()->baseUrl . '/image/all',
        'rowCssClassExpression' => '($data->active == 1) ? "row-public":"row-unpublic"',
        'dataProvider' => $images,

        'summaryText' => '',
        'enableSorting' => true,

        'enablePagination' => false,
        'cssFile' => Yii::app()->baseUrl . '/css/gridView.css',
        'allActions' => $actions,
        'columns' =>
            array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 2,
                    'checkBoxHtmlOptions' => array('class' => 'chboxes'),
                ),
                array(
                    'name' => 'Изображение',
                    'type' => 'html',
                    'htmlOptions' => array('class' => 'td_center'),
                    'filter' => '',

                    'value' => function ($data) {
                        if (isset($data->photo)) {
                            return
                                '<a class="fancybox" href="' . $data->photo['path'] . '">' .
                                CHtml::image($data->photo['small'], $data->name, array('style' => 'height: 100px;')) .
                                '</a>';
                        } else {
                            return CHtml::image('/admin/images/no-photo.gif', $data->name, array('style' => 'height: 100px;'));
                        }
                    }
                ),
                array(
                    'name' => 'name',
                    'type' => 'raw',
                    'header' => 'Название',
                    'value' => function ($data) {
                        return CHtml::textField('name', $data->name, array('style' => 'width:300px;'));
                    },
                    'htmlOptions' => array('class' => 'textcolumn'),
                    'headerHtmlOptions' => array('class' => 'textcolumn')
                ),
                array(
                    'name' => 'order',
                    'type' => 'raw',
                    'header' => 'Порядок',
                    'value' => function ($data) {
                        return CHtml::textField('order', $data->order, array('style' => 'width:50px;'));
                    },
                    'htmlOptions' => array('class' => 'textcolumn'),
                    'headerHtmlOptions' => array('class' => 'textcolumn')
                ),

                array(
                    'class' => 'CButtonColumn',
                    'template' => '{public} {delete}',
                    'buttons' => array(
                        'public' => CGridView::getPublicButtonImage(),
                        'delete' => CGridView::getDeleteButtonImage(),
                    ),
                ),
            ),
    ));

endif;

?>
<div style="clear: both;"></div>
<br/>
<?
$this->widget('CMultiFileUpload',
    array(
        'model' => $model->images,
        'name' => 'Image',
        'attribute' => 'photo',
        'accept' => 'jpg|gif|png|jpeg',
        'denied' => 'Только файлы формата jpg, jpeg, png, gif',
        'max' => 100,
        'remove' => '[x]',
        'htmlOptions' => array('multiple' => 'multiple'),
        'duplicate' => 'Уже выбран',
        'options' => array('list' => '#list-block')
    )); ?>
<div id="list-block"></div>
<br/>



    